@extends("layouts.app")

@section("content")
    <div id="track-wrapper">
        <h1>Strecke</h1>
        <canvas id="track"></canvas>
    </div>

    <div id="energy-current-wrapper">
        <h1>Energie</h1>
        <canvas id="energy-current"></canvas>
    </div>

    <div id="energy-wrapper">
        <h1>Energie (Alle)</h1>
        <canvas id="energy"></canvas>
    </div>

    <div class="clear"></div>

    @include("central.fahrrad-information")
@endsection