<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Даромадан ба профил</title>
    @vite('resources/css/app.css')
    <link rel="icon" type="image/x-icon" href="/assets/brand/logo.png">
</head>
<body>
    


<div class=" md:flex lg:px-80 justify-center items-start pt-4 md:space-x-4 md:px-40 bg-gray-100">
<div class="w-full flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 bg-white shadow-md rounded-lg">
        <div class="flex justify-center">
            <img src="/assets/brand/logo-horizontal.png" width="200" class="mb-8" alt="">
        </div>

        <h2 class="text-2xl font-bold mb-6 text-center">{{ __('Воридшавӣ') }}</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Почтаи электронӣ') }}</label>
                <input id="email" type="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Рамз (Парол)') }}</label>
                <input id="password" type="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('password') border-red-500 @enderror" name="password" required autocomplete="current-password">

                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center mb-4">
                <input id="remember" type="checkbox" name="remember" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember" class="ml-2 block text-sm text-gray-900">{{ __('Маро фаромуш накунед') }}</label>
            </div>

            <div class="flex flex-col items-center justify-center space-y-8">
                <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Ворид шудан') }}
                </button>

                <!-- @if (Route::has('password.request'))
                    <a class="text-sm text-indigo-600 hover:text-indigo-800" href="{{ route('password.request') }}">
                        {{ __('Рамзи худро фаромуш кардед ?') }}
                    </a>
                @endif -->
                <a class=" text-indigo-600 hover:text-indigo-800" href="/register">
                        {{ __('Ҳоло саҳифа надоред ? Худро ба қайд гиред !') }}
                </a>
            </div>
        </form>
    </div>
</div>

</div>


</body>
</html>