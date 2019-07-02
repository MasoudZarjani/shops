<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" type="image/jpg" href="{{ asset('images/vesam-logo.jpg') }}" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vuetify.min.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <router-view></router-view>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>