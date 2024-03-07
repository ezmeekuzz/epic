<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccountInformationsModel;

class ChangePasswordController extends BaseController
{
    public function index()
    {
        $email_address = $this->request->getGet('email');
        $studentId = $this->request->getGet('student_id');
        $data = [
            'title' => 'Change Password | Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
            'emailAddress' => $email_address,
            'studentId' => $studentId,
        ];
        return view('pages/changepassword', $data);
    }
    public function updatePassword()
    {
        $accountModel = new AccountInformationsModel();
        $emailAddress = $this->request->getPost('emailAddress');
        $studentId = $this->request->getPost('studentId');
        $password = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);
        $data = [
            'password' => $password
        ];
    
        $accountId = $accountModel
            ->set($data)
            ->where('email_address', $emailAddress)
            ->where('student_id', $studentId)
            ->update();
    
        return redirect()->back()->with('success', 'You successfully changed your password!');
    }
}
