@extends('template')

@section('header')
    <h1 class="page-header">
        Register
    </h1>
@stop

@section('content')

{{ Form::model('User', array('class' => 'form-horizontal')) }}
{{ Form::token() }}

<div class="control-group">
    {{ Form::label('username', 'Username', array('class' => 'control-label')) }}
    <div class="controls">
        {{ Form::text('username', null, array('id' =>'username')) }}
    </div>
</div>


<div class="control-group">
    {{ Form::label('email', 'Email', array('class' => 'control-label')) }}
    <div class="controls">
        {{ Form::email('email') }}
    </div>
</div>

<div class="control-group">
    {{ Form::label('password', 'Password', array('class' => 'control-label')) }}
    <div class="controls">
        {{ Form::password('password') }}
    </div>
</div>

<div class="form-actions">
    {{ Form::submit('Register', array('class' => 'btn btn-primary')) }}
    {{ HTML::linkRoute('home', 'Back to Home', null, array('class' => 'btn')) }}
    {{ HTML::linkRoute('login', 'Kalau udah punya akun, klik disini kk', null, array('class' => 'btn')) }}
</div>

{{ Form::close() }}

@stop

@section('script')
<script>
    document.getElementById('username').focus();
</script>
@stop
