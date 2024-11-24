<div class="modal-header">
    <h5 class="modal-title">Редактирование события</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    @foreach ($events as $event)
        <form action="{{ route('calendar.update', $event->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="team_code">Код команды</label>
                <input type="text" name="team_code" value="{{ $event->team_code }}" class="form-control">
            </div>
            <div class="mb-3">
                <label for="participants_number">Количество участников</label>
                <input type="number" name="participants_number" value="{{ $event->participants_number }}" class="form-control">
            </div>

            <div class="mb-3">
                <label for="start_date">Дата начала</label>
                <input type="date" name="start_date" value="{{ $event->start_date }}" class="form-control">
            </div>
            <div class="mb-3">
                <label for="end_date">Дата окончания</label>
                <input type="date" name="end_date" value="{{ $event->end_date }}" class="form-control">
            </div>

            <div class="mb-3">
                <label for="country">Страна</label>
                <input type="text" name="country" value="{{ $event->country }}" class="form-control">
            </div>
            <div class="mb-3">
                <label for="city">Город</label>
                <input type="text" name="city" value="{{ $event->city }}" class="form-control">
            </div>
            <div class="mb-3">
                <label for="sport_base">Спортивная база</label>
                <input type="text" name="sport_base" value="{{ $event->sport_base }}" class="form-control">
            </div>
            <div class="mb-3">
                <label for="centre">Центр</label>
                <input type="text" name="centre" value="{{ $event->centre }}" class="form-control">
            </div>

            <div class="mb-3">
                <label for="discipline">Дисциплина</label>
                <input type="text" name="discipline" value="{{ $event->discipline }}" class="form-control">
            </div>
            <div class="mb-3">
                <label for="program">Программа</label>
                <input type="text" name="program" value="{{ $event->program }}" class="form-control">
            </div>
            <div class="mb-3">
                <label for="gender">Пол</label>
                <input type="text" name="gender" value="{{ $event->gender }}" class="form-control">
            </div>
            <div class="mb-3">
                <label for="age_group">Возрастная группа</label>
                <input type="text" name="age_group" value="{{ $event->age_group }}" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Сохранить изменения</button>
        </form>
    @endforeach
</div>
