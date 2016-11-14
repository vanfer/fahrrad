@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-8 pull-left">
                                        <input id="name" type="name" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                    </div>
                                    <div class="col-md-4 pull-left">
                                        <input id="btnGenerateName" type="button" class="form-control btn-success" value="Zufall" autofocus>
                                    </div>
                                </div>
                                <div class="clear"></div>

                                @if (isset($err_name))
                                    <div class="panel panel-danger">
                                        <div class="panel-heading">
                                            <strong>{{ $err_name }}</strong><br>
                                        </div>
                                        <div class="panel-body">
                                            <small>{{ $err_msg }}</small>
                                        </div>
                                    </div>

                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Addresse <small>(optional)</small></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
