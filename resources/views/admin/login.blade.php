@if ($errors->has('password'))
    <span class="help-block">
        <strong>{{ $errors->first('password') }}</strong>
    </span>
@endif

<form action="{{ url("admin/login") }}" method="post">
    <input type="password" name="password" placeholder="Admin-Passwort">
    <input type="submit" value="Login">
    {{ csrf_field() }}
</form>