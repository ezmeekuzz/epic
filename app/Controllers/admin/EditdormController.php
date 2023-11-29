<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\admin\DormsModel;

class EditdormController extends BaseController
{
    protected $bName = 'App\Models\admin\DormsModel';

    public function index($id)
    {
        // Check if the user is logged in
        if (!session()->has('user_id')) {
            return redirect()->to('/admin/login');
        }

        $dModel = new DormsModel();
        $dresult = $dModel->where('dorm_id', $id)->findAll();

        $data = [
            'title' => 'Edit Dorm | Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
            'session' => \Config\Services::session(),
            'activelink' => 'dormmasterlist',
            'records' => $dresult,
        ];
        return view('pages/admin/editdorm', $data);
    }    
    public function update()
    {
        $dorm_id = $this->request->getPost('dorm_id');
        $data = [
            'dorm_name' => $this->request->getPost('dorm_name'),
        ];
        $dormModel = new dormsModel();
        $dormId = $dormModel->update($dorm_id, $data);
        $response = [
            'status' => 'success',
            'message' => 'Dorm updated successfully!',
        ];

        return $this->response->setJSON($response);
    }
}
