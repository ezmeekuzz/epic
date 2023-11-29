<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\admin\DormsModel;

class AdddormController extends BaseController
{
    protected $gsmName = 'App\Models\admin\GeneralsettingsModel';
    protected $uName = 'App\Models\admin\DormsModel';

    public function index()
    {
        // Check if the user is logged in
        if (!session()->has('user_id')) {
            return redirect()->to('/admin/login');
        }
        
        $data = [
            'title' => 'Add Dorm | Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
            'session' => \Config\Services::session(),
            'activelink' => 'adddorm'
        ];
        return view('pages/admin/adddorm', $data);
    }
    public function insert()
    {
        $data = [
            'dorm_name' => $this->request->getPost('dorm_name'),
        ];
        $dormModel = new DormsModel();
        $dormId = $dormModel->insert($data);
    
        if ($dormId) {
            $response = [
                'status' => 'success',
                'message' => 'Dorm added successfully!',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to add dorm.',
            ];
        }

        return $this->response->setJSON($response);
    }
}
