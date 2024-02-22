<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\admin\DropOffModel;
use App\Models\BookingsModel;
use App\Models\BookingItemsModel;
use App\Models\AccountInformationsModel;
use App\Models\ServiceInformationsModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class DropOffController extends BaseController
{
    protected $uName = 'App\Models\admin\DormsModel';

    public function index()
    {
        // Check if the user is logged in
        if (!session()->has('user_id')) {
            return redirect()->to('/admin/login');
        }

        $dModel = new DropOffModel();
        $dresult = $dModel
                ->join('account_informations', 'account_informations.account_information_id = drop_off.account_information_id', 'left')
                ->join('dorms', 'dorms.dorm_id = drop_off.dorm_id', 'left')
                ->findAll();

        $data = [
            'title' => 'Drop Off Masterlist |  Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
            'session' => \Config\Services::session(),
            'records' => $dresult,
            'activelink' => 'dropoff'
        ];
        return view('pages/admin/dropoffmasterlist', $data);
    }
    public function delete($id)
    {
        // Delete the data from the database
        $dModel = new DropOffModel();
        $item = $dModel->find($id);

        if ($item) {
            $dModel->delete($id);
        }
        // Return a JSON response indicating success
        return $this->response->setJSON(['status' => 'success']);
    }
    public function generatePdf($dropOffId)
    {
        $path = 'assets/images/Logo-header.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        
        $dOModel = new DropOffModel();
        $bookingsModel = new BookingsModel();
        $bookingItemsModel = new BookingItemsModel();
        $accountInformationsModel = new AccountInformationsModel();
        $serviceInformationsModel = new ServiceInformationsModel();
        
        $bookingDetails = $dOModel
            ->select('drop_off.*, bookings.*, account_informations.*, dorms.*, dorms.dorm_name as dormName')
            ->join('bookings', 'bookings.booking_id = drop_off.booking_id')
            ->join('account_informations', 'account_informations.account_information_id = drop_off.account_information_id')
            ->join('dorms', 'dorms.dorm_id = drop_off.dorm_id', 'left')
            ->find($dropOffId);
        $bookingId = $bookingDetails['booking_id'];
        $bookingItemDetails = $bookingItemsModel
        ->select('booking_items.*, items.item_name, sizes.size, sizes.cost')
        ->join('items', 'items.item_id = booking_items.item_id', 'left')
        ->join('sizes', 'sizes.size_id = booking_items.size_id', 'left')
        ->where('booking_items.booking_id', $bookingId)
        ->findAll();
        $accountInformationDetails = $accountInformationsModel
        ->select('account_informations.*, dorms.dorm_name')
        ->join('bookings', 'bookings.account_information_id = account_informations.account_information_id', 'left')
        ->join('dorms', 'dorms.dorm_id = account_informations.dorm_id', 'left')
        ->where('bookings.booking_id', $bookingId)
        ->first();
        $serviceInformationDetails = $serviceInformationsModel->where('booking_id', $bookingId)->first();

        $data = [
            'bookingDetails' => $bookingDetails,
            'accountInformationDetails' => $accountInformationDetails,
            'bookingItemDetails' => $bookingItemDetails,
            'serviceInformationDetails' => $serviceInformationDetails,
            'logo' => $base64
        ];
        // Load the Dompdf library
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);

        // HTML content for the PDF
        $html = view('components/printDropOff', $data);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // Set paper size (optional)
        $dompdf->setPaper('letter', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF
        $dompdf->stream('document.pdf', ['Attachment' => false]);
    }
}
