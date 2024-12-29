<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TOAST UI Calendar</title>

        <link rel="stylesheet" href="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.css" />
        <link rel="stylesheet" href="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.min.css" />
        <link rel="stylesheet" href="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.min.css" />

        <script src="https://uicdn.toast.com/tui.code-snippet/latest/tui-code-snippet.js"></script>
        <script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.min.js"></script>
        <script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.min.js"></script>
        <script src="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <style>
            .btn-export {
                display: inline-block;
                padding: 15px 50px;
                background-color: #4CAF50; /* Yeşil arka plan */
                color: white; /* Beyaz yazı rengi */
                font-size: 18px;
                font-weight: bold;
                text-decoration: none;
                border-radius: 30px; /* Yuvarlak köşeler */
            }
        </style>

    </head>
    <body>
        <div id="calendar"></div>
        <a href="/pdf" class="btn-export" id="exportButton">Takvimi Dışarıya Aktar</a>

        <script>

            var calendar = new tui.Calendar('#calendar', {
            defaultView: 'month', // 'day', 'week', 'month' gibi görünümler
            useCreationPopup: true, // Etkinlik oluşturma popup'ı
            useDetailPopup: true, // Detay popup'ı
            useStatePopup: false,

            calendars: [
                @if (count($users) > 0)
                    @foreach ($users as $user)
                        {
                            id: '{{ $user->id }}',
                            name: '{{ $user->name }}',
                        },
                    @endforeach
                @endif
            ],

            template: {
                    popupStateFree: function() {
                        return 'Kritik';
                    },
                    popupStateBusy: function() {
                        return 'Önemli';
                    },
                    titlePlaceholder: function() {
                        return 'Başlık';
                    },
                    locationPlaceholder: function() {
                        return 'Konum';
                    },
                    startDatePlaceholder: function() {
                        return 'Start date';
                    },
                    endDatePlaceholder: function() {
                        return 'End date';
                    },
                    popupSave: function() {
                        return 'Add Event';
                    },
                    popupUpdate: function() {
                        return 'Update Event';
                    },
                    popupEdit: function() {
                        return 'Modify';
                    },
                    popupDelete: function() {
                        return 'Remove';
                    },
                },
            });

            calendar.on('beforeDeleteSchedule', function (event) {
                const schedule = event.schedule;
                // AJAX isteği ile backend'e silme işlemini gönder
                fetch('/api/event', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        id: schedule.id,
                        calendarId: schedule.calendarId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log(calendar);
                        calendar.deleteSchedule(schedule.id, schedule.calendarId)
                    // calendar.removeSchedule(schedule.id, schedule.calendarId);
                        alert('Etkinlik başarıyla silindi!');
                    } else {
                        alert('Etkinlik silinirken bir hata oluştu.');
                    }
                });
            });
            
            calendar.on('beforeUpdateSchedule', function (event) {
            const schedule = event.schedule;
            console.log(event);

            // AJAX isteği ile backend'e güncelleme işlemini gönder
            fetch('/api/event', {
                method: 'PUT',  // PUT isteği kullanıyoruz
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    id: schedule.id,  // Etkinlik ID'si
                    user_id: event.changes.calendarId,  // Takvim ID'si
                    title: event.changes.title,  // Güncellenmiş başlık
                    start: schedule.start._date,
                    end: schedule.end._date,
                    description: event.changes.location,  // Güncellenmiş bitiş tarihi
                    rating: event.changes.state, 
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Etkinlik başarıyla güncellendi!');
                    alert('Etkinlik başarıyla güncellendi!');
                    // Takvimdeki etkinliği güncelle
                    calendar.updateSchedule(schedule.id, schedule.calendarId, event.changes);
                } else {
                    alert('Etkinlik güncellenirken bir hata oluştu.');
                }
            })
            .catch(error => {
                console.error('Hata:', error);
                alert('Etkinlik güncellenirken bir hata oluştu.');
                });
            });

            calendar.createSchedules([
                    @if (count($events) > 0)
                        @foreach ($events as $event)
                            {
                                id: '{{ $event->id }}',
                                calendarId: '{{ $event->user_id }}',
                                title: '{{ $event->title }}',
                                location: '{{ $event->description }}',
                                state: '{{ $event->state }}',
                                start: '{{ $event->start }}',
                                end: '{{ $event->end }}',
                                category: 'time',
                                dueDateClass: '',
                            },
                        @endforeach
                    @endif
                ]);

            calendar.on('beforeCreateSchedule', function(event) {
                console.log(event);
                    const { title, start, end, location, state, calendarId} = event;

                    // Backend'e gönderilecek veri
                    const eventData = {
                        title: title,
                        start: start._date,
                        end: end._date,
                        description: location,
                        state: state,
                        user_id: calendarId,
                    };

                    console.log('Gönderilen Veri:', eventData); // Konsolda kontrol
                    // Backend'e POST isteği
                    fetch('/api/event', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(eventData),
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Sunucudan Gelen Cevap:', data);
                        console.log(data.event);
                        // Takvime yeni etkinlik ekle
                        calendar.createSchedules([
                            {
                                id: data.event.id,
                                title: data.event.title,
                                start: data.event.start,
                                end: data.event.end,
                                location: data.event.description,
                                state: data.event.rating,
                                calendarId: data.event.user_id,
                                category: 'time',
                                dueDateClass: '',
                                
                            }
                        ]);
                    })
                    .catch(error => {
                        console.error('Hata:', error);
                        alert('Etkinlik eklenirken bir hata oluştu!');
                    });
                });
                console.log(calendar); // Takvim nesnesini kontrol
        </script>
    </body>
</html>
