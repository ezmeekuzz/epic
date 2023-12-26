<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\admin\UsersModel;
use CodeIgniter\API\ResponseTrait;

class LoginController extends BaseController
{
    public function index()
    {
        // Check if the user is logged in
        if (session()->has('user_id')) {
            return redirect()->to('/admin/bookings');
        }
        $data = [
            'title' => 'Login | Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
        ];
        return view('pages/admin/login', $data);
    }
    public function loginfunc() 
    {
        $userModel = new UsersModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $result = $userModel->where('username', $username)->first();

        if ($result && password_verify($password, $result['encryptedpass'])) {
            session()->set('user_id', $result['user_id']);
            session()->set('firstname', $result['firstname']);
            session()->set('lastname', $result['lastname']);
            session()->set('emailaddress', $result['emailaddress']);
            return redirect()->to('/admin/bookings');
        } else {
            return redirect()->back()->with('error', 'Invalid login credentials');
        }
    }
}
