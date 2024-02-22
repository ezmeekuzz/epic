<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccountInformationsModel;

class LoginController extends BaseController
{
    public function index()
    {
        // Check if the user is logged in
        if (session()->has('account_information_id')) {
            return redirect()->to('/services');
        }
        $data = [
            'title' => 'Login | Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
        ];
        return view('pages/login', $data);
    }
    public function loginfunc() 
    {
        $accountModel = new AccountInformationsModel();

        $email_address = $this->request->getPost('email_address');
        $password = $this->request->getPost('password');

        $result = $accountModel->where('email_address', $email_address)->first();

        if ($result && password_verify($password, $result['password'])) {
            session()->set('account_information_id', $result['account_information_id']);
            session()->set('first_name', $result['first_name']);
            session()->set('last_name', $result['last_name']);
            session()->set('email_address', $result['email_address']);
            return redirect()->to('/services');
        } else {
            return redirect()->back()->with('error', 'Invalid login credentials');
        }
    }
}
