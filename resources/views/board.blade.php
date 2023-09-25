@section('content')
    <style>

        .container-tab {
            width: 80%;
            border: 1px solid #ccc;
            padding: 20px;
        }

        .tabs {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ccc;
        }

        .tab {
            flex: 1;
            text-align: center;
            padding: 10px;
            cursor: pointer;
        }

        .tab-content {
            margin-top: 20px;
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Добавляем стили для таблицы во вкладке "ЗАДАЧА" */
        .custom-table {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        .table-cell {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        select {
            width: 100%;
        }

        /* Стили для флажков */
        .checkbox {
            margin-top: 10px;
        }
    </style>

<div class="container-tab">
    <div class="tabs">
        <div class="tab" onclick="showTab(1)">НОВЫЙ</div>
        <div class="tab" onclick="showTab(2)">ЗАДАЧА</div>
    </div>
    <div class="tab-content" id="tab2">
    <div class="container mx-auto grid grid-cols-4">
        <div class="p-4 w-4/5 mx-auto ">
            <div class="grid grid-cols-1 gap-4">
                <div class="flex col-span-1 text-center text-lg font-bold">
                    <div class="container border border-gray-300 py-4 mx-auto">Column 1</div>
                </div>
                <div class="border border-gray-300 p-2 text-center">Row 1, Cell 1<input type="checkbox"></div>
                <div class="border border-gray-300 p-2 text-center">Row 2, Cell 1<input type="checkbox"></div>
                <div class="border border-gray-300 p-2 text-center">Row 3, Cell 1<input type="checkbox"></div>
                <div class="border border-gray-300 p-2 text-center">Row 4, Cell 1<input type="checkbox"></div>
            </div>
        </div>

        <div class="p-4 w-4/5 mx-auto">
            <div class="grid grid-cols-1 gap-4">
                <div class="flex col-span-1 text-center text-lg font-bold">
                    <div class="container border border-gray-300 py-4 mx-auto">Column 2</div>
                </div>
                <div class="border border-gray-300 p-2 text-center">Row 1, Cell 2<input type="checkbox"></div>
                <div class="border border-gray-300 p-2 text-center">Row 2, Cell 2<input type="checkbox"></div>
                <div class="border border-gray-300 p-2 text-center">Row 3, Cell 2<input type="checkbox"></div>
                <div class="border border-gray-300 p-2 text-center">Row 4, Cell 2<input type="checkbox"></div>
            </div>
        </div>

        <div class="p-4 w-4/5 mx-auto">
            <div class="grid grid-cols-1 gap-4">
                <div class="flex col-span-1 text-center text-lg font-bold">
                    <div class="container border border-gray-300 py-4 mx-auto">Column 3</div>
                </div>
                <div class="border border-gray-300 p-2 text-center">Row 1, Cell 3<input type="checkbox"></div>
                <div class="border border-gray-300 p-2 text-center">Row 2, Cell 3<input type="checkbox"></div>
                <div class="border border-gray-300 p-2 text-center">Row 3, Cell 3<input type="checkbox"></div>
                <div class="border border-gray-300 p-2 text-center">Row 4, Cell 3<input type="checkbox"></div>
            </div>
        </div>

        <div class="p-4 w-4/5 mx-auto">
            <div class="grid grid-cols-1 gap-4">
                <div class="flex col-span-1 text-center text-lg font-bold">
                    <div class="container border border-gray-300 py-4 mx-auto">Column 4</div>
                </div>
                <div class="border border-gray-300 p-2 text-center">Row 1, Cell 4<input type="checkbox"></div>
                <div class="border border-gray-300 p-2 text-center">Row 2, Cell 4<input type="checkbox"></div>
                <div class="border border-gray-300 p-2 text-center">Row 3, Cell 4<input type="checkbox"></div>
                <div class="border border-gray-300 p-2 text-center">Row 4, Cell 4<input type="checkbox"></div>
            </div>
        </div>
    </div>

        <div class="container mx-auto grid grid-cols-1 grid-row">
            <!-- Добавляем таблицу с одной строкой и четырьмя столбцами -->
                <div class="container flex mx-auto">
                    <!-- Столбец 1 - Текстовые заметки -->
                    <div class="border border-gray-300 p-2">
                        <input type="text" class="w-full border border-gray-300 p-2" placeholder="Текстовые заметки">
                    </div>
                    <!-- Столбец 2 - Дата -->
                    <div class="border border-gray-300 p-2">
                        <input type="date" class="w-full border border-gray-300 p-2">
                    </div>
                    <!-- Столбец 3 - Время -->
                    <div class="border border-gray-300 p-2">
                        <input type="time" class="w-full border border-gray-300 p-2">
                    </div>
                    <!-- Столбец 4 - Тип покупателя и выпадающий список -->
                    <div class="border border-gray-300 p-2">
                        <label for="customerType">Тип покупателя:</label>
                        <select id="customerType" class="w-full border border-gray-300 p-2">
                            <option value="option1">Опция 1</option>
                            <option value="option2">Опция 2</option>
                            <option value="option3">Опция 3</option>
                        </select>
                    </div>
                </div>
            </div>


    <div class="tab-content" id="tab2">

    </div>
</div>

<script>
    function showTab(tabNumber) {
        const tabContents = document.querySelectorAll('.tab-content');
        tabContents.forEach(tabContent => {
            tabContent.classList.remove('active');
        });
        document.getElementById('tab' + tabNumber).classList.add('active');
    }
</script>
@show
