<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingsModel;
use App\Models\BookingItemsModel;
use App\Models\AccountInformationsModel;
use App\Models\ServiceInformationsModel;
use App\Models\admin\DropOffModel;
use App\Models\admin\ItemsModel;
use App\Models\admin\SizesModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Dompdf\Dompdf;
use Dompdf\Options;
use CodeIgniter\I18n\Time;

class BookingDetailsController extends BaseController
{

    public function index($bookingId)
    {
        // Check if the user is logged in
        if (!session()->has('user_id')) {
            return redirect()->to('/admin/login');
        }

        $bookingsModel = new BookingsModel();
        $bookingItemsModel = new BookingItemsModel();
        $accountInformationsModel = new AccountInformationsModel();
        $serviceInformationsModel = new ServiceInformationsModel();
        $itemsModel = new ItemsModel();
        $dropOffModel = new DropOffModel();
        $bookingDetails = $bookingsModel->find($bookingId);
        $bookingItemDetails = $bookingItemsModel
        ->select('booking_items.*, items.item_name, sizes.size, sizes.cost')
        ->join('items', 'items.item_id = booking_items.item_id', 'left')
        ->join('sizes', 'sizes.size_id = booking_items.size_id', 'left')
        ->where('booking_items.booking_id', $bookingId)
        ->findAll();
        $accountInformationDetails = $accountInformationsModel
        ->select('account_informations.*, dorms.dorm_name')
        ->join('bookings', 'bookings.account_information_id = account_informations.account_information_id', 'left')
        ->join('dorms', 'dorms.dorm_id = account_informations.dorm_id', 'left')
        ->where('bookings.booking_id', $bookingId)
        ->first();
        $dropOffDetails = $dropOffModel
        ->select('drop_off.*, dorms.dorm_name')
        ->join('bookings', 'bookings.account_information_id = drop_off.account_information_id', 'left')
        ->join('dorms', 'dorms.dorm_id = drop_off.dorm_id', 'left')
        ->where('bookings.booking_id', $bookingId)
        ->first();
        $serviceInformationDetails = $serviceInformationsModel->where('booking_id', $bookingId)->findAll();

        $data = [
            'title' => 'Booking Details |  Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
            'session' => \Config\Services::session(),
            'activelink' => 'bookings',
            'bookingDetails' => $bookingDetails,
            'accountInformationDetails' => $accountInformationDetails,
            'dropOffDetails' => $dropOffDetails,
            'serviceInformationDetails' => $serviceInformationDetails,
            'bookingItemDetails' => $bookingItemDetails,
            'booking_id' => $bookingId,
            'item' => $itemsModel->findAll(),
        ];
        return view('pages/admin/bookingdetails', $data);
    }
    public function updatePickUpDate()
    {
        $booking_id = $this->request->getPost('booking_id');
        $picking_date = $this->request->getPost('picking_date');

        // Validate or sanitize data if needed

        $bookingModel = new BookingsModel(); // Adjust based on your actual model class
        $updated = $bookingModel->update($booking_id, ['picking_date' => $picking_date]);

        if ($updated) {
            $response = ['success' => true, 'message' => 'Pickup date updated successfully'];
        } else {
            $response = ['success' => false, 'message' => 'Failed to update pickup date'];
        }

        return $this->response->setJSON($response);
    }
    public function updatePickUpTime()
    {
        $booking_id = $this->request->getPost('booking_id');
        $timeObject = Time::createFromFormat('g:i A', $this->request->getPost('picking_time'));
        $picking_time = $timeObject->format('H:i:s');
    
        // Validate or sanitize data if needed
    
        $bookingModel = new BookingsModel(); // Adjust based on your actual model class
        $updated = $bookingModel->update($booking_id, ['picking_time' => $picking_time]);
    
        if ($updated) {
            $response = ['success' => true, 'message' => 'Pickup time updated successfully'];
        } else {
            $response = ['success' => false, 'message' => 'Failed to update pickup time'];
        }
    
        return $this->response->setJSON($response);
    }
    public function updateRowInWarehouse()
    {
        $booking_id = $this->request->getPost('booking_id');
        $row_in_warehouse = $this->request->getPost('row_in_warehouse');
    
        // Validate or sanitize data if needed
    
        $bookingModel = new BookingsModel(); // Adjust based on your actual model class
        $updated = $bookingModel->update($booking_id, ['row_in_warehouse' => $row_in_warehouse]);
    
        if ($updated) {
            $response = ['success' => true, 'message' => 'Row in warehouse updated successfully'];
        } else {
            $response = ['success' => false, 'message' => 'Failed to update row in warehouse'];
        }
    
        return $this->response->setJSON($response);
    }
    public function deleteBookingItem()
    {
        $bookingItemId = $this->request->getPost('booking_item_id');
    
        // Load your model (adjust the namespace and class name based on your actual model)
        $bookingItemsModel = new BookingItemsModel();
    
        // Get the booking_id before deletion
        $bookingId = $this->request->getPost('booking_id');
    
        // Check if the item exists before attempting deletion
        $existingItem = $bookingItemsModel->find($bookingItemId);
    
        if (!$existingItem) {
            return $this->response->setJSON(['success' => false, 'message' => 'Item not found']);
        }
    
        // Perform deletion logic
        $deleted = $bookingItemsModel->delete($bookingItemId);
    
        if ($deleted) {
            // Calculate the new total amount
            $totalAmount = $this->calculateTotalAmount($bookingId);
    
            // Check if the student is studying abroad
            $serviceInformationsModel = new ServiceInformationsModel();
            $isStudyingAbroad = $serviceInformationsModel->where('booking_id', $bookingId)->get()->getRow()->is_studying_abroad;
    
            // If the student is studying abroad, multiply the total amount by 2
            if ($isStudyingAbroad == 'Yes') {
                $totalAmount *= 2;
            }
    
            // Update the total_amount in the bookings table
            $bookingModel = new BookingsModel();
            $bookingModel->update($bookingId, ['total_amount' => $totalAmount]);
    
            // Return a success response
            return $this->response->setJSON(['success' => true, 'message' => 'Item deleted successfully']);
        } else {
            // Return an error response
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete item']);
        }
    }
    private function calculateTotalAmount($bookingId)
    {
        $bookingItemsModel = new BookingItemsModel();

        // Sum the totalamount column for the given booking_id
        $totalAmount = $bookingItemsModel
            ->selectSum('totalamount')
            ->where('booking_id', $bookingId)
            ->get()
            ->getRow()
            ->totalamount;
        $total = $totalAmount + 425;
        return $total;
    }
    public function getSizes()
    {
        $itemId = $this->request->getGet('item_id');
        $sizesModel = new SizesModel();
        $sizes = $sizesModel
                ->where('item_id', $itemId)
                ->findAll();
        return $this->response->setJSON($sizes);
    }
    public function sizeAmount()
    {
        $sizeId = $this->request->getGet('size_id');
        $sizesModel = new SizesModel();
        $sizes = $sizesModel
                ->select('cost')
                ->where('size_id', $sizeId)
                ->first();
        return $this->response->setJSON($sizes);
    }
    public function insertBookingDetails()
    {
        $data = [
            'booking_id' => $this->request->getPost('booking_id'),
            'item_id' => $this->request->getPost('item_id'),
            'size_id' => $this->request->getPost('size_id'),
            'quantity' => $this->request->getPost('quantity'),
            'price' => $this->request->getPost('price'),
            'totalamount' => $this->request->getPost('totalamount'),
            'order_date' => date('Y-m-d')
        ];
    
        $bookingDetailsModel = new BookingItemsModel();
        $insertedId = $bookingDetailsModel->insert($data);
        
        $totalAmount = $this->calculateTotalAmount($this->request->getPost('booking_id'));
    
        // Check if the student is studying abroad
        $serviceInformationsModel = new ServiceInformationsModel();
        $isStudyingAbroad = $serviceInformationsModel->where('booking_id', $this->request->getPost('booking_id'))->get()->getRow()->is_studying_abroad;

        // If the student is studying abroad, multiply the total amount by 2
        if ($isStudyingAbroad == 'Yes') {
            $totalAmount *= 2;
        }

        // Update the total_amount in the bookings table
        $bookingModel = new BookingsModel();
        $bookingModel->update($this->request->getPost('booking_id'), ['total_amount' => $totalAmount]);

        // Retrieve the inserted row data for response
        $insertedRow = $bookingDetailsModel
                    ->select('booking_items.*, items.item_name, sizes.size')
                    ->join('items', 'items.item_id = booking_items.item_id')
                    ->join('sizes', 'sizes.size_id = booking_items.size_id')
                    ->find($insertedId);
    
        return $this->response->setJSON($insertedRow);
    }
    public function finalTotalAmount()
    {
        $bookingsModel = new BookingsModel();
        
        $bookingId = $this->request->getPost('booking_id');
        // Sum the totalamount column for the given booking_id
        $totalAmount = $bookingsModel
            ->select('total_amount')
            ->where('booking_id', $bookingId)
            ->get()
            ->getRow()
            ->total_amount;
        return $totalAmount;
    }
    public function updateBookingItemDetails()
    {
        // Retrieve data from the Ajax request
        $bookingItemId = $this->request->getPost('booking_item_id');
        $newQuantity = $this->request->getPost('new_quantity');

        // Fetch the existing booking item details
        $bookingDetailsModel = new BookingItemsModel();
        $bookingItem = $bookingDetailsModel->find($bookingItemId);

        // Calculate the new total amount based on the new quantity
        $newTotalAmount = $newQuantity * $bookingItem['price'];

        // Update the database with the new quantity and total amount
        $data = [
            'quantity' => $newQuantity,
            'totalamount' => $newTotalAmount,
        ];
        $bookingDetailsModel->update($bookingItemId, $data);

        
        $totalAmount = $this->calculateTotalAmount($this->request->getPost('booking_id'));
    
        // Check if the student is studying abroad
        $serviceInformationsModel = new ServiceInformationsModel();
        $isStudyingAbroad = $serviceInformationsModel->where('booking_id', $this->request->getPost('booking_id'))->get()->getRow()->is_studying_abroad;

        // If the student is studying abroad, multiply the total amount by 2
        if ($isStudyingAbroad == 'Yes') {
            $totalAmount *= 2;
        }

        // Update the total_amount in the bookings table
        $bookingModel = new BookingsModel();
        $bookingModel->update($this->request->getPost('booking_id'), ['total_amount' => $totalAmount]);

        // Return the updated data for the Ajax response
        $updatedData = [
            'new_quantity' => $newQuantity,
            'new_total_amount' => $newTotalAmount,
        ];

        return $this->response->setJSON($updatedData);
    }
    public function updateAdminNotes()
    {
        // Retrieve data from the Ajax request
        $bookingId = $this->request->getPost('booking_id');
        $adminNotes = $this->request->getPost('admin_notes');

        // Update the database with the new admin notes
        $bookingsModel = new BookingsModel();
        $data = [
            'admin_notes' => $adminNotes,
        ];
        $bookingsModel->update($bookingId, $data);

        // Return a success response
        return $this->response->setJSON(['status' => 'success']);
    }
    public function updateBalanceStatus()
    {
        $bookingItemId = $this->request->getPost('booking_item_id');
        $isChecked = filter_var($this->request->getPost('is_checked'), FILTER_VALIDATE_BOOLEAN);

        $bookingItemModel = new BookingItemsModel();

        $updateData = ['is_balanced' => ($isChecked) ? 'Yes' : ''];

        $bookingItemModel->update($bookingItemId, $updateData);

        // Respond to the AJAX request
        echo json_encode(['status' => 'success']);
    }
    public function test()
    {
        $itemsModel = new ItemsModel();
        $item = $itemsModel->findAll();
        foreach($item as $items) {
            echo $items['item_id'].'<br/>';
        }
    }
}
