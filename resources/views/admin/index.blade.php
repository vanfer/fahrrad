@extends("layouts.app")

@section("title")
    - Admin
@endsection

@section('content')
    {{-- Linke Seite in der Adminansicht --}}
    @include("admin.fahrraeder")

    {{-- Rechte Seite in der Adminansicht --}}
    @include("admin.datenbank")

    <div class="container pull-right text-right">
        <button type="button" class="btn btn-default" id="btnEinstellungen">
            <span class="glyphicon glyphicon-cog"></span>
        </button>
        <a class="btn btn-default" href="{{ url("admin/logout") }}">Logout</a>
    </div>

    @include("admin.dialoge")
@endsection

@section("scripts")
    <script src="{{ asset("js/admin.js") }}"></script>
@endsection