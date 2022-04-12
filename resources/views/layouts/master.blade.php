<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    {{-- chart google js --}}
    @stack('chartJs')
    @include('include.css')
</head>

<body>
    <div id="app" class="main-wrapper">
        @include('include.sidebar')
        <div class="page-wrapper">
            @include('include.header')


            {{-- {{ $content }} --}}
            @yield("content")


            @include('include.footer')


        </div>
    </div>
    @include('include.js')
</body>

</html>
