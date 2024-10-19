@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">{{ __('Edit Post') }}</h2>

        <form method="POST" action="{{ route('poems.edit') }}">
            @csrf

            <input type="hidden" name="poem_id" value="{{ $poem->id }}">

            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">{{ __('Content') }}</label>
                <textarea id="content_in" rows="12" required
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('content') border-red-500 @enderror">{{ $poem->content }}</textarea>

                @error('content')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <input value="{{ $poem->content }}" type="hidden" id="content_out" name="content" rows="4" required
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('content') border-red-500 @enderror">

                @error('content')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>


            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">{{ __('Author') }}</label>
                <select name="author" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @foreach($authors as $poet) 
                    @if($poem->poet->id == $poet->id)
                        <option selected value="{{ $poet->id }}">{{ $poet->name }}</option>
                    @else 
                        <option value="{{ $poet->id }}">{{ $poet->name }}</option>
                    @endif
                @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">{{ __('Genre') }}</label>
                <select name="genre" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @foreach($genres as $genre) 
                    @if($poem->genre == $genre)
                        <option selected value="{{ $genre }}">{{ $genre }}</option>
                    @else 
                        <option value="{{ $genre }}">{{ $genre }}</option>
                    @endif
                @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">{{ __('Tags') }}</label>
                <input value="{{ $poem->tags }}" id="title" type="text" name="tags" value="{{ old('tags') }}" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('title') border-red-500 @enderror">

                @error('tags')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>


            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">{{ __('Vocabulary') }}</label>
                <textarea id="content_in2" rows="9"
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('content') border-red-500 @enderror">{{ $poem->vocabulary->first()->word ?? '' }}</textarea>
            </div>

            <div class="mb-4">
                <input type="hidden" id="content_out2" name="vocabs" rows="4"
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('content') border-red-500 @enderror">
            </div>

            



            <div>
                <button id type="btn" class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Edit') }}
                </button>
            </div>


        </form>

        <div>

                <form action="{{ route('poems.delete') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $poem->id }}" name="poem_id">

                    <button type="submit" class="w-full py-2 px-4 text-red-800 font-semibold ">
                        {{ __('Delete') }}
                    </button>
                </form>
      
        </div>

    </div>
</div>


<script src="/js/jquery.js"></script>
<script>

    

    $(document).ready(function() {


        var inputText = $('#content_in').val();
        var outputText = inputText.split('<br>').join('\n')
        $('#content_in').val(outputText)

        var inputText = $('#content_in2').val();
        var outputText = inputText.split('<br>').join('\n')
        $('#content_in2').val(outputText)


        $('#content_in').on('input',function() {
            var inputText = $(this).val();
            var outputText = inputText.split('\n').join('<br>')
            $('#content_out').val(outputText)
        })

        $('#content_in2').on('input',function() {
            var inputText = $(this).val();
            var outputText = inputText.split('\n').join('<br>')
            $('#content_out2').val(outputText)
        })

        
    })


</script>

@endsection
