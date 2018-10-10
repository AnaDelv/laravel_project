<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Anaëlle Delavau">
    <meta name="author" content="Yao Merle">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'iNotreDame') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link href="{{asset('css/summernote.css')}}" rel="stylesheet">



</head>
<body>
<div id="app">
    @include('inc.navbar')
    @include('inc.messages')
    @yield('content')
    @include('inc.footer')
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/intranet.js') }}"></script>
<script src="{{asset('js/summernote.js')}}"></script>

<script>
    function ConfirmDelete(){
        return confirm('Êtes-vous sûr·e de vouloir supprimer cet élément ?');
    }
</script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });
</script>
</body>
</html>