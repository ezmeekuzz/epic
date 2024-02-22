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
              <form method="POST" action="/loginfunc">
                <?php if (session()->has('error')) : ?>
                  <center>
                    <div class="alert alert-danger">
                      <?= session('error') ?>
                    </div>
                  </center><br>
                <?php endif; ?>
                <input type="email" placeholder="Email*" name="email_address" />
                <div class="password-wrapper">
                  <input type="password" placeholder="Password" name="password" id="id_password"/>
                  <i class="fa fa-eye" id="togglePassword"></i>
                </div>
                <div class="forget">
                  <a href="#">Forgot password?</a>
                </div>
                <button>LOGIN</button>
                <a href="/sign-up"
                  >Don't have an account yet? <span>Sign Up!</span>
                </a>
              </form>
            </div>
          </div>
        </div>
      </section>
    </main>
    <?=$this->include('templates/footer');?>