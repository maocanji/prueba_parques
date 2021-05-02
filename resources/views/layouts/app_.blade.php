<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="johanm mauricio carrillo dev ">

    <title>Prueba Parques Nacional  </title>

    <!-- Bootstrap core CSS -->

    <link href="{!! asset('asset/bootstrap.css') !!}" rel="stylesheet" type="text/css" />
{{--    <link href="{!! asset('https://cdnjs.cloudflare.com/ajax/libs/ng-table/1.0.0-beta.9/ng-table.css') !!}" rel="stylesheet" type="text/css" />--}}



</head>
<body class="gray-bg">

            <!-- Main view  -->
            @yield('content')





@section('scripts')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">
    {{--<script src="{!! asset('asset/jquery-2.1.1.js') !!}"></script>--}}
    <!-- Mainly scripts -->

    <script src="{{ asset('asset/bootstrap.js') }}"></script>∫

    <script src="{{ asset('asset/Angularjs/angular.min.js') }}"></script>
    <script src="{{ asset('asset/Angularjs/ngTable/ng-table.js') }}"></script>
    <script src="{{ asset('asset/Angularjs/ui-bootstrap.min.js') }}"></script>
@include('scripts')

@show

</body>
</html>
