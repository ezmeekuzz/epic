    <?=$this->include('templates/header');?>
    <main>
      <!-- FOR SECTIONS -->

      <section class="login">
        <div class="container">
          <div class="log-wrapper">
            <img src="assets/images/Logo-header.png" alt="" />
            <div class="form">
              <form method="POST" action="/sendEmail">
                <?php if (session()->has('error')) : ?>
                    <center>
                        <div class="alert alert-danger">
                        <?= session('error') ?>
                        </div>
                    </center><br>
                    <?php elseif (session()->has('success')) : ?>
                    <center>
                        <div class="alert alert-success">
                        <?= session('success') ?>
                        </div>
                    </center><br>
                <?php endif; ?>
                <input type="email" placeholder="Email*" name="email_address" />
                <div class="forget">
                  <a href="/login">Login</a>
                </div>
                <button>SUBMIT</button>
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