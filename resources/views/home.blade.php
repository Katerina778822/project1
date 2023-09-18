<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
<div class="flex justify-between p-4">
    <h1 class="text-2xl font-bold">Home Page</h1>
    <a href="/" class="text-red-600 hover:text-red-800">Log out</a>
</div>

<div class="container mx-auto grid grid-cols-4">
    <div class="border border-gray-300 p-4 w-4/5 mx-auto">
        <div class="grid grid-cols-1 gap-4">
            <div class="flex col-span-1 text-center text-lg font-bold">
                <div class="container border border-gray-300 py-4">Column 1</div>
            </div>
            <div class="border border-gray-300 p-2 text-center">Row 1, Cell 1</div>
            <div class="border border-gray-300 p-2 text-center">Row 2, Cell 1</div>
            <div class="border border-gray-300 p-2 text-center">Row 3, Cell 1</div>
            <div class="border border-gray-300 p-2 text-center">Row 4, Cell 1</div>
        </div>
    </div>

    <div class="border border-gray-300 p-4 w-4/5 mx-auto">
        <div class="grid grid-cols-1 gap-4">
            <div class="flex col-span-1 text-center text-lg font-bold">
                <div class="container border border-gray-300 py-4">Column 2</div>
            </div>
            <div class="border border-gray-300 p-2 text-center">Row 1, Cell 2</div>
            <div class="border border-gray-300 p-2 text-center">Row 2, Cell 2</div>
            <div class="border border-gray-300 p-2 text-center">Row 3, Cell 2</div>
            <div class="border border-gray-300 p-2 text-center">Row 4, Cell 2</div>
        </div>
    </div>

    <div class="border border-gray-300 p-4 w-4/5 mx-auto">
        <div class="grid grid-cols-1 gap-4">
            <div class="flex col-span-1 text-center text-lg font-bold">
                <div class="container border border-gray-300 py-4">Column 2</div>
            </div>
            <div class="border border-gray-300 p-2 text-center">Row 1, Cell 3</div>
            <div class="border border-gray-300 p-2 text-center">Row 2, Cell 3</div>
            <div class="border border-gray-300 p-2 text-center">Row 3, Cell 3</div>
            <div class="border border-gray-300 p-2 text-center">Row 4, Cell 3</div>
        </div>
    </div>

    <div class="border border-gray-300 p-4 w-4/5 mx-auto">
        <div class="grid grid-cols-1 gap-4">
            <div class="flex col-span-1 text-center text-lg font-bold">
                <div class="container border border-gray-300 py-4">Column 2</div>
            </div>
            <div class="border border-gray-300 p-2 text-center">Row 1, Cell 4</div>
            <div class="border border-gray-300 p-2 text-center">Row 2, Cell 4</div>
            <div class="border border-gray-300 p-2 text-center">Row 3, Cell 4</div>
            <div class="border border-gray-300 p-2 text-center">Row 4, Cell 4</div>
        </div>
    </div>
</div>
</body>
</html>
