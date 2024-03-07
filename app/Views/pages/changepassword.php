    <?=$this->include('templates/header');?>
    <main>
      <!-- FOR SECTIONS -->

      <section class="login">
        <div class="container">
          <div class="log-wrapper">
            <img src="assets/images/Logo-header.png" alt="" />
            <div class="form">
              <form method="POST" action="/updatePassword">
                <?php if (session()->has('success')) : ?>
                    <center>
                        <div class="alert alert-success">
                        <?= session('success') ?>
                        </div>
                    </center><br>success
                <?php endif; ?>
                <input type="hidden" placeholder="Email Address*" name="emailAddress" value="<?=$emailAddress;?>" />
                <input type="hidden" placeholder="Student ID*" name="studentId" value="<?=$studentId;?>" />
                <input type="password" placeholder="Password*" name="password" />
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