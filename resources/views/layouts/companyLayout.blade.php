<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company view</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<!-- Шапка страницы -->
<header class="bg-white border-b border-gray-200 p-4 flex justify-between items-center">
    <!-- Имя компании -->
        <div class="text-lg font-bold">{{ $company->title }}</div>
    <div>
        <x-button onclick="goBack()">Назад</x-button>
    </div>
</header>

@section('content')


@endsection

<script>
    function goBack() {
        // Перенаправляем на предыдущий URL с помощью PHP
        window.location.href = "{{ url()->previous() }}";
    }
</script>

</body>
</html>
