@extends("layouts.app")

@section("content")
    <div id="track-wrapper">
        <canvas id="track"></canvas>
    </div>

    <div id="energy-current-wrapper">
        <canvas id="energy-current"></canvas>
    </div>

    <div id="energy-wrapper">
        <canvas id="energy"></canvas>
    </div>

    <div class="clear"></div>

    @include("central.fahrrad-information")
@endsection