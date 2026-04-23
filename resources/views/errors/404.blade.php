<!DOCTYPE html>
<html>
    <head>
        <title>Forbidden.</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: black;
                display: table;
                font-weight: 100;

            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 10px;
                font-family: 'Lato', sans-serif;
            }
            .subtitle{
              font-family: 'Lato', sans-serif;
              font-size: 32px;
              font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Acceso Denegado.</div><br>
                <div class="subtitle">No cuenta con los permisos suficientes</div>
                <div> <img src="{{ asset('dist\img\403.png') }}" width="200px" height="200px"> </div>

                <a href="#" onclick="goBack()" style="text-decoration: none;font-size: 32px"><b>Volver</b></a>
            </div>
        </div>
    </body>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</html>
