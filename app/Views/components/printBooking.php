<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .header-logo {
            text-align: left;
        }

        .signature-info {
            text-align: right;
            margin-top: 10px;
            font-size: 12px;
        }

        table {
            width: 100%;
            margin-bottom: 0.5rem;
            color: #212529;
            border-collapse: collapse;
        }
        td {
            padding: 0.35rem;
            vertical-align: top;
            font-size: 12px;
            width: 50%;
        }

        .section-title {
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .bold-text {
            font-weight: bold;
        }
        .row::after {
            content: "";
            clear: both;
            display: table;
        }

        .row {
            margin-right: -15px;
            margin-left: -15px;
        }
        .col-lg-12 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        /* For col-lg-12 */
        .col-lg-12 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-lg-12">
            <table>
                <tbody>
                    <tr>
                        <td class="bold-text">
                            <div class="header-logo">
                                <img src="<?=$logo;?>" height="80" alt="Logo">
                            </div>
                        </td>
                        <td>
                            <div class="signature-info">
                                <span>Student Signature : ____________________</span><br/><br/>
                                <span>Epic Signature : ____________________</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-lg-12">
            <h5 class="section-title">Booking Details</h5>
            <table border="1">
                <tbody>
                    <tr>
                        <td style="font-weight: bold;">Order #</td>
                        <td><?=$bookingDetails['ordernumber'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Student Name</td>
                        <td><?=$accountInformationDetails['first_name'].' '.$accountInformationDetails['last_name'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Student ID</td>
                        <td><?=$accountInformationDetails['student_id'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Pick Up Dorm</td>
                        <td><?=$accountInformationDetails['dorm_name'].' / Room No.'.$accountInformationDetails['dorm_room_number'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Address</td>
                        <td><?=$accountInformationDetails['street_name'].' '.$accountInformationDetails['street_number'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Pickup Date</td>
                        <td><?=$bookingDetails['picking_date'] ? date('F d, Y', strtotime($bookingDetails['picking_date'])) : "N/A";?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Phone Number</td>
                        <td><?=$accountInformationDetails['phone_number'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Email Address</td>
                        <td><?=$accountInformationDetails['email_address'];?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-lg-12">
            <table border="1">
                <tbody>
                    <tr>
                        <td style="font-weight: bold;">Parent Phone Number</td>
                        <td><?=$accountInformationDetails['parent_phone_number'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Parent Email Address</td>
                        <td><?=$accountInformationDetails['parent_email_address'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Drop Off Dorm</td>
                        <td><?php echo !empty($dropOffDetails) ? $dropOffDetails['dorm_name'] . ' / Room No.' . $dropOffDetails['roomNumber'] : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Address</td>
                        <td><?php echo !empty($dropOffDetails) ? $dropOffDetails['streetName'] . ' ' . $dropOffDetails['streetNumber'] : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Return Date</td>
                        <td><?php echo !empty($dropOffDetails) ? $dropOffDetails['returnDate'] : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td class="bold-text">Do you study abroad?</td>
                        <td><?=$serviceInformationDetails['is_studying_abroad'];?></td>
                    </tr>
                    <tr>
                        <td class="bold-text">Are you doing summer school?</td>
                        <td><?=$serviceInformationDetails['is_summer_school'];?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Row in Warehouse</td>
                        <td><?=$bookingDetails['row_in_warehouse'];?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-lg-12">
            <h5 class="section-title">Additional Items</h5>
            <table border="1">
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
        <div class="col-lg-12">
            <div style="height: 150px; background: #d9d7d7; padding: 10px;">
                <h5 class="section-title">Note Section</h5>
            </div>
        </div>
    </div>
</body>

</html>
