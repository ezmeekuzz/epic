    <?=$this->include('templates/header');?>
    <main>
      <!-- FOR SECTIONS -->
      <section
        class="contact-banner"
        style="background-image: url('assets/images/6-1.png')"
      >
        <div class="container">
          <div class="row wrapper">
            <div class="col-lg-5">
              <div class="contact-content">
                <h1>Questions? Comments? You're in the right place.</h1>
                <p>
                  Rather talk to us in person? Give us a call at
                  <span>336-549-5216.</span>
                </p>
                <div class="list">
                  <img src="assets/images/fb.png" alt="" />
                  <img src="assets/images/twi.png" alt="" />
                  <img src="assets/images/in.png" alt="" />
                </div>
              </div>
            </div>

            <div class="col-lg-7">
              <div class="con-form">
                <form id="sendmessage">
                  <input type="text" name="firstname" id="firstname" placeholder="FIRST NAME" />
                  <input type="text" name="lastname" id="lastname" placeholder="LAST NAME" />
                  <input type="number" name="phone" id="phone" placeholder="PHONE" />
                  <input type="email" name="email" id="email" placeholder="EMAIL" />
                  <textarea name="message" id="message" cols="66" rows="6" placeholder="MESSAGE" ></textarea>
                  <button type="button" onclick="submitForm()">SUBMIT NOW</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
    <script src="<?=base_url();?>assets_admin/js/custom/contact.js"></script>
    <?=$this->include('templates/footer');?>