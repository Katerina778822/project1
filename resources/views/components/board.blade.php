@section('content')
    <div class="container">
        <h2 class="font-medium px-6 py-4 mx-auto">Введите стадию:</h2>
        <form action="{{route('stage.store')}}" method="post">
            @csrf
            <input type="text" name="stage" placeholder="Введите стадию" required>
            <br>
            <input class="px-6 py-4" type="submit" value="Добавить">
        </form>

    </div>
    <button id="toggleButton">Показать данные</button>
    <div id="hiddenData" style="display: none;">
        @foreach($stages as $stage)
            <p style="font-size: 18px; font-weight: bold; color: #333;">{{$stage->stage}}</p>
        @endforeach
    </div>

    <script>
        // JavaScript для скрытия/показа данных по нажатию на кнопку
        const toggleButton = document.getElementById('toggleButton');
        const hiddenData = document.getElementById('hiddenData');

        toggleButton.addEventListener('click', function() {
            if (hiddenData.style.display === 'block') {
                hiddenData.style.display = 'none'; // Скрыть данные при повторном клике
            } else {
                hiddenData.style.display = 'block'; // Показать данные при клике
            }
        });
    </script>

@show
