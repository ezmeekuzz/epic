<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MessagesModel;

class ContactController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Contact Us | Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
        ];
        return view('pages/contact', $data);
    }
    public function sendMessage()
    {
        $validationRules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'email' => 'required|valid_email',
            'message' => 'required'
        ];

        if ($this->validate($validationRules)) {
            // Form validation passed, handle form submission
            // You can access the form data using $this->request->getPost('fieldname')
            
            // Example: Send an email, save to the database, etc.
            $data = [
                'firstname' => $this->request->getPost('firstname'),
                'lastname' => $this->request->getPost('lastname'),
                'phone' => $this->request->getPost('phone'),
                'email' => $this->request->getPost('email'),
                'message' => $this->request->getPost('message'),
                'messagedate' => date('Y-m-d')
            ];

            $messageModel = new MessagesModel();

            $messageModel->insert($data);
            
            // Return a success message
            return json_encode(['status' => 'success', 'message' => 'Form submitted successfully']);
        } else {
            // Form validation failed, return error messages
            $errors = $this->validator->getErrors();
            return json_encode(['status' => 'error', 'message' => implode('<br>', $errors)]);
        }
    }
}
