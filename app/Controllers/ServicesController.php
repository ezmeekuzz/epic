<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ServicesController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Services | Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
        ];
        return view('pages/services', $data);
    }
    public function summerStorageSession() 
    {
        $session = session();
        $session->set('selectedService', 'summer-storage');
        return redirect()->to('/scheduling/account-information/'. $session->get('selectedService'));
    }
    public function summerAdvantageSession()
    {
        $session = session();
        $session->set('selectedService', 'summer-advantage');
        return redirect()->to('/scheduling/account-information/'. $session->get('selectedService'));
    }
}
