<div id="addFahrer" title="Fahrer hinzufügen">
    <div>
        <br>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label">Name</label>

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-xs-8 pull-left">
                            <input id="name" type="name" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                        </div>
                        <div class="col-xs-4 pull-left">
                            <input id="btnGenerateName" type="button" class="form-control btn-success" value="Zufall" autofocus>
                        </div>
                    </div>
                    @if (isset($err_name))
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <small>{{ $err_name }}</small>
                            </div>
                        </div>
                    @endif
                    <div class="clear"></div>
                </div>
            </div>

            <div class="form-group{{ $errors->has('fahrrad') ? ' has-error' : '' }}">
                <label for="fahrrad" class="col-md-4 control-label">Fahrrad w&auml;hlen</label>

                <div class="col-md-6">
                    <select name="fahrrad" id="selFahrrad" class="form-control">
                        <option value="1">Fahrrad 1</option>
                        <option value="2">Fahrrad 2</option>
                        <option value="3">Fahrrad 3</option>
                    </select>
                </div>

                @if (isset($err_fahhrad))
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <strong>{{ $err_fahhrad }}</strong><br>
                        </div>
                    </div>
                @endif
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
                <label class="col-md-4 control-label">Betriebsmodus</label>
                <div class="col-md-6">
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsfeldRadio" value="option1" checked>
                            Konstante Leistung
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsfeldRadio" value="option2">
                            Konstante mechanische Kraft
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsfeldRadio" value="option3">
                            Streckenmodus
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group{{ $errors->has('groesse') ? ' has-error' : '' }}">
                <label for="groesse" class="col-md-4 control-label">Gr&ouml;&szlig;e <small>(optional)</small></label>

                <div class="col-md-6">
                    <input id="groesse" type="text" class="form-control" name="groesse" value="{{ old('groesse') }}" placeholder="1.80" autofocus>

                    @if ($errors->has('groesse'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('groesse') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('gewicht') ? ' has-error' : '' }}">
                <label for="gewicht" class="col-md-4 control-label">Gewicht <small>(optional)</small></label>

                <div class="col-md-6">
                    <input id="gewicht" type="text" class="form-control" name="gewicht" value="{{ old('gewicht') }}" placeholder="80" autofocus>

                    @if ($errors->has('gewicht'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('gewicht') }}</strong>
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