@inject('request', 'Illuminate\Http\Request')
        <!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
@include('partials.header')

<!-- Content Wrapper. Contains page content -->
    <div class="app-main">
        @include('partials.sidebar')
        <div class="app-main__outer">
            <div class="app-main__inner">
                @if(isset($siteTitle))
                    <h3 class="app-page-title">
                        {{ $siteTitle }}
                    </h3>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        @if (Session::has('message'))
                            <div class="alert alert-info">
                                <p>{{ Session::get('message') }}</p>
                            </div>
                        @endif
                        @if ($errors->count() > 0)
                            <div class="alert alert-danger">
                                <ul class="list-unstyled">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @yield('content')

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{!! Form::open(['route' => 'auth.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit">Logout</button>
{!! Form::close() !!}


@yield('modal')

@include('partials.javascripts')
</body>
</html>