    <?=$this->include('templates/header');?>
    <main>
        <section class="scheduling-time">
          <div class="container">
            <div class="container-title">
              <h2>Account Information</h2>
            </div>
            <div class="account-container">
               <form id="account-information">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-row align-items-end">
                            <div class="col-lg-6">
                                <div class="form-wrapper common-wrapper">
                                    <h3>Student Name *</h3>
                                    <input type="text" placeholder="First Name*" name="first_name" id="first_name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-wrapper common-wrapper">
                                    <input type="text" placeholder="Last Name*" name="last_name" id="last_name">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                           <div class="col-12">
                            <div class="form-wrapper common-wrapper">
                                <h3>Student ID# *</h3>
                                <input type="text" placeholder="--- ----- ----" name="student_id" id="student_id">
                            </div>  
                           </div>
                        </div>
                        <div class="form-row">
                           <div class="col-12">
                            <div class="form-wrapper common-wrapper">
                                <h3>Student Phone Number *</h3>
                                <input type="tel" name="phone_number" id="phone_number">
                            </div>  
                           </div>
                        </div>
                        <div class="form-row">
                           <div class="col-12">
                            <div class="form-wrapper common-wrapper">
                                <h3>Student Email *</h3>
                                <input type="email" name="email_address" id="email_address">
                            </div>  
                           </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-row">
                            <div class="col-12">
                             <div class="form-wrapper common-wrapper">
                                 <h3>Dorm Name For May Pick-Up  *</h3>
                                 <select name="dorm_id" id="dorm_id">
                                    <option hidden></option>
                                    <option disabled></option>
                                    <?php foreach($records as $dorm) : ?>
                                    <option value="<?=$dorm['dorm_id'];?>"><?=$dorm['dorm_name'];?></option>
                                    <?php endforeach; ?>
                                 </select>
                             </div>  
                            </div>
                         </div>
                         <div class="form-row">
                            <div class="col-12">
                             <div class="form-wrapper common-wrapper">
                                 <h3>Dorm Room Number  *</h3>
                                  <input type="number" value="1" min="1" name="dorm_room_number" id="dorm_room_number">
                             </div>  
                             <div class="option-field">
                              <div class="form-row">
                                <div class="col-lg-6">
                                  <div class="form-wrapper common-wrapper">
                                    <h4>Street name (optional)</h4>
                                    <input type="text" name="street_name" id="street_name">
                                  </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-wrapper common-wrapper">
                                    <h4>Street number (optional)</h4>
                                    <input type="text" name="street_number" id="street_number">
                                  </div>
                                </div>
                                <div class="col-lg-6"></div>
                              </div>
                             </div>
                            </div>
                         </div>
                         <div class="form-row">
                            <div class="col-12">
                                <div class="form-wrapper common-wrapper">
                                    <h3>Parent Phone Number*</h3>
                                    <input type="tel" name="parent_phone_number" id="parent_phone_number">
                                </div>   
                            </div>
                         </div>
                         <div class="form-row">
                            <div class="col-12">
                                <div class="form-wrapper common-wrapper">
                                    <h3>Parent Email *</h3>
                                    <input type="email" name="parent_email_address" id="parent_email_address">
                                </div>   
                            </div>
                         </div>
                    </div>
                </div>
               </form>
            </div>
            <div class="container-form-footer">
                <a href="/scheduling/intro" class="back-btn"><i class="fa fa-arrow-left"></i> BACK</a>
                <a href="javascript:void(0);" class="continue-btn">CONTINUE <i class="fa fa-arrow-right"></i></a>
            </div>
          </div>
        </section>
    </main>
    <script src="<?=base_url();?>assets_admin/js/custom/account-information.js"></script>
    <?=$this->include('templates/footer');?>