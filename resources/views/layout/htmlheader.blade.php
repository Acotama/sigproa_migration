<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-88030392-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-88030392-2');
    </script>
    <meta charset="utf-8">
    <meta name = "csrf-token" content = "{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="icon" href="{{asset('ico.png')}}">
    <title>SIGPROA</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}">
    <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"-->
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('dist/css/skins/skin-blue.min.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery 2.2.3 -->
    <script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>

    <!-- SELECT2 -->
    <link rel="stylesheet" href="{{asset('plugins/select2/select2.min.css')}}"/>
    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert2.min.css') }}">

    <!-- BootStrap Modal Addon -->
    <link href="{{ asset('plugins/bootstrap-addon/css/bootstrap-modal-bs3patch.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('plugins/bootstrap-addon/css/bootstrap-modal.min.css')}}" rel="stylesheet" />
    <!-- FancyBox -->
    <link rel="stylesheet" href="{{asset('plugins/fancybox/source/jquery.fancybox.min.css')}}" type="text/css" media="screen" />
    <!-- jqGRID >
    <link rel="stylesheet" href="{{asset('plugins/jqgrid/css/ui.jqgrid.css')}}"/>
    <link rel="stylesheet" href="{{asset('plugins/jqgrid/plugins/css/ui.multiselect.min.css')}}"/-->
    <!-- Intro JS -->
    <link rel="stylesheet" href="{{asset('plugins/introjs/introjs.min.css')}}"/>

    <!-- Pickadate -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/plugins/pickadate/compressed/themes/default.date.css') }}">

    <!-- CHART JS >
    <script type="text/javascript" language="javascript" src="{{asset('plugins/chartjs/chart.min.js')}}"></script-->
    <!--  -->
    <script>
         $.ajaxSetup({
             headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
          });
    </script>

    <style>
        /*#map{
            display: none;
        }*/
        .swal2-container{
            z-index: 2000;
        }

        #dvLoading
        {
           background:#000 url(http://media.riffsy.com/images/a6a6686cbddb3e99a5f0b60a829effb3/tenor.gif) no-repeat center center;
           height: 100px;
           width: 100px;
           position: fixed;
           z-index: 1000;
           left: 50%;
           top: 50%;
           margin: -25px 0 0 -25px;
        }

        /* for custom scrollbar for webkit browser*/

      ::-webkit-scrollbar {
          width: 6px;
      }
      ::-webkit-scrollbar-track {
          -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
      }
      ::-webkit-scrollbar-thumb {
          -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
      }



        /*.tour-backdrop,
        .tour-step-background {
            position: fixed;
        }*/
    </style>

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">



    @yield('htmlhead')
</head>
