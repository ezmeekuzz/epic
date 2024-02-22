<?php

namespace App\Controllers;
use App\Models\admin\DormsModel;
use App\Models\AccountInformationsModel;

use App\Controllers\BaseController;

class SignupController extends BaseController
{
    public function index()
    {
        // Check if the user is logged in
        if (session()->has('account_information_id')) {
            return redirect()->to('/services');
        }
        $dormModel = new DormsModel();
        $dresult = $dormModel->findAll();

        $data = [
            'title' => 'Sign Up | Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
            'records' => $dresult,
        ];
        return view('pages/signup', $data);
    }    
    public function insert()
    {
        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'student_id' => $this->request->getPost('student_id'),
            'phone_number' => $this->request->getPost('phone_number'),
            'email_address' => $this->request->getPost('email_address'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'dorm_id' => $this->request->getPost('dorm_id'),
            'dorm_room_number' => $this->request->getPost('dorm_room_number'),
            'street_name' => $this->request->getPost('street_name'),
            'street_number' => $this->request->getPost('street_number'),
            'parent_phone_number' => $this->request->getPost('parent_phone_number'),
            'parent_email_address' => $this->request->getPost('parent_email_address'),
        ];
        $accountModel = new AccountInformationsModel();
        $accountId = $accountModel->insert($data);
    
        if ($accountId) {
            $response = [
                'status' => 'success',
                'message' => 'Successfully Signed Up!',
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
