@extends("layouts.app")

@section("content")
    <div id="track-wrapper-mobile">
        <canvas id="track"></canvas>
    </div>

    @if ($errors->has('fahrrad'))
        <span class="help-block">
            <strong>{{ $errors->first('fahrrad') }}</strong>
        </span>
    @endif

    @include("mobile.fahrrad-information")

    <div id="logout-wrapper">
        <button class="btn btn-danger" id="btnLogout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</button>

        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
@endsection