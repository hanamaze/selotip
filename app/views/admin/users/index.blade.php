@extends('template')

@section('header')
    <h1>Manage Users</h1>
@stop

@section('content')

    <fieldset>

        <legend>Filters</legend>

        <div class="row">
            <ul class="span3">
                Groups
                <li>{{ HTML::linkRoute('admin_manage_user', 'Super Users', array(1)) }}</li>
                <li>{{ HTML::linkRoute('admin_manage_user', 'Administrator', array(2)) }}</li>
                <li>{{ HTML::linkRoute('admin_manage_user', 'Users', array(3)) }}</li>
                <li>{{ HTML::linkRoute('admin_manage_user', 'Companies', array(4)) }}</li>
                <li>{{ HTML::linkRoute('admin_manage_user', 'Venture Capital', array(5)) }}</li>
                <li>{{ HTML::link('', 'No Group', array(5)) }}</li>
            </ul>
            <ul class="span3">
                Active?
                <select name="is_active">
                    <option value="1">Active</option>
                    <option value="0">Nope</option>
                    <option value="">Both</option>
                </select>
            </ul>
        </div>
        <input type="submit" value="Filter" class="btn btn-primary" />
        <a href="{{ URL::route('admin_manage_user') }}" class="btn">Reset</a>

    </fieldset>

    @if ($users)
        <table class="table">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Last Login</th>
                    <th>Active?</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                    <td>
                        @if (strtotime($user->last_login) > 0)
                            {{ date('Y-m-d H:i:s', strtotime($user->last_login)) }}
                        @else
                            Never! :(
                        @endif
                    </td>
                    <td>{{ $user->activated ? 'Active' : 'Nope' }}</td>
                    <td>
                        <a href="{{ URL::route('permission', array($user->id)) }}">
                            Permission
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        No User
    @endif

    {{ $pagination->links() }}

@stop

@section('script')

@stop
