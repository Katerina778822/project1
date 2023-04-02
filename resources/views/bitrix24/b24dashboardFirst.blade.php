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
                    <div>
                        <form action="{{ route('b24field.fetchAll') }}" method="POST">
                            @csrf
                            <button class="btn-main my-4">Fetch fields</button>
                        </form>

                    </div>

                    <div>
                        <form action="{{ route('b24user.fetchAll') }}" method="POST">
                            <button class="btn-main my-4">Fetch users</button>
                            @csrf
                        </form>
                        {{$countArray['usersDB']??''}}/{{$countArray['usersB24']??''}}
                    </div>

                    <div>
                        <form action="{{ route('company.fetchAll') }}" method="POST">
                            <button class="btn-main my-4">Fetch companies</button>
                            @csrf
                        </form>
                        {{$countArray['companiesDB']??''}}/{{$countArray['companiesB24']??''}}
                    </div>


                    <div>
                        <form action="{{ route('b24ring.fetchAll') }}" method="POST">
                            <button class="btn-main my-4">Fetch rings</button>
                            @csrf
                        </form>
                        {{$countArray['ringsDB']??''}}/{{$countArray['ringsB24']??''}}
                    </div>


                    <div>
                        <form action="{{ route('b24task.fetchAll') }}" method="POST">
                            <button class="btn-main my-4">Fetch tasks</button>
                            @csrf
                        </form>
                        {{$countArray['tasksDB']??''}}/{{$countArray['tasksB24']??''}}
                    </div>


                    <div>
                        <form action="{{ route('b24deal.fetchAll') }}" method="POST">
                            <button class="btn-main my-4">Fetch deals</button>
                            @csrf
                        </form>
                        {{$countArray['dealsDB']??''}}/{{$countArray['dealsB24']??''}}
                    </div>


                    <div>
                        <form action="{{ route('b24lead.fetchAll') }}" method="POST">
                            <button class="btn-main my-4">Fetch leads</button>
                            @csrf
                        </form>
                        {{$countArray['leadsDB']??''}}/{{$countArray['leadsB24']??''}}
                    </div>


                    <div>
                        <form action="{{ route('b24contact.fetchAll') }}" method="POST">
                            <button class="btn-main my-4">Fetch contacts</button>
                            @csrf
                        </form>
                        {{$countArray['contactsDB']??''}}/{{$countArray['contactsB24']??''}}
                    </div>

                </div>

                <div></div>
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