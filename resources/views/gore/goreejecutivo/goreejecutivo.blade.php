@extends('starter')
@section('htmlhead')
<style type="text/css">
    /* Absolute Center Spinner */
      .loading {
        position: fixed;
        z-index: 999;
        height: 2em;
        width: 2em;
        overflow: show;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
      }

      /* Transparent Overlay */
      .loading:before {

        display: block;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.3);
      }

      /* :not(:required) hides these rules from IE9 and below */
      .loading:not(:required) {
        /* hide "loading..." text */
        font: 0/0 a;
        color: transparent;
        text-shadow: none;
        background-color: transparent;
        border: 0;
      }

      .loading:not(:required):after {
        content: '';
        display: block;
        font-size: 10px;
        width: 1em;
        height: 1em;
        margin-top: -0.5em;
        -webkit-animation: spinner 1500ms infinite linear;
        -moz-animation: spinner 1500ms infinite linear;
        -ms-animation: spinner 1500ms infinite linear;
        -o-animation: spinner 1500ms infinite linear;
        animation: spinner 1500ms infinite linear;
        border-radius: 0.5em;
        -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
        box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
      }

    /* Animation */
      @-webkit-keyframes spinner {
        0% {
          -webkit-transform: rotate(0deg);
          -moz-transform: rotate(0deg);
          -ms-transform: rotate(0deg);
          -o-transform: rotate(0deg);
          transform: rotate(0deg);
        }
        100% {
          -webkit-transform: rotate(360deg);
          -moz-transform: rotate(360deg);
          -ms-transform: rotate(360deg);
          -o-transform: rotate(360deg);
          transform: rotate(360deg);
        }
      }
      @-moz-keyframes spinner {
        0% {
          -webkit-transform: rotate(0deg);
          -moz-transform: rotate(0deg);
          -ms-transform: rotate(0deg);
          -o-transform: rotate(0deg);
          transform: rotate(0deg);
        }
        100% {
          -webkit-transform: rotate(360deg);
          -moz-transform: rotate(360deg);
          -ms-transform: rotate(360deg);
          -o-transform: rotate(360deg);
          transform: rotate(360deg);
        }
      }
      @-o-keyframes spinner {
        0% {
          -webkit-transform: rotate(0deg);
          -moz-transform: rotate(0deg);
          -ms-transform: rotate(0deg);
          -o-transform: rotate(0deg);
          transform: rotate(0deg);
        }
        100% {
          -webkit-transform: rotate(360deg);
          -moz-transform: rotate(360deg);
          -ms-transform: rotate(360deg);
          -o-transform: rotate(360deg);
          transform: rotate(360deg);
        }
      }
      @keyframes spinner {
        0% {
          -webkit-transform: rotate(0deg);
          -moz-transform: rotate(0deg);
          -ms-transform: rotate(0deg);
          -o-transform: rotate(0deg);
          transform: rotate(0deg);
        }
        100% {
          -webkit-transform: rotate(360deg);
          -moz-transform: rotate(360deg);
          -ms-transform: rotate(360deg);
          -o-transform: rotate(360deg);
          transform: rotate(360deg);
        }
      }

      .scrollbar
      {
      	float: left;
      	height: 300px;
      	background: #F5F5F5;
      	overflow-y: scroll;
      	margin-bottom: 25px;
      }

      .force-overflow
      {
      	min-height: 450px;
      }


      /*
       *  STYLE 3
       */

      #style-3::-webkit-scrollbar-track
      {
      	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
      	background-color: #F5F5F5;
      }

      #style-3::-webkit-scrollbar
      {
      	width: 6px;
      	background-color: #F5F5F5;
      }

      #style-3::-webkit-scrollbar-thumb
      {
      	background-color: #000000;
      }


        .nav-side-menu {
          overflow: auto;
          font-family: verdana;
          font-size: 12px;
          font-weight: 200;
          background-color: #2e353d;
          position: fixed;
          top: 0px;
          width: 300px;
          height: 100%;
          color: #e1ffff;
        }
        .nav-side-menu .brand {
          background-color: #23282e;
          line-height: 50px;
          display: block;
          text-align: center;
          font-size: 14px;
        }
        .nav-side-menu .toggle-btn {
          display: none;
        }
        .nav-side-menu ul,
        .nav-side-menu li {
          list-style: none;
          padding: 0px;
          margin: 0px;
          line-height: 35px;
          cursor: pointer;
          /*
            .collapsed{
               .arrow:before{
                         font-family: FontAwesome;
                         content: "\f053";
                         display: inline-block;
                         padding-left:10px;
                         padding-right: 10px;
                         vertical-align: middle;
                         float:right;
                    }
             }
        */
        }
        .nav-side-menu ul :not(collapsed) .arrow:before,
        .nav-side-menu li :not(collapsed) .arrow:before {
          font-family: FontAwesome;
          content: "\f078";
          display: inline-block;
          padding-left: 10px;
          padding-right: 10px;
          vertical-align: middle;
          float: right;
        }
        .nav-side-menu ul .active,
        .nav-side-menu li .active {
          border-left: 3px solid #d19b3d;
          background-color: #4f5b69;
        }
        .nav-side-menu ul .sub-menu li.active,
        .nav-side-menu li .sub-menu li.active {
          color: #d19b3d;
        }
        .nav-side-menu ul .sub-menu li.active a,
        .nav-side-menu li .sub-menu li.active a {
          color: #d19b3d;
        }
        .nav-side-menu ul .sub-menu li,
        .nav-side-menu li .sub-menu li {
          background-color: #181c20;
          border: none;
          line-height: 28px;
          border-bottom: 1px solid #23282e;
          margin-left: 0px;
        }
        .nav-side-menu ul .sub-menu li:hover,
        .nav-side-menu li .sub-menu li:hover {
          background-color: #020203;
        }
        .nav-side-menu ul .sub-menu li:before,
        .nav-side-menu li .sub-menu li:before {
          font-family: FontAwesome;
          content: "\f105";
          display: inline-block;
          padding-left: 10px;
          padding-right: 10px;
          vertical-align: middle;
        }
        .nav-side-menu li {
          padding-left: 0px;
          border-left: 3px solid #2e353d;
          border-bottom: 1px solid #23282e;
        }
        .nav-side-menu li a {
          text-decoration: none;
          color: #e1ffff;
        }
        .nav-side-menu li a i {
          padding-left: 10px;
          width: 20px;
          padding-right: 20px;
        }
        .nav-side-menu li:hover {
          border-left: 3px solid #d19b3d;
          background-color: #4f5b69;
          -webkit-transition: all 1s ease;
          -moz-transition: all 1s ease;
          -o-transition: all 1s ease;
          -ms-transition: all 1s ease;
          transition: all 1s ease;
        }
        @media (max-width: 767px) {
          .nav-side-menu {
            position: relative;
            width: 100%;
            margin-bottom: 10px;
          }
          .nav-side-menu .toggle-btn {
            display: block;
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 10px;
            z-index: 10 !important;
            padding: 3px;
            background-color: #ffffff;
            color: #000;
            width: 40px;
            text-align: center;
          }
          .brand {
            text-align: left !important;
            font-size: 22px;
            padding-left: 20px;
            line-height: 50px !important;
          }
        }
        @media (min-width: 767px) {
          .nav-side-menu .menu-list .menu-content {
            display: block;
          }
        }
</style>
@endsection
@section('body')
<div class="well">
    <div class="text-center">
      <span style="font-weight: bold;font-size: 22px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;text-transform: uppercase;">11° GORE EJECUTIVO LIMA
      </span>
    </div>
</div>

<div class="row">
  <div class="col-md-3"></div>
  <div class="col-md-6">
    <div class="form-group">
        <select class="form-control" name="hoja" onchange="loadModal()" id="hoja">
          <option value="">SELECCIONAR</option>
          <option value="1">ANEMIA INFANTIL Y SUS PRINCIPALES INDICADORES</option>
          <option value="2">PRESUPUESTO ASIGNADO: META 04 - PLAN DE INCENTIVOS MUNICIPALES</option>
          <option value="3">DISPONIBILIDAD DE RECURSOS HUMANO - CAÑETE</option>
          <option value="4">DISPONIBILIDAD DE RECURSOS HUMANO - HUAROCHIRI</option>
          <option value="5">DISPONIBILIDAD DE RECURSOS HUMANO - OYON</option>
          <option value="6">DISPONIBILIDAD DE RECURSOS HUMANO - YAUYOS</option>
          <option value="7">BRECHA DE RECURSOS HUMANOS EN LIMA POR UNIDAD EJECUTORA - LIMA REGION</option>
          <option value="8">BRECHA DE MEDICOS ESPECIALISTAS EN LIMA POR UNIDAD EJECUTORA - LIMA REGION</option>
          <option value="9">SEGURO INTEGRAL DE SALUD - LIMA PROVINCIAS</option>
          <option value="10">SEGURO INTEGRAL DE SALUD - UNIDAD EJECUTORA</option>
          <option value="11">SEGURO INTEGRAL DE SALUD - UNIDAD FINAL</option>
        </select>
    </div>
  </div>
  <div class="col-md-3"></div>
</div>


<div id="cargando" class="loading" style="display: none;"></div>
<div id="contenido">

</div>

<script type="text/javascript">
  $(function(){
    loadModal = function() {
            $.ajax({
                url: '{{ asset("gore/goreejecutivocargar") }}',
                type: 'POST',
                data:{hoja :$("#hoja :selected").val()},
                beforeSend: function () {
                    $("#cargando").show();
                },
                success: function (response) {
                    $('#contenido').html($(response).filter('#container'));
                },
                complete: function(response) {
                  $("#cargando").hide();
                },
            });
      }
  });
</script>
@endsection
