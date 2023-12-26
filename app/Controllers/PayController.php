<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookingsModel;
use App\Models\AccountInformationsModel;
use App\Models\ServiceInformationsModel;
use App\Models\BookingItemsModel;
use App\Models\admin\DormsModel;
use App\Models\admin\ItemsModel;
use Square\SquareClient;

class PayController extends BaseController
{
    public function index()
    {
        if (!session()->has('selectedService') || empty(session()->get('selectedService'))) {
            return redirect()->to('/');
        }
        $data = [
            'title' => 'Pay | Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
        ];
        if(session()->get('selectedService') === 'summer-storage') {
            return view('pages/pay-summer-storage', $data);
        }
        else {
            return view('pages/pay-summer-advantage', $data);
        }
    }
    public function processPayment()
    {
        $request = $this->request;
        $amount = $request->getVar('amount');
        $cardNonce = $request->getVar('card_nonce');
        
        $squareApiUrl = 'https://connect.squareupsandbox.com/v2/payments';
        $squareAccessToken = 'EAAAEPCljthgP4lIrU6Lm20V4f_zuCKb95YsZR_u6HbU3aR1ZX4V-8DPadhkA8h-';

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $squareAccessToken,
        ];

        $body = [
            'source_id' => $cardNonce,
            'amount_money' => [
                'amount' => $amount * 100,
                'currency' => 'USD',
            ],
            'idempotency_key' => uniqid(),
        ];

        $ch = curl_init($squareApiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode == 200) {
            $paymentResult = json_decode($response, true);

            $this->savePayment();
            
            return $this->response->setJSON([
                'status' => 'SUCCESS',
                'message' => 'Payment successful',
                'result' => $paymentResult,
            ]);
        } else {
            
            return $this->response->setJSON([
                'status' => 'FAILURE',
                'message' => 'Payment failed',
                'error' => json_decode($response, true),
            ]);
        }
    }
    private function savePayment()
    {
        $bookingModel = new BookingsModel();

        $body = $this->request->getBody();

        $postData = json_decode($body, true);
        
        $additionalData = $postData['additionalData'];

        $referenceCode = 'REF_' . uniqid();

        $formData = [
            'reference_code' => $referenceCode,
            'serviceType' => session()->get('selectedService'),
            'card_holder_name' => $additionalData['fname'].' '.$additionalData['lname'],
            'booking_date' => date('Y-m-d'),
            'base_price' => $additionalData['base_amount'] ?? 0,
            'additional_box_amount' => $additionalData['addtl_box_amount'] ?? 0,
            'addtl_box_total_amount' => $additionalData['addtl_box_total_amount'] ?? 0,
            'additional_box_quantity' => $additionalData['addtl_box_quantity'] ?? 0,
            'total_amount' => $additionalData['totalAmount'] ?? 0,
            'status' => 'Pending'
        ];
        
        $bookingModel->insert($formData);
        $bookingId = $bookingModel->insertID();
        $this->insertAccountInformation($bookingId, $additionalData);
        $this->insertServiceInformation($bookingId, $additionalData);
        $this->insertBookingItems($bookingId, $additionalData);
        $this->sendEmailtoStudent($additionalData, $referenceCode);
        
        return redirect()->to('/success');
    }
    private function insertAccountInformation($bookingId, $additionalData)
    {
        $accountInformationModel = new AccountInformationsModel();
        
        $formData = [
            'booking_id' => $bookingId,
            'dorm_id' => $additionalData['dorm_id'],
            'first_name' => $additionalData['first_name'],
            'last_name' => $additionalData['last_name'],
            'student_id' => $additionalData['student_id'],
            'dorm_room_number' => $additionalData['dorm_room_number'],
            'phone_number' => $additionalData['phone_number'],
            'email_address' => $additionalData['email_address'],
            'street_name' => $additionalData['street_name'],
            'street_number' => $additionalData['street_number'],
            'parent_phone_number' => $additionalData['parent_phone_number'],
            'parent_email_address' => $additionalData['parent_email_address'],
        ];
        
        $accountInformationModel->insert($formData);
    }
    private function insertServiceInformation($bookingId, $additionalData)
    {
        $serviceInformationModel = new ServiceInformationsModel();
        
        $formData = [
            'booking_id' => $bookingId,
            'is_boxes_included' => $additionalData['is_boxes_included'] ?? "",
            'box_quantity' => $additionalData['box_quantity'] ?? "",
            'is_storage_additional_item' => $additionalData['is_storage_additional_item'] ?? "",
            'is_storage_car_in_may' => $additionalData['is_storage_car_in_may'] ?? "",
            'is_storage_vehicle_in_may' => $additionalData['is_storage_vehicle_in_may'] ?? "",
            'is_summer_school' => $additionalData['is_summer_school'] ?? "",
        ];
        
        $serviceInformationModel->insert($formData);
    }
    private function insertBookingItems($bookingId, $additionalData)
    {
        $bookingItemModel = new BookingItemsModel();
        if (isset($additionalData['order_item_id[]']) && is_array($additionalData['order_item_id[]'])) {
            $order_item_id = $additionalData['order_item_id[]'];
            for($i=0; $i < COUNT($order_item_id); $i++) {
                $formData = [
                    'booking_id' => $bookingId,
                    'item_id' => $additionalData['order_item_id[]'][$i],
                    'size_id' => $additionalData['order_size_id[]'][$i],
                    'quantity' => $additionalData['item_quantity[]'][$i],
                    'price' => $additionalData['item_amount[]'][$i],
                    'totalamount' => $additionalData['item_total_amount[]'][$i]
                ];
                
                $bookingItemModel->insert($formData);
            }
        }
    }
    private function sendEmailtoStudent($additionalData, $referenceCode)
    {
        $dModel = new DormsModel();
        
        $dorm = isset($additionalData['dorm_id']) ? $dModel->find($additionalData['dorm_id']) : null;
        
        if ($dorm) {
            $additionalData['dorm_name'] = $dorm['dorm_name'];
        } else {
            
        }
        
        if (isset($additionalData['order_item_id[]'])) {
            $order_item_ids = (array) $additionalData['order_item_id[]'];
            $orderItems = [];
            
            $itemModel = new ItemsModel();
            $totalAmounts = $additionalData['item_total_amount[]'];
            $itemQuantity = $additionalData['item_quantity[]'];
            
            $itemCount = count($order_item_ids);
        
            for ($i = 0; $i < $itemCount; $i++) {
                $itemId = $order_item_ids[$i];
                
                $item = $itemModel->find($itemId);
        
                if ($item) {
                    $itemName = $item['item_name'];
                    
                    $itemTotalAmount = is_array($totalAmounts) ? (count($totalAmounts) > 1 ? $totalAmounts[$i] : $additionalData['item_total_amount[]']) : $additionalData['item_total_amount[]'];
                    $itemTotalQuantity = is_array($itemQuantity) ? (count($itemQuantity) > 1 ? $itemQuantity[$i] : $additionalData['item_quantity[]']) : $additionalData['item_quantity[]'];
        
                    $orderItems[] = [
                        'item_name' => $itemName,
                        'item_total_amount' => $itemTotalAmount,
                        'item_quantity' => $itemTotalQuantity,
                    ];
                } else {
                    
                }
            }
            
            $additionalData['orderItems'] = $orderItems;
        }
        
        $additionalData['referenceCode'] = $referenceCode;
        
        $email = \Config\Services::email();
        
        $email->setFrom('testing@braveegg.com', 'Epic Storage Solutions');
        $email->setTo($additionalData['email_address']);
        $email->setCC($additionalData['parent_email_address']);
        $email->setSubject('HPU Storage Receipt – EPIC Storage');
        
        $email->setMailType('html');
        
        $emailContent = view('email_templates/order_confirmation', ['additionalData' => $additionalData]);
        $email->setMessage($emailContent);
        
        $email->send();
        echo $email->printDebugger();        
    }
    
    public function removeServiceSession()
    {
        session()->remove('selectedService');
        return redirect()->to('/');
    }
}
