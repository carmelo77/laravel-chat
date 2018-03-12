<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel chat</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ url('/css/app.css') }}">
  </head>
  <body>
    <div id="app" class="container">
      <div class="row-fluid">
        <contacts></contacts>
        <messages></messages>
      </div>
    </div>
    <!-- Latest compiled and minified JavaScript -->
    <script src="{{ url('/js/app.js') }}"></script>
    <script src="{{url('/')}}/scripts/socket.js" type="text/javascript"></script>
    <script>
        var socket = io('http://localhost:3000/');
    </script>
  </body>
</html>
