<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\admin\DormsModel;
use App\Models\admin\ItemsModel;
use App\Models\admin\SizesModel;
use App\Models\BookingsModel;
use App\Models\AccountInformationsModel;
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
        $itemModel = new ItemsModel();
        $iresult = $itemModel->findAll();
        $data = [
            'title' => 'Scheduling - Service Information | Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
            'records' => $iresult
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
    
    public function calculateTotal()
    {
        $item = $this->request->getPost('item');
        $size = $this->request->getPost('size');
        $quantity = $this->request->getPost('quantity');
        
        $priceData = $this->getPriceByItemAndSize($item, $size);
        $price = $priceData['cost'];
        $item_id = $priceData['item_id'];
        $item_name = $priceData['item_name'];
        $size = $priceData['size'];
        $size_id = $priceData['size_id'];

        $total = (float)$price * $quantity;
        
        return $this->response->setJSON([
            'total' => $total,
            'item_id' => $item_id,
            'item_name' => $item_name,
            'size' => $size,
            'price' => $price,
            'size_id' => $size_id,
        ]);
    }
    
    private function getPriceByItemAndSize($item, $size)
    {
        $sizeModel = new SizesModel();
        
        $priceRow = $sizeModel
            ->select('sizes.cost, sizes.size, items.item_name, items.item_id, sizes.size_id')
            ->join('items', 'items.item_id = sizes.item_id')
            ->where('items.item_id', $item)
            ->where('sizes.size_id', $size)
            ->first(); 
            
        if ($priceRow) {
            return [
                'cost' => $priceRow['cost'],
                'item_id' => $priceRow['item_id'],
                'item_name' => $priceRow['item_name'],
                'size' => $priceRow['size'],
                'size_id' => $priceRow['size_id'],
            ];
        }

        return [
            'cost' => 0,
            'item_id' => '',
            'item_name' => '',
            'size' => '',
            'size_id' => '',
        ];
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
        $refCode = $this->request->getPost('refCode');
        $timeObject = \CodeIgniter\I18n\Time::createFromFormat('h:i A', $this->request->getPost('picking_time'));
        $formattedTime = $timeObject->format('H:i:s');
        
        // Check if there are already three bookings for the given picking_date, picking_time, and status
        $bookingModel = new BookingsModel();
    
        $bookingScheduled = $bookingModel
            ->where('status', 'Scheduled')
            ->where('reference_code', $refCode)
            ->countAllResults();
            
        // Check if $booking_id is empty
        if ($bookingScheduled > 0) {
            $response = [
                'status' => 'error',
                'message' => 'You already scheduled this booking! Contact Us to reschedule it!',
            ];
    
            return $this->response->setJSON($response);
        }
    
        // Fetch the booking_id based on the provided refCode
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
                'message' => 'Cannot schedule more than three bookings for the selected date and time.',
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
        
        $aresult = $aModel->where('booking_id', $booking_id)->first();
        
        $data = array_merge($data, $aresult);
        $email = \Config\Services::email();
        
        $email->setFrom('testing@braveegg.com', 'Epic Storage Solutions');
        $email->setTo($aresult['email_address']);
        $email->setSubject('EPIC Pickup Confirmation');
        
        $email->setMailType('html');
        
        $emailContent = view('email_templates/pickup_confirmation', ['result' => $data]);
        $email->setMessage($emailContent);
        
        $email->send();
        //echo $email->printDebugger();        
    } 
}