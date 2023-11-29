    <?=$this->include('templates/header');?>
    <main>
        <section class="scheduling-time">
          <div class="container">
            <div class="container-title">
              <h2>Service  Information</h2>
            </div>
            <div class="service-container">
               <form action="">
                <div class="row">
                    <div class="col-lg-6">
                       <div class="form-wrapper common-wrapper">
                            <h3>Our Base Package Includes Five 18 X 18 X 24 Boxes. If You Need Additional Boxes, Please Select Quantity Below ($50) Each. *</h3>
                            <div class="radio-container">
                                <div class="radio-wrapper">
                                    <input type="radio" name ="choice_1" id="choice_1_1" checked>
                                    <label for="choice_1_1"><span><div></div></span> Yes</label>
                                </div>
                                <!-- <div class="radio-wrapper">
                                    <input type="radio" name ="choice_1" id="choice_1_2">
                                    <label for="choice_1_2"><span><div></div></span> No</label>
                                </div> -->
                            </div>
                       </div>
                       <div class="form-wrapper common-wrapper">
                            <h3>Select Quantity Of Additional Boxes You Are Purchasing.  *</h3>
                            <select name="" id="">
                                <option value="">1</option>
                                <option value="">2</option>
                                <option value="">3</option>
                                <option value="">4</option>
                                <option value="">5</option>
                                <option value="">6</option>
                                <option value="">7</option>
                                <option value="">8</option>
                                <option value="">9</option>
                                <option value="">10</option>
                            </select>
                        </div>
                        <div class="form-wrapper common-wrapper">
                            <h3>Click YES To Purchase Storage For Additional Items. Selecting YES Will Expand A List Of Items To Choose From (Mini-Fridge, Microwave, TV). *</h3>
                            <div class="radio-container">
                                <div class="radio-wrapper">
                                    <input type="radio" name ="choice_2" id="choice_2_1">
                                    <label for="choice_2_1"><span><div></div></span> Yes</label>
                                </div>
                                <div class="radio-wrapper">
                                    <input type="radio" name ="choice_2" id="choice_2_2">
                                    <label for="choice_2_2"><span><div></div></span> No</label>
                                </div>
                            </div>
                       </div>
                       <div class="form-wrapper common-wrapper">
                            <h3>Select All That Apply, THEN SELECT QUANTITY*</h3>
                            <div class="form-row">
                                <div class="col-lg-4">
                                    <h5>Select Item</h5>
                                    <select name="" id="">
                                        <option value="">TV</option>
                                        <option value="">Refregirator</option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <h5>Choose Size</h5>
                                    <select name="" id="">
                                        <option value="">10 x 24</option>
                                        <option value="">placeholder text</option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <h5>Select Quantity</h5>
                                    <select name="" id="">
                                        <option value="">1</option>
                                        <option value="">2</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-wrapper common-wrapper">
                            <h3>Do You Need Car Storage For May - August? (Full Summer)  *</h3>
                            <div class="radio-container">
                                <div class="radio-wrapper">
                                    <input type="radio" name ="choice_3" id="choice_3_1">
                                    <label for="choice_3_1"><span><div></div></span> Yes</label>
                                </div>
                                <div class="radio-wrapper">
                                    <input type="radio" name ="choice_3" id="choice_3_2" checked>
                                    <label for="choice_3_2"><span><div></div></span> No</label>
                                </div>
                            </div>
                       </div>
                       <div class="form-wrapper common-wrapper">
                          <h3>Do You Need Other Vehicle Storage For May - August? (Full Summer)(Motorcycle, Scooter, Bike)*</h3>
                          <div class="radio-container">
                              <div class="radio-wrapper">
                                  <input type="radio" name ="choice_4" id="choice_4_1">
                                  <label for="choice_4_1"><span><div></div></span> Yes</label>
                              </div>
                              <div class="radio-wrapper">
                                  <input type="radio" name ="choice_4" id="choice_4_2" checked>
                                  <label for="choice_4_2"><span><div></div></span> No</label>
                              </div>
                          </div>
                      </div>
                      <div class="form-wrapper common-wrapper">
                        <h3>Are you doing summer school?</h3>
                        <div class="radio-container">
                            <div class="radio-wrapper">
                                <input type="radio" name ="choice_5" id="choice_5_1">
                                <label for="choice_5_1"><span><div></div></span> Yes</label>
                            </div>
                            <div class="radio-wrapper">
                                <input type="radio" name ="choice_5" id="choice_5_2" checked>
                                <label for="choice_5_2"><span><div></div></span> No</label>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="price-summary">
                            <div class="summary-row">
                                <h2>Base Price</h2>
                                <h2>$425.00
                                </h2>
                            </div>
                            <div class="summary-row">
                                <h3>24 inch or smaller TV  (1)</h3>
                                <h2>$45 .0
                                </h2>
                            </div>
                            <div class="total-summary-row">
                                <h2>TOTAL</h2>
                                <h3>$425.00</h3>
                            </div>
                        </div>
                    </div>
                </div>
               </form>
            </div>
            <div class="container-form-footer">
                <a href="/scheduling/account-information" class="back-btn"><i class="fa fa-arrow-left"></i> BACK</a>
                <a href="payment.html" class="continue-btn">CONTINUE <i class="fa fa-arrow-right"></i></a>
            </div>
          </div>
        </section>
    </main>
    <script src="<?=base_url();?>assets_admin/js/custom/account-information.js"></script>
    <?=$this->include('templates/footer');?>