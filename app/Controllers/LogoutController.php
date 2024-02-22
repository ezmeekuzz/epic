<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class LogoutController extends BaseController
{
    public function index()
    {
        session()->remove(['account_information_id', 'first_name', 'last_name', 'email_address']);
        return redirect()->to('/login');
    }
}
