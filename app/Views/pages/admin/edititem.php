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
                                        <h1>Edit Item</h1>
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
                                                <li class="breadcrumb-item active text-primary" aria-current="page">Edit Item</li>
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
                                    <form id="edititem" enctype="multipart/form-data">
                                        <div class="form-group" hidden="">
                                            <label for="item_id">Item ID</label>
                                            <input type="text" name="item_id" id="item_id" class="form-control" value="<?= $record['item_id']; ?>" placeholder="Enter Item ID">
                                        </div>
                                        <div class="form-group">
                                            <label for="item_name">Item Name</label>
                                            <input type="text" name="item_name" id="item_name" class="form-control" placeholder="Enter Item Name" value="<?= $record['item_name']; ?>">
                                        </div>
                                        <div class="sizes">
                                        <?php foreach ($sizes as $size) : ?>
                                            <div class="sizesLists">
                                                <div class="form-group">
                                                    <label for="size" style="float: left;">Size</label>
                                                    <div style="float: right;">
                                                        <a href="javascript:void(0);" onclick="addSizes();" title="Add Size">
                                                            <i class="fa fa-plus-circle" style="font-size: 18px; color: blue;"></i>
                                                        </a>
                                                        <a href="#" style="color: red; font-size: 18px;" class="remove-size">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                    <input type="hidden" class="form-control" value='<?= $size['size_id']; ?>' name="size_id[]">
                                                    <input type="text" class="form-control" value='<?= $size['size']; ?>' name="size[]">
                                                </div>
                                                <div class="form-group">
                                                    <label for="cost">Cost</label>
                                                    <input type="text" class="form-control" value="<?= $size['cost']; ?>" name="cost[]">
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                        </div>
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
            <script src="<?=base_url();?>assets_admin/js/custom/admin/edititem.js"></script>
            <?=$this->include('templates/admin/footer');?>