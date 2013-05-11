@extends('template')

@section('header')
    <h1>
        Groups

    </h1>
@stop

@section('content')
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>User Count</th>
            <th>Grant</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($groups as $group)
        <tr>
            <td>{{ @++$i }}</td>
            <td>
                <a href="{{ URL::route('admin_manage_group_edit', $group->id) }}">
                    {{ $group->name }}
                </a>
            </td>
            <td>
                {{ count($group->users) }}
            </td>
            <td>
                @foreach ($group->getPermissions() as $key => $value)

                    @if($key == 'superuser')
                        <span class="label label-inverse">* Allow All</span>
                    @else

                    <div class="">
                        {{
                            $value
                            ? '<span class="label label-info">&check;Allow</span>'
                            : '<span class="label">&times; Disallow</span>'
                        }} &rarr;
                        {{ $key }}
                    <div>

                    @endif
                @endforeach
            </td>
            <td>
                @if($key != 'superuser')
                    <a href="{{ URL::route('admin_manage_group_permission', $group->id) }}">Permission</a>
                    |
                    <a href="{{ URL::route('admin_manage_user', $group->id) }}">User List</a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop

@section('script')
@stop
