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
                                        <h1>Add Item</h1>
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
                                                <li class="breadcrumb-item active text-primary" aria-current="page">Add Item</li>
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
                                            <h4 class="card-title"><i class="ti ti-archive"></i> Items & Sizes</h4>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form id="additem" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="item_name">Item Name</label>
                                                <input type="text" name="item_name" id="item_name" class="form-control" placeholder="Enter First Name">
                                            </div>
                                            <div class="form-group">
                                                <label for="size" style="float: left;">Size</label>
                                                <div style="float: right;">
                                                    <a href="javascript:void(0);" onclick="addsizes();" title="Add Size"><i class="fa fa-plus-circle" style="font-size: 18px; color: blue;"></i></a>
                                                </div>
                                                <input type="text" class="form-control" id="size" name="size[]" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="cost">Cost</label>
                                                <input type="text" class="form-control" id="cost" name="cost[]" placeholder="0.00">
                                            </div>
                                            <div class="sizes"></div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
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
            <script src="<?=base_url();?>assets_admin/js/custom/admin/additem.js"></script>
            <?=$this->include('templates/admin/footer');?>ad