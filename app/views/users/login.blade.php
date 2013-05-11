@extends('template')

@section('header')
    <h1 class="page-header">
        Login
    </h1>
@stop

@section('content')

{{ Form::model('User', array('route' => 'loginAuth', 'class' => 'form-horizontal')) }}
{{ Form::token() }}

<div class="control-group">
    {{ Form::label('username', 'Username/Email', array('class' => 'control-label')) }}
    <div class="controls">
    {{ Form::text('username') }}
    </div>
</div>

<div class="control-group">
    {{ Form::label('password', 'Password', array('class' => 'control-label')) }}
    <div class="controls">
        {{ Form::password('password') }}
    </div>
</div>

<div class="form-actions">
    {{ Form::submit('Login', array('class' => 'btn btn-primary')) }}
    {{ HTML::linkRoute('home', 'Back to Home', null, array('class' => 'btn')) }}
    {{ HTML::linkRoute('register', 'Kalau belum daftar klik disini kk', null, array('class' => 'btn')) }}
</div>

{{ Form::close() }}

@stop

@section('script')
<script>
    document.getElementById('username').focus();
</script>
@stop

