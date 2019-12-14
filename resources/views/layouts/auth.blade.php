<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.auth.head')
</head>

<body class="page-header-fixed">
    <section id="login-container">
        <div class="login-wrapper">
            @yield('content')
        </div>
    </section>
    @include('partials.javascripts')
</body>
</html>