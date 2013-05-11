@extends('template')

@section('header')
    <h1 class="page-header">
        Edit Group {{ $group->name }}
    </h1>
@stop

@section('content')

{{ Form::model(null, array('class' => 'form-horizontal', 'method' => 'PUT')) }}

<div class="control-group">
    {{ Form::label('name', 'Name', array('class' => 'control-label')) }}

    <div class="controls">
        {{ Form::text('name', $group->name, array('required')) }}
    </div>
</div>

<div class="form-actions">
    {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
    {{ HTML::linkRoute('admin_manage_group', 'Back', null, array('class' => 'btn')) }}

    {{ Form::close() }}
</div>

@if (!$is_superuser)
    <div class="pull-right">
        {{ Form::open(array('route' => array('admin_delete_group', $group->id), 'method' => 'DELETE')) }}
        <button type="submit" class="btn btn-danger" onclick='return confirm("Sure?")'>
            Delete
        </button>
        {{ Form::close() }}
    </div>
@endif

@stop

@section('script')
@stop
