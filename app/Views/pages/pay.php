    <?=$this->include('templates/header');?>
    <main>
        <section class="scheduling-time">
          <div class="container">
            <div class="container-title">
              <h2 style="color: #89C4F2;">Payment</h2>
            </div>
            <div class="service-container">
               <form id="payment-form">
                <div class="row">
                    <div class="col-lg-6">
                       <div class="form-wrapper common-wrapper">
                            <h3>Please Indicate Any Special Instructions (Optional)</h3>
                            <textarea cols="30" name="notes" id="notes" rows="10"></textarea>
                       </div>
                        <div class="form-note">
                            <p>Check The Gray Box At Top Right Of Form For Your Total. Click "Pay Now" To Complete Your Storage Solutions Reservation.</p>
                        </div>
                        <div class="form-row align-items-end">
                            <div class="col-12">
                                <div class="form-wrapper common-wrapper">
                                    <h3>Enter The Name Of The Cardholder*</h3>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-wrapper common-wrapper">
                                    <input type="text" placeholder="First Name*" name="fname" id="fname">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-wrapper common-wrapper">
                                    <input type="text" placeholder="Last Name*" name="lname" id="lname">
                                </div>
                            </div>
                        </div>
                        <div class="form-row align-items-end">
                            <div class="col-lg-12">
                                <div class="form-wrapper common-wrapper">
                                  <div id="card-container"></div>
                                  <div id="payment-status-container" style="visibility: hidden;"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-wrapper common-wrapper">
                                    <img src="assets/images/assets/logo.png" alt="">
                                </div>
                            </div>
                            <div class="col-lg-6" hidden>
                              <button id="card-button">Submit Payment</button>
                            </div>
                        </div>
                        <div class="form-row align-items-end">
                            <p><b>TERMS & CONDITIONS</b> <br>
                                I Have Read To And Understand The <a href="javascript: void(0)" style="color: #89C4F2; text-decoration: underline;" data-toggle="modal" data-target="#terms">Terms & Conditions</a> Of Epic Storage Solutions.
                            </p>
                            <div class="checkbox-container">
                                <div class="checkbox-wrapper">
                                    <input type="checkbox" name ="terms_conditions" id="choice_4_1">
                                    <label for="choice_4_1"><span><div></div></span> Yes</label>
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
                                <input type="hidden" name="base_name" id="base_name" value="Base Price" />
                                <input type="hidden" name="base_amount" id="base_amount" value="425.00" />
                                <input type="hidden" name="base_total_amount" id="base_total_amount" value="425.00" />
                                <input type="hidden" name="base_quantity" id="base_quantity" value="1" />
                            </div>
                            <div id="additional-box-row"></div>
                            <div id="dynamic-summary-rows"></div>
                            <div class="total-summary-row">
                                <h2>TOTAL</h2>
                                <h3 id="total-price">$0.00</h3>
                                <input type="hidden" name="totalAmount" id="totalAmount" value="0.00" />
                            </div>
                        </div>
                    </div>
                </div>
              </form>
            </div>
            <div class="container-form-footer">
                <a href="/scheduling/service-information/<?=session()->get('selectedService');?>" class="back-btn"><i class="fa fa-arrow-left"></i> BACK</a>
                <a href="javascript:void(0);" class="continue-btn">CONTINUE <i class="fa fa-arrow-right"></i></a>
            </div>
          </div>
        </section>
    </main>
    <div id="loading">
        <img id="loading-image" src="<?=base_url();?>assets_admin/img/loader.gif" alt="Loading..." />
    </div>


    <!-- modal -->
    <div class="modal fade" id="terms" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
        
          <div class="modal-body">
            <div class="terms">
              <h1>Terms & Conditions</h1>
              <p>
                The Customer and the Company known as EPIC Storage Solutions, LLC (EPIC) agree to the following terms and conditions as confirmed upon check out of the online cart:
              </p>
              <h2>OWNERSHIP OF PROPERTY:</h2>
              <p>
                The Customer has represented and warranted to EPIC that they are the legal owner or in lawful possession of the Property and has the legal right and authority to contract for services for all the Property tendered upon provisions, limitations, terms, and conditions herein set forth and that there are no existing liens, mortgages, or encumbrances on the Property.  In the event the Company should incur any costs and expenses, including attorney’s fees, because of Customer’s misrepresentation or breach of this agreement, Customer agrees to pay all said costs and expenses and Company shall have a lien on the Property for all charges that may be due to it as well as for such costs and expenses.
              </p>
              <h2>PAYMENT:</h2>
              <p>
                It is agreed that the Company shall have a general lien upon all the Property deposited with it or hereafter deposited with it. All goods deposited upon which storage and all other charges are not paid when due, will be sold at public auction to pay accrued charges and expenses of the sale, after due notice to the depositor, and publication of the time and place of said sale, according to NC law. The Company shall have a further lien for all monies advanced to any third parties for account of the Customer.
              </p>
              <p>
                Accounts are due and payable upon Customer contracting Company’s service via the checkout function on Company’s website.   All charges must be paid in cash, money order, cashier’s check, or major credit card before services are rendered. 
              </p>
              <h2>LIMITATION OF LIABILITY:</h2>
              <p>
                The Company when transporting to or from the warehouse for storage acts as a private carrier only, reserving the right to refuse any order for transportation.
              </p>
              <p>This contract is accepted subject to delays or damages caused by war, insurrection, labor troubles, strikes, Acts of God or the public enemy, riots, the elements, street traffic, elevator services or other causes beyond the control of the Company.</p>
              <p>
                The Company is not responsible for any fragile articles injured or broken. The Company will not be responsible for mechanical or electrical functioning of any article.
              </p>
              <p>No liability of any kind shall attach to the Company for any preexisting damage caused to the goods by inherent vice, moths, vermin, rust, fire, water, fumigation, or deterioration. EPIC reserves the right to open and inspect and repack client's boxes and property in the event of a natural disaster or other similar event to preserve client's property and/or the property of other EPIC Customers.  If client's boxes or property contain hazardous substances, materials or vermin, client shall be responsible for the costs of the removal of said substances, materials, or vermin and for damages to any other EPIC clients' property caused by said substances, materials, or vermin.</p>
              <p>Unless a greater valuation is stated herein, the Customer declares that the value of the Property in case of loss or damage arising out of storage, transportation, packing, unpacking, clearing or handling of the goods shall not exceed, and is strictly limited to not more than the total of the cost paid by the Customer to the Company for its services.   The Customer may declare a higher valuation, without limitation, in case of loss or damage from any cause, whether the fault of the Company, its principals, its agents, employees, successors and/or assigns, or an act of God, or other reason.  In the event the Customer chooses to declare a higher valuation; the Company reserves the right to require the Customer to supply a certificate of insurance to cover any losses and the Company reserves the right to assess a higher rate for service based on the increased risk of loss.  The Company has the right to refuse to store, transport, pack, unpack, clearing or handling of the Property and the Company will refund the Customer for any services not rendered. </p>
              <p>Unless a greater valuation is stated herein, the Customer declares that the value of the Property in case of loss or damage arising out of storage, transportation, packing, unpacking, clearing or handling of the goods shall not exceed, and is strictly limited to not more than the total of the cost paid by the Customer to the Company for its services.   The Customer may declare a higher valuation, without limitation, in case of loss or damage from any cause, whether the fault of the Company, its principals, its agents, employees, successors and/or assigns, or an act of God, or other reason.  In the event the Customer chooses to declare a higher valuation; the Company reserves the right to require the Customer to supply a certificate of insurance to cover any losses and the Company reserves the right to assess a higher rate for service based on the increased risk of loss.  The Company has the right to refuse to store, transport, pack, unpack, clearing or handling of the Property and the Company will refund the Customer for any services not rendered. </p>
              <h2>ADDRESS AND CHANGE:</h2>
              <p>
                It is agreed that the address (Dorm and Room) of the Customer will be given upon contracting services and shall be relied upon as the Company’s sole form of communications. It is expected that all address changes and forms of communication (emails and/or phone) will be communicated in a timely fashion to the Company. 
              </p>
              <h2>FILING OF CLAIM-NOTICE:</h2>
              <p>
                As a condition precedent to recovery, claims must be in writing to the Company’s claims department.  No action may be maintained by the Customer against the Company either by suit or arbitration to recover for claimed loss or damage, unless commenced within ten (10) days after the date of delivery by the Company. The Company shall have the right to inspect, and repair alleged damaged articles.
              </p>
              <h2>ARBITRATION:</h2>
              <p>
                Any controversy or claim arising out of or relating to this contract and/or the breach thereof, or the goods affected thereby, whether such claims be found in tort or contract shall be settled by arbitration and shall be controlled by North Carolina law and under the rules the rules of the American Arbitration Association, provided however, that upon any such arbitration the arbitrator(s) may not vary or modify any of the foregoing provisions.
              </p>
              <h2>AGREEMENT:</h2>
              <p>
                The contract represents the entire agreement between the parties hereto and cannot be modified except in writing and shall be deemed to apply to all the Property of any nature of description which the company may now or any time in the future store, pack, transport or ship for the Customer.
              </p>
              <h2>GENERAL CONDITIONS:</h2>
              <p>
                If the Property cannot be delivered by stairs or elevator, the Customer agrees to pay an additional charge for hoisting or lowering or other necessary labor to affect delivery. Customer shall arrange in advance for all necessary elevator and other services and any charges for same shall be paid immediately by the Customer. 
              </p>
              <p>
                Moving charges do not include the taking down or putting up of doors, fixtures, banisters or other fitting, or the relaying of floor coverings, or similar services.  All such provisions will be made and paid for by Customer prior to and after our arrival.
              </p>
              <p>
                Packing fees will be charged on an hourly rate of $150.00 per hour. The packer will perform all packing duties on behalf of the Customer. The Customer will approve all packed boxes upon completion of work. The Company is not responsible for any fragile articles injured or broken. The Company will not be responsible for mechanical or electrical functioning of any article.  No liability of any kind shall attach to the Company for any preexisting damage caused to the goods by inherent vice, moths, vermin, rust, fire, water, fumigation, or deterioration.
              </p>
              <h2>STORAGE:</h2>
              <p>
                Storage is in a conditioned environment. The offering is customized on per Customer basis and the cost of the Company’s services are outlined on the Company’s website upon ordering.  The Company’s service is billed upon execution of the agreement.  All remaining storage fees along with any additional charges for shipping, packaging and extended storage will be negotiated on a case-by-case basis between the Company and the Customer. 
              </p>
              <h2>PICK UP / DELIVERY: </h2>
              <p>
                Customer shall provide a clear path free from snow, ice, mud, etc. for the safety of all parties.  The Company reserves the right to pick up for multiple Customers at once. 
              </p>
              <h2>SCHEDULING:  </h2>
              <p>
                To maintain reasonable rates and quality service, the Company must combine moves. This requires constant change and updating to the Company’s schedule.  The Company will attempt to give the Customer a 24-hour notice when dates are scheduled or changed.  On the day of the move, Company will give Customer a one-hour window.  If Customer should need to be elsewhere during this time, Customer shall provide Company with a contact number that Company’s driver can call one hour prior to arrival. 
              </p>
              <p>Weather and other circumstances beyond Company’s control may prevent Company from meeting exact time schedules.  Customers are welcome to call the office at any time for an update. The Company’s crews work seven days a week from 7 AM to 10 PM.  If the Company attempts a scheduled pick-up or delivery and no one is available, a charge of $50 will apply to cover the additional handling and labor required. </p>
              <p>There will be a 24-hour grace period for canceling or adjusting pickup and delivery times. Inside of the 24-hour grace period, the Company has the right to charge a $50.00 change fee. Any changes to the Customer’s schedule will be handled on a best-case scenario and will be communicated to the Customer. </p>
              <h2>SHIPPING: </h2>
              <p>
                The offering is customized on a per individual basis and the cost of the Company's services are outlined on the Company's website upon ordering.  The Company's service is billed upon execution of the agreement.  All remaining shipping fees along with additional charges will be negotiated on a case-by-case basis between the Customer and the Company.
              </p>
              <h2>PACKING: </h2>
              <p>
                Packing fees will be charged on an hourly rate of $150.00 per hour/per person from Company. The packer (s) will perform all packing duties on behalf of the Customer.  The Customer will approve all packed boxes upon completion of work. The Company will not be responsible for any fragile articles injured or broken. The Company will not be responsible for mechanical or electrical functioning of any article.  No liability of any kind shall attach to the Company for any preexisting damage caused to the goods by inherent vice, moths, vermin, rust, fire, water, fumigation, or deterioration.
              </p>
              <h2>VEHICLE STORAGE:  </h2>
              <p>
                Customer must provide us with documentary proof that you have either, ownership or are in legal charge over the vehicle that you propose to place with us. This may be via a copy of a Vehicle Title or Vehicle Registration. All information will be copied for our files. 
              </p>
              <p>Customer may not place a stolen or illegally possessed or repossessed vehicle with us. Any such attempt will be reported to the police. </p>
              <p>Customer shall, prior to our completion of any storage agreement, notify us in detail of any special issues, conditions, requirements, or precautions that may be particular to your vehicle or type. </p>
              <p>The vehicle will be presented for inspection prior to acceptance for entry to storage in a condition that presents no likelihood of risk of damage or injury, to either our staff or representatives, or other vehicles within the facility or the facility itself. </p>
              <p>No explosive or dangerous articles may be left within the vehicle. All personal items should be removed from the vehicle. No responsibility will be held for any items remaining. </p>
              <p>Fuel tank contents are advised to be maintained to a level that will allow periodic or sporadic movement of the vehicle whilst in our care for the period planned. It is advised that if a vehicle is expected to be stored for a prolonged period, the fuel tank is filled to maximum to reduce excessive condensation within the ullage and therefore fuel contamination with water being kept to a minimum. </p>
              <p>Battery condition can be affected dramatically when left for prolonged periods of un-use. If no instruction for battery care is requested, we will not be liable for battery deterioration as a result. Refer to additional services within our web pages. </p>
              <p>You agree to indemnify Company against any loss or damage how-so-ever resulting from any breach of the above. </p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <script src="<?=base_url();?>assets_admin/js/custom/pay.js"></script>
    <?=$this->include('templates/footer');?>