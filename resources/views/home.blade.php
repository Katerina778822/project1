<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
<header class="bg-gray-800 text-white">
    <div class="flex justify-between p-4">
        <h1 class="text-2xl font-bold">Home Page</h1>
        <a href="/" class="text-red-600 hover:text-red-800">Log out</a>
    </div>
</header>


<div class="container mx-auto justify-center"
@include('components.board')
</div>






</body>
</html>
