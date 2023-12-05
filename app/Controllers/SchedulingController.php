<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\admin\DormsModel;
use App\Models\admin\ItemsModel;
use App\Models\admin\SizesModel;

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
    public function intro() {
        $data = [
            'title' => 'Scheduling - Step 1 | Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
        ];
        return view('pages/intro', $data);
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
    public function serviceInformation() {
        $itemModel = new ItemsModel();
        $iresult = $itemModel->findAll();
        $data = [
            'title' => 'Scheduling - Service Information | Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
            'records' => $iresult
        ];
        return view('pages/service-information', $data);
    }
    public function getSizes()
    {
        $itemId = $this->request->getPost('item_id');
        $sizeModel = new SizesModel(); // Replace with your actual size model
        $sizes = $sizeModel->where('item_id', $itemId)->findAll();
    
        // Return sizes as JSON
        return $this->response->setJSON(['sizes' => $sizes]);
    }
    // Scheduling controller
    public function calculateTotal()
    {
        $item = $this->request->getPost('item');
        $size = $this->request->getPost('size');
        $quantity = $this->request->getPost('quantity');

        // Implement your logic to calculate the total based on the item, size, and quantity
        // For simplicity, let's assume the price is hardcoded based on the item and size
        $priceData = $this->getPriceByItemAndSize($item, $size);
        $price = $priceData['cost'];
        $item_name = $priceData['item_name'];
        $size = $priceData['size'];

        $total = $price * $quantity;

        // Return the total, item_name, and size as JSON
        return $this->response->setJSON([
            'total' => $total,
            'item_name' => $item_name,
            'size' => $size,
        ]);
    }
    // Helper method to get the price based on the item and size (replace with your actual logic)
    private function getPriceByItemAndSize($item, $size)
    {
        $sizeModel = new SizesModel(); // Replace with your actual size model
        // Assuming you have a 'price' column in your 'sizes' table
        $priceRow = $sizeModel
            ->select('sizes.cost, sizes.size, items.item_name')
            ->join('items', 'items.item_id = sizes.item_id')
            ->where('items.item_id', $item)
            ->where('sizes.size_id', $size)
            ->first(); // Assuming you expect only one result

        // Check if the row was found
        if ($priceRow) {
            return [
                'cost' => $priceRow['cost'],
                'item_name' => $priceRow['item_name'],
                'size' => $priceRow['size'],
            ];
        }

        return [
            'cost' => 0, // Default to 0 if not found
            'item_name' => '',
            'size' => '',
        ];
    }
}