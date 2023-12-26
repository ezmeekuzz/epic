    <?=$this->include('templates/header');?>
    <main>
        <section class="scheduling-time">
          <div class="container">
            <div class="container-title">
              <h2>Date & Time</h2>
            </div>
            <div class="scheduling-container">
              <div class="row justify-content-center">
                <div class="col-md-6">
                  <div class="select-wrapper scheduling-3">
                    <div class="sched-wrapper">
                      <h2 class="calendar-label">SELECT A DAY</h2>
                      <div class="calendar">
                        <div class="calendar-header">
                          <button id="prevMonth">&#9665;</button>
                          <h2 id="currentMonthYear">Month Year</h2>
                          <button id="nextMonth">&#9655;</button>
                        </div>
                        <div class="calendar-body">
                          <div class="day-names">
                            <div>Sun</div>
                            <div>Mon</div>
                            <div>Tue</div>
                            <div>Wed</div>
                            <div>Thu</div>
                            <div>Fri</div>
                            <div>Sat</div>
                          </div>
                          <div class="days"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row justify-content-center">
                <div class="col-md-6">
                  <form id="chooseSchedule">
                    <div class="date-option">
                      <h2 class="calendar-label">SELECT A TIME</h2>
                      <div class="date-pick">
                        <h4>Tuesday May 29, 2022</h4>
                        <input type="hidden" id="refCode" name="refCode" value="<?= $refCode;?>" readonly>
                        <input type="hidden" id="selectedDateInput" name="picking_date" readonly>
                      </div>
                      <div class="time-pick">
                        <select id="timePicker" name="picking_time" class="time-select w-100"></select>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              
            </div>
            <div class="container-form-footer">
              <a href="javascript:void(0);" class="continue-btn">CONTINUE <i class="fa fa-arrow-right"></i></a>
            </div>
          </div>
        </section>
    </main>
    <div id="loading">
        <img id="loading-image" src="<?=base_url();?>assets_admin/img/loader.gif" alt="Loading..." />
    </div>
    <script src="<?=base_url();?>assets_admin/js/custom/choose-schedule.js"></script>
    <?=$this->include('templates/footer');?>