<x-app-layout>
    <x-slot name="header">
    <div class="flex ">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mx-4">
                <a href="first" class="btn-main" >First fetch</a>
            </h2>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mx-4">
                <a href="new" class="btn-main">New data</a>
            </h2>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mx-4">
                <a href="analitics" class="btn-main">Analitics</a>
            </h2>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mx-4">
                <a href="{{ route('UpdatecompanySTATUS') }}" class="btn-main">Update company B24 STATUS</a>
            </h2>
    </div>  
    
    </x-slot>
    <div>
        <div>
            <div class="bg-blue-300 rounded-lg  p-6">

                <p>
                <form action="{{ route('b24fetch.updateDataCompany') }}" method="POST">
                    @csrf
                    <button class="btn-main"> Update DATA Company</button>
                    <input type="date" class="field-main" id="date" name="date">
                    
                </form>
                </p>
                
                <p>
                <form action="{{ route('b24fetch.updateDataRing') }}" method="POST">
                    @csrf
                    <button class="btn-main"> Update Ring</button>
                    <input type="date" class="field-main" id="date" name="date">
                    
                </form>
                </p>
                <p>
                <form action="{{ route('b24fetch.updateDataTask') }}" method="POST">
                    @csrf
                    <button class="btn-main"> Update Task</button>
                    <input type="date" class="field-main" id="date" name="date">
                    
                </form>
                </p>
                <p>
                <form action="{{ route('b24fetch.updateDataActivity') }}" method="POST">
                    @csrf
                    <button class="btn-main"> Update Activity</button>
                    <input type="date" class="field-main" id="date" name="date">
                    
                </form>
                </p>
                <p>
                <form action="{{ route('b24fetch.updateDataDeal') }}" method="POST">
                    @csrf
                    <button class="btn-main"> Update DATA Deal</button>
                    <input type="date" class="field-main" id="date" name="date">
                    
                </form>
                </p>
                <p>
                <form action="{{ route('b24fetch.updateDataLead') }}" method="POST">
                    @csrf
                    <button class="btn-main"> Update Lead</button>
                    <input type="date" class="field-main" id="date" name="date">
                    
                </form>
                </p>
                <p>
                <form action="{{ route('b24fetch.updateData') }}" method="POST" class="mx-10 ">
                    @csrf
                    <button class="btn-main"> Update ALL</button>
                    <input type="date" class="field-main" id="date" name="date">
                    
                </form>
                </p>

            </div>

        </div>
    </div>
    </div>
</x-app-layout>