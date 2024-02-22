<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingsModel;

class CalendarSchedulesController extends BaseController
{

    public function index()
    {
        // Check if the user is logged in
        if (!session()->has('user_id')) {
            return redirect()->to('/admin/login');
        }

        $data = [
            'title' => 'Calendar Schedules |  Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
            'session' => \Config\Services::session(),
            'activelink' => 'calendarschedules'
        ];
        return view('pages/admin/calendarschedules', $data);
    }
    public function Lists()
    {
        $bookingModel = new BookingsModel();
        
        $eventsData = $bookingModel->where('status', 'Scheduled')->findAll();
        
        $events = [];
        foreach ($eventsData as $event) {
            // Assuming 'picking_date' and 'picking_time' are in a format compatible with FullCalendar
            $startDateTime = $event['picking_date'] . 'T' . date('H:i:s', strtotime($event['picking_time']));
            
            // Creating an event object with required properties
            $events[] = [
                'title' => 'Reference Code: ' . $event['reference_code'],
                'start' => $startDateTime,
                'url' => '/admin/booking-details/' . $event['booking_id'],
            ];
        }
    
        // Returning events data as JSON response
        return $this->response->setJSON($events);
    }
}
