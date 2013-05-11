<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        JogjaHub.com - {{ $title }}
    </title>

    {{ HTML::style('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.no-icons.min.css') }}
    {{ HTML::style('//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css') }}

    {{ HTML::style('css/style.min.css') }}

    <style>
    [role="main"] {
        padding-top: 40px;
    }
    </style>
</head>
<body>

    <nav>
        <div class="navbar navbar-static-top navbar-inverse">
            <div class="navbar-inner">
                <div class="container">
                    <div class="row">
                        <div class="span12">
                        <a href="{{ URL::route('home') }}" class="brand">
                            <i class="icon-home"></i> JogjaHub
                        </a>
                        <ul class="nav">
                            <li>{{ HTML::linkRoute('developer_list', 'Developers') }}</li>
                            <li>{{ HTML::linkRoute('company_list', 'Company') }}</li>
                            <li>{{ HTML::linkRoute('venture_list', 'Ventures') }}</li>
                        </ul>

                            @if (Sentry::check())

                                <ul class="nav">

                                @if (Sentry::getUser()->isSuperUser())
                                    <li class="dropdown">
                                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                            Manage <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu" >
                                            <li>{{ HTML::linkRoute('admin_manage_user', 'Users', array(3)) }}</li>
                                            <li>{{ HTML::linkRoute('admin_manage_group', 'Group') }}</li>
                                        </ul>
                                    </li>
                                    <li class="dropdown">
                                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                            Settings <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu" >
                                            <li>{{ HTML::link('admin/site', 'General') }}</li>
                                            <li>{{ HTML::link('admin/seo', 'SEO') }}</li>
                                        </ul>
                                    </li>
                                @endif
                                </ul>

                                <ul class="nav pull-right">
                                    <li class="dropdown">
                                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                            {{ HTML::image('http://www.gravatar.com/avatar/'.md5(Sentry::getUser()->email).'?s=24') }}
                                            {{ Sentry::getUser()->username }} <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu" >
                                            <li><a href="{{ URL::route('profile') }}">Profile</a></li>
                                            <li><a href="{{ URL::route('settings') }}">Settings</a></li>
                                            <li><a href="{{ URL::route('settings') }}">Change Password</a></li>
                                            <li class="divider"></li>
                                            <li><a href="{{ URL::route('logout') }}">Logout</a></li>
                                        </ul>
                                    </li>
                                </ul>

                            @else
                                <ul class="nav pull-right">
                                    <li>{{ HTML::linkRoute('register', 'Register') }}</li>
                                    <li>{{ HTML::linkRoute('login', 'Login') }}</li>
                                </ul>
                            @endif
                        </ul>
                        </div><!--/ .span12 -->
                    </div><!--/ .row -->
                </div><!--/ .container -->
            </div><!--/ .navbar-inner -->
        </div><!--/ .navbar -->
    </nav>

    <div class="container" role="main">

        <header>

            <form class="form-inline" style="text-align:center">
                <div class="input-append">
                    <input type="text" class="span6" placeholder="Search anything" />
                    <button type="submit" class="btn">
                        <i class="icon-search"></i> Search
                    </button>
                    <button type="button" class="btn">
                        <b class="caret"></b>
                    </button>
                </div>
            </form>

            @yield('header')

        </header>

        <div class="">
            @yield('errors')

            @if (Session::has('errors'))
                <div class="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Warning!</strong>
                    {{-- Session::get('errors') --}}
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (Session::has('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Success!</strong>
                    {{ Session::get('success') }}
                </div>
            @endif
        </div>

        <div>
            @yield('content')
        </div>

    </div>

    <footer>
        <div class="container">
            <div style="text-align: right">Copyright 2011 - 2013 JogjaHub</div>
        </div>
    </footer>


    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js') }}
    {{ HTML::script('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js') }}

    @yield('script')
</body>
</html>
