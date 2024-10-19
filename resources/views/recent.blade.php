@extends('layouts.app')

@section('content')




<div class="flex items-center justify-center min-h-screen ">
    <div class="w-full p-8 bg-white shadow-md rounded-lg">

        @include('inc.search')


        <div class="flex justify-center">
            <img src="/assets/brand/logo.png" style="height: 60px;" alt="">
        </div>
        <h2 class="text-2xl font-bold mb-6 text-center">{{ __('Шеърҳои нав') }}</h2>

        @if ($poems->isEmpty())
            @include('inc.nothing')
        @else
            <ul class="space-y-4">
            @foreach ($poems as $poem)
                <li class="p-4 bg-indigo-10 border border-b-4 border-l-4 border-gray-200 rounded-md shadow-sm">
                    <div class="flex space-x-4 items-center mb-4">
                        <div class="rounded-full bg-gray-600 cursor-pointer">
                            <a href="/{{ $poem->poet->name }}">
                                <img src="{{ $poem->poet->avatar }}" alt="" style="width: 35px; height: 35px;" class="rounded-full">
                            </a>
                        </div>
                        <div class="space-y-4">
                            <a href="/poets/{{ $poem->poet->name }}" class="font-bold text-lg">{{ $poem->poet->name }}</a> 
                        </div>
                    </div>
                    <a href="{{ route('poems.show', $poem) }}">
                        <p class="text-gray-700 whitespace-pre-line">{!! Str::limit($poem->content, 150) !!}</p>
                        <span class="text-indigo-600 hover:text-indigo-800 mt-2 inline-block">
                            {{ __('Муфассал') }}
                        </span>
                    </a>
                    <div class="mt-4">
                        <div class="flex items-center justify-end md:justify-start">
                            @if(Auth::check() && $poem->likes->contains('user_id', Auth::user()->id)) 
                                <img src="/assets/heart-fill.svg" alt="Liked">
                            @else
                                <button class="likebtn" data-poem-id="{{ $poem->id }}">
                                    <img src="/assets/heart-disabled.svg" alt="Not Liked">
                                </button>
                            @endif
                            <div class="likes"></div>
                            <div class="like_amount ms-2">{{ count($poem->likes) }}</div>
                        </div>                            
                    </div>  
                </li>
            @endforeach

            </ul>
        @endif
    </div>
</div>
@endsection

<script src="/js/jquery.js"></script>
<script>
    $(document).ready(function() {
        var loggedIn = '{{ Auth::check() }}';

        $('.likebtn').on('click', function() {
            if (loggedIn !== '1') {
                location.href = '/register';
                return;
            }

            var button = $(this);
            var poemId = button.data('poem-id');

            button.hide();
            button.siblings('.likes').append('<img id="dislike" src="/assets/heart-fill.svg" alt="">');

            $.ajax({
                url: '{{ route("addLike") }}',
                type: 'POST',
                data: {
                    poem_id: poemId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    let prev_likes = parseInt(button.siblings('.like_amount').text());
                    button.siblings('.like_amount').text(prev_likes + 1);
                },
                error: function(xhr) {
                    console.log(xhr.error);
                }
            });
        });
    });
</script>
