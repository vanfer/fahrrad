<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset("css/bootstrap.css") }}" rel="stylesheet">
    <link href="{{ asset("css/style.css") }}" rel="stylesheet">
    <link href="{{ asset("css/jquery-ui.min.css") }}" rel="stylesheet">
    <link href="{{ asset("css/jquery-ui.structure.min.css") }}" rel="stylesheet">
    <link href="{{ asset("css/jquery-ui.theme.min.css") }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app"  >
        <nav class="navbar">
                    <img src="{{URL::asset('/img/whs_logo.png')}}" alt="Logo" height=100px class="pull-right">
                    <a class="softwaretitel" href="{{ url('/') }}">
                        <span>SPIN WiSe 16/17 Fahrradergometer</span>
                    </a>
        </nav>

        <div class="main-wrapper ">
            @yield('content')
        </div>

    </div>

    <!-- Scripts -->
    <script src="{{ asset("js/jquery.js") }}"></script>
    <script src="{{ asset("js/jquery-ui.min.js") }}"></script>
    <script src="{{ asset("js/mindmup-editabletable.js") }}"></script>
    <script src="{{ asset("js/bootstrap.js") }}"></script>
    <script src="{{ asset("js/Chart.bundle.js") }}"></script>
    <script src="{{ asset("js/main.js") }}"></script>
</body>
</html>
