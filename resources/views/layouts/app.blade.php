<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/assets/brand/logo.png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <title>@yield('title')</title>
    @vite('resources/css/app.css')
</head>
<body>
    

    <div class=" hidden md:flex lg:px-80 justify-center items-start pt-4 md:space-x-4 md:px-40 bg-gray-100">
        <div class="hidden md:block shadow-md p-4 py-8 sticky top-4 bg-white rounded-md" style="min-width: 300px">

            @include('inc.sidebar')

        </div>
        <div class="w-full" style="min-width: 100%;">
            @yield('content')
        </div>

        @include('inc.ai-button')

    </div>





    <div class=" md:hidden lg:px-80 pt-4  md:px-40 bg-gray-100">
        
            @yield('content')
            @include('inc.ai-button')

    </div>













</body>
</html>