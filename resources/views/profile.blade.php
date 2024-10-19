@extends('layouts.app')
@section('title') Профили {{ $user->name }} @endsection
@section('content')
<div class="bg-gray-100 space-y-4">
    <div class="p-8 bg-white shadow-md rounded-lg">

        <div class="flex items-center space-x-4">
            <div class="rounded-2xl border-2 " style="position: relative;">
                <img src="/assets/brand/character_nobg.png" width="80" class="rounded-2xl"  alt="">
                <button style="position: absolute; bottom: -10px; right: -10px;" class="text-sm font-bold px-2 py-1 rounded-full bg-yellow-500 text-white">{{ $rank }}</button>
            </div>
            <div class="space-y-2">
                <h1 class="font-black text-xl">{{ $user->name }}</h1>     
                <button class="bg-indigo-800 text-white rounded-full px-3 pb-1">хонанда</button>       
            </div>
        </div>

        <div class="flex justify-evenly  mt-12">
            <div class="flex flex-col items-center space-y-3">
                <div class="rounded-xl border-2 p-5 text-lg border-b-4 border-l-4 border-indigo-100">{{ count($user->poems) }}</div>
                <div class="text-center font-bold leading-5">Шеърҳои <br> воридкарда</div>
            </div>
            <div class="flex flex-col items-center space-y-3">
                <div class="rounded-xl border-2 p-5 text-lg border-b-4 border-l-4 border-indigo-100">{{ $rank }}</div>
                <div class="text-center font-bold leading-5">Ҷой</div>
            </div>
            <div class="flex flex-col items-center space-y-3">
                <div class="rounded-xl border-2 p-5 text-lg border-b-4 border-l-4 border-indigo-100">{{ count($user->views) }}</div>
                <div class="text-center font-bold leading-5">Шеърҳои <br> хондашуда</div>
            </div>
        </div>


    </div>

    <div class="p-4 bg-white shadow-md rounded-lg">
        <h1 class="text-xl font-bold my-4">Шоирони дустдошта </h1>
        <div>
            @foreach($user->subscriptions as $sub)
            <a href="/poets/{{ $sub->poet->name }}" class="font-bold text-md">
                <div class="mb-2 flex justify-between items-center space-x-4 items-center bg-gray-50 border-b-4 border-l-4 cursor-pointer rounded-lg p-3">
                    <div class="flex items-center space-x-3">
                        <div class="rounded-full bg-gray-600 cursor-pointer">
                            <img src="{{ $sub->poet->avatar }}" alt="" style="width: 35px; height: 35px;" class="rounded-full">
                        </div>
                        <div class="space-y-4 font-bold">
                            {{ $sub->poet->name }}
                        </div>
                    </div>
                    <div>
                        <img src="/assets/arrow-right-1.svg" alt="">
                    </div>
                </div>
            </a>     
            @endforeach
            
        </div>

    </div>


    <div class="p-4 bg-white shadow-md rounded-lg">
        <h1 class="text-xl font-bold my-4">Шеърҳои дустдошта </h1>
        <div>
        @foreach($favPoems as $poem)
            <a href="/poems/{{$poem->poem_id}}" class="font-bold text-md">
                <div class="mb-2 flex justify-between items-center space-x-4 bg-gray-50 border-b-4 border-l-4 cursor-pointer rounded-lg p-3">
                    
                    <div class="space-y-4 font-bold">
                        @if ($poem->poem)
                            {{ explode('<br>', $poem->poem->content)[0] ?? 'No content available' }}
                        @else
                            No content available
                        @endif
                    </div>

                    <div class="flex items-center space-x-3">
                        <img src="/assets/heart-fill.svg" alt="">
                        <div>
                            {{ $poem->poem ? count($poem->poem->likes) : 0 }}
                        </div>
                    </div>
                </div>
            </a>     
        @endforeach


        </div>

    </div>


</div>

@endsection