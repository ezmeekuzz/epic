<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\admin\ItemsModel;
use App\Models\admin\SizesModel;

class AdditemController extends BaseController
{
    protected $sName = 'App\Models\admin\SizesModel';
    protected $iName = 'App\Models\admin\ItemsModel';

    public function index()
    {
        // Check if the user is logged in
        if (!session()->has('user_id')) {
            return redirect()->to('/admin/login');
        }
        
        $data = [
            'title' => 'Add Item | Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
            'session' => \Config\Services::session(),
            'activelink' => 'additem'
        ];
        return view('pages/admin/additem', $data);
    }
    public function insert()
    {
    
        // Insert item into 'items' table
        $itemData = [
            'item_name' => $this->request->getPost('item_name'),
        ];
    
        $itemModel = new ItemsModel();
        $itemId = $itemModel->insert($itemData);
    
        if ($itemId) {
            // Insert sizes into 'sizes' table
            $sizeData = [];
            $sizes = $this->request->getPost('size');
            $costs = $this->request->getPost('cost');
    
            $sizeCount = count($sizes);
    
            for ($index = 0; $index < $sizeCount; $index++) {
                $sizeData[] = [
                    'item_id' => $itemId,
                    'size'    => $sizes[$index],
                    'cost'    => $costs[$index],
                ];
            }
    
            // Assuming you have a SizeModel
            $sizeModel = new SizesModel();
            $sizeModel->insertBatch($sizeData);
    
            $response = [
                'status'  => 'success',
                'message' => 'Item and sizes added successfully!',
            ];
        } else {
            $response = [
                'status'  => 'error',
                'message' => 'Failed to add item.',
            ];
        }
    
        return $this->response->setJSON($response);
    }    
}
