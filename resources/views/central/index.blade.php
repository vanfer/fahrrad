@extends("layouts.app")

@section("content")

    <div class ="container-fluid">
        {{-- Anzeige sStreckenmodus  --}}
        <div class="panel panel-default pull-left strecken-panel">
            <div class="panel-heading panel-heading-zd">
                <h3 class="panel-title panel-title-zd">Strecke</h3>
            </div>
            <div class="panel-body panel-body-zd">
                <div id="track-wrapper col-lg-12">
                    <!--<canvas id="track"></canvas>-->
                    <div id="container-strecke" style="width:100%; height: 250px;"></div>
                </div>
            </div>
        </div>

        {{-- Anzeige der Leistung im Modus konstante Leistung und konstanter Drehmoment --}}
        <div class="panel panel-default pull-left leistung-panel">
            <div class="panel-heading panel-heading-zd">
                <h3 class="panel-title panel-title-zd">Leistung</h3>
            </div>
            <div class="panel-body panel-body-zd">
                <div id="energy-current-wrapper col-lg-12">
                    <div id="container-leistung" style="width:100%; height: 250px;"></div>
                </div>
            </div>
        </div>

        {{-- Anzeige Gesamtenergie  --}}
        <div class="panel panel-default pull-left gesamtleistung-panel">
            <div class="panel-heading panel-heading-zd">
                <h3 class="panel-title panel-title-zd">Gesamtleistung</h3>
            </div>
            <div class="panel-body panel-body-zd">
                <div id="energy-wrapper col-lg-12">
                    <canvas id="energy"></canvas>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
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
        <div class="clearfix"></div>
    </div>


@endsection

@section("scripts")
    <script src="{{ asset("js/central.js") }}"></script>
@endsection
