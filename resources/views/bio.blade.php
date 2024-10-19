@extends('layouts.app')


@section('title')

    Тарҷумаи ҳоли {{ $poet->name }}

@endsection

@section('content')

<div class="flex items-center justify-center ">
    <div class="w-full p-8 bg-white shadow-md rounded-lg">

       <div>
       @include('inc.search')
       </div>


        <div class="bio mt-4">
            <div class="flex flex-col justify-center items-center space-y-4">
                <img src="{{ $poet->avatar }}" class="rounded-full" style="width: 100px; height: 100px;" alt="">
                <h2 class="text-2xl font-bold text-center mt-4">{{ $poet->name }}</h2>
                <div class="flex space-x-4 items-center">
                    <div class="text-blue-800 text-lg font-bold">{{ $poet->lifetime }}</div>
                    <button class="p-2 rounded-full bg-gray-200">{{ $poet->category }}</button>
                </div>
            </div>

            <div class="p-2 md:p-8">
                <article>
                    {!! $poet->bio !!}
                </article>
            </div>

            <div class="mb-16">
                <h1 class="text-xl font-bold my-4">Монанди ин</h1>
                <ul class="flex space-x-4 flex-wrap">
                    @foreach($similarPoets as $similar)
                        <li class="mt-10 md:mt-10">
                           <a href="/poets/{{$similar->name}}/bio">
                                <div class="rounded-full" style="position: relative;">
                                    <img class="rounded-full " src="{{ $similar->avatar }}" style="height: 150px; width: 150px;" alt="">
                                    <button class="border-2 bg-white border-indigo-700 leading-5 rounded-full px-4  text-indigo-900" style="bottom: -30px; position: absolute; min-height: 45px">{{ $similar->name }}</button>
                                </div>
                           </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h1 class="text-xl font-bold my-4">Шеърҳои машҳури {{ $poet->name }} </h1>
                <ul class="space-y-4">
                @foreach ($poems as $poem)
                    <li class="p-4 bg-gray-50 border border-gray-200 rounded-md shadow-sm">
                        <p class="text-gray-700 whitespace-pre-xline">{!! Str::limit($poem->content, 150) !!}</p>
                        <a href="{{ route('poems.show', $poem->id) }}" class="text-indigo-600 hover:text-indigo-800 mt-2 inline-block">
                            {{ __('Муфассал') }}
                        </a>

                        <div class="my-8 flex space-x-3 items-center">
                            <div class="likes">
                                @if(Auth::check() && $poem->likes->contains('user_id', Auth::user()->id)) 
                                    <img src="/assets/heart-fill.svg" alt="Liked" class="liked">
                                @else
                                    <img src="/assets/heart-disabled.svg" alt="Not Liked">
                                @endif
                            </div>
                            <div class="like_amount ms-2">{{ count($poem->likes) }}</div>
                        </div>
                    </li>
                @endforeach
                <ul>
            </div>

        </div>
    </div>
</div>

@endsection