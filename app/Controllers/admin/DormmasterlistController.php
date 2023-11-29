<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\admin\DormsModel;

class DormmasterlistController extends BaseController
{
    protected $uName = 'App\Models\admin\DormsModel';

    public function index()
    {
        // Check if the user is logged in
        if (!session()->has('user_id')) {
            return redirect()->to('/admin/login');
        }

        $dModel = new DormsModel();
        $dresult = $dModel->findAll();

        $data = [
            'title' => 'Dorm Masterlist |  Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
            'session' => \Config\Services::session(),
            'records' => $dresult,
            'activelink' => 'dormmasterlist'
        ];
        return view('pages/admin/dormmasterlist', $data);
    }
    public function delete($id)
    {
        // Delete the data from the database
        $dModel = new DormsModel();
        $item = $dModel->find($id);

        if ($item) {
            $dModel->delete($id);
        }
        // Return a JSON response indicating success
        return $this->response->setJSON(['status' => 'success']);
    }
}
