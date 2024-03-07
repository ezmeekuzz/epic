<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingsModel;
use App\Models\BookingItemsModel;
use App\Models\AccountInformationsModel;
use App\Models\ServiceInformationsModel;
use App\Models\admin\DropOffModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Dompdf\Dompdf;
use Dompdf\Options;

class BookingsController extends BaseController
{
    protected $bName = 'App\Models\BookingsModel';

    public function index()
    {
        
        if (!session()->has('user_id')) {
            return redirect()->to('/admin/login');
        }

        $bModel = new BookingsModel();
        $bresult = $bModel->findAll();

        $data = [
            'title' => 'Bookings |  Epic Storage Solutions',
            'description' => 'The mission of EPIC Storage Solutions is to provide High Point University students and parents with a convenient, accountable, and safe moving and storage experience. EPIC was established in 2009 and is locally owned and operated in High Point, NC by Anissa Roy. Anissa is a graduate of High Point College in the class 1991 and after a successful corporate career, her goal was to operating her own business. Over the last 13 plus years, we have had the opportunity to service 1000s of HPU students helping us to evolve into the company we are today. We pride ourselves in providing a high touch and always available experience. This approach allows us to directly engage in each customer relationship placing a personal touch on each parent and student experience.',
            'session' => \Config\Services::session(),
            'records' => $bresult,
            'activelink' => 'bookings'
        ];
        return view('pages/admin/bookings', $data);
    }
    public function delete($id)
    {
        $bModel = new BookingsModel();
        
        $booking = $bModel->find($id);
        
        if ($booking) {
            
            $bIModel = new BookingItemsModel();
            $bIModel->where('booking_id', $id)->delete();
            
            $sModel = new ServiceInformationsModel();
            $sModel->where('booking_id', $id)->delete();
            
            $bModel->delete($id);
    
            return $this->response->setJSON(['status' => 'success']);
        }
    
        return $this->response->setJSON(['status' => 'error', 'message' => 'Booking not found']);
    }    
    public function getData()
    {
        
        $bModel = new BookingsModel();
        
        $draw = $this->request->getPost('draw');
        $start = $this->request->getPost('start');
        $length = $this->request->getPost('length');
        $search = $this->request->getPost('search')['value'];
        
        $totalRecords = $bModel->countAll();
        
        $filteredRecords = $bModel
            ->like('card_holder_name', $search)
            ->orLike('serviceType', $search)
            ->limit($length, $start)
            ->findAll();
            
        $data = [
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => count($filteredRecords),
            'data' => $filteredRecords,
        ];
        
        return $this->response->setJSON($data);
    }
    public function updateStatus($id)
    {
        $bModel = new BookingsModel();
        $data = [
            'status' => 'Done',
        ];
        $bModel->update($id, $data);
    }
    
    public function exportToCsv()
    {
        $bModel = new BookingsModel();
        $bookingItemModel = new BookingItemsModel();

        $selectedIds = $this->request->getVar('selectedIds');
        $search = $this->request->getVar('search');
        
        if (!empty($selectedIds)) {
            
            $selectedIds = explode(',', $selectedIds);
            
            $bModel->whereIn('booking_id', $selectedIds);
        } elseif ($search !== null) {
            
            $bModel->like('card_holder_name', $search)
                   ->orLike('serviceType', $search);
        }
    
        $filteredRecords = $bModel
                        ->select('bookings.*, account_informations.*, drop_off.*, dorms.*, dorms.dorm_name as dorm_pick_up, drop_off_dorms.dorm_name as dorm_drop_off')
                        ->join('account_informations', 'account_informations.account_information_id = bookings.account_information_id', 'left')
                        ->join('drop_off', 'drop_off.booking_id = bookings.booking_id', 'left')
                        ->join('dorms as dorms', 'dorms.dorm_id = account_informations.dorm_id', 'left')
                        ->join('dorms as drop_off_dorms', 'drop_off_dorms.dorm_id = drop_off.dorm_id', 'left')
                        ->findAll();
        
        $csvData = [];
        foreach ($filteredRecords as $record) {

            $balancedOwed = $bookingItemModel
                        ->selectSum('totalamount', 'total_sum')
                        ->where('is_balanced', 'Yes')
                        ->where('booking_id', $record['booking_id'])
                        ->get()
                        ->getRow()->total_sum;
            $csvData[] = [
                $record['ordernumber'],
                $record['serviceType'],
                $record['first_name'],
                $record['last_name'],
                $record['student_id'],
                $record['email_address'],
                $record['phone_number'],
                $record['parent_email_address'],
                $record['parent_phone_number'],
                $record['dorm_pick_up'],
                !empty($record['picking_date']) ? date('F d, Y', strtotime($record['picking_date'])) : "N/A",
                $record['dorm_drop_off'],
                !empty($record['returnDate']) ? date('F d, Y', strtotime($record['returnDate'])) : "N/A",
                $balancedOwed,
            ];
        }
        
        $csvFileName = 'exported_data.csv';
        $csvFilePath = WRITEPATH . 'uploads/' . $csvFileName;
    
        $file = fopen($csvFilePath, 'w');
        fputcsv($file, ['Order #', 'Service Offering', 'First Name', 'last Name', 'Student ID', 'Student Email', 'Student Phone', 'Parent Email', 'Parent Phone', 'Pick Up Dorm', 'Pick Up Date', 'Drop Off Dorm', 'Drop Off Date', 'Balanced Owed']);
        foreach ($csvData as $data) {
            fputcsv($file, $data);
        }
        fclose($file);
        
        return $this->response->download($csvFilePath, null)->setFileName($csvFileName);
    }
    public function exportToExcel()
    {
        $bookingId = $this->request->getGet('bookingId');
        $accountInformationId = $this->request->getGet('accountInformationId');
    
        // Retrieve data based on the booking ID
        $getBookingDetails = $this->getBookingDetails($bookingId);
        $getBookingItems = $this->getBookingItems($bookingId);
        $getAccountInformations = $this->getAccountInformations($accountInformationId);
        $getServiceInformations = $this->getServiceInformations($bookingId);
    
        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->setTitle('Booking Details');
    
        // Set header style
        $headerStyle = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ];
    
        // Add logo
        $spreadsheet->getActiveSheet()->setCellValue('A1', '')->mergeCells('A1:B1');
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(60);
        
        $logoPath = FCPATH . 'assets/images/Logo-header.png';
        if (file_exists($logoPath)) {
            $drawing = new Drawing();
            $drawing->setPath($logoPath);
            $drawing->setHeight(50);
            $drawing->setCoordinates('A1');
            $drawing->setWorksheet($spreadsheet->getActiveSheet());
        }
    
        // Set header for Booking Details
        $spreadsheet->getActiveSheet()->setCellValue('A2', 'Booking Details')->mergeCells('A2:D2');
        $spreadsheet->getActiveSheet()->getStyle('A2:D2')->applyFromArray($headerStyle);
    
        // Add data
        $rowIndex = 3;
        foreach ($getBookingDetails as $booking) {
            $spreadsheet->getActiveSheet()->mergeCells('A' . $rowIndex . ':B' . $rowIndex);

            // Merge columns C to D for the data in column C for this row
            $spreadsheet->getActiveSheet()->mergeCells('C' . $rowIndex . ':D' . $rowIndex);

            // Add borders
            $spreadsheet->getActiveSheet()->getStyle('A' . $rowIndex . ':D' . ($rowIndex + 11))->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ]);
            $spreadsheet->getActiveSheet()->setCellValue('A' . $rowIndex, 'Service Type')->setCellValue('B' . $rowIndex, $booking['serviceType']);
            $spreadsheet->getActiveSheet()->setCellValue('A' . ($rowIndex + 1), 'Reference Code')->setCellValue('B' . ($rowIndex + 1), $booking['reference_code']);
            $spreadsheet->getActiveSheet()->setCellValue('A' . ($rowIndex + 2), 'Card Holder')->setCellValue('B' . ($rowIndex + 2), $booking['card_holder_name']);
            $spreadsheet->getActiveSheet()->setCellValue('A' . ($rowIndex + 3), 'Booking Date')->setCellValue('B' . ($rowIndex + 3), date('F d, Y', strtotime($booking['booking_date'])));
            $spreadsheet->getActiveSheet()->setCellValue('A' . ($rowIndex + 4), 'Pickup Date')->setCellValue('B' . ($rowIndex + 4), $booking['picking_date'] ? date('F d, Y', strtotime($booking['picking_date'])) : "N/A");
            $spreadsheet->getActiveSheet()->setCellValue('A' . ($rowIndex + 5), 'Pickup Time')->setCellValue('B' . ($rowIndex + 5), $booking['picking_time'] ? date('h:i A', strtotime($booking['picking_time'])) : "N/A");
            $spreadsheet->getActiveSheet()->setCellValue('A' . ($rowIndex + 6), 'Base Price')->setCellValue('B' . ($rowIndex + 6), $booking['base_price']);
            $spreadsheet->getActiveSheet()->setCellValue('A' . ($rowIndex + 7), 'Additional Box Quantity (50.00 per Box)')->setCellValue('B' . ($rowIndex + 7), $booking['additional_box_quantity']);
            $spreadsheet->getActiveSheet()->setCellValue('A' . ($rowIndex + 8), 'Additional Box Total Amount')->setCellValue('B' . ($rowIndex + 8), $booking['addtl_box_total_amount']);
            $spreadsheet->getActiveSheet()->setCellValue('A' . ($rowIndex + 9), 'Total Amount')->setCellValue('B' . ($rowIndex + 9), $booking['total_amount']);
            $spreadsheet->getActiveSheet()->setCellValue('A' . ($rowIndex + 10), 'Notes')->setCellValue('B' . ($rowIndex + 10), $booking['notes']);
            $spreadsheet->getActiveSheet()->setCellValue('A' . ($rowIndex + 11), 'Schedule')->setCellValue('B' . ($rowIndex + 11), $booking['status']);
            // Add more rows for other details as needed...
        
            $rowIndex += 12; // Adjust accordingly based on the number of rows in each section
        }
        // Set header for Account Information
        $spreadsheet->getActiveSheet()->setCellValue('A' . $rowIndex, 'Account Information')->mergeCells('A' . $rowIndex . ':D' . $rowIndex);
        $spreadsheet->getActiveSheet()->getStyle('A' . $rowIndex . ':D' . $rowIndex)->applyFromArray($headerStyle);

        // Add Account Information data
        $rowIndex += 1; // Move to the next row

        if (!empty($getAccountInformations) && array_key_exists(0, $getAccountInformations)) {
            $accountInformationDetails = $getAccountInformations[0];

            $accountInformationLabels = [
                'Student Name', 'Student ID', 'Dorm', 'Phone Number', 'Email Address', 'Address',
                'Parent Phone Number', 'Parent Email Address',
            ];

            foreach ($accountInformationLabels as $label) {
                $value = ''; // Default value if the key is not found
                if (array_key_exists($label, $accountInformationDetails)) {
                    $value = $accountInformationDetails[$label];
                }

                $spreadsheet->getActiveSheet()->mergeCells('A' . $rowIndex . ':B' . $rowIndex);
                $spreadsheet->getActiveSheet()->mergeCells('C' . $rowIndex . ':D' . $rowIndex);

                // Add borders
                $spreadsheet->getActiveSheet()->getStyle('A' . $rowIndex . ':D' . $rowIndex)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                $spreadsheet->getActiveSheet()->getStyle('A' . $rowIndex)->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);

                $spreadsheet->getActiveSheet()->setCellValue('A' . $rowIndex, $label);
                $spreadsheet->getActiveSheet()->setCellValue('C' . $rowIndex, $value);

                $rowIndex += 1;
            }
        } else {
            // Handle the case where $getAccountInformations is empty or doesn't have key 0
            $spreadsheet->getActiveSheet()->mergeCells('A' . $rowIndex . ':D' . $rowIndex);
            $spreadsheet->getActiveSheet()->getStyle('A' . $rowIndex . ':D' . $rowIndex)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ]);

            $spreadsheet->getActiveSheet()->getStyle('A' . $rowIndex)->applyFromArray([
                'font' => [
                    'bold' => true,
                ],
            ]);

            $spreadsheet->getActiveSheet()->setCellValue('A' . $rowIndex, 'No Account Information available');

            $rowIndex += 1;
        }
    
        // Set response headers
        $filename = 'booking_details_' . $bookingId . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
    
        // Save the Excel file to output
        $writer->save('php://output');
    }    
    
    private function getBookingDetails($bookingId)
    {
        $bookingsModel = new BookingsModel();
    
        // Retrieve booking details based on the booking ID
        $bookingDetails = $bookingsModel->find($bookingId);
    
        return $bookingDetails ? [$bookingDetails] : [];
    }
    

    private function getBookingItems($bookingId)
    {
        $bookingItemsModel = new BookingItemsModel();

        $bookingItemDetails = $bookingItemsModel
        ->select('booking_items.*, items.item_name, sizes.size, sizes.cost')
        ->join('items', 'items.item_id = booking_items.item_id', 'left')
        ->join('sizes', 'sizes.size_id = booking_items.size_id', 'left')
        ->where('booking_items.booking_id', $bookingId)
        ->findAll();
        return $bookingItemDetails;
    }

    private function getAccountInformations($accountInformationId)
    {
        $accountInformationsModel = new AccountInformationsModel();
        $accountInformationDetails = $accountInformationsModel
        ->select('account_informations.*, dorms.dorm_name')
        ->join('dorms', 'dorms.dorm_id = account_informations.dorm_id', 'left')
        ->where('account_informations.account_information_id', $accountInformationId)
        ->first();
        return $accountInformationDetails;
    }

    private function getServiceInformations($bookingId)
    {
        $serviceInformationsModel = new ServiceInformationsModel();
        $serviceInformationDetails = $serviceInformationsModel->where('booking_id', $bookingId)->findAll();
        return $serviceInformationDetails;
    }
    public function reSchedule($bookingId, $accountInformationId)
    {
        $accountModel = new AccountInformationsModel();
        $bookingModel = new BookingsModel();
        $bookingItemModel = new BookingItemsModel();
        
        $booking = $bookingModel->find($bookingId);

        $account = $accountModel
                ->select('account_informations.*, dorms.*') // select the columns you need
                ->join('dorms', 'dorms.dorm_id = account_informations.dorm_id') // join based on the relationship
                ->where('account_informations.account_information_id', $accountInformationId)
                ->first(); // Assuming you expect only one result
    
        // Check if $booking is not null before accessing its array offsets
        if ($bookingId) {
            $bookingItem = $bookingItemModel
                ->select('booking_items.*, items.*') // Select the columns you need
                ->join('items', 'items.item_id = booking_items.item_id') // Join based on the relationship
                ->where('booking_items.booking_id', $bookingId)
                //->where('items.item_name !=', 'Additional Box')
                ->findAll();
        } else {
            // Handle the case where $booking is null
            $bookingItem = [];
        }
    
        $additionalData = [
            'referenceCode' => $booking['reference_code'],
            'email_address' => $account['email_address'] ?? '',
            'parent_email_address' => $account['parent_email_address'] ?? '',
            'parent_phone_number' => $account['parent_phone_number'] ?? '',
            'first_name' => $account['first_name'] ?? '',
            'last_name' => $account['last_name'] ?? '',
            'student_id' => $account['student_id'] ?? '',
            'phone_number' => $account['phone_number'] ?? '',
            'dorm_name' => $account['dorm_name'] ?? '',
            'dorm_room_number' => $account['dorm_room_number'] ?? '',
            'base_amount' => $booking['base_price'] ?? '0.00',
            'study_abroad_additional_storage_price' => $booking['study_abroad_additional_storage_price'] ?? '0.00',
            'totalAmount' => $booking['total_amount'] ?? '0.00',
            'orderItems' => $bookingItem,
        ];

        $bookingModel->update($bookingId, ['status' => 'Pending']);
    
        $email = \Config\Services::email();
    
        $email->setFrom('testing@braveegg.com', 'Epic Storage Solutions');
        $email->setTo($account['email_address']);
        $email->setCC($account['parent_email_address']);
        $email->setSubject('HPU Storage Receipt – EPIC Storage');
    
        $email->setMailType('html');
    
        $emailContent = view('email_templates/order_confirmation', ['additionalData' => $additionalData]);
        $email->setMessage($emailContent);
    
        $email->send();
        //echo $email->printDebugger();
        return $this->response->setJSON(['status' => 'success', 'message' => 'Reschedule email has been sent!']);
    }
    public function dropOff($bookingId, $accountInformationId)
    {
        $accountModel = new AccountInformationsModel();
        $dOffModel = new DropOffModel();

        $referenceCode = 'REF_' . uniqid();

        $data = [
            'account_information_id' => $accountInformationId,
            'booking_id' => $bookingId,
            'referenceCode' => $referenceCode,
            'dropOffStatus' => 'Pending',
        ];

        $dOffModel->insert($data);

        $account = $accountModel
                ->select('account_informations.*, dorms.*') // select the columns you need
                ->join('dorms', 'dorms.dorm_id = account_informations.dorm_id') // join based on the relationship
                ->where('account_informations.account_information_id', $accountInformationId)
                ->first(); // Assuming you expect only one result
    
        $email = \Config\Services::email();
    
        $email->setFrom('testing@braveegg.com', 'Epic Storage Solutions');
        $email->setTo($account['email_address']);
        //$email->setCC($account['parent_email_address']);
        $email->setSubject('Drop Off Notification – EPIC Storage');
    
        $email->setMailType('html');
    
        $emailContent = view('email_templates/drop_off_noti', ['referenceCode' => $referenceCode]);
        $email->setMessage($emailContent);
    
        $email->send();
        //echo $email->printDebugger();
        return $this->response->setJSON(['status' => 'success', 'message' => $email->printDebugger()]);
    }
    public function pickUp($bookingId, $accountInformationId)
    {
        $bookingModel = new BookingsModel();
        $bookingItemModel = new BookingItemsModel();
    
        $bookings = $bookingModel
            ->where('bookings.booking_id', $bookingId)
            ->where('bookings.account_information_id', $accountInformationId)
            ->join('account_informations', 'bookings.account_information_id = account_informations.account_information_id', 'left')
            ->join('dorms', 'dorms.dorm_id = account_informations.dorm_id', 'left')
            ->find();
        
            $bookingItem = $bookingItemModel
                ->where('booking_id', $bookingId)
                ->join('items', 'booking_items.item_id=items.item_id', 'left')
                ->join('sizes', 'booking_items.size_id=sizes.size_id', 'left')
                ->findAll();
        
            $additionalData = [
                'referenceCode' => $bookings[0]['reference_code'] ?? '',
                'email_address' => $bookings[0]['email_address'] ?? '',
                'parent_email_address' => $bookings[0]['parent_email_address'] ?? '',
                'parent_phone_number' => $bookings[0]['parent_phone_number'] ?? '',
                'first_name' => $bookings[0]['first_name'] ?? '',
                'last_name' => $bookings[0]['last_name'] ?? '',
                'student_id' => $bookings[0]['student_id'] ?? '',
                'phone_number' => $bookings[0]['phone_number'] ?? '',
                'dorm_name' => $bookings[0]['dorm_name'] ?? '',
                'dorm_room_number' => $bookings[0]['dorm_room_number'] ?? '',
                'base_amount' => $bookings[0]['base_price'] ?? '0.00',
                'study_abroad_additional_storage_price' => $bookings[0]['study_abroad_additional_storage_price'] ?? '0.00',
                'totalAmount' => $bookings[0]['total_amount'] ?? '0.00',
                'orderItems' => $bookingItem,
            ];
        
            $email = \Config\Services::email();
        
            $email->setFrom('testing@braveegg.com', 'Epic Storage Solutions');
            $email->setTo($bookings[0]['email_address']);
            $email->setSubject('Pick Up Schedule Notification – EPIC Storage');
            $email->setMailType('html');
        
            // Load the email template with the additional data
            $emailContent = view('email_templates/order_confirmation', ['additionalData' => $additionalData]);
            $email->setMessage($emailContent);
        
            // Send the email
            $email->send();
        
            // Uncomment the line below if you want to print email debugging information
            // echo $email->printDebugger();
        
            return $this->response->setJSON(['status' => 'success', 'message' => 'Email sent successfully']);
    }
    public function generatePdf($bookingId)
    {
        $path = 'assets/images/Logo-header.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        
        $bookingsModel = new BookingsModel();
        $bookingItemsModel = new BookingItemsModel();
        $accountInformationsModel = new AccountInformationsModel();
        $serviceInformationsModel = new ServiceInformationsModel();
        $dropOffModel = new DropOffModel();
        
        $bookingDetails = $bookingsModel->find($bookingId);
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
        $dropOffDetails = $dropOffModel
        ->select('drop_off.*, dorms.dorm_name')
        ->join('bookings', 'bookings.account_information_id = drop_off.account_information_id', 'left')
        ->join('dorms', 'dorms.dorm_id = drop_off.dorm_id', 'left')
        ->where('bookings.booking_id', $bookingId)
        ->first();
        $serviceInformationDetails = $serviceInformationsModel->where('booking_id', $bookingId)->first();

        $data = [
            'bookingDetails' => $bookingDetails,
            'accountInformationDetails' => $accountInformationDetails,
            'bookingItemDetails' => $bookingItemDetails,
            'serviceInformationDetails' => $serviceInformationDetails,
            'dropOffDetails' => $dropOffDetails,
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
        $html = view('components/printBooking', $data);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // Set paper size (optional)
        $dompdf->setPaper('a4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF
        $dompdf->stream('document.pdf', ['Attachment' => false]);
    }
    public function previewPdf($bookingId)
    {
        $path = 'assets/images/Logo-header.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        
        $bookingsModel = new BookingsModel();
        $bookingItemsModel = new BookingItemsModel();
        $accountInformationsModel = new AccountInformationsModel();
        $serviceInformationsModel = new ServiceInformationsModel();
        $dropOffModel = new DropOffModel();
        
        $bookingDetails = $bookingsModel->find($bookingId);
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
        $dropOffDetails = $dropOffModel
        ->select('drop_off.*, dorms.dorm_name')
        ->join('bookings', 'bookings.account_information_id = drop_off.account_information_id', 'left')
        ->join('dorms', 'dorms.dorm_id = drop_off.dorm_id', 'left')
        ->where('bookings.booking_id', $bookingId)
        ->first();
        $serviceInformationDetails = $serviceInformationsModel->where('booking_id', $bookingId)->first();

        $data = [
            'bookingDetails' => $bookingDetails,
            'accountInformationDetails' => $accountInformationDetails,
            'bookingItemDetails' => $bookingItemDetails,
            'serviceInformationDetails' => $serviceInformationDetails,
            'dropOffDetails' => $dropOffDetails,
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
        $html = view('components/printBooking', $data);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // Set paper size (optional)
        $dompdf->setPaper('a4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF
        $pdfContent = $dompdf->output();

        $data['pdfContent'] = $pdfContent;

        return view('components/preview', $data);
    }
    public function sendDropOffNotificationToAll()
    {
        $bookingModel = new BookingsModel();
        $dropOffModel = new DropOffModel();
    
        $bookings = $bookingModel
            ->where('bookings.status', 'Scheduled')
            ->join('account_informations', 'bookings.account_information_id = account_informations.account_information_id', 'left')
            ->get()
            ->getResultArray();
    
        $email = \Config\Services::email();
    
        $totalEmails = count($bookings);
        $successMessages = []; // To store success messages for each email sent
    
        foreach ($bookings as $index => $booking) {
            $dropOffExists = $dropOffModel->where('booking_id', $booking['booking_id'])->get()->getResult();
    
            $email->setFrom('testing@braveegg.com', 'Epic Storage Solutions');
    
            if (empty($dropOffExists)) {
                $email->setTo($booking['email_address']);
                $email->setSubject('Drop Off Notification – EPIC Storage');
                $email->setMailType('html');
                $emailContent = view('email_templates/drop_off_noti', ['referenceCode' => $booking['reference_code']]);
                $email->setMessage($emailContent);
                $email->send();
                $email->clear();
                $successMessages[] = 'Email sent to ' . $booking['email_address'];
    
                // Return progress after each email sent
                $progress = ($index + 1) / $totalEmails * 100;
                $this->response->setJSON(['status' => 'progress', 'progress' => $progress]);
            }
        }
    
        // Return success messages for all emails sent
        return $this->response->setJSON(['status' => 'success', 'messages' => $successMessages]);
    }
    public function sendPickUpNotificationToAll()
    {
        $bookingModel = new BookingsModel();
        $bookingItemModel = new BookingItemsModel();
    
        $bookings = $bookingModel
            ->where('bookings.status', 'Pending')
            ->join('account_informations', 'bookings.account_information_id = account_informations.account_information_id', 'left')
            ->join('dorms', 'dorms.dorm_id = account_informations.dorm_id', 'left')
            ->get()
            ->getResultArray();
    
        $email = \Config\Services::email();
    
        $totalEmails = count($bookings);
        $successMessages = []; // To store success messages for each email sent
    
        foreach ($bookings as $index => $booking) {

            $bookingItem = $bookingItemModel
                        ->where('booking_id', $booking['booking_id'])
                        ->join('items', 'booking_items.item_id=items.item_id', 'left')
                        ->join('sizes', 'booking_items.size_id=sizes.size_id', 'left')
                        ->findAll();

            $additionalData = [
                'referenceCode' => $booking['reference_code'],
                'email_address' => $booking['email_address'] ?? '',
                'parent_email_address' => $booking['parent_email_address'] ?? '',
                'parent_phone_number' => $booking['parent_phone_number'] ?? '',
                'first_name' => $booking['first_name'] ?? '',
                'last_name' => $booking['last_name'] ?? '',
                'student_id' => $booking['student_id'] ?? '',
                'phone_number' => $booking['phone_number'] ?? '',
                'dorm_name' => $booking['dorm_name'] ?? '',
                'dorm_room_number' => $booking['dorm_room_number'] ?? '',
                'base_amount' => $booking['base_price'] ?? '0.00',
                'study_abroad_additional_storage_price' => $booking['study_abroad_additional_storage_price'] ?? '0.00',
                'totalAmount' => $booking['total_amount'] ?? '0.00',
                'orderItems' => $bookingItem,
            ];

            $email->setFrom('testing@braveegg.com', 'Epic Storage Solutions');
            $email->setTo($booking['email_address']);
            $email->setSubject('Pick Up Schedule Notification – EPIC Storage');
            $email->setMailType('html');
            $emailContent = view('email_templates/order_confirmation', ['additionalData' => $additionalData]);
            $email->setMessage($emailContent);
            $email->send();
            $email->clear();
            $successMessages[] = 'Email sent to ' . $booking['email_address'];

            // Return progress after each email sent
            $progress = ($index + 1) / $totalEmails * 100;
            $this->response->setJSON(['status' => 'progress', 'progress' => $progress]);
        }
    
        // Return success messages for all emails sent
        return $this->response->setJSON(['status' => 'success', 'messages' => $successMessages]);
    }
}
