@extends('layouts.app')
@section('title') {{ $poet->name }} @endsection
@section('content')
<div class="flex items-center justify-center bg-gray-100">
    <div class="w-full p-2 py-8 md:p-8 bg-white shadow-md rounded-lg">

        <div class="flex items-center justify-between flex-wrap space-y-4">
            <div class="flex items-center space-x-4">
                <img src="{{ $poet->avatar }}" alt="" style="width: 70px; height: 70px;" class="rounded-full" >
                <div>
                    <h1 class="text-xl font-black">{{ $poet->name }}</h1>
                    <div><span class="font-bold">{{ count($poet->views) }}</span> просмотров</div>

                </div>
            </div>
            <form action="/follow" method="POST">
                @csrf
                <input type="hidden" name="poet_id" value="{{ $poet->id }}" required>
                <input type="hidden" name="poet_name" value="{{ $poet->name }}" required>
                
                @if(Auth::check() && $poet->subscriptions->contains('user_id', Auth::user()->id)) 
                <h4 class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-700 focus:outline-none">
                    Отписаться 
                </h4>
                @else
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-700 focus:outline-none">
                    Подписаться <span class="font-black">&nbsp +</span>
                </button>
                @endif
            </form>
        </div>
        <div class="flex items-center space-x-8 my-8">
            <h4 class="text-lg">Подписчиков <span class="font-black">{{ count($poet->subscriptions) }}</span></h4>
            <button class="p-2 rounded-full bg-gray-200">{{ $poet->category }}</button>
        </div>

        <div class="mt-8 bg-gray-100 rounded-xl p-6">
            {{ Str::limit($poet->bio, 170) }}
            <br>
            <a href="/poets/{{ $poet->name }}/bio" class="text-lg text-blue-800">тарҷумаи ҳол</a>
        </div>

        <br>

        <div class="flex sticky top-0 bg-white" style="overflow-x: auto">
            @if(request('filter') == 'recent') 
                <a href="?safina" class="w-full text-center p-2 px-4 border-2 cursor-pointer rounded-t-xl">Машҳур</a>
                <a class="w-full text-center p-2 px-4 border-2 cursor-pointer rounded-t-xl border-indigo-800 text-indigo-800 font-bold">Навтарин</a>
                <!-- <a class="w-full text-center p-2 px-4 border-2 cursor-pointer rounded-t-xl">Сохранённые</a> -->
            @elseif(request('filter') == null) 
                <a class="w-full text-center p-2 px-4 border-2 cursor-pointer rounded-t-xl border-indigo-800 text-indigo-800 font-bold">Машҳур</a>
                <a href="?filter=recent" class="w-full text-center p-2 px-4 border-2 cursor-pointer rounded-t-xl">Навтарин</a>
                <!-- <a class="w-full text-center p-2 px-4 border-2 cursor-pointer rounded-t-xl">Сохранённые</a> -->
            @endif
        </div>

        @if ($poems->isEmpty())
            @include('inc.nothing')
        @else
            <ul class="space-y-4">
                @foreach ($poems as $poem)
                    <li class="p-4 bg-gray-50 border border-gray-200 rounded-md shadow-sm">
                        <p class="text-gray-700 whitespace-pre-line">{!! Str::limit($poem->content, 150) !!}</p>
                        <a href="{{ route('poems.show', $poem->id) }}" class="text-indigo-600 hover:text-indigo-800 mt-2 inline-block">
                            {{ __('Муфассал') }}
                        </a>

                        <div class="my-8 flex space-x-3 items-center">
                            <div class="likes">
                                @if(Auth::check() && $poem->likes->contains('user_id', Auth::user()->id)) 
                                    <img src="/assets/heart-fill.svg" alt="Liked" class="liked">
                                @else
                                    <button class="likebtn" data-poem-id="{{ $poem->id }}">
                                        <img src="/assets/heart-disabled.svg" alt="Not Liked">
                                    </button>
                                @endif
                            </div>
                            <div class="like_amount ms-2">{{ count($poem->likes) }}</div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

<script src="/js/jquery.js"></script>
<script>

    const sendSignalForMail = () => {
        $.ajax({
                url: '{{ route("reco-mail") }}',
                type: 'POST',
                data: {
                    poet_name: '{{ $poet->name }}',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('sent email signal to server !')
                },
                error: function(xhr) {
                }
            });

    }

    $(document).ready(function() {



        $.ajax({
                url: '{{ route("reco-mail") }}',
                type: 'POST',
                data: {
                    poet_name: '{{ $poet->name }}',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('sent email signal to server !')
                },
                error: function(xhr) {
                    console.log(xhr)
                }
            });

        var loggedIn = '{{ Auth::check() }}';

        $('.likebtn').on('click', function() {
            if (loggedIn !== '1') {
                location.href = '/register';
                return;
            }

            var button = $(this);
            var poemId = button.data('poem-id');

            button.hide();
            button.parent().append('<img id="dislike" src="/assets/heart-fill.svg" alt="">');

            $.ajax({
                url: '{{ route("addLike") }}',
                type: 'POST',
                data: {
                    poem_id: poemId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    let prev_likes = parseInt(button.parent().siblings('.like_amount').text());
                    button.parent().siblings('.like_amount').text(prev_likes + 1);
                },
                error: function(xhr) {
                    console.log(xhr.error);
                }
            });
        });
    });
</script>
@endsection
