@extends('layout')
@section('content')
    @push('css')
        <!-- fullCalendar -->
        <link rel="stylesheet" href="{{ URL::asset('/app/plugins/fullcalendar/main.css') }}">
    @endpush
    <script>
        document.title = "My Calendar";
    </script>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Calendar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Calendar</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="sticky-top mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Draggable Events</h4>
                            </div>
                            <div class="card-body">
                                <!-- the events -->
                                <div id="external-events">
                                    <div class="external-event bg-success">Lunch</div>
                                    <div class="external-event bg-warning">Go home</div>
                                    <div class="external-event bg-info">Do homework</div>
                                    <div class="checkbox">
                                        <label for="drop-remove">
                                            <input type="checkbox" id="drop-remove">
                                            remove after drop
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Create Event</h3>
                            </div>
                            <div class="card-body">
                                <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                                    <ul class="fc-color-picker" id="color-chooser">
                                        <li><a class="text-primary" href="#"><i class="fas fa-square"></i></a></li>
                                        <li><a class="text-warning" href="#"><i class="fas fa-square"></i></a></li>
                                        <li><a class="text-success" href="#"><i class="fas fa-square"></i></a></li>
                                        <li><a class="text-danger" href="#"><i class="fas fa-square"></i></a></li>
                                        <li><a class="text-muted" href="#"><i class="fas fa-square"></i></a></li>
                                    </ul>
                                </div>
                                <!-- /btn-group -->
                                <div class="input-group">
                                    <input id="new-event" type="text" class="form-control" placeholder="Event Title">
                                    <div class="input-group-append">
                                        <button id="add-new-event" type="button" class="btn btn-primary">Add</button>
                                    </div>
                                    <!-- /btn-group -->
                                </div>
                                <!-- /input-group -->
                            </div>
                        </div>
                        <div class="card">
                            @csrf
                            <input type="hidden" name="user_id" value="<?php echo Session::get('id'); ?>">
                            <div class="card-header">
                                <h3 class="card-title">Save Event</h3>
                            </div>
                            <div class="card-body">
                                <div class="input-group"><button class="btn btn-success" style="width: 100%"
                                        id="save-event">Save</button>
                                </div>
                                <!-- /input-group -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card card-primary">
                        <div class="card-body p-0">
                            <!-- THE CALENDAR -->
                            <div id="calendar"></div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    @push('scripts')
        <!-- fullCalendar 2.2.5 -->
        <script src="{{ URL::asset('/app/plugins/moment/moment.min.js') }}"></script>
        <script src="{{ URL::asset('/app/plugins/fullcalendar/main.js') }}"></script>
        <script src="{{ URL::asset('/app/plugins/fullcalendar/locales/vi.js') }}"></script>
        <script>
            $(function() {
                /* initialize the external events
                 -----------------------------------------------------------------*/
                function ini_events(ele) {
                    ele.each(function() {

                        // create an Event Object (https://fullcalendar.io/docs/event-object)
                        // it doesn't need to have a start or end
                        var eventObject = {
                            title: $.trim($(this).text()) // use the element's text as the event title
                        }

                        // store the Event Object in the DOM element so we can get to it later
                        $(this).data('eventObject', eventObject)

                        // make the event draggable using jQuery UI
                        $(this).draggable({
                            zIndex: 1070,
                            revert: true, // will cause the event to go back to its
                            revertDuration: 0 //  original position after the drag
                        })

                    })
                }

                ini_events($('#external-events div.external-event'))

                /* initialize the calendar
                 -----------------------------------------------------------------*/
                //Date for the calendar events (dummy data)
                var date = new Date()
                var d = date.getDate(),
                    m = date.getMonth(),
                    y = date.getFullYear()

                var Calendar = FullCalendar.Calendar;
                var Draggable = FullCalendar.Draggable;

                var containerEl = document.getElementById('external-events');
                var checkbox = document.getElementById('drop-remove');
                var calendarEl = document.getElementById('calendar');

                // initialize the external events
                // -----------------------------------------------------------------

                new Draggable(containerEl, {
                    itemSelector: '.external-event',
                    eventData: function(eventEl) {
                        return {
                            id: 2,
                            title: eventEl.innerText,
                            backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue(
                                'background-color'),
                            borderColor: window.getComputedStyle(eventEl, null).getPropertyValue(
                                'background-color'),
                            textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color'),
                        };
                    }
                });

                let clickCnt = 0;

                var calendar = new Calendar(calendarEl, {
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay',
                    },
                    themeSystem: 'bootstrap',
                    locale: 'vi',
                    //Random default events
                    // events: dataEvents,
                    editable: true,
                    droppable: true, // this allows things to be dropped onto the calendar !!!
                    drop: function(info) {
                        // is the "remove after drop" checkbox checked?
                        if (checkbox.checked) {
                            // if so, remove the element from the "Draggable Events" list
                            info.draggedEl.parentNode.removeChild(info.draggedEl);
                        }
                    },
                    eventClick: function(info) {
                        clickCnt++;
                        if (clickCnt === 1) {
                            oneClickTimer = setTimeout(function() {
                                clickCnt = 0;
                            }, 400);
                        } else if (clickCnt === 2) {
                            clearTimeout(oneClickTimer);
                            clickCnt = 0;
                            var r = confirm("Delete this event!");
                            if (r == true)
                                info.event.remove();
                        }
                    }
                });


                calendar.render();
                // $('#calendar').fullCalendar()
                var _token = $('input[name=_token]').val();
                var user_id = $('input[name=user_id]').val();
                $('#save-event').click(function() {
                    let evs = calendar.getEvents();
                    var listEvents = [];
                    evs.forEach(element => {
                        if (element.id == 2) {
                            listEvents.push({
                                user_id: user_id,
                                title: element.title,
                                start: element.start,
                                end: element.end,
                                allDay: element.allDay,
                                daysOfWeek: element.daysOfWeek,
                                url: element.url,
                                backgroundColor: element.backgroundColor,
                                borderColor: element.borderColor,
                            });
                        }
                    });
                    $.ajax({
                        type: "POST",
                        cache: false,
                        url: '/api/save-event',
                        data: {
                            user_id: user_id,
                            events: listEvents,
                            _token: _token
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data == true)
                                Swal.fire(
                                    'Done!',
                                    'You event has been saved!',
                                    'success'
                                );
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                })
                /* ADDING EVENTS */
                var currColor = '#3c8dbc' //Red by default
                // Color chooser button
                $('#color-chooser > li > a').click(function(e) {
                    e.preventDefault()
                    // Save color
                    currColor = $(this).css('color')
                    // Add color effect to button
                    $('#add-new-event').css({
                        'background-color': currColor,
                        'border-color': currColor
                    })
                });
                $('#add-new-event').click(function(e) {
                    e.preventDefault()
                    // Get value and make sure it is not null
                    var val = $('#new-event').val()
                    if (val.length == 0) {
                        return
                    }

                    // Create events
                    var event = $('<div/>')
                    event.css({
                        'background-color': currColor,
                        'border-color': currColor,
                        'color': '#fff'
                    }).addClass('external-event')
                    event.text(val)
                    $('#external-events').prepend(event)

                    // Add draggable funtionality
                    ini_events(event)

                    // Remove event from text input
                    $('#new-event').val('')
                });
                $.ajax({
                    type: "GET",
                    cache: false,
                    url: '/api/event',
                    data: {
                        _token: _token
                    },
                    dataType: "json",
                    success: function(data) {
                        data.forEach(element => {
                            calendar.addEvent({
                                id: element.id,
                                title: element.title,
                                start: new Date(element.start),
                                end: new Date(element.end),
                                allDay: element.allDay,
                                daysOfWeek: element.daysOfWeek,
                                url: element.url,
                                backgroundColor: element.backgroundColor,
                                borderColor: element.borderColor,
                            });
                        });
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });

                $.ajax({
                    type: "GET",
                    cache: false,
                    url: '/api/room-event',
                    data: {
                        _token: _token
                    },
                    dataType: "json",
                    success: function(data) {
                        data.forEach(element => {
                            calendar.addEvent({
                                id: element.id,
                                title: element.title,
                                startRecur: new Date(element.start),
                                endRecur: new Date(element.end),
                                allDay: element.allDay,
                                daysOfWeek: element.daysOfWeek,
                                startTime: element.startTime,
                                endTime: element.endTime,
                                url: element.url,
                                backgroundColor: element.backgroundColor,
                                borderColor: element.borderColor,
                            });
                        });
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            })
        </script>
    @endpush
@endsection
