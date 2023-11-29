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
                                        <h1>Dashboard</h1>
                                    </div>
                                    <div class="ml-auto d-flex align-items-center">
                                        <nav>
                                            <ol class="breadcrumb p-0 m-b-0">
                                                <li class="breadcrumb-item">
                                                    <a href="<?=base_url();?>admin/"><i class="ti ti-home"></i></a>
                                                </li>
                                                <li class="breadcrumb-item">
                                                    Dashboard
                                                </li>
                                                <li class="breadcrumb-item active text-primary" aria-current="page">Dashboard</li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- begin row -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card card-statistics">
                                    <div class="row no-gutters">
                                        <div class="col-xxl-3 col-lg-12">
                                            <div class="p-20 border-lg-right border-bottom border-xxl-bottom-0">
                                                <div class="d-flex m-b-10">
                                                    <p class="mb-0 font-regular text-muted font-weight-bold">Total Clicks</p>
                                                    <a class="mb-0 ml-auto font-weight-bold" href="#"><i class="ti ti-more-alt"></i> </a>
                                                </div>
                                                <div class="d-block d-sm-flex h-100 align-items-center">
                                                    <div class="apexchart-wrapper">
                                                        <div id="analytics7"></div>
                                                    </div>
                                                    <div class="statistics mt-3 mt-sm-0 ml-sm-auto text-center text-sm-right">
                                                        <h3 class="mb-0"><i class="icon-arrow-up-circle"></i> 15,640</h3>
                                                        <p>Clicks</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-lg-12">
                                            <div class="p-20 border-xxl-right border-bottom border-xxl-bottom-0">
                                                <div class="d-flex m-b-10">
                                                    <p class="mb-0 font-regular text-muted font-weight-bold">Overall Earnings</p>
                                                    <a class="mb-0 ml-auto font-weight-bold" href="#"><i class="ti ti-more-alt"></i> </a>
                                                </div>
                                                <div class="d-block d-sm-flex h-100 align-items-center">
                                                    <div class="apexchart-wrapper">
                                                        <div id="analytics8"></div>
                                                    </div>
                                                    <div class="statistics mt-3 mt-sm-0 ml-sm-auto text-center text-sm-right">
                                                        <h3 class="mb-0"><i class="icon-arrow-up-circle"></i>$16,656</h3>
                                                        <p>Earnings</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-lg-12">
                                            <div class="p-20 border-lg-right border-bottom border-lg-bottom-0">
                                                <div class="d-flex m-b-10">
                                                    <p class="mb-0 font-regular text-muted font-weight-bold">Total Amount Owned</p>
                                                    <a class="mb-0 ml-auto font-weight-bold" href="#"><i class="ti ti-more-alt"></i> </a>
                                                </div>
                                                <div class="d-block d-sm-flex h-100 align-items-center">
                                                    <div class="apexchart-wrapper">
                                                        <div id="analytics9"></div>
                                                    </div>
                                                    <div class="statistics mt-3 mt-sm-0 ml-sm-auto text-center text-sm-right">
                                                        <h3 class="mb-0"><i class="icon-arrow-up-circle"></i>$569,000.00</h3>
                                                        <p>Owned</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xxl-3 m-b-30">
                                <div class="card card-statistics h-100 mb-0 widget-income-list">
                                    <div class="card-body d-flex align-itemes-center">
                                        <div class="media align-items-center w-100">
                                            <div class="text-left">
                                                <h3 class="mb-0">45.8k </h3>
                                                <span>Total Visits</span>
                                            </div>
                                            <div class="img-icon bg-pink ml-auto">
                                                <a href = "javascript:void(0);"><i class="ti ti-user text-white"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body d-flex align-itemes-center">
                                        <div class="media align-items-center w-100">
                                            <div class="text-left">
                                                <h3 class="mb-0">65.4k </h3>
                                                <span>Total Registered Candidates</span>
                                            </div>
                                            <div class="img-icon bg-primary ml-auto">
                                                <a href = "<?=base_url();?>admin/candidate-register-list"><i class="ti ti-user text-white"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body d-flex align-itemes-center">
                                        <div class="media align-items-center w-100">
                                            <div class="text-left">
                                                <h3 class="mb-0">78.2k </h3>
                                                <span>Total Job Posted</span>
                                            </div>
                                            <div class="img-icon bg-orange ml-auto">
                                                <a href = "<?=base_url();?>admin/job-masterlist"><i class="ti ti-briefcase text-white"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end container-fluid -->
                </div>
                <!-- end app-main -->
            </div>
            <!-- end app-container -->                
            <?=$this->include('templates/admin/footer')?>