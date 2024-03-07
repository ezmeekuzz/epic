<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccountInformationsModel;

class ForgotPasswordController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Forgot Password | Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
        ];
        return view('pages/forgotpassword', $data);
    }
    public function sendEmail()
    {
        $accountInformationModel = new AccountInformationsModel();
        $emailAddress = $this->request->getPost('email_address');
    
        $accountInfo = $accountInformationModel
            ->where('email_address', $emailAddress)
            ->first();
    
        if ($accountInfo) {
    
            $email = \Config\Services::email();
    
            $email->setFrom('testing@braveegg.com', 'Epic Storage Solutions');
            $email->setTo($emailAddress);
            $email->setSubject('Change Password Request – EPIC Storage');
    
            $email->setMailType('html');
    
            $emailContent = '<a href="' . base_url() . 'change-password?email=' . $emailAddress . '&student_id=' . $accountInfo['student_id'] . '">Click this link to change your password!</a>';
            $email->setMessage($emailContent);
    
            $email->send();
            return redirect()->back()->with('success', 'We sent you an email. Check your email now!');
    
        } else {
            return redirect()->back()->with('error', 'Email Address Doesn\'t Exist');
        }
    }
}
