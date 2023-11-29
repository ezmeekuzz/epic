    <?=$this->include('templates/header');?>
    <main>
      <!-- FOR SECTIONS -->

      <section class="login">
        <div class="container">
          <div class="log-wrapper">
            <img src="assets/images/Logo-header.png" alt="" />
            <div class="google">
              <a href="#"><img src="assets/images/google.png" alt="" /></a>
            </div>
            <div class="or">
              <h1>or</h1>
            </div>

            <div class="form">
              <form>
                <input type="email" placeholder="Email*" />
                <div class="password-wrapper">
                  <input type="password" placeholder="Password" id="id_password"/>
                  <i class="fa fa-eye" id="togglePassword"></i>
                </div>
                <div class="forget">
                  <a href="#">Forgot password?</a>
                </div>
                <button>lOGIN</button>
                <a href="#"
                  >Don't have an account yet? <span>Sign Up!</span>
                </a>
              </form>
            </div>
          </div>
        </div>
      </section>
    </main>
    <?=$this->include('templates/footer');?>