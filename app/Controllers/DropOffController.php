<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\admin\DropOffModel;
use App\Models\admin\DormsModel;
use App\Models\AccountInformationsModel;

class DropOffController extends BaseController
{
    public function index($referenceCode)
    {
        // Check if the user is logged in
        if (!session()->has('account_information_id')) {
            return redirect()->to('/login');
        }
        
        $dormModel = new DormsModel();
        $dOModel = new DropOffModel();
        $dresult = $dormModel->findAll();

        $filterDropOff = $dOModel
                    ->where('referenceCode', $referenceCode)
                    ->where('dropOffStatus', 'Pending')
                    ->first();

        if(!$filterDropOff) {
            return redirect()->to('/');
        }
        
        $data = [
            'title' => 'Drop Off | Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
            'records' => $dresult,
            'referenceCode' => $referenceCode
        ];
        return view('pages/drop-off', $data);
    }
    public function update()
    {
        $dOModel = new DropOffModel();
        $accountModel = new AccountInformationsModel();

        $referenceCode = $this->request->getPost('referenceCode');
        $filterDropOff = $dOModel
            ->where('referenceCode', $referenceCode)
            ->where('dropOffStatus', 'Pending')
            ->first();
        
        if ($filterDropOff) {
            $accountModel->update(
                $filterDropOff['account_information_id'],
                [
                    'first_name' => $this->request->getPost('firstName'),
                    'last_name' => $this->request->getPost('lastName'),
                    'student_id' => $this->request->getPost('studentNumber'),
                    'street_name' => $this->request->getPost('streetName'),
                    'street_number' => $this->request->getPost('streetNumber'),
                    'dorm_room_number' => $this->request->getPost('roomNumber'),
                ]
            );
        } else {
            log_message('error', 'Drop-off record not found for reference code: ' . $referenceCode);
        }        

        $data = [
            'firstName' => $this->request->getPost('firstName'),
            'lastName' => $this->request->getPost('lastName'),
            'studentNumber' => $this->request->getPost('studentNumber'),
            'streetName' => $this->request->getPost('streetName'),
            'streetNumber' => $this->request->getPost('streetNumber'),
            'dorm_id' => $this->request->getPost('dorm_id'),
            'roomNumber' => $this->request->getPost('roomNumber'),
            'returnDate' => $this->request->getPost('returnDate'),
            'dropOffStatus' => 'Scheduled'
        ];

        $dOModel->set($data)->where('referenceCode', $this->request->getPost('referenceCode'))->update();

        $response = [
            'status' => 'success',
            'message' => 'Drop-off information updated successfully.',
        ];

        return $this->response->setJSON($response);
    }
}
