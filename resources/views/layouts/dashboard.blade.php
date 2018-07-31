<!DOCTYPE html>
<html lang="{{app()->getLocale()}}" data-controller="layouts--html-load">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - ORCHID</title>
    <meta name="csrf_token" content="{{csrf_token()}}">
    <meta name="auth" content="{{Auth::check()}}">
    <link rel="stylesheet" type="text/css" href="{{mix('/css/orchid.css','orchid')}}">

    <link rel="apple-touch-icon" sizes="180x180" href="/orchid/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/orchid/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/orchid/favicon/favicon-16x16.png">
    <link rel="manifest" href="/orchid/favicon/manifest.json">
    <link rel="mask-icon" href="/orchid/favicon/safari-pinned-tab.svg" color="#1a2021">
    <meta name="apple-mobile-web-app-title" content="ORCHID">
    <meta name="application-name" content="ORCHID">
    <meta name="theme-color" content="#ffffff">

    <meta name="turbolinks-root" content="{{Dashboard::prefix()}}">
    <meta name="dashboard-prefix" content="{{Dashboard::prefix()}}">

    <meta http-equiv="X-DNS-Prefetch-Control" content="on"/>
    <link rel="dns-prefetch" href="{{ config('app.url') }}"/>
    <link rel="dns-prefetch" href="https://fonts.googleapis.com"/>

    <script src="{{ mix('/js/manifest.js','orchid')}}" type="text/javascript"></script>
    <script src="{{ mix('/js/vendor.js','orchid')}}" type="text/javascript"></script>
    <script src="{{ mix('/js/orchid.js','orchid')}}" type="text/javascript"></script>

    @foreach(Dashboard::getResource('stylesheets') as $stylesheet)
        <link rel="stylesheet" href="{{$stylesheet}}">
    @endforeach

    @stack('stylesheets')
    
    @foreach(Dashboard::getResource('scripts') as $scripts)
        <script src="{{$scripts}}" type="text/javascript"></script>
    @endforeach

</head>

<body>
    <div id="app" class="app" data-controller="@yield('controller')">

        <!-- header  -->
        <header id="header" class="app-header navbar" role="menu">
            <!-- navbar header  -->
            <div class="navbar-header bg-black dk v-center">

                <button class="pull-left click" data-toggle="open" title="Menu" data-target="#aside">
                    <i class="icon-menu"></i>
                </button>

                <!-- brand  -->
                <a href="{{route('platform.index')}}" class="navbar-brand text-lt center">
                    <i class="{{config('platform.logo')}}"></i>
                </a>
                <!-- /brand  -->

                <button class="pull-right"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="icon-logout"></i>
                </button>

            </div>
            <!-- /navbar header  -->

            <!-- navbar collapse  -->
            <div class="app-header wrapper navbar-collapse box-shadow bg-white-only v-center">

                <div class="col-xs-12 col-md-4">
                    <h1 class="m-n font-thin h3 text-black">@yield('title')</h1>
                    <small class="text-muted text-ellipsis">@yield('description')</small>
                </div>

                <div class="col-xs-12 col-md-8">
                    @yield('navbar')
                </div>


            </div>
            <!-- / navbar collapse  -->
        </header>
        <!-- / header  -->


        <!-- aside  -->
        <aside id="aside" class="app-aside d-none d-md-block" data-controller="layouts--left-menu">
            <div class="aside-wrap-main">

                <div class="navi-wrap">

                    <!-- nav  -->
                    <nav class="navi clearfix">
                        <ul class="nav flex-column" role="tablist">

                            {{--
                            <li class="nav-item">
                                <a href="#" class="nav-link click" data-toggle="open" title="Menu" data-target="#aside">
                                    <i class="icon-menu" aria-hidden="true"></i>
                                </a>
                            </li>
                            --}}

                            <li class="nav-item">
                                <a href="{{route('platform.index')}}" class="navbar-brand nav-link text-lt w-full">

                                    <i class="icon-orchid text-primary" style="font-size: 2rem"></i>
                                </a>
                            </li>

                            {!! Dashboard::menu()->render('Main') !!}

                        </ul>

                        <ul class="nav nav-footer-fix">
                            @if(Auth::user()->hasAccess('platform.systems.index'))
                                <li>
                                    <a href="{{ route('platform.systems.index') }}">
                                        <i class="icon-settings" aria-hidden="true"></i>
                                        <span>{{trans('platform::menu.systems')}}</span>
                                    </a>
                                </li>
                            @endif

                            <li>
                                <a href="{{ route('platform.logout') }}"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                   dusk="logout-button">
                                    <i class="icon-logout" aria-hidden="true"></i>
                                    <span>{{trans('platform::auth/account.sign_out')}}</span>
                                </a>

                                <form id="logout-form" class="hidden" action="{{ route('platform.logout') }}"
                                      method="POST">
                                    @csrf
                                </form>
                            </li>
                        </ul>

                    </nav>
                    <!-- nav  -->
                </div>


            </div>

            <div class="aside-wrap">
                <div class="navi-wrap">

                    <!-- nav  -->
                    <nav class="navi clearfix">

                        <div class="nav tab-content flex-column" id="aside-wrap-list">

                            <div class="w-full tab-pane fade in nav show"
                                 role="tabpanel"
                                 id="menu-default"
                                 aria-labelledby="notise-tab">
                                @yield('aside', View::make('platform::partials.notifications'))
                            </div>

                            {!! Dashboard::menu()->render('Main','platform::partials.leftSubMenu') !!}
                        </div>
                    </nav>
                    <!-- nav  -->


                </div>
            </div>


        </aside>
        <!-- / aside  -->


        <!-- content  -->
        <div id="content" class="app-content" role="main">
            <div class="app-content-body" id="app-content-body">

                <nav aria-label="breadcrumb" class="m-b-n">
                    <ol class="breadcrumb padder-lg">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Library</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data</li>
                    </ol>
                </nav>


                @include('platform::partials.alert')

                @if (count($errors) > 0)
                    <div class="alert alert-danger m-b-none" role="alert">
                        <strong>Oh snap!</strong>
                        Change a few things up and try submitting again.
                        <ul class="m-t-xs">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                @yield('content')
            </div>
        </div>
        <!-- /content  -->

    </div>

@stack('scripts')

</body>
</html>
