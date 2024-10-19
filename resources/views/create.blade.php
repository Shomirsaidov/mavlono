@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">{{ __('Create Post') }}</h2>

        <form method="POST" action="{{ route('poems.create') }}">
            @csrf

            

            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">{{ __('Content') }}</label>
                <textarea id="content_in" rows="12" required
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>

                @error('content')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <input type="hidden" id="content_out" name="content" rows="4" required
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('content') border-red-500 @enderror">

                @error('content')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>


            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">{{ __('Author') }}</label>
                <select name="author" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @foreach($authors as $poet) 
                        <option value="{{ $poet->id }}">{{ $poet->name }}</option>
                @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">{{ __('Genre') }}</label>
                <select name="genre" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @foreach($genres as $genre) 
                        <option value="{{ $genre }}">{{ $genre }}</option>
                @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">{{ __('Theme') }}</label>
                <input id="title" type="text" name="tags" value="{{ old('tags') }}" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('title') border-red-500 @enderror">

                @error('tags')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">{{ __('Vocabulary') }}</label>
                <textarea id="content_in2" rows="9" 
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('content') border-red-500 @enderror"></textarea>
            </div>

            <div class="mb-4">
                <input type="hidden" id="content_out2" name="vocabs" rows="4" required
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('content') border-red-500 @enderror">
            </div>


            



            <div>
                <button id type="btn" class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Submit') }}
                </button>
            </div>
        </form>
    </div>
</div>


<script src="/js/jquery.js"></script>
<script>

    

    $(document).ready(function() {
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
