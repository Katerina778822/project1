<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{('Bitrix24') }}
        </h2>
    </x-slot>
    <div>
        <div>
            <div class="bg-blue-300 rounded-lg  p-8">

                <form action="{{ route('b24field.fetchAll') }}" method="POST">
                    @csrf
                    <button class="btn-main">Fetch fields</button>
                </form>
                
                <form action="{{ route('company.fetchAll') }}" method="POST">
                    <button class="btn-main my-4">Fetch companies</button>
                    @csrf
                </form>

                <form action="{{ route('b24user.fetchAll') }}" method="POST">
                    <button class="btn-main my-4">Fetch users</button>
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

            </div>

        </div>
    </div>
    </div>
</x-app-layout>