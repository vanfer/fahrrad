@extends("layouts.app")

@section('content')
    {{-- Linke Seite in der Adminansicht --}}
    @include("admin.fahrraeder")

    {{-- Rechte Seite in der Adminansicht --}}
    @include("admin.datenbank")
@endsection