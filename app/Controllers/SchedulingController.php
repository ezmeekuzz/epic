<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\admin\DormsModel;
use App\Models\admin\ItemsModel;
use App\Models\admin\SizesModel;
use App\Models\BookingsModel;
use App\Models\AccountInformationsModel;
use App\Models\BookingItemsModel;
use App\Models\ServiceInformationsModel;
use CodeIgniter\I18n\Time;

class SchedulingController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Scheduling | Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
        ];
        return view('pages/scheduling', $data);
    }
    public function accountInformation() {
        $dormModel = new DormsModel();
        $dresult = $dormModel->findAll();
        $data = [
            'title' => 'Scheduling - Account Information | Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
            'records' => $dresult
        ];
        return view('pages/account-information', $data);
    }
    public function serviceInformation($serviceType) {
        if (!session()->has('account_information_id')) {
            return redirect()->to('/login');
        }
        
        $bookingsModel = new BookingsModel();
    
        $accountInformationId = session()->get('account_information_id');
        $serviceType = session()->get('selectedService');

        $booking = $bookingsModel
                ->where('account_information_id', $accountInformationId)
                ->where('serviceType', $serviceType)
                ->where('status', 'Ongoing')
                ->findAll();

        $referenceCode = 'REF_' . uniqid();
        $bookingDate = date('Y-m-d');

        $ordernumber = $bookingsModel
            ->select('ordernumber')
            ->findAll();
            
        $orderNumbers = array_column($ordernumber, 'ordernumber');

        $targetYear = date('Y') + 1;

        $incrementingNumber = 100;

        do {
            $generatedNumber = $targetYear . ' - ' . $incrementingNumber;

            $isUnique = !in_array($generatedNumber, $orderNumbers);

            if (!$isUnique) {
                $incrementingNumber++;
            }
        } while (!$isUnique);
        
        if($serviceType === 'summer-storage') {
            $basePrice = 425;
        }
        else {
            $basePrice = 0;
        }
    
        if (!$booking) {
            $data = [
                'account_information_id' => $accountInformationId,
                'serviceType' => $serviceType,
                'reference_code' => $referenceCode,
                'ordernumber' => $generatedNumber,
                'booking_date' => $bookingDate,
                'base_price' => $basePrice,
                'total_amount' => 425,
                'status' => 'Ongoing',
            ];
        
            $bookingsModel->insert($data);
        }
        else {
            $bookingId = $booking[0]['booking_id'];
            $data = [
                'account_information_id' => $accountInformationId,
                'serviceType' => $serviceType,
                'booking_date' => $bookingDate,
                'base_price' => $basePrice,
                'status' => 'Ongoing',
            ];
        
            $bookingsModel->update($bookingId, $data);
        }

        $itemModel = new ItemsModel();
        $sizeModel = new SizesModel();
        $iresult = $itemModel
                ->where('item_name !=', 'Additional Box')
                ->where('item_name !=', 'Summer School Deliver Fee ')
                ->findAll();

        $sresult = $sizeModel
                ->select('sizes.cost, sizes.size, items.item_name, items.item_id, sizes.size_id')
                ->join('items', 'items.item_id = sizes.item_id')
                ->where('items.item_name', 'Additional Box')
                ->orderBy('CAST(sizes.size AS SIGNED)', 'ASC')
                ->findAll();
            
        $data = [
            'title' => 'Scheduling - Service Information | Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
            'records' => $iresult,
            'additional_box' => $sresult,
        ];
        if($serviceType === 'summer-storage') {
            return view('pages/summer-storage', $data);
        }
        else {
            return view('pages/summer-advantage', $data);
        }
    }
    public function getSizes()
    {
        $itemId = $this->request->getPost('item_id');
        $sizeModel = new SizesModel();
        $sizes = $sizeModel->where('item_id', $itemId)->findAll();
        
        return $this->response->setJSON(['sizes' => $sizes]);
    }
    public function insertAdditionalBoxTotalAmount()
    {
        $bookingItemModel = new BookingItemsModel();
        $servicesModel = new ServiceInformationsModel();
        $bookingsModel = new BookingsModel();
    
        $accountInformationId = session()->get('account_information_id');
        $serviceType = session()->get('selectedService');
        $total_amount = $bookingsModel
                    ->selectSum('total_amount')
                    ->where('account_information_id', $accountInformationId)
                    ->where('serviceType', $serviceType)
                    ->where('status', 'Ongoing')
                    ->get()
                    ->getRow();

        $additionalBoxPrice = 50;
    
        $size_id = $this->request->getPost('size_id');
        $item_id = $this->request->getPost('item_id');
        $quantity = $this->request->getPost('quantity');
        $additionalBoxTotalAmount = $quantity * $additionalBoxPrice;
        $totalAmount = $total_amount->total_amount + $additionalBoxTotalAmount;
    
        $booking = $bookingsModel
                ->where('account_information_id', $accountInformationId)
                ->where('serviceType', $serviceType)
                ->where('status', 'Ongoing')
                ->findAll();

        $sumItem = $bookingItemModel
                ->selectSum('totalamount', 'total_amount')
                ->join('items', 'items.item_id = booking_items.item_id') // Adjust the join condition based on your actual database schema
                ->where('booking_id', $booking[0]['booking_id'])
                ->where('item_name !=', 'Additional Box')
                //->where('item_name !=', 'Summer School Deliver Fee ')
                ->first();
                
        $bookingId = $booking[0]['booking_id'];
        $bookingTotalAmount = $booking[0]['base_price'] + $additionalBoxTotalAmount + $sumItem['total_amount'];
        
        
        $service = $servicesModel
                ->where('booking_id', $bookingId)
                ->findAll();
                
        if(!empty($service) && isset($service[0]['is_studying_abroad']) && $service[0]['is_studying_abroad'] === 'Yes') {
            $studyAbroadAdditionalStoragePrice = $bookingTotalAmount * 2;
            $this->updateBooking($bookingId, $quantity, $additionalBoxPrice, $bookingTotalAmount, $additionalBoxTotalAmount, 'AddtlBox', $studyAbroadAdditionalStoragePrice);
        }
        else {
            $studyAbroadAdditionalStoragePrice = $bookingTotalAmount;
            $this->updateBooking($bookingId, $quantity, $additionalBoxPrice, '', $additionalBoxTotalAmount, 'AddtlBox', $studyAbroadAdditionalStoragePrice);
        }
    
        $bookingItem = $bookingItemModel
            ->where('booking_id', $bookingId)
            ->where('item_id', $item_id)
            ->first();
    
        $data = [
            'booking_id' => $bookingId,
            'size_id' => $size_id,
            'item_id' => $item_id,
            'quantity' => $quantity,
            'price' => $additionalBoxPrice,
            'totalamount' => $additionalBoxTotalAmount,
            'order_date' => date('Y-m-d')
        ];
    
        if ($bookingItem) {
            $bookingItemModel->update($bookingItem['booking_item_id'], $data);
        } else {
            $bookingItemModel->insert($data);
        }
    
        return $this->response->setJSON(['message' => 'Data inserted successfully']);
    }     
    public function insertSummerSchoolDeliveryFee()
    {
        $bookingItemModel = new BookingItemsModel();
        $bookingsModel = new BookingsModel();
        $servicesModel = new ServiceInformationsModel();
    
        $accountInformationId = session()->get('account_information_id');
        $serviceType = session()->get('selectedService');
        $selectedValue = $this->request->getPost('selectedValue');
    
        $booking = $bookingsModel
            ->where('account_information_id', $accountInformationId)
            ->where('serviceType', $serviceType)
            ->where('status', 'Ongoing')
            ->findAll();
    
        if (empty($booking)) {
            return $this->response->setJSON(['message' => 'No ongoing booking found.']);
        }
    
        $bookingId = $booking[0]['booking_id'];

        $service = $servicesModel
                ->where('booking_id', $bookingId)
                ->findAll();
    
        $summerSchoolDeliveryFee = $bookingItemModel
            ->select('i.*, s.*')
            ->from('items i')
            ->join('sizes s', 's.item_id = i.item_id')
            ->where('i.item_name', 'Summer School Deliver Fee')
            ->findAll();

        $bookingItemID = $bookingItemModel
            ->select('booking_items.*, items.*')
            ->join('items', 'items.item_id = booking_items.item_id') // Adjust the join condition based on your actual database schema
            ->where('booking_id', $bookingId)
            ->where('items.item_name', 'Summer School Deliver Fee')
            ->first();        

        if (!empty($selectedValue) && $selectedValue === 'No') {
            $itemIdToDelete = $bookingItemID['booking_item_id'];
            
            // Ensure $itemIdToDelete is valid and not empty
            if (!empty($itemIdToDelete)) {            
                $bookingsModel->set('total_amount', 'total_amount - ' . $bookingItemID['totalamount'], false)
                ->where('booking_id', $bookingId)
                ->update();
                $bookingItemModel->where('booking_item_id', $itemIdToDelete)->delete();
                return $this->response->setJSON(['success' => $bookingItemModel->getLastQuery()->getQuery()]);
            } else {
                // Log an error or handle the case where $itemIdToDelete is empty
                return $this->response->setJSON(['success' => false, 'error' => 'Invalid itemIdToDelete']);
            }
        }

        $sumItem = $bookingItemModel
            ->selectSum('totalamount', 'total_amount')
            ->join('items', 'items.item_id = booking_items.item_id') // Adjust the join condition based on your actual database schema
            ->where('booking_id', $booking[0]['booking_id'])
            ->where('item_name !=', 'Additional Box')
            //->where('item_name !=', 'Summer School Deliver Fee ')
            ->first();
        
        $bookingTotalAmount = $booking[0]['base_price'] + $booking[0]['addtl_box_total_amount'] + $sumItem['total_amount'] + $summerSchoolDeliveryFee[0]['cost'];    
        $quantity = $booking[0]['additional_box_quantity'];
        $additionalBoxTotalAmount = $booking[0]['addtl_box_total_amount'];
        $studyAbroadAdditionalStoragePrice = $booking[0]['study_abroad_additional_storage_price'];
        $additionalBoxPrice = 50;
                
        if(!empty($service) && isset($service[0]['is_studying_abroad']) && $service[0]['is_studying_abroad'] === 'Yes') {
            $studyAbroadAdditionalStoragePrice = $bookingTotalAmount * 2;
            $this->updateBooking($bookingId, $quantity, $additionalBoxPrice, $bookingTotalAmount, $additionalBoxTotalAmount, 'AddtlBox', $studyAbroadAdditionalStoragePrice);
        }
        else {
            $studyAbroadAdditionalStoragePrice = $bookingTotalAmount;
            $this->updateBooking($bookingId, $quantity, $additionalBoxPrice, '', $additionalBoxTotalAmount, 'AddtlBox', $studyAbroadAdditionalStoragePrice);
        }
        if (empty($summerSchoolDeliveryFee)) {
            return $this->response->setJSON(['message' => 'Summer School Deliver Fee not found in items.']);
        }
    
        $data = [
            'booking_id' => $bookingId,
            'size_id' => $summerSchoolDeliveryFee[0]['size_id'],
            'item_id' => $summerSchoolDeliveryFee[0]['item_id'],
            'quantity' => 1,
            'price' => $summerSchoolDeliveryFee[0]['cost'],
            'totalamount' => $summerSchoolDeliveryFee[0]['cost'],
            'order_date' => date('Y-m-d')
        ];
    
        $bookingItemModel->insert($data);
    
        return $this->response->setJSON(['message' => 'Data inserted successfully']);
    }
    
    private function updateBooking($bookingId, $quantity, $additionalBoxPrice, $totalAmount, $additionalBoxTotalAmount, $orderType, $studyAbroadAdditionalStoragePrice)
    {
        $bookingsModel = new BookingsModel();
        if($orderType === 'Item') {
            $data = [
                'study_abroad_additional_storage_price' => $totalAmount,
                'total_amount' => $studyAbroadAdditionalStoragePrice,
                'status' => 'Ongoing',
            ];
        }
        else {
            $data = [
                'additional_box_quantity' => $quantity,
                'additional_box_amount' => $additionalBoxPrice,
                'addtl_box_total_amount' => $additionalBoxTotalAmount,
                'study_abroad_additional_storage_price' => $totalAmount,
                'total_amount' => $studyAbroadAdditionalStoragePrice,
                'status' => 'Ongoing',
            ];
        }
    
        $bookingsModel->update($bookingId, $data);
    } 
    public function insertBookingItem()
    {
        $bookingItemsModel = new BookingItemsModel();
        $servicesModel = new ServiceInformationsModel();
        $item_id = $this->request->getPost('item_id');
        $size_id = $this->request->getPost('size_id');
        $quantity = $this->request->getPost('quantity');
        $price = $this->getItemPrice($item_id, $size_id);
        
        $latestBooking = $this->fetchLatestBooking();

        $booking_id = $latestBooking['booking_id'];

        $bookingItem = $bookingItemsModel
                ->where('booking_id', $latestBooking['booking_id'])
                ->where('item_id', $item_id)
                ->where('size_id', $size_id)
                ->first();

        $sumItem = $bookingItemsModel
                ->selectSum('totalamount', 'total_amount')
                ->join('items', 'items.item_id = booking_items.item_id') // Adjust the join condition based on your actual database schema
                ->where('booking_id',  $booking_id)
                ->where('item_name !=', 'Additional Box')
                //->where('item_name !=', 'Summer School Deliver Fee ')
                ->first();  

        if ($bookingItem !== null && isset($bookingItem['totalamount'])) {
            $itemTotal = $bookingItem['totalamount'];
        } else {
            $itemTotal = 0;
        }
        $totalAmount = $price * $quantity;
        $compare =   $totalAmount - $itemTotal;
        $bookingTotalAmount = $latestBooking['base_price'] + $latestBooking['addtl_box_total_amount'] + $sumItem['total_amount'] + $compare;
        
        
        
        $service = $servicesModel
                ->where('booking_id', $booking_id)
                ->findAll();      
        if(!empty($service) && isset($service[0]['is_studying_abroad']) && $service[0]['is_studying_abroad'] === 'Yes') {
            $studyAbroadAdditionalStoragePrice = $bookingTotalAmount * 2;
            $this->updateBooking($booking_id, '', '', $bookingTotalAmount, '', 'Item', $studyAbroadAdditionalStoragePrice);
        }
        else {
            $this->updateBooking($booking_id, '', '', '', '', 'Item', $bookingTotalAmount);
        }
    
        $data = [
            'booking_id' => $booking_id,
            'item_id' => $item_id,
            'size_id' => $size_id,
            'quantity' => $quantity,
            'price' => $price,
            'totalamount' => $totalAmount,
            'order_date' => date('Y-m-d')
        ];
    
        if ($bookingItem) {
            $bookingItemsModel->update($bookingItem['booking_item_id'], $data);
        } else {
            $bookingItemsModel->insert($data);
        }
        return $this->response->setJSON(['message' => 'Data inserted successfully']);
    } 
    public function getBookingItems()
    {
        $bookingModel = new BookingsModel();
        $bookingItemsModel = new BookingItemsModel();
    
        $accountInformationId = session()->get('account_information_id');
        $serviceType = session()->get('selectedService');
    
        $bookings = $bookingModel
            ->where('account_information_id', $accountInformationId)
            ->where('serviceType', $serviceType)
            ->where('status', 'Ongoing')
            ->findAll();
    
        $bookingItems = [];
    
        if ($bookings) {
            $bookingId = $bookings[0]['booking_id'];
    
            $bookingItems = $bookingItemsModel
            ->distinct()
                ->select('bi.*, s.size, i.item_name')
                ->from('booking_items bi')
                ->join('sizes s', 's.size_id = bi.size_id')
                ->join('items i', 'i.item_id = bi.item_id')
                ->where('bi.booking_id', $bookingId)
                ->findAll();
        }
    
        return $this->response->setJSON(['bookingItems' => $bookingItems]);
    }
    
    public function getTotalAmount()
    {
        $bookingsModel = new BookingsModel();

        $accountInformationId = session()->get('account_information_id');
        $serviceType = session()->get('selectedService');

        $totalAmount = $bookingsModel
            ->selectSum('total_amount')
            ->where('account_information_id', $accountInformationId)
            ->where('serviceType', $serviceType)
            ->where('status', 'Ongoing')
            ->get()
            ->getRow();

        return $this->response->setJSON(['totalAmount' => $totalAmount->total_amount]);
    }
    public function deleteBookingItem()
    {
        $request = $this->request;
        $bookingItemsModel = new BookingItemsModel();
        $bookingsModel = new BookingsModel();
        $ServicesModel = new ServiceInformationsModel();

        $index = $request->getVar('index');
        $deletedItem = $bookingItemsModel->find($index);
        $deletedAmount = $deletedItem['totalamount'];
        $item = $bookingItemsModel
            ->select('booking_items.*, items.item_name')
            ->join('items', 'items.item_id = booking_items.item_id')
            ->where('booking_items.booking_item_id', $index)
            ->where('items.item_name', 'Additional Box')
            ->first();
        $result = $bookingItemsModel->where('booking_item_id', $index)->delete();
        $bookingId = $deletedItem['booking_id'];
        if ($item) {
            $bookingsModel->update($bookingId, 
                                    [
                                        'additional_box_quantity' => '0',
                                        'addtl_box_total_amount' => '0',
                                    ]);
        }
        if ($result) {
            $currentTotalAmount = $bookingsModel->select('total_amount')->find($bookingId)['total_amount'];
            $newTotalAmount = $currentTotalAmount - $deletedAmount;

            $service = $ServicesModel
            ->where('booking_id', $deletedItem['booking_id'])
            ->findAll();

            if($service[0]['is_studying_abroad'] === 'Yes') {
                $currentStudyAbroadAdditionalStoragePrice = $bookingsModel->select('study_abroad_additional_storage_price')->find($bookingId)['study_abroad_additional_storage_price'];
                $newStudyAbroadAdditionalStoragePrice = $currentStudyAbroadAdditionalStoragePrice - $deletedAmount;
                $bookingsModel->update($bookingId, 
                                    [
                                        'study_abroad_additional_storage_price' => $newStudyAbroadAdditionalStoragePrice,
                                        'total_amount' => $currentTotalAmount - ($deletedAmount*2),
                                    ]);
            }
            else {
                $bookingsModel->update($bookingId, ['total_amount' => $newTotalAmount]);
            }
        }

        return $this->response->setJSON(['success' => $result]);
    }
    private function fetchLatestBooking()
    {
        $bookingsModel = new BookingsModel();

        return $bookingsModel
            ->where('status', 'Ongoing')
            ->where('serviceType', session()->get('selectedService'))
            ->where('account_information_id', session()->get('account_information_id'))
            ->orderBy('booking_id', 'DESC')
            ->first();
    }
    private function getItemPrice($item_id, $size_id)
    {
        $sizeModel = new SizesModel();

        $cost = $sizeModel
            ->select('cost')
            ->where('item_id', $item_id)
            ->where('size_id', $size_id)
            ->get()
            ->getRow();

        if ($cost) {
            return $cost->cost;
        }
        
        return 0;
    }
    public function updateServiceOption()
    {
        $optionName = $this->request->getPost('optionName');
        $optionValue = $this->request->getPost('optionValue');
    
        $bookingModel = new BookingsModel();
        $serviceModel = new ServiceInformationsModel();
    
        $accountInformationId = session()->get('account_information_id');
        $serviceType = session()->get('selectedService');
    
        $bookings = $bookingModel
            ->where('account_information_id', $accountInformationId)
            ->where('serviceType', $serviceType)
            ->where('status', 'Ongoing')
            ->findAll();
    
        if (!$bookings) {
            return $this->response->setJSON(['message' => 'No booking data found.']);
        }
    
        $services = $serviceModel
            ->where('booking_id', $bookings[0]['booking_id'])
            ->findAll();
    
        $data = [
            'booking_id' => $bookings[0]['booking_id'],
            $optionName => $optionValue,
        ];

        if($optionName === 'is_studying_abroad' && $optionValue === 'Yes') {
            $totalAmount = $bookings[0]['total_amount'] * 2;
            $bookingModel->update(
                $bookings[0]['booking_id'],
                [
                    'study_abroad_additional_storage_price' => $bookings[0]['total_amount'],
                    'total_amount' => $totalAmount,
                ]
            );
        }
        else if($optionName === 'is_studying_abroad' && $optionValue === 'No') {
            $totalAmount = $bookings[0]['total_amount'] / 2;
            $bookingModel->update(
                $bookings[0]['booking_id'],
                [
                    'study_abroad_additional_storage_price' => 0,
                    'total_amount' => $totalAmount
                ]
            );
        }

        if(!$services) {
            $serviceModel->insert($data);
        }
        else {
            $serviceModel->update($services[0]['service_information_id'], $data);
        }
    
        return $this->response->setJSON(['message' => 'Data updated successfully']);
    }
    
    public function checkServiceOptions()
    {
        $serviceModel = new ServiceInformationsModel();
        $bookingsModel = new BookingsModel();

        $accountInformationId = session()->get('account_information_id');
        $serviceType = session()->get('selectedService');

        $bookings = $bookingsModel
            ->where('account_information_id', $accountInformationId)
            ->where('serviceType', $serviceType)
            ->where('status', 'Ongoing')
            ->findAll();

        $services = $serviceModel
            ->where('booking_id', $bookings[0]['booking_id'])
            ->findAll();

        $response = [
            'is_studying_abroad' => $services ? $services[0]['is_studying_abroad'] : null,
            'is_storage_additional_item' => $services ? $services[0]['is_storage_additional_item'] : null,
            'is_summer_school' => $services ? $services[0]['is_summer_school'] : null,
        ];

        return $this->response->setJSON($response);
    }
    public function getStudyAbroadAdditionalStoragePrice()
    {
        $bookingsModel = new BookingsModel();
        $selectedService = session()->get('selectedService');
        $accountInformationId = session()->get('account_information_id');
        $result = $bookingsModel
            ->select('study_abroad_additional_storage_price')
            ->where('serviceType', $selectedService)
            ->where('account_information_id', $accountInformationId)
            ->where('status', 'Ongoing')
            ->where('study_abroad_additional_storage_price IS NOT NULL', null, false)
            ->where('study_abroad_additional_storage_price !=', 0)
            ->findAll();

        if (!empty($result)) {
            $studyAbroadAdditionalStoragePrice = $result[0]['study_abroad_additional_storage_price'];
            return $this->response->setJSON(['study_abroad_additional_storage_price' => $studyAbroadAdditionalStoragePrice]);
        } else {
            return $this->response->setJSON(['error' => 'No matching record found']);
        }
    }
    public function chooseSchedule($refCode)
    {
        $data = [
            'title' => 'Choose Schedule | Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
            'refCode' => $refCode
        ];
        return view('pages/choose-schedule', $data);
    }
    public function finalizeSchedule()
    {
        if (!session()->has('account_information_id')) {
            return redirect()->to('/login');
        }
        
        $refCode = $this->request->getPost('refCode');
        $timeObject = \CodeIgniter\I18n\Time::createFromFormat('h:i A', $this->request->getPost('picking_time'));
        $formattedTime = $timeObject->format('H:i:s');
        $bookingModel = new BookingsModel();
    
        $bookingScheduled = $bookingModel
            ->where('status', 'Scheduled')
            ->where('reference_code', $refCode)
            ->countAllResults();
            
        if ($bookingScheduled > 0) {
            $response = [
                'status' => 'error',
                'message' => 'You already scheduled this booking! Contact Us to reschedule it!',
            ];
    
            return $this->response->setJSON($response);
        }
        
        $existingBooking = $bookingModel
            ->select('booking_id')
            ->where('reference_code', $refCode)
            ->first();
    
        if (!$existingBooking) {
            $response = [
                'status' => 'error',
                'message' => 'Booking with the provided refCode not found.',
            ];
    
            return $this->response->setJSON($response);
        }
    
        $booking_id = $existingBooking['booking_id'];
    
        $bookingCount = $bookingModel
            ->where('picking_date', $this->request->getPost('picking_date'))
            ->where('picking_time', $formattedTime)
            ->countAllResults();
    
        if ($bookingCount >= 3) {
            $response = [
                'status' => 'error',
                'message' => 'Cannot schedule more than three bookings for the selected date and time. Select another date to schedule.',
            ];
    
            return $this->response->setJSON($response);
        }
    
        $data = [
            'picking_date' => $this->request->getPost('picking_date'),
            'picking_time' => $formattedTime,
            'status' => 'Scheduled',
        ];
    
        $result = $bookingModel->update($booking_id, $data);
    
        if ($result) {
            $this->sendEmailtoStudent($booking_id, $data);
            $response = [
                'status' => 'success',
                'message' => 'Schedule Pickup Successfully',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to finalize schedule. You may have provided an invalid booking ID.',
            ];
        }
    
        return $this->response->setJSON($response);
    }
    
    private function sendEmailtoStudent($booking_id, $data)
    {
        $aModel = new AccountInformationsModel();
        
        $aresult = $aModel->find(session()->get('account_information_id'));
        
        $data = array_merge($data, $aresult);
        $email = \Config\Services::email();
        
        $email->setFrom('testing@braveegg.com', 'Epic Storage Solutions');
        $email->setTo($aresult['email_address']);
        $email->setSubject('EPIC Pickup Confirmation');
        
        $email->setMailType('html');
        
        $emailContent = view('email_templates/pickup_confirmation', ['result' => $data]);
        $email->setMessage($emailContent);
        
        $email->send();     
    } 
    public function test()
    {
        // Assuming you are using CodeIgniter 4 syntax for database queries

        // Load the necessary model
        $bookingsModel = new BookingsModel(); // Replace BookingsModel with your actual model name

        // Fetch all order numbers from the database
        $ordernumber = $bookingsModel
            ->select('ordernumber')
            ->findAll();

        // Extract the 'ordernumber' values from the result
        $orderNumbers = array_column($ordernumber, 'ordernumber');

        // Determine the target year
        $targetYear = date('Y') + 1;

        // Initialize the incrementing number
        $incrementingNumber = 100;

        // Loop until a unique order number is generated
        do {
            // Calculate the final result
            $generatedNumber = $targetYear . ' - ' . $incrementingNumber;

            // Check if the generated number already exists
            $isUnique = !in_array($generatedNumber, $orderNumbers);

            // If not unique, increment the incrementing number
            if (!$isUnique) {
                $incrementingNumber++;
            }
        } while (!$isUnique);

        // At this point, $generatedNumber contains a unique order number for the next year
        echo $generatedNumber;
    }
    
}