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
                                <h3>Our Base Package Includes Five 18 X 18 X 24 Boxes. If You Need Additional Boxes, Please Select Quantity Below ($50) Each. *</h3>
                                <div class="radio-container">
                                    <div class="radio-wrapper">
                                        <input type="radio" name ="is_boxes_included" id="is_boxes_included" value="Yes" checked>
                                        <label for="is_boxes_included"><span><div></div></span> Yes</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-wrapper common-wrapper">
                                <h3>Select Quantity Of Additional Boxes You Are Purchasing.  *</h3>
                                <select name="box_quantity" id="box_quantity" onchange="updateTotalPrice()">
                                    <option disabled selected>Select a quantity</option>
                                    <option hidden></option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
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
                            <div class="form-wrapper common-wrapper">
                                <h3>Select All That Apply, THEN SELECT QUANTITY*</h3>
                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <h5>Select Item</h5>
                                        <select name="item_id" id="item_id" onchange="getSizes();">
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
                                                <input type="number" name="quantity" id="quantity" />
                                            </div>
                                            <!-- new button to add -->
                                            <button type="button" onclick="updateTotal();"  class="btn btn-add"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-wrapper common-wrapper">
                                <h3>Do You Need Car Storage For May - August? (Full Summer)  *</h3>
                                <div class="radio-container">
                                    <div class="radio-wrapper">
                                        <input type="radio" name ="is_storage_car_in_may" id="is_storage_car_in_may1" value="Yes">
                                        <label for="is_storage_car_in_may1"><span><div></div></span> Yes</label>
                                    </div>
                                    <div class="radio-wrapper">
                                        <input type="radio" name ="is_storage_car_in_may" id="is_storage_car_in_may2" value="No" checked>
                                        <label for="is_storage_car_in_may2"><span><div></div></span> No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-wrapper common-wrapper">
                                <h3>Do You Need Other Vehicle Storage For May - August? (Full Summer)(Motorcycle, Scooter, Bike)*</h3>
                                <div class="radio-container">
                                    <div class="radio-wrapper">
                                        <input type="radio" name ="is_storage_vehicle_in_may" id="is_storage_vehicle_in_may1" value="Yes">
                                        <label for="is_storage_vehicle_in_may1"><span><div></div></span> Yes</label>
                                    </div>
                                    <div class="radio-wrapper">
                                        <input type="radio" name ="is_storage_vehicle_in_may" id="is_storage_vehicle_in_may2" value="No" checked>
                                        <label for="is_storage_vehicle_in_may2"><span><div></div></span> No</label>
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
                                <div class="summary-row" id="basePrice" data-cost="0.00">
                                    <h2>Base Price</h2>
                                    <h2 id="base-price-row">$0.00</h2>
                                </div>
                                <!-- Placeholder for dynamically generated rows -->
                                <div id="dynamic-summary-rows"></div>
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
                <a href="/scheduling/account-information" class="back-btn"><i class="fa fa-arrow-left"></i> BACK</a>
                <a href="javascript:void(0);" class="continue-btn">CONTINUE <i class="fa fa-arrow-right"></i></a>
            </div>
          </div>
        </section>
    </main>
    <script src="<?=base_url();?>assets_admin/js/custom/service-information.js"></script>
    <?=$this->include('templates/footer');?>