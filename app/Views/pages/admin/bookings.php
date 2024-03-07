                <?=$this->include('templates/admin/header')?>
                <?=$this->include('templates/admin/sidebar')?>
                <!-- begin app-main -->
                <div class="app-main" id="main">
                    <!-- begin container-fluid -->
                    <div class="container-fluid">
                        <!-- begin row -->
                        <div class="row">
                            <div class="col-md-12 m-b-30">
                                <div class="d-block d-sm-flex flex-nowrap align-items-center">
                                    <div class="page-title mb-2 mb-sm-0">
                                        <h1>Bookings</h1>
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
                                                <li class="breadcrumb-item active text-primary" aria-current="page">Bookings</li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- begin row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-statistics">
                                    <div class="card-header">
                                        <div class="card-heading">
                                            <h4 class="card-title float-left"><i class="ti ti-book"></i> Bookings</h4>
                                            <div class="float-right">
                                                <div class="form-group">
                                                    <a class="btn btn-success" href="javascript:void(0);" id="exportCsv"><i class="fa fa-file-excel-o"></i> Export</a>
                                                    <a class="btn btn-success" href="javascript:void(0);" id="sendAllDropOffNotification"><i class="fa fa-truck"></i> Send Drop Off Notification to Everyone</a>
                                                    <a class="btn btn-success" href="javascript:void(0);" id="sendAllPickUpNotification"><i class="fa fa-truck"></i> Send Pick Up Notification to Everyone</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="datatable-wrapper table-responsive">
                                            <table id="bookings" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Service Type</th>
                                                        <th>Customer</th>
                                                        <th>Booking Date</th>
                                                        <th>Base Price</th>
                                                        <th>Addtl. Box Qty</th>
                                                        <th>Addtl. Box Total Amount</th>
                                                        <th>Total Amount</th>
                                                        <th>Schedule</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <iframe id="exportFrame" style="display: none;"></iframe>
                        <!-- end row -->
                    </div>
                    <!-- end container-fluid -->
                </div>
                <!-- end app-main -->
            </div>
            <!-- end app-container -->  
            <div class="modal fade" id="bookingDetails" tabindex="-1" role="dialog" aria-labelledby="bookingDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="bookingDetailsModalLabel"><i class="fa fa-info-circle"></i> Booking Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="text-align: justify;">
                            <div id="displayDetails"></div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="<?=base_url();?>assets_admin/js/custom/admin/bookings.js"></script>              
            <?=$this->include('templates/admin/footer')?>