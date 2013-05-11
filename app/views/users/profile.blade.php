@extends('template')

@section('header')
    <h1 class="page-header">
        Profile {{ $user->username }}
    </h1>
@stop


@section('content')

{{ Form::model(null, array('class' => 'form-horizontal', 'method' => 'PUT')) }}
{{ Form::token() }}

<div class="control-group">
    {{ Form::label('name', 'Name', array('class' => 'control-label')) }}

    <div class="controls">
        {{ Form::text('first_name', $user->first_name, array('required', 'placeholder' => 'First name')) }}
        {{ Form::text('last_name', $user->last_name, array('', 'placeholder' => 'Last name')) }}
    </div>
</div>

<div class="control-group">
    {{ Form::label('email', 'Email', array('class' => 'control-label')) }}

    <div class="controls">
        {{ Form::text('email', $user->email, array('required', 'placeholder' => 'Email')) }}
    </div>
</div>

<div class="form-actions">
    {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}

    @if (Sentry::isSuperUser())
        {{ HTML::linkRoute('admin_manage_group', 'Back', null, array('class' => 'btn')) }}
    @else
        {{ HTML::linkRoute('home', 'Cancel', null, array('class' => 'btn')) }}
    @endif
</div>

{{ Form::close() }}

@stop

@section('script')

@stop
