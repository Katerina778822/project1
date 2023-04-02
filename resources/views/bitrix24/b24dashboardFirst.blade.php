<x-app-layout>
    <x-slot name="header">
        <div class="flex ">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mx-4">
                <a href="first" class="btn-main">First fetch</a>
            </h2>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mx-4">
                <a href="new" class="btn-main">New data</a>
            </h2>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mx-4">
                <a href="analitics" class="btn-main">Analitics</a>
            </h2>
        </div>

    </x-slot>
    <div>
        <div>
            <div class="bg-blue-300 rounded-lg  p-2 flex">
                <div class="flex">
                    <form action="{{ route('b24field.fetchAll') }}" method="POST">
                        @csrf
                        <button class="btn-main my-4">Fetch fields</button>
                        <button type="submit" name="action" value="create">Создать</button>
                    </form>

                    <form action="{{ route('b24user.fetchAll') }}" method="POST">
                        <button class="btn-main my-4">Fetch users</button>
                        @csrf
                    </form>

                    <form action="{{ route('company.fetchAll') }}" method="POST">
                        <button class="btn-main my-4">Fetch companies</button>
                        @csrf
                    </form>


                    <form action="{{ route('b24ring.fetchAll') }}" method="POST">
                        <button class="btn-main my-4">Fetch rings</button>
                        @csrf
                    </form>

                    <form action="{{ route('b24task.fetchAll') }}" method="POST">
                        <button class="btn-main my-4">Fetch tasks</button>
                        @csrf
                    </form>

                    <form action="{{ route('b24deal.fetchAll') }}" method="POST">
                        <button class="btn-main my-4">Fetch deals</button>
                        @csrf
                    </form>

                    <form action="{{ route('b24lead.fetchAll') }}" method="POST">
                        <button class="btn-main my-4">Fetch leads</button>
                        @csrf
                    </form>

                    <form action="{{ route('b24contact.fetchAll') }}" method="POST">
                        <button class="btn-main my-4">Fetch contacts</button>
                        @csrf
                    </form>
                </div>
                <div class="mx-8">
                    <form action="{{ route('b24fetch.state') }}" method="POST">
                        <button class="btn-main my-4">State</button>
                        @csrf
                    </form>
                </div>



            </div>

        </div>
    </div>
    </div>
</x-app-layout>