@extends('layouts.app')


@section('title')

    Маънои калимаҳои @foreach($vocab->take(10) as $word) {{ $word->word }} @endforeach

@endsection

@section('content')

    <div class="p-8 bg-white shadow-md rounded-lg">
        <h1 class="text-xl font-bold my-4 mt-6">Луғат ва калимаҳои душворфаҳм </h1>
        <div class=" rounded-md mt-4">
            @foreach($vocab as $word)
                <div class="flex justify-between border-b p-4 border-blue-800">
                    <div class="text-gray-800">{!! $word->word !!}</div>
                </div>
            @endforeach

        
        </div>
    </div>


@endsection