@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">{{ __('Add Poet') }}</h2>

        <form method="POST" action="{{ route('poets.create') }}" enctype="multipart/form-data">
            @csrf

            

            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                <input id="content" name="name" rows="4" required
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('content') border-red-500 @enderror">

                @error('content')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">{{ __('Lifetime') }}</label>
                <input placeholder="1944 - 2022" id="content" name="lifetime" rows="4" required
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('content') border-red-500 @enderror">
            </div>

            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">{{ __('Bio') }}</label>
                <textarea id="content_in" id="" cols="30" rows="20" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('content') border-red-500 @enderror"></textarea>
            </div>

            <input type="hidden" id="content_out" name="bio" required
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('content') border-red-500 @enderror">

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">{{ __('Category') }}</label>
                <select name="category" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="классик">Классик</option>
                    <option value="7 аллома">7 аллома</option>
                    <option value="классик">Муосир</option>
                    <option value="классик">Шурави</option>
                    <option value="классик">Совети</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">{{ __('Photo') }}</label>
                <input type="file" name="image" id="image" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Create') }}
                </button>
            </div>

        </form>
    </div>
</div>
@endsection

<script src="/js/jquery.js"></script>
<script>

    

    $(document).ready(function() {
        $('#content_in').on('input',function() {
            var inputText = $(this).val();
            var outputText = inputText.split('\n').join('<br>')
            $('#content_out').val(outputText)
        })
    })


</script>
