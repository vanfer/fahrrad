@extends("layouts.app")

@section("content")

    <div class ="container-fluid">
        {{-- Anzeige Streckenmodus  --}}
        <div class="panel panel-default pull-left strecken-panel">
            <div class="panel-heading">
                <h3 class="panel-title">Streckenmodus</h3>
            </div>
            <div class="panel-body">
                <div id="track-wrapper col-lg-12">
                    <canvas id="track"></canvas>
                </div>
            </div>
        </div>

        {{-- Anzeige der Leistung im Modus konstante Leistung und konstanter Drehmoment --}}
        <div class="panel panel-default pull-left leistung-panel">
            <div class="panel-heading">
                <h3 class="panel-title">Leistung</h3>
            </div>
            <div class="panel-body">
                <div id="energy-current-wrapper col-lg-12">
                    <canvas id="energy-current"></canvas>
                </div>
            </div>
        </div>

        {{-- Anzeige Gesamtenergie  --}}
        <div class="panel panel-default pull-left gesamtleistung-panel">
            <div class="panel-heading">
                <h3 class="panel-title">Gesamtleistung</h3>
            </div>
            <div class="panel-body">
                <div id="energy-wrapper col-lg-12">
                    <canvas id="energy"></canvas>
                </div>
            </div>
        </div>

        <div class="clear"></div>
    </div>



    {{-- Anzeige der Fahrerdetails  --}}
    @include("central.fahrrad-information")

    <div class ="container-fluid">
        {{-- Anzeige der Tagesstatistik --}}
        @include("central.tagesstatistik")
        {{-- Anzeige der Highscore  --}}
        @include("central.highscore")
        {{-- Anzeige der Batterieladung  --}}
        @include("central.batterieladung")
        <div class="clear"></div>
    </div>

@endsection


