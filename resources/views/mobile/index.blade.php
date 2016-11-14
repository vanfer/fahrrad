@extends("layouts.app")

@section("content")
    @if(Auth::check())
        Hallo, {{ Auth::user()->name }}
    @endif
@endsection