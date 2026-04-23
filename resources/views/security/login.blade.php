@extends('plantilla.container')
@section('content')

<style>
  .say-logo{
    display: block;
    margin-left: auto;
    margin-right: auto;
    height: 110px;
  }

  .body {
    position:fixed;
    top: 30%;
    left: 50%;
    width:30em;
    height:30em;
    margin-top: -9em; /*set to a negative number 1/2 of your height*/
    margin-left: -15em; /*set to a negative number 1/2 of your width*/
  }
</style>

  <div class="login-logo">
    <div class="text-center">
      <!-- <img class="say-logo" src="dist/img/user2-160x160.jpg"> -->
      <h1 style="font-size: 40px;
        font-family: 'Arial Black', Gadget, sans-serif;
        letter-spacing: 0.6px;
        word-spacing: 0.2px;
        color: #B3452E;
        font-weight: 400;
        text-decoration: none solid rgb(68, 68, 68);
        font-style: normal;
        font-variant: normal;
        text-transform: none;
        text-shadow: 2px 2px 2px #CECECE;"
        >
        SPMI
      </h1>
      <h4 style="font-weight: bold;">Subgerencia de Programación Multianual de Inversiones</h4>
    </div>
  </div>
  <br>
  <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" style="background-color: rgba(255, 255, 255, 0.6)">
                <div class="panel-heading" style="background-color: rgba(255, 255, 255, 0.6)">
                    <h4 style="opacity: 1;font-size: 20px;text-align:center;">
                      <i class="glyphicon glyphicon-credit-card" aria-hidden="true">
                      </i> Inicio de Sesión
                    </h4>
                </div>
                <div class="panel-body">
                  <form class="form-horizontal" method="POST" action="{{  url('/login') }}">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user" aria-hidden="true"></i></span>
                        <label class="sr-only">Usuario</label>
                        <input type="text" name="username" class="form-control" placeholder="Usuario">
                    </div>
                    <br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-eye-close" aria-hidden="true"></i></span>
                        <label class="sr-only">Contraseña</label>
                        <input type="password" name="password" class="form-control" placeholder="Contraseña" require>
                    </div>
                    @if(Session::has('mensaje_error'))
                      <br>
                      <span id="mensaje" class="label label-danger center">{{Session::get('mensaje_error')}}</span>
                    @endif
                    <br>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="pull-right" style="color:black;font-size: 13px;font-weight: normal">
                              Mantener Sesión Activa
                              <input style="padding: 0;margin: 0;width: 20px" type="checkbox" name="rememberme"/>
                            </label>
                        </div>
                    </div>
                    <div class="form-group last">
                        <div class="row">
                          <div class="col-md-12" style="padding: 0 25px 0 25px;">
                            <button type="submit" class="btn btn-primary btn-block center" name="login">
                                <span class="glyphicon glyphicon-ok"></span> Iniciar
                            </button>
                          </div>
                        </div>
                    </div>
                  </form>
              </div>
                <div class="panel-footer" style="text-align: right">
                    <a href="{{URL::to('/email')}}">¿Olvidaste tu Contraseña?</a>
                </div>
            </div>
        </div>
@stop
