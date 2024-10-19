@extends('layouts.app')
@section('title') {{ Str::limit($poem->content, 20) }}... Шеъри {{ $poem->poet->name }} @endsection
@section('content')
<div style="" class="bg-gray-100">
    <div class="p-8 bg-white shadow-md rounded-lg">
        <div class="flex space-x-3 items-center mb-8">
            <img src="/assets/brand/character.png" width="45" class="rounded-full" alt="">
            <a href="/readers/{{$poem->user->id}}">
                <h2 class="text-xl font-">{{ $poem->user->name }}</h2>
            </a>
        </div>
        <p class="text-gray-700 text-2xl cormorant-garamond-light" style="font-family: 'Cormorant Garamond', serif; font-weight: 500;">{!! $poem->content !!}</p>

        <div class="flex space-x-8 my-8">
            <div class="flex space-x-3 items-center">
                <div class="likes">
                    @if(Auth::check() && $poem->likes->contains('user_id', Auth::user()->id)) 
                        <img src="/assets/heart-fill.svg" alt="Liked" class="liked">
                    @else
                        <img src="/assets/heart-disabled.svg" alt="Not Liked" class="likebtn">
                    @endif

                    <img style="display: none" src="/assets/heart-fill.svg" alt="Liked" class="liked">


                </div>
                
                <div class="like_amount">
                    {{ count($poem->likes) }}
                </div>
            </div>

            <div class="flex space-x-3 items-center">
                <div>
                    <img src="/assets/eye.svg" alt="">
                </div>
                <div>
                    {{ count($poem->views) }}
                </div>
            </div>

           

            @if(Auth::check())
                @if(Auth::user()->role == 'admin' || $poem->user->id == Auth::user()->id)
                    <a href="/edit/{{$poem->id}}">
                        <div>
                            <img src="/assets/edit.svg" class="cursor-pointer" alt="">
                        </div>
                    </a>
                @endif
            @endif

        </div>


        <p class=" text-blue-700 font-light">{{ $poem->created_at }}</p>



        <div class="tags flex flex-wrap space-x-2 mt-4">
            <a href="/">
                <button class="p-2 bg-indigo-800 text-white rounded-xl ">
                    {{ $poem->genre }}
                </button>
            </a>
            @foreach(explode(',',$poem->tags) as $tag)
            <a href="/search?query={{ $tag }}">
                <button class="p-2 text-indigo-800 bg-white border-indigo-800 border-2 rounded-xl hover:bg-indigo-800 hover:text-white">
                    {{ $tag }}
                </button>
            </a>
            @endforeach
        </div>


        @if(count($poem->vocabulary) > 0)
            <h1 class="text-xl font-bold my-4 mt-6">Луғат ва калимаҳои душворфаҳм </h1>
        @endif
       
        <div class="bg-gray-100 rounded-md mt-4">
            @foreach($poem->vocabulary->take(5) as $word)
                <div class="flex justify-between border-b p-4 border-blue-800">
                    <div class="text-gray-800">{!! Str::limit($word->word, 80) !!}</div>
                </div>
            @endforeach

            @if(strlen($poem->vocabulary->first()->word ?? '') > 80)
                <div class="flex justify-center py-4 hover:bg-gray-200 cursor-pointer">
                    <a href="{{ route('poem.full_vocabulary', $poem->id) }}" class="text-blue-700 font-bold">
                        Ҳама калимаҳо
                    </a>
                </div>
            @endif

        </div>




        <div class="my-8">
            @if (count($poem->comments) > 0)
                @foreach ($poem->comments as $comment)
                <div class="p-4 border border-t-4 rounded-lg my-2">
                    <a href="/readers/{{$comment->user->id}}">
                        <div class="flex items-center space-x-3 mb-3">
                            <img src="/assets/brand/character.png" width="30" class="rounded-full" alt="">
                            <div class="font-bold">
                                    {{ $comment->user->name }}                        
                            </div>
                        </div>
                    </a>
                    <p>{{ $comment->text }}</p>
                </div>
                @endforeach
            @endif
        </div>


        <div class="mb-8">
            <a href="{{ '/ai?query='.$poem->content }}">
                <button class="flex items-center font-bold border-2 border-black shadow-xl space-x-3 p-4 rounded-md">
                    <img src="/assets/send-sqaure-2.svg" width="28" alt="">
                    <div>маънои шеър</div>
                </button>
            </a>
        </div>

        <h1 class="text-xl font-bold my-4">Шарҳи шеърро гузоред </h1>


        <form action="/comment" method="POST" class="mb-8">
            @csrf

           

            <div class="mb-4">
                <textarea name="text" id="description" rows="4" class="mt-1 border-2 outline-none p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required></textarea>
            </div>

            <input type="hidden" name="poem_id" value="{{ $poem->id }}"  required>


            <div class="mt-6">
                <button type="submit" class="inline-flex justify-center py-2 px-4  shadow-sm text-sm font-medium rounded-md border-2 text-indigo-700 border-indigo-700 ">
                    Равон кардан
                </button>
            </div>


        </form>



        <div class="my-8 flex space-x-4 items-center bg-gray-100 p-4 rounded-md">
            <div class="rounded-full bg-gray-600 cursor-pointer">
                <a href="/{{ $poem->poet->name }}">
                    <img src="{{ $poem->poet->avatar }}" alt="" style="width: 70px; height: 70px;" class="rounded-full" >
                </a>
            </div>
            <div class="space-y-4">
                <a href="/poets/{{ $poem->poet->name }}" class="font-bold text-lg">{{ $poem->poet->name }}</a>

                <form action="/follow" method="POST">
                    @csrf
                    <input type="hidden" name="poet_id" value="{{ $poem->poet->id }}"  required>
                    <input type="hidden" name="poet_name" value="{{ $poem->poet->name }}"  required>

                    @if(Auth::check() && $poem->poet->subscriptions->contains('user_id', Auth::user()->id)) 
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


        </div>



        @include('inc.similar')











    </div>


    


</div>



<script src="/js/jquery.js"></script>
<script>

    var loggedIn = '{{ Auth::check() }}';
    var requestInProgress = false; // Flag to prevent multiple requests

    $('.likebtn').on('click', function() {
        if(loggedIn !== '1') {
            location.href = '/register';
            return;
        }

        if (requestInProgress) {
            return; // Prevent multiple requests
        }

        requestInProgress = true; // Set flag to indicate request is in progress

        let likeButton = $(this);
        let likesCountElement = $('.like_amount');

        $.ajax({
            url: '{{ route("addLike") }}',
            type: 'POST',
            data: {
                poem_id: '{{ $poem->id }}',
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Toggle the like state
                likeButton.hide(); // Hide the like button
                $('.liked').show();

                // Update the likes count
                let prevLikes = parseInt(likesCountElement.text());
                likesCountElement.text(prevLikes + 1);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            },
            complete: function() {
                requestInProgress = false; // Reset the flag once the request is complete
            }
        });
    });

</script>




@endsection
