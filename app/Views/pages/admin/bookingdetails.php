                <?=$this->include('templates/admin/header');?>
                <?=$this->include('templates/admin/sidebar');?>
                <!-- begin app-main -->
                <div class="app-main" id="main">
                    <!-- begin container-fluid -->
                    <div class="container-fluid">
                        <!-- begin row -->
                        <div class="row">
                            <div class="col-md-12 m-b-30">
                                <div class="d-block d-sm-flex flex-nowrap align-items-center">
                                    <div class="page-title mb-2 mb-sm-0">
                                        <h1>Booking Details</h1>
                                    </div>
                                    <div class="ml-auto d-flex align-items-center">
                                        <nav>
                                            <ol class="breadcrumb p-0 m-b-0">
                                                <li class="breadcrumb-item">
                                                    <a href="<?=base_url();?>admin/"><i class="ti ti-book"></i></a>
                                                </li>
                                                <li class="breadcrumb-item">
                                                    Bookings
                                                </li>
                                                <li class="breadcrumb-item active text-primary" aria-current="page">Booking Details</li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- begin row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <button id="updateStatus" data-id="<?=$bookingDetails['booking_id'];?>" class="btn btn-info"><i class="fa fa-shopping-cart"></i> Finish</button>
                                <button id="reschedule" data-account-id = "<?=$bookingDetails['account_information_id'];?>" data-id="<?=$bookingDetails['booking_id'];?>" class="btn btn-info"><i class="fa fa-clock-o"></i> Send Re-Schedule Email</button>
                                <button id="dropOff" data-account-id = "<?=$bookingDetails['account_information_id'];?>" data-id="<?=$bookingDetails['booking_id'];?>" class="btn btn-info"><i class="fa fa-truck"></i> Drop Off</button>
                                <a href = "/admin/bookings/generatePdf/<?=$bookingDetails['booking_id'];?>" download target="_blank" class="btn btn-info"><i class="fa fa-download"></i> Download PDF</a>
                                <img src="<?=base_url();?>assets/images/Logo-header.png" />
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="2" style="text-align: center; text-transform: uppercase;">Booking Details</th>
                                            <th hidden><input type="text" name="booking_id" id="booking_id" value="<?=$bookingDetails['booking_id'];?>" /></th>
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
                                            <td><input type="text" class="form-control" name="pickupDate" id="pickUpDate" value="<?=$bookingDetails['picking_date'] ? $bookingDetails['picking_date'] : '';?>" /></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold;">Pickup Time</td>
                                            <td><input type="text" class="form-control" name="pickUpTime" id="pickUpTime" value="<?=$bookingDetails['picking_time'] ? date('h:i A', strtotime($bookingDetails['picking_time'])) : "N/A";?>" /></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold;">Base Price</td>
                                            <td id="basePrice"><?= $bookingDetails['base_price']; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold;">Additional Box Total Amount</td>
                                            <td id=""additionalBoxTotalAmount><?= $bookingDetails['addtl_box_total_amount']; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold;">Total Amount</td>
                                            <td id="overAllTotalAmount"><?= $bookingDetails['total_amount']; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold;">Notes</td>
                                            <td><?= $bookingDetails['notes']; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold;">Status</td>
                                            <td><?= $bookingDetails['status']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-6">
                                <table class="table table-bordered">
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
                            <div class="col-lg-6">
                                <table class="table table-bordered">
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
                                            <td><?php echo !empty($dropOffDetails) ? $dropOffDetails['streetName'] . ' ' . $dropOffDetails['streetNumber'] :
                                        'N/A'; ?></td>

                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold;">Return Date</td>
                                            <td><?php echo !empty($dropOffDetails) ? $dropOffDetails['returnDate'] : 'N/A'; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold;">Study Abroad</td>
                                            <td id="studyAbroad"><?=$serviceInformationDetails[0]['is_studying_abroad'];?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold;">Summer School</td>
                                            <td><?=$serviceInformationDetails[0]['is_summer_school'];?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold;">Row in Warehouse</td>
                                            <td><input type="number" oninput="validateInteger(this);" onkeyup="updateRowInWarehouse(this.value);" value="<?=$bookingDetails['row_in_warehouse'];?>" name="row_in_warehouse" id="row_in_warehouse" class="form-control" max="50" min="0" /></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="6" style="text-align: center; text-transform: uppercase;">Additional Items</th>
                                        </tr>
                                        <tr>
                                            <th>Item</th>
                                            <th>Size</th>
                                            <th>Quantity</th>
                                            <th>Amount</th>
                                            <th>Total Amount</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($bookingItemDetails)) : ?>
                                            <?php
                                            $totalAmountSum = 0; // Initialize a variable to store the sum
                                            foreach ($bookingItemDetails as $items) :
                                                $totalAmountSum += $items['totalamount']; // Add the current totalamount to the sum
                                            ?>
                                                <tr>
                                                    <td style="font-weight: bold;"><?= $items['item_name']; ?></td>
                                                    <td style="font-weight: bold;"><?= $items['size']; ?></td>
                                                    <td><input type="number" name="orig_quantity" id="orig_quantity" onkeydown="return false;" <?php if ($items['item_name'] === 'Additional Box') { echo 'max="10"'; } ?> <?php if ($items['item_name'] === 'Summer School Deliver Fee') { echo 'readonly'; } ?> oninput="validateInteger(this);" class="form-control orig_quantity" value="<?= $items['quantity'] ?>"></td>
                                                    <td class="orig_cost"><?= $items['cost'] ?></td>
                                                    <td class="totalAmount">$<?= $items['totalamount']; ?></td>
                                                    <td hidden><input type="text" name="booking_item_id" class="booking_item_id" id="booking_item_id" value="<?= $items['booking_item_id']; ?>" /></td>
                                                    <td>
                                                        <?php if ($items['item_name'] !== 'Additional Box' && $items['item_name'] !== 'Summer School Deliver Fee') : ?>
                                                            <a href="javascript:" style="color: red; font-size: 20px;" onclick="deleteRow(this);"><i class="fa fa-trash"></i></a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td>
                                                    <select class="form-control chosen-select" data-placeholder="Select an Item" name="item_id" id="item_id">
                                                        <option></option>
                                                        <?php foreach($item as $items) : ?>
                                                        <option value="<?=$items['item_id'];?>"><?=$items['item_name'];?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control chosen-select" data-placer="Select a Size" name="size_id" id="size_id">
                                                        <option></option>
                                                    </select>
                                                </td>
                                                <td><input type="number" min="1" onkeydown="return false;" class="form-control" name="quantity" id="quantity"></td>
                                                <td id="newItemAmount">$0.00</td>
                                                <td id="newItemTotalAmount">$0.00</td>
                                                <td><a href="javascript:" class="checkmark" style="color: green; font-size: 20px;"><i class="fa fa-check"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="text-align: right; font-weight: bold;">Total:</td>
                                                <td colspan="2" class="overAllTotalAmount" id="totalAmountRow">$<?= number_format($totalAmountSum, 2); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-12">
                                <textarea name="admin_notes" id="admin_notes" class="form-control" cols="30" rows="10" style="resize: none; padding: 20px;" placeholder="Notes..."><?= $bookingDetails['admin_notes']; ?></textarea>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end container-fluid -->
                </div>
                <!-- end app-main -->
            </div>
            <!-- end app-container -->
            <script>
                var booking_id = '<?=$booking_id;?>';
            </script>
            <script src="<?=base_url();?>assets_admin/js/custom/admin/bookingdetails.js"></script>
            <?=$this->include('templates/admin/footer');?>