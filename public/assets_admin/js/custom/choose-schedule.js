$(document).ready(function () {
    const accordionTitle = $(".accordion-title");

    accordionTitle.click(function () {
        
        $(this).toggleClass("selected");
        
        $(this).find("i").toggleClass("fa-chevron-down fa-chevron-up");
        $(this).next(".accordion-content").slideToggle(300);
    });
});

const calendarBody = document.querySelector(".days");
const currentMonthYear = document.getElementById("currentMonthYear");
const prevMonthButton = document.getElementById("prevMonth");
const nextMonthButton = document.getElementById("nextMonth");

let currentDate = new Date();

function renderCalendar() {
    const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();
    const firstDayIndex = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();
    const lastDayIndex = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDay();
    const prevLastDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 0).getDate();
    const months = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    currentMonthYear.textContent = `${months[currentDate.getMonth()]} ${currentDate.getFullYear()}`;
    let days = "";

    for (let x = firstDayIndex; x > 0; x--) {
        days += `<div class="day prev-month">${prevLastDay - x + 1}</div>`;
    }

    for (let i = 1; i <= lastDay; i++) {
        const isToday = (i === new Date().getDate() && currentDate.getMonth() === new Date().getMonth());
        const isSelected = (i === currentDate.getDate() && currentDate.getMonth() === currentDate.getMonth());
        days += `<div class="day ${isToday ? 'today' : ''} ${isSelected ? 'selected' : ''}" onclick="selectDate(this)">${i}</div>`;
    }

    for (let j = 1; j <= 6 - lastDayIndex; j++) {
        days += `<div class="day next-month" onclick="selectDate(this)">${j}</div>`;
    }

    calendarBody.innerHTML = days;
}

function formatAndDisplaySelectedDate() {
    const formattedDate = currentDate.toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' });
    const datePick = document.querySelector('.date-pick h4');
    datePick.textContent = formattedDate;
    
    const inputDate = document.getElementById('selectedDateInput');
    const formattedInputDate = currentDate.toISOString().split('T')[0];
    inputDate.value = formattedInputDate;
}

function selectDate(element) {
    
    const clickedDate = parseInt(element.textContent);
    currentDate.setDate(clickedDate);
    
    if (element.classList.contains('next-month')) {
        currentDate.setMonth(currentDate.getMonth() + 1);
    }
    
    const allDates = document.querySelectorAll('.day');
    allDates.forEach(date => date.classList.remove('selected'));
    
    element.classList.add('selected');
    
    renderCalendar();
    
    formatAndDisplaySelectedDate();
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

//Time Picker
function generateTimeIntervals() {
    const intervals = [];
    const startTime = new Date();
    startTime.setHours(7, 0, 0, 0); // Set the start time to 7:00 AM

    const endTime = new Date();
    endTime.setHours(18, 0, 0, 0); // Set the end time to 6:00 PM

    const intervalDuration = 30 * 60000; // 30 minutes in milliseconds

    for (let currentTime = startTime; currentTime <= endTime; currentTime = new Date(currentTime.getTime() + intervalDuration)) {
        const formattedTime = currentTime.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        intervals.push(formattedTime);
    }

    return intervals;
}

function populateTimePicker() {
    const timePicker = document.getElementById('timePicker');
    const intervals = generateTimeIntervals();

    intervals.forEach(interval => {
        const option = document.createElement('option');
        option.value = interval;
        option.text = interval;
        timePicker.add(option);
    });
}
function submitFormAjax() {
    const dateInput = document.querySelector('input[name="picking_date"]');
    const timeInput = document.querySelector('select[name="picking_time"]');

    // Check if either date or time is empty
    if (!dateInput.value.trim() || !timeInput.value.trim()) {
        Swal.fire({
            title: "Warning",
            text: "Please select both date and time before continuing!",
            icon: "error"
        });
        return;
    }

    // Prepare form data
    const formData = new FormData(document.getElementById('chooseSchedule'));

    $.ajax({
        url:"/scheduling/finalizeSchedule",
        method: 'POST',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        beforeSend: function() {
            $('#loading').css('display', 'flex');
        },
        complete: function(){
            $('#loading').css('display', 'none');
        },
        success: function(response) {
            if (response.status === 'success') {
                Swal.fire({
                    title: "Success",
                    text: response.message,
                    icon: "success"
                }).then(() => {
                    window.location.href = '/';
                });
            } else {
                Swal.fire({
                    title: "Oppps",
                    text: response.message,
                    icon: "error"
                });
            }
        },
        error: function() {
            alert('Error occurred while inserting data.');
        }
    });
}
const continueButton = document.querySelector('.continue-btn');
continueButton.addEventListener('click', submitFormAjax);

populateTimePicker();