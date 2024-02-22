    <?=$this->include('templates/header');?>
    <main>
        <section class="scheduling-time">
          <div class="container">
            <div class="container-title">
              <h2>Drop Off Information</h2>
            </div>
            <div class="account-container">
               <form id="drop-off-information">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-row align-items-end">
                            <div class="col-lg-6" hidden>
                                <div class="form-wrapper common-wrapper">
                                    <h3>Reference Code *</h3>
                                    <input type="text" placeholder="Reference Code*" name="referenceCode" id="referenceCode" value="<?=$referenceCode;?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-wrapper common-wrapper">
                                    <h3>Student Name *</h3>
                                    <input type="text" placeholder="First Name*" name="firstName" id="firstName">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-wrapper common-wrapper">
                                    <input type="text" placeholder="Last Name*" name="lastName" id="lastName">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                           <div class="col-12">
                            <div class="form-wrapper common-wrapper">
                                <h3>Student ID# *</h3>
                                <input type="text" placeholder="--- ----- ----" name="studentNumber" id="studentNumber">
                            </div>  
                           </div>
                        </div>
                         <div class="form-row">
                            <div class="col-12">
                             <div class="option-field">
                              <div class="form-row">
                                <div class="col-lg-6">
                                  <div class="form-wrapper common-wrapper">
                                    <h4>Street name (optional)</h4>
                                    <input type="text" name="streetName" id="streetName">
                                  </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-wrapper common-wrapper">
                                    <h4>Street number (optional)</h4>
                                    <input type="text" name="streetNumber" id="streetNumber">
                                  </div>
                                </div>
                                <div class="col-lg-6"></div>
                              </div>
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
                             <div class="form-wrapper common-wrapper">
                                 <h3>Dorm Room Number  *</h3>
                                  <input type="number" min="1" name="roomNumber" id="roomNumber">
                             </div>   
                            </div>
                         </div>
                         <div class="form-row">
                            <div class="col-12">
                                <div class="form-wrapper common-wrapper">
                                    <h3>Return Date*</h3>
                                    <input type="text" name="returnDate" id="returnDate" readonly>
                                </div>   
                            </div>
                         </div>
                    </div>
                </div>
               </form>
            </div>
            <div class="container-form-footer">
                <a href="javascript:$('#drop-off-information').submit();" class="continue-btn">SUBMIT <i class="fa fa-arrow-right"></i></a>
            </div>
          </div>
        </section>
    </main>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="<?=base_url();?>assets_admin/js/custom/drop-off-information.js"></script>
    <?=$this->include('templates/footer');?>