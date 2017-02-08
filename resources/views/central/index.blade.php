@extends("layouts.app")

@section("title")
    - Central
@endsection

@section("content")
    {{-- Anzeige der Diagramme  --}}
    @include("partial.charts")

    {{-- Anzeige der Fahrerinformationen  --}}
    @include("central.fahrrad-information")

    <div class ="container-fluid">
        {{-- Anzeige der Tagesstatistik --}}
        @include("central.tagesstatistik")
        {{-- Anzeige der Highscore  --}}
        @include("central.highscore")
        {{-- Anzeige der Batterieüberwachung  --}}
        @include("central.batterieladung")
        <div class="clearfix"></div>
    </div>
@endsection

@section("scripts")
    <script src="{{ asset("js/central.js") }}"></script>
@endsection
