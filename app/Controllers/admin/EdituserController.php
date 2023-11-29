<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\admin\UsersModel;

class EdituserController extends BaseController
{
    protected $bName = 'App\Models\admin\UsersModel';

    public function index($id)
    {
        // Check if the user is logged in
        if (!session()->has('user_id')) {
            return redirect()->to('/admin/login');
        }

        $uModel = new UsersModel();
        $uresult = $uModel->where('user_id', $id)->findAll();

        $data = [
            'title' => 'Edit User | Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
            'session' => \Config\Services::session(),
            'activelink' => 'usermasterlist',
            'records' => $uresult,
        ];
        return view('pages/admin/edituser', $data);
    }    
    public function update()
    {
        $user_id = $this->request->getPost('user_id');
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
        $excludedIds = [$user_id];
        $userList = $userModel->where('username', $username)
                              ->whereNotIn('user_id', $excludedIds)
                              ->first();
        $userFilter = $userModel->where('user_id', $user_id)->first();
        if($userList) {
            $response = [
                'status' => 'existed',
                'message' => 'Username is not available',
            ];
        }
        else {
            $userId = $userModel->update($user_id, $data);
            $response = [
                'status' => 'success',
                'message' => 'User updated successfully!',
            ];
        }

        return $this->response->setJSON($response);
    }
}
