
    <!-- FOR FOOTER -->
    <footer class="footer" style="background-image: url('<?=base_url();?>assets/images/footer.png')">
      <div class="container">
        <div class="row wrapper">
          <div class="col-lg">
            <div class="contact">
              <h1>Contact Us</h1>
              <div class="list">
                <img src="<?=base_url();?>assets/images/Layer_1.png" alt="" />
                <!-- <span>500 W 5th St, Suite 400, Winston Salem, NC 27101 </span> -->
                <span>265 Eastchester Drive, Suite 133 PMB 264 High Point NC 27262</span>
              </div>
              <div class="list">
                <img src="<?=base_url();?>assets/images/email-svgrepo-com (8).png" alt="" />
                <!-- <span>(336) 815-0100 </span> -->
                <span>info@epicstoragesolutions</span>
              </div>
              <div class="list">
                <img src="<?=base_url();?>assets/images/loc.png" alt="" />
                <span>336.549.5216</span>
              </div>
            </div>
          </div>
          <div class="col-lg">
            <div class="links">
              <h1>Quick Links</h1>
              <div class="list">
                <ul>
                  <li>
                    <a href="<?=base_url();?>">Home</a>
                  </li>
                  <li>
                    <a href="<?=base_url();?>about">About Us </a>
                  </li>
                  <li>
                    <a href="<?=base_url();?>services">Services </a>
                  </li>
                  <li>
                    <a href="<?=base_url();?>scheduling">Scheduling </a>
                  </li>
                  <li>
                    <a href="<?=base_url();?>faqs">FAQs </a>
                  </li>
                  <li>
                    <a href="<?=base_url();?>testimonials">Testimonials </a>
                  </li>
                  <li>
                    <a href="<?=base_url();?>contact">Contact Us </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg">
            <div class="social">
              <h1>Follow Us</h1>
              <div class="list">
                <img src="<?=base_url();?>assets/images/fb.png" alt="" />
                <img src="<?=base_url();?>assets/images/twi.png" alt="" />
                <img src="<?=base_url();?>assets/images/in.png" alt="" />
              </div>
            </div>
          </div>
        </div>
        <div class="footnote">
          <span>Copyright 2023. EPIC Storage Solution</span>
          <div class="list">
            <!-- <li><a href="<?=base_url();?>shipping">Privacy</a></li> -->
            <li><a href="<?=base_url();?>terms-condition">Terms and conditions</a></li>
          </div>
        </div>
      </div>
    </footer>

    <script src="https://momentjs.com/downloads/moment.js"></script>
    <script src="https://momentjs.com/downloads/moment-timezone-with-data.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous" ></script>
    <script src="<?=base_url();?>assets/js/owl.carousel.min.js"></script>
    <script src="<?=base_url();?>assets/js/jquery.matchHeight.js"></script>
    <script src="<?=base_url();?>assets/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <script>
      $(document).ready(function () {
          $(".accordion-title").click(function () {
              // Toggle the background color class for the clicked title
              $(this).toggleClass("selected");
              
              // Toggle the icon and content visibility
              $(this).find("i").toggleClass("fa-chevron-down fa-chevron-up");
              $(this).next(".accordion-content").slideToggle(300);
          });
      });
    </script>
    <script type="text/javascript"></script>
    <script>
      const calendarBody = document.querySelector(".days");
      const currentMonthYear = document.getElementById("currentMonthYear");
      const prevMonthButton = document.getElementById("prevMonth");
      const nextMonthButton = document.getElementById("nextMonth");

      let currentDate = new Date();

      function renderCalendar() {
        const lastDay = new Date(
          currentDate.getFullYear(),
          currentDate.getMonth() + 1,
          0
        ).getDate();
        const firstDayIndex = new Date(
          currentDate.getFullYear(),
          currentDate.getMonth(),
          1
        ).getDay();
        const lastDayIndex = new Date(
          currentDate.getFullYear(),
          currentDate.getMonth() + 1,
          0
        ).getDay();
        const prevLastDay = new Date(
          currentDate.getFullYear(),
          currentDate.getMonth(),
          0
        ).getDate();
        const months = [
          "January",
          "February",
          "March",
          "April",
          "May",
          "June",
          "July",
          "August",
          "September",
          "October",
          "November",
          "December",
        ];

        currentMonthYear.textContent = `${
          months[currentDate.getMonth()]
        } ${currentDate.getFullYear()}`;
        let days = "";

        for (let x = firstDayIndex; x > 0; x--) {
          days += `<div class="day prev-month">${prevLastDay - x + 1}</div>`;
        }

        for (let i = 1; i <= lastDay; i++) {
          if (
            i === new Date().getDate() &&
            currentDate.getMonth() === new Date().getMonth()
          ) {
            days += `<div class="day today" onclick="selectDate(this)">${i}</div>`;
          } else {
            days += `<div class="day" onclick="selectDate(this)">${i}</div>`;
          }
        }

        for (let j = 1; j <= 6 - lastDayIndex; j++) {
          days += `<div class="day next-month">${j}</div>`;
        }

        calendarBody.innerHTML = days;
      }

      function selectDate(element) {
        const selectedDate = element.innerText;
        alert(
          `You selected: ${currentDate.getFullYear()}-${
            currentDate.getMonth() + 1
          }-${selectedDate}`
        );
      }

      renderCalendar();

      prevMonthButton.addEventListener("click", () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
      });

      nextMonthButton.addEventListener("click", () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
      });
    </script>
    <script>
      const dateTimeUtc = moment("2017-06-05T19:41:03Z").utc();
        document.querySelector(".js-TimeUtc").innerHTML = dateTimeUtc.format("ddd, DD MMM YYYY HH:mm:ss");

        const selectorOptions = moment.tz.names()
          .reduce((memo, tz) => {
            memo.push({
              name: tz,
              offset: moment.tz(tz).utcOffset()
            });
            
            return memo;
          }, [])
          .sort((a, b) => {
            return a.offset - b.offset
          })
          .reduce((memo, tz) => {
            const timezone = tz.offset ? moment.tz(tz.name).format('Z') : '';

            return memo.concat(`<option value="${tz.name}">(GMT${timezone}) ${tz.name}</option>`);
          }, "");

        document.querySelector(".js-Selector").innerHTML = selectorOptions;

        document.querySelector(".js-Selector").addEventListener("change", e => {
          const timestamp = dateTimeUtc.unix();
          const offset = moment.tz(e.target.value).utcOffset() * 60;
          const dateTimeLocal = moment.unix(timestamp + offset).utc();

          document.querySelector(".js-TimeLocal").innerHTML = dateTimeLocal.format("ddd, DD MMM YYYY HH:mm:ss");
        });

        document.querySelector(".js-Selector").value = "Europe/Madrid";

        const event = new Event("change");
        document.querySelector(".js-Selector").dispatchEvent(event);

    </script>
  </body>
</html>