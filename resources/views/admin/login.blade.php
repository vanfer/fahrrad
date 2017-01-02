@extends("layouts.app")

@section('content')
    @if ($errors->has('password'))
        <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
    @endif
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default" id="panelAdmin">
            <div class="panel-heading" id="panelHeadingAdmin">
                <h3 class="panel-title" id="panelTitelAdmin">Anmeldung Administrationsbereich
                </h3>
                <span class="clearfix"></span>
            </div>
            <form class="panel-body form-inline" id="panelBodyAdmin" action="{{ url("admin/login") }}" method="post">
                <div class="form-group">
                    <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Admin-Passwort">
                    <input class="btn btn-default" type="submit" value="Login">
                    {{ csrf_field() }}
                </div>
            </form>
        </div>
    </div>
@endsection


