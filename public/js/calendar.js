document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: '/entrainement/events', // Endpoint pour récupérer les événements
        eventClick: function(info) {
            alert('Entraînement: ' + info.event.title);
        }
    });
    calendar.render();
}); 