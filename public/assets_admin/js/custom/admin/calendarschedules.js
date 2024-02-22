$(document).ready(function() {
    $('#event-calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek'
        },
        defaultView: 'agendaWeek',
        events: '/admin/calendarschedules/Lists',
        eventClick: function(info) {
            // Redirect to the link when an event is clicked
            window.location.href = info.url; // Replace '/your-link/' with the desired link and info.event.id with the event identifier
        }
    });
});