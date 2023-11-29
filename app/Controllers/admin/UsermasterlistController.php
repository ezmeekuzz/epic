<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\admin\UsersModel;

class UsermasterlistController extends BaseController
{
    protected $uName = 'App\Models\admin\UsersModel';

    public function index()
    {
        // Check if the user is logged in
        if (!session()->has('user_id')) {
            return redirect()->to('/admin/login');
        }

        $uModel = new UsersModel();
        $uresult = $uModel->findAll();

        $data = [
            'title' => 'User Masterlist |  Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
            'session' => \Config\Services::session(),
            'records' => $uresult,
            'activelink' => 'usermasterlist'
        ];
        return view('pages/admin/usermasterlist', $data);
    }
    public function delete($id)
    {
        // Delete the data from the database
        $uModel = new UsersModel();
        $item = $uModel->find($id);

        if ($item) {
            // Delete associated image if it exists
            if (!empty($item['userimage'])) {
                unlink(ROOTPATH . 'uploads' . $item['userimage']);
            }
            $uModel->delete($id);
        }
        // Return a JSON response indicating success
        return $this->response->setJSON(['status' => 'success']);
    }
}
