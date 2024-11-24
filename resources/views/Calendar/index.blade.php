@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Календарь</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.4/fullcalendar.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.4/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<div id="calendar"></div>

<script>
    $(document).ready(function () {
        $('#calendar').fullCalendar({
            events: [
                    @foreach($events as $event)
                {
                    title: '{{ $event->event_count }} событие(й)',
                    start: '{{ $event->event_date }}',
                    url: '{{ route('calendar.date', $event->event_date) }}'
                },
                @endforeach
            ]
        });
    });
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Календарь</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.4/fullcalendar.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.4/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<div id="calendar"></div>

<script>
    $(document).ready(function () {
        $('#calendar').fullCalendar({
            events: [
                    @foreach($events as $event)
                {
                    title: '{{ $event->event_count }} событие(й)',
                    start: '{{ $event->event_date }}',
                    url: '{{ route('calendar.date', $event->event_date) }}'
                },
                @endforeach
            ]
        });
    });
</script>
</body>
</html>
