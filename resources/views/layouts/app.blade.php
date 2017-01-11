<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Fahrrad @yield("title")</title>

    <!-- Styles -->
    <link href="{{ asset("css/bootstrap.css") }}" rel="stylesheet">
    <link href="{{ asset("css/style.css") }}" rel="stylesheet">
    <link href="{{ asset("css/jquery-ui.min.css") }}" rel="stylesheet">
    <link href="{{ asset("css/jquery-ui.structure.min.css") }}" rel="stylesheet">
    <link href="{{ asset("css/jquery-ui.theme.min.css") }}" rel="stylesheet">
    <link href="{{ asset("css/dataTables.bootstrap.min.css") }}" rel="stylesheet">
    <link href="{{ asset("css/jquery.dataTables.min.css") }}" rel="stylesheet">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset("favicon.ico") }}">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>

    <div class="smartphone-overlay">
        <img src="{{URL::asset('/img/whs_logo.png')}}" alt="Logo" class="logo-smartphone">
        <div class="smartphone-overlay-text">
            <span>Die von Ihnen gewünschte Seite oder Funktion steht leider nicht zur Verfügung.</span>
        </div>
    </div>

    <div id="app">
        <div class="header">
            <nav class="container-fluid">
                <div class="logo">
                    <img src="{{URL::asset('/img/whs_logo.png')}}" alt="Logo" class="pull-right">
                </div>
                <div class="softwaretitel-wrapper">
                    <a class="softwaretitel" href="{{ url('/') }}">
                        <span>SPIN WiSe 16/17 Fahrradergometer</span>
                    </a>
                </div>
            </nav>
        </div>

        <div class="main-wrapper">
            @yield('content')
        </div>

    </div>

    <!-- Scripts -->

    <script src="{{ asset("js/libs/jquery.js") }}"></script>
    <script src="{{ asset("js/libs/bootstrap.js") }}"></script>

    <script src="{{ asset("js/libs/jquery-ui.min.js") }}"></script>

    <script src="{{ asset("js/libs/highcharts.js") }}"></script>
    <script src="{{ asset("js/libs/mindmup-editabletable.js") }}"></script>

    <script src="{{ asset("js/libs/dataTables.bootstrap.min.js") }}"></script>
    <script src="{{ asset("js/libs/jquery.dataTables.min.js") }}"></script>

    @yield('scripts')
</body>
</html>
