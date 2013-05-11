@extends('template')

@section('header')
    <h1 class="page-header">
        Permission
        <small>ID: {{ $user->id }} | Username: {{ $user->username }}</small>
    </h1>
@stop

@section('content')
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Route</th>
            <th>Grant</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>#</td>
            <td></td>
            <td>{{ pr($user->getPermissions()) }}</td>
        </tr>
    </tbody>
</table>
@stop

@section('script')
@stop
