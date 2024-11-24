@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Ваши мероприятия</h1>

        @if ($userEvents->isEmpty())
            <p>У вас нет помеченных мероприятий.</p>
        @else
            <ul class="list-group">
                @foreach ($userEvents as $event)
                    <li class="list-group-item">
                        <strong>{{ $event->event_name }}</strong><br>
                        Дата: {{ \Carbon\Carbon::parse($event->start_date)->format('d.m.Y') }}<br>
                        Место: {{ $event->city }}, {{ $event->country }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
