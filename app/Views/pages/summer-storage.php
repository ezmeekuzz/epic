    <?=$this->include('templates/header');?>
    <main>
        <section class="scheduling-time">
          <div class="container">
            <div class="container-title">
              <h2>Service  Information</h2>
            </div>
            <div class="service-container">
                <form id="serviceInformation">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-wrapper common-wrapper">
                                <h3>Our Base Package Includes (Five) 18” X 18” X 24” Boxes, Packing Tape, Secure storage, Pick -      up and redelivery.</h3>
                                <div class="radio-container"></div>
                            </div>
                            <div class="form-wrapper common-wrapper">
                                <!-- <h3>Select Quantity Of Additional Boxes You Are Purchasing.  *</h3> -->
                                <h3>If you need additional boxes, please select the quantity below ($50) Each.</h3>
                                <select name="box_quantity" id="box_quantity">
                                    <option disabled selected>Select a quantity</option>
                                    <option hidden></option>
                                    <?php foreach($additional_box as $box) : ?>
                                    <option value="<?=$box['size_id'];?>" data-item-id="<?=$box['item_id'];?>" data-quantity="<?=$box['size'];?>"><?=$box['size'];?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-wrapper common-wrapper">
                                <h3>Click YES To Purchase Storage For Additional Items. Selecting YES Will Expand A List Of Items To Choose From (Mini-Fridge, Microwave, TV). *</h3>
                                <div class="radio-container">
                                    <div class="radio-wrapper">
                                        <input type="radio" name ="is_storage_additional_item" id="is_storage_additional_item1" value="Yes" checked>
                                        <label for="is_storage_additional_item1"><span><div></div></span> Yes</label>
                                    </div>
                                    <div class="radio-wrapper">
                                        <input type="radio" name ="is_storage_additional_item" id="is_storage_additional_item2" value="No">
                                        <label for="is_storage_additional_item2"><span><div></div></span> No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-wrapper common-wrapper additional-items-form" style="display: none;">
                                <h3>Select All That Apply, THEN SELECT QUANTITY*</h3>
                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <h5>Select Item</h5>
                                        <select name="item_id" id="item_id">
                                            <option disabled selected>Select an item</option>
                                            <option hidden></option>
                                            <?php foreach($records as $item) : ?>
                                            <option value="<?=$item['item_id'];?>"><?=$item['item_name'];?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <h5>Choose Size</h5>
                                        <select name="size_id" id="size_id">
                                            <option disabled selected>Choose a size</option>
                                            <option hidden></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="quantity-row">
                                            <div class="inner">
                                                <h5>Select Quantity</h5>
                                                <input type="number" name="quantity" id="quantity" min="1" />
                                            </div>
                                            <!-- new button to add -->
                                            <button type="button" class="btn btn-add"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-wrapper common-wrapper">
                                <h3>Are you studying abroad?*</h3>
                                <div class="radio-container">
                                    <div class="radio-wrapper">
                                        <input type="radio" name ="studying_abroad" id="studying_abroad1" value="Yes">
                                        <label for="studying_abroad1"><span><div></div></span> Yes</label>
                                    </div>
                                    <div class="radio-wrapper">
                                        <input type="radio" name ="studying_abroad" id="studying_abroad2" value="No" checked>
                                        <label for="studying_abroad2"><span><div></div></span> No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-wrapper common-wrapper">
                                <h3>Are you doing summer school?</h3>
                                <div class="radio-container">
                                    <div class="radio-wrapper">
                                        <input type="radio" name ="is_summer_school" id="is_summer_school1" value="Yes">
                                        <label for="is_summer_school1"><span><div></div></span> Yes</label>
                                    </div>
                                    <div class="radio-wrapper">
                                        <input type="radio" name ="is_summer_school" id="is_summer_school2" value="No" checked>
                                        <label for="is_summer_school2"><span><div></div></span> No</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="price-summary">
                                <div class="serviceType" hidden>
                                    <label>Service Type</label>
                                    <input type="hidden" name="serviceType" id="serviceType" value="<?=session()->get('selectedService');?>" />
                                </div>
                                <div class="summary-row">
                                    <h2>Base Price (x 1)</h2>
                                    <h2 id="base-price-row">$425.00</h2>
                                </div>
                                <!-- Placeholder for dynamically generated rows -->
                                <div id="dynamic-summary-rows"></div>
                                <div id="studyAbroadAddtionalStoragePrice"></div>
                                <div class="total-summary-row">
                                    <h2>TOTAL</h2>
                                    <h3 id="total-price">$0.00</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="container-form-footer">
                <a href="javascript:void(0);" class="continue-btn">CONTINUE <i class="fa fa-arrow-right"></i></a>
            </div>
          </div>
        </section>
    </main>
    <script src="<?=base_url();?>assets_admin/js/custom/summer-storage.js"></script>
    <?=$this->include('templates/footer');?>