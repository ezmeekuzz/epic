<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\admin\UsersModel;

class AdduserController extends BaseController
{
    protected $gsmName = 'App\Models\admin\GeneralsettingsModel';
    protected $uName = 'App\Models\admin\UsersModel';

    public function index()
    {
        // Check if the user is logged in
        if (!session()->has('user_id')) {
            return redirect()->to('/admin/login');
        }
        
        $data = [
            'title' => 'Add User | Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
            'session' => \Config\Services::session(),
            'activelink' => 'adduser'
        ];
        return view('pages/admin/adduser', $data);
    }
    public function insert()
    {
        $data = [
            'firstname' => $this->request->getPost('firstname'),
            'lastname' => $this->request->getPost('lastname'),
            'emailaddress' => $this->request->getPost('emailaddress'),
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'usertype' => $this->request->getPost('usertype'),
            'encryptedpass' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
        ];
        $username = $this->request->getPost('username');
        $userModel = new UsersModel();
        $userList = $userModel->where('username', $username)->first();
        if($userList) {
            $response = [
                'status' => 'existed',
                'message' => 'Username is not available',
            ];
        }
        else {
            $userId = $userModel->insert($data);
    
            if ($userId) {
                $response = [
                    'status' => 'success',
                    'message' => 'User added successfully!',
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Failed to add user.',
                ];
            }
        }

        return $this->response->setJSON($response);
    }
}
