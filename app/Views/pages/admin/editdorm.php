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
                                        <h1>Edit User</h1>
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
                                                <li class="breadcrumb-item active text-primary" aria-current="page">Edit Dorm</li>
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
                                            <h4 class="card-title"><i class="ti ti-user"></i> Dorms</h4>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form id="editdorm" enctype="multipart/form-data">
                                            <?php foreach($records as $row) : ?>
                                            <div class="form-group" hidden="">
                                                <label for="dorm_id">Dorm ID</label>
                                                <input type="text" name="dorm_id" id="dorm_id" class="form-control" value="<?=$row['dorm_id'];?>" placeholder="Enter User ID">
                                            </div>
                                            <div class="form-group">
                                                <label for="dorm_name">Dorm Name</label>
                                                <input type="text" name="dorm_name" id="dorm_name" class="form-control" placeholder="Enter First Name" value = "<?=$row['dorm_name'];?>">
                                            </div>
                                            <?php endforeach; ?>
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
            <script src="<?=base_url();?>assets_admin/js/custom/admin/editdorm.js"></script>
            <?=$this->include('templates/admin/footer');?>e