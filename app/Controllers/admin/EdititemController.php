<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\admin\ItemsModel;
use App\Models\admin\SizesModel;

class EdititemController extends BaseController
{
    protected $iName = 'App\Models\admin\ItemsModel';
    protected $sName = 'App\Models\admin\SizesModel';

    public function index($id)
    {
        // Check if the user is logged in
        if (!session()->has('user_id')) {
            return redirect()->to('/admin/login');
        }

        $iModel = new ItemsModel();
        $iresult = $iModel->find($id);

        $sModel = new SizesModel();
        $sresult = $sModel->where('item_id', $id)->findAll();

        $data = [
            'title' => 'Edit Item | Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
            'session' => \Config\Services::session(),
            'activelink' => 'itemmasterlist',
            'record' => $iresult,
            'sizes' => $sresult,
        ];
        return view('pages/admin/edititem', $data);
    }    
    public function update()
    {
        $itemId = $this->request->getPost('item_id');
        
        // Update item details
        $itemModel = new ItemsModel();
        $data = [
            'item_name' => $this->request->getPost('item_name'),
        ];
        $itemModel->update($itemId, $data);
    
        // Delete existing sizes for the item
        $sizeModel = new SizesModel();
        $sizeModel->where('item_id', $itemId)->delete();
    
        // Insert new sizes
        $newSizes = $this->request->getPost('size');
        $newCosts = $this->request->getPost('cost');
    
        foreach ($newSizes as $index => $size) {
            $sizeData = [
                'item_id' => $itemId,
                'size' => $size,
                'cost' => $newCosts[$index],
            ];
            $sizeModel->insert($sizeData);
        }
    
        $response = [
            'status' => 'success',
            'message' => 'Item and sizes updated successfully!',
        ];
    
        return $this->response->setJSON($response);
    }    
}
