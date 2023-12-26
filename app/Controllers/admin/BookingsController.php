<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingsModel;
use App\Models\BookingItemsModel;
use App\Models\AccountInformationsModel;
use App\Models\ServiceInformationsModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

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
            
            $aModel = new AccountInformationsModel();
            $aModel->where('booking_id', $id)->delete();
            
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
    public function bookingDetails()
    {
        
        $bookingId = $this->request->getGet('bookingId');
        
        $bookingsModel = new BookingsModel();
        $bookingItemsModel = new BookingItemsModel();
        $accountInformationsModel = new AccountInformationsModel();
        $serviceInformationsModel = new ServiceInformationsModel();
        
        $bookingDetails = $bookingsModel->find($bookingId);
        $bookingItemDetails = $bookingItemsModel
        ->select('booking_items.*, items.item_name, sizes.size, sizes.cost')
        ->join('items', 'items.item_id = booking_items.item_id', 'left')
        ->join('sizes', 'sizes.size_id = booking_items.size_id', 'left')
        ->where('booking_items.booking_id', $bookingId)
        ->findAll();
        $accountInformationDetails = $accountInformationsModel
        ->select('account_informations.*, dorms.dorm_name')
        ->join('dorms', 'dorms.dorm_id = account_informations.dorm_id', 'left')
        ->where('account_informations.booking_id', $bookingId)
        ->first();
        $serviceInformationDetails = $serviceInformationsModel->where('booking_id', $bookingId)->findAll();
        ?>
        <button id="updateStatus" data-id="<?=$bookingDetails['booking_id'];?>" class="btn btn-info"><i class="fa fa-shopping-cart"></i> Finish</button>
        <button id="print" class="btn btn-info"><i class="fa fa-print"></i> Print</button>
        <br/><br/>
        <div id="booking-details">
            <img src="<?=base_url();?>assets/images/Logo-header.png" />
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center; text-transform: uppercase;">Booking Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-weight: bold;">Service Type</td>
                        <td><?=$bookingDetails['serviceType'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Reference Code</td>
                        <td><?=$bookingDetails['reference_code'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Card Holder</td>
                        <td><?=$bookingDetails['card_holder_name'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Booking Date</td>
                        <td><?=date('F d, Y', strtotime($bookingDetails['booking_date']));?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Pickup Date</td>
                        <td><?=$bookingDetails['picking_date'] ? date('F d, Y', strtotime($bookingDetails['picking_date'])) : "N/A";?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Pickup Time</td>
                        <td><?=$bookingDetails['picking_time'] ? date('h:i A', strtotime($bookingDetails['picking_time'])) : "N/A";?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Base Price</td>
                        <td><?=$bookingDetails['base_price'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Additional Box Quantity (50.00 per Box)</td>
                        <td contenteditable="true" oninput="validateInteger(this)"><?=$bookingDetails['additional_box_quantity'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Additional Box Total Amount</td>
                        <td><?=$bookingDetails['addtl_box_total_amount'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Total Amount</td>
                        <td><?=$bookingDetails['total_amount'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Notes</td>
                        <td><?=$bookingDetails['notes'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Schedule</td>
                        <td><?=$bookingDetails['status'];?></td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center; text-transform: uppercase;">Account Informations</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-weight: bold;">Student Name</td>
                        <td><?=$accountInformationDetails['first_name'].' '.$accountInformationDetails['last_name'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Student ID</td>
                        <td><?=$accountInformationDetails['student_id'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Dorm</td>
                        <td><?=$accountInformationDetails['dorm_name'].' / Room No.'.$accountInformationDetails['dorm_room_number'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Phone Number</td>
                        <td><?=$accountInformationDetails['phone_number'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Email Address</td>
                        <td><?=$accountInformationDetails['email_address'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Address</td>
                        <td><?=$accountInformationDetails['street_name'].' '.$accountInformationDetails['street_number'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Parent Phone Number</td>
                        <td><?=$accountInformationDetails['parent_phone_number'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Parent Email Address</td>
                        <td><?=$accountInformationDetails['parent_email_address'];?></td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center; text-transform: uppercase;">Service Informations</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-weight: bold;">Is Boxes Included</td>
                        <td><?=$serviceInformationDetails[0]['is_boxes_included'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Box(es) Quantity</td>
                        <td><?=$serviceInformationDetails[0]['box_quantity'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Do You Need Other Vehicle Storage For May - August? (Full Summer)(Motorcycle, Scooter, Bike)*</td>
                        <td><?=$serviceInformationDetails[0]['is_storage_additional_item'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Do You Need Car Storage For May - August? (Full Summer) *</td>
                        <td><?=$serviceInformationDetails[0]['is_storage_car_in_may'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Do You Need Other Vehicle Storage For May - August? (Full Summer)(Motorcycle, Scooter, Bike)*</td>
                        <td><?=$serviceInformationDetails[0]['is_storage_vehicle_in_may'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Are you doing summer school?</td>
                        <td><?=$serviceInformationDetails[0]['is_summer_school'];?></td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="4" style="text-align: center; text-transform: uppercase;">Additional Items</th>
                    </tr>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(COUNT($bookingItemDetails)) : ?>
                    <?php foreach($bookingItemDetails as $items) : ?>
                    <tr>
                        <td style="font-weight: bold;"><?=$items['item_name'].' '.$items['size'];?></td>
                        <td contenteditable="true" oninput="validateInteger(this)"><?=$items['quantity']?></td>
                        <td><?=$items['cost']?></td>
                        <td>$<?=$items['totalamount'];?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div id="printBookingDetails" hidden>
            <table class="table">
                <thead>
                    <tr>
                        <th><img src="<?=base_url();?>assets/images/Logo-header.png" /></th>
                        <th style="text-align: right;">
                            <span>Signature Over Printed Name : ____________________</span><br/>
                            <span>Date of Signed : ____________________</span>
                        </th>
                    </tr>
                </thead>
            <table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center; text-transform: uppercase;">Booking Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-weight: bold;">Service Type</td>
                        <td><?=$bookingDetails['serviceType'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Reference Code</td>
                        <td><?=$bookingDetails['reference_code'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Card Holder</td>
                        <td><?=$bookingDetails['card_holder_name'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Booking Date</td>
                        <td><?=date('F d, Y', strtotime($bookingDetails['booking_date']));?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Pickup Date</td>
                        <td><?=$bookingDetails['picking_date'] ? date('F d, Y', strtotime($bookingDetails['picking_date'])) : "N/A";?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Pickup Time</td>
                        <td><?=$bookingDetails['picking_time'] ? date('h:i A', strtotime($bookingDetails['picking_time'])) : "N/A";?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Notes</td>
                        <td><?=$bookingDetails['notes'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Schedule</td>
                        <td><?=$bookingDetails['status'];?></td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center; text-transform: uppercase;">Account Informations</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-weight: bold;">Student Name</td>
                        <td><?=$accountInformationDetails['first_name'].' '.$accountInformationDetails['last_name'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Student ID</td>
                        <td><?=$accountInformationDetails['student_id'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Dorm</td>
                        <td><?=$accountInformationDetails['dorm_name'].' / Room No.'.$accountInformationDetails['dorm_room_number'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Phone Number</td>
                        <td><?=$accountInformationDetails['phone_number'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Email Address</td>
                        <td><?=$accountInformationDetails['email_address'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Address</td>
                        <td><?=$accountInformationDetails['street_name'].' '.$accountInformationDetails['street_number'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Parent Phone Number</td>
                        <td><?=$accountInformationDetails['parent_phone_number'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Parent Email Address</td>
                        <td><?=$accountInformationDetails['parent_email_address'];?></td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center; text-transform: uppercase;">Service Informations</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-weight: bold;">Is Boxes Included</td>
                        <td><?=$serviceInformationDetails[0]['is_boxes_included'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Box(es) Quantity</td>
                        <td><?=$serviceInformationDetails[0]['box_quantity'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Do You Need Other Vehicle Storage For May - August? (Full Summer)(Motorcycle, Scooter, Bike)*</td>
                        <td><?=$serviceInformationDetails[0]['is_storage_additional_item'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Do You Need Car Storage For May - August? (Full Summer) *</td>
                        <td><?=$serviceInformationDetails[0]['is_storage_car_in_may'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Do You Need Other Vehicle Storage For May - August? (Full Summer)(Motorcycle, Scooter, Bike)*</td>
                        <td><?=$serviceInformationDetails[0]['is_storage_vehicle_in_may'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Are you doing summer school?</td>
                        <td><?=$serviceInformationDetails[0]['is_summer_school'];?></td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center; text-transform: uppercase;">Additional Items</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(COUNT($bookingItemDetails)) : ?>
                    <?php foreach($bookingItemDetails as $items) : ?>
                    <tr>
                        <td colspan="2" style="font-weight: bold;"><?=$items['item_name'].' '.$items['size'].' (x'.$items['quantity'].')';?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
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

        $selectedIds = $this->request->getVar('selectedIds');
        $search = $this->request->getVar('search');
        
        if (!empty($selectedIds)) {
            
            $selectedIds = explode(',', $selectedIds);
            
            $bModel->whereIn('booking_id', $selectedIds);
        } elseif ($search !== null) {
            
            $bModel->like('card_holder_name', $search)
                   ->orLike('serviceType', $search);
        }
    
        $filteredRecords = $bModel->findAll();
        
        $csvData = [];
        foreach ($filteredRecords as $record) {
            $csvData[] = [
                $record['serviceType'],
                $record['card_holder_name'],
                $record['booking_date'],
                $record['base_price'],
                $record['additional_box_quantity'],
                $record['addtl_box_total_amount'],
                $record['total_amount'],
                $record['status'],
            ];
        }
        
        $csvFileName = 'exported_data.csv';
        $csvFilePath = WRITEPATH . 'uploads/' . $csvFileName;
    
        $file = fopen($csvFilePath, 'w');
        fputcsv($file, ['Service Type', 'Card Holder Name', 'Booking Date', 'Base Price', 'Additional Box Quantity', 'Additional Box Total Amount', 'Total Amount', 'Status']);
        foreach ($csvData as $data) {
            fputcsv($file, $data);
        }
        fclose($file);
        
        return $this->response->download($csvFilePath, null)->setFileName($csvFileName);
    }
    public function exportToExcel()
    {
        $bookingId = $this->request->getGet('bookingId');
    
        // Retrieve data based on the booking ID
        $getBookingDetails = $this->getBookingDetails($bookingId);
        $getBookingItems = $this->getBookingItems($bookingId);
        $getAccountInformations = $this->getAccountInformations($bookingId);
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

    private function getAccountInformations($bookingId)
    {
        $accountInformationsModel = new AccountInformationsModel();
        $accountInformationDetails = $accountInformationsModel
        ->select('account_informations.*, dorms.dorm_name')
        ->join('dorms', 'dorms.dorm_id = account_informations.dorm_id', 'left')
        ->where('account_informations.booking_id', $bookingId)
        ->first();
        return $accountInformationDetails;
    }

    private function getServiceInformations($bookingId)
    {
        $serviceInformationsModel = new ServiceInformationsModel();
        $serviceInformationDetails = $serviceInformationsModel->where('booking_id', $bookingId)->findAll();
        return $serviceInformationDetails;
    }
}
