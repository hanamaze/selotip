@extends('template')

@section('content')

    @foreach($users as $user)

        <div class="">
            <div class="name">{{ HTML::link($user->username, $user->first_name.' '.$user->last_name) }}</div>
            <div class="skill">PHP JAVA METAL</div>
        </div>

    @endforeach

    {{ $users->links() }}

@stop

@section('script')
@stop
