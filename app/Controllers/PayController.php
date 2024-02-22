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
        // Check if the user is logged in
        if (!session()->has('account_information_id')) {
            return redirect()->to('/login');
        }
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
    
        $accountInformationId = session()->get('account_information_id');
        $serviceType = session()->get('selectedService');

        $booking = $bookingModel
                ->where('account_information_id', $accountInformationId)
                ->where('serviceType', $serviceType)
                ->where('status', 'Ongoing')
                ->findAll();
        
        $bookingId = $booking[0]['booking_id'];
        $referenceCode = $booking[0]['reference_code'];
        $base_amount = $booking[0]['base_price'];
        $total_amount = $booking[0]['total_amount'];
        $study_abroad_additional_storage_price = $booking[0]['study_abroad_additional_storage_price'];

        $body = $this->request->getBody();

        $postData = json_decode($body, true);
        
        $additionalData = $postData['additionalData'];

        $formData = [
            'card_holder_name' => $additionalData['fname'].' '.$additionalData['lname'],
            'booking_date' => date('Y-m-d'),
            'notes' => $additionalData['notes'],
            'status' => 'Pending',
        ];
        
        $bookingModel->update($bookingId, $formData);
        $this->sendEmailtoStudent($additionalData, $referenceCode, $bookingId, $base_amount, $total_amount, $study_abroad_additional_storage_price);
        
        return redirect()->to('/success');
    }
    private function sendEmailtoStudent($additionalData, $referenceCode, $bookingId, $base_amount, $total_amount, $study_abroad_additional_storage_price)
    {
        $dModel = new DormsModel();
        $accountModel = new AccountInformationsModel();
        $bookingModel = new BookingsModel();
        $bookingItemModel = new BookingItemsModel();
    
        $accountInformationId = session()->get('account_information_id');
        $serviceType = session()->get('selectedService');
    
        $account = $accountModel
                ->select('account_informations.*, dorms.*') // select the columns you need
                ->join('dorms', 'dorms.dorm_id = account_informations.dorm_id') // join based on the relationship
                ->where('account_informations.account_information_id', $accountInformationId)
                ->first(); // Assuming you expect only one result
    
        // Check if $booking is not null before accessing its array offsets
        if ($bookingId) {
            $bookingItem = $bookingItemModel
                ->select('booking_items.*, items.*') // Select the columns you need
                ->join('items', 'items.item_id = booking_items.item_id') // Join based on the relationship
                ->where('booking_items.booking_id', $bookingId)
                //->where('items.item_name !=', 'Additional Box')
                ->findAll();
        } else {
            // Handle the case where $booking is null
            $bookingItem = [];
        }
    
        $additionalData = [
            'referenceCode' => $referenceCode,
            'email_address' => $account['email_address'] ?? '',
            'parent_email_address' => $account['parent_email_address'] ?? '',
            'parent_phone_number' => $account['parent_phone_number'] ?? '',
            'first_name' => $account['first_name'] ?? '',
            'last_name' => $account['last_name'] ?? '',
            'student_id' => $account['student_id'] ?? '',
            'phone_number' => $account['phone_number'] ?? '',
            'dorm_name' => $account['dorm_name'] ?? '',
            'dorm_room_number' => $account['dorm_room_number'] ?? '',
            'base_amount' => $base_amount ?? '0.00',
            'study_abroad_additional_storage_price' => $study_abroad_additional_storage_price ?? '0.00',
            'totalAmount' => $total_amount ?? '0.00',
            'orderItems' => $bookingItem,
        ];
    
        $email = \Config\Services::email();
    
        $email->setFrom('testing@braveegg.com', 'Epic Storage Solutions');
        $email->setTo($account['email_address']);
        $email->setCC($account['parent_email_address']);
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
