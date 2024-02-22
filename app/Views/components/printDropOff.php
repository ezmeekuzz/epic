<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 30px;
        }

        .header-logo {
            text-align: center;
        }

        .signature-info {
            text-align: right;
            margin-top: 20px;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        th, td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .section-title {
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .bold-text {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">

<table class="table table-bordered">
            <tbody>
                <tr>
                    <td class="bold-text">
                        <div class="header-logo">
                            <img src="<?=$logo;?>" height="100">
                        </div>
                    </td>
                    <td>
                        <div class="signature-info">
                            <span>Signature Over Printed Name : ____________________</span><br/>
                            <span>Date of Signed : ____________________</span>
                        </div>
                    </td>
                </tr>
    </tbody>
    </table>
    <!-- Booking Details -->
    <div>
        <h2 class="section-title">Booking Details</h2>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td class="bold-text">Service Type</td>
                    <td><?=$bookingDetails['serviceType'];?></td>
                </tr>
                <tr>
                    <td class="bold-text">Reference Code</td>
                    <td><?=$bookingDetails['referenceCode'];?></td>
                </tr>
                <tr>
                    <td class="bold-text">Card Holder</td>
                    <td><?=$bookingDetails['card_holder_name'];?></td>
                </tr>
                <tr>
                    <td class="bold-text">Booking Date</td>
                    <td><?=date('F d, Y', strtotime($bookingDetails['booking_date']));?></td>
                </tr>
                <tr>
                    <td class="bold-text">Pickup Date</td>
                    <td><?=$bookingDetails['picking_date'] ? date('F d, Y', strtotime($bookingDetails['picking_date'])) : "N/A";?></td>
                </tr>
                <tr>
                    <td class="bold-text">Pickup Time</td>
                    <td><?=$bookingDetails['picking_time'] ? date('h:i A', strtotime($bookingDetails['picking_time'])) : "N/A";?></td>
                </tr>
                <tr>
                    <td class="bold-text">Return Date</td>
                    <td><?=$bookingDetails['returnDate'] ? date('F d, Y', strtotime($bookingDetails['returnDate'])) : "N/A";?></td>
                </tr>
                <tr>
                    <td class="bold-text">Notes</td>
                    <td><?=$bookingDetails['notes'];?></td>
                </tr>
                <tr>
                    <td class="bold-text">Drop Off Status</td>
                    <td><?=$bookingDetails['dropOffStatus'];?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Account Informations -->
    <div>
        <h2 class="section-title">Account Informations</h2>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td class="bold-text">Student Name</td>
                    <td><?=$bookingDetails['firstName'].' '.$bookingDetails['lastName'];?></td>
                </tr>
                <tr>
                    <td class="bold-text">Student ID</td>
                    <td><?=$bookingDetails['studentNumber'];?></td>
                </tr>
                <tr>
                    <td class="bold-text">Dorm</td>
                    <td><?=$bookingDetails['dormName'].' / Room No.'.$bookingDetails['roomNumber'];?></td>
                </tr>
                <tr>
                    <td class="bold-text">Phone Number</td>
                    <td><?=$accountInformationDetails['phone_number'];?></td>
                </tr>
                <tr>
                    <td class="bold-text">Email Address</td>
                    <td><?=$accountInformationDetails['email_address'];?></td>
                </tr>
                <tr>
                    <td class="bold-text">Address</td>
                    <td><?=$accountInformationDetails['street_name'].' '.$accountInformationDetails['street_number'];?></td>
                </tr>
                <tr>
                    <td class="bold-text">Parent Phone Number</td>
                    <td><?=$accountInformationDetails['parent_phone_number'];?></td>
                </tr>
                <tr>
                    <td class="bold-text">Parent Email Address</td>
                    <td><?=$accountInformationDetails['parent_email_address'];?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Service Informations -->
    <div>
        <h2 class="section-title">Service Informations</h2>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td class="bold-text">Do you need storage for additional items?</td>
                    <td><?=$serviceInformationDetails['is_storage_additional_item'];?></td>
                </tr>
                <tr>
                    <td class="bold-text">Do you study abroad?</td>
                    <td><?=$serviceInformationDetails['is_studying_abroad'];?></td>
                </tr>
                <tr>
                    <td class="bold-text">Are you doing summer school?</td>
                    <td><?=$serviceInformationDetails['is_summer_school'];?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Additional Items -->
    <div>
        <h2 class="section-title">Additional Items</h2>
        <table class="table table-bordered">
            <tbody>
                <?php if(count($bookingItemDetails)) : ?>
                    <?php foreach($bookingItemDetails as $items) : ?>
                        <tr>
                            <td colspan="2" class="bold-text"><?=$items['item_name'].' '.$items['size'].' (x'.$items['quantity'].')';?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
