<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta name = "csrf-token" content = "{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <meta name="keywords" content="SISTEMA GEOREFERENCIADO REGIONAL - SAYHUITE, MAPA, LIMA, REGION LIMA, GOBIERNO REGIONAL DE LIMA, HUACHO, CAÑETE, HUAURA, OYON, HUAROCHIRI, CAJATAMBO, BARRANCA, HUARAL, CANTA, YAUYOS, SIGPROA, SAYHUITE, PROYECTOS , INVERSIONES REGION LIMA" />
    <meta http-equiv="Cache-Control" content="no-cache" />
    <link rel="icon" href="{{asset('ico.png')}}">
    <title>SIGPROA - PROYECTOS</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('bootstrap/css/bootstrap.min.css')}}" />
    <!-- jQuery 2.2.3 -->
    <script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
    <script type="text/javascript" src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
<body style="background: url('dist/img/log_back.jpg');background-size: cover;height:100%">
  <div class="login-box">
    @yield('content')
  </div>
</body>
</html>

<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-69088536-1', 'auto');
    ga('send', 'pageview');
</script>
