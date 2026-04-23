@extends('plantilla.container')
@include('plantilla.topbar')
@section('content')
<div class="jumbotron jumbotron-sm">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <h1 class="h1">Acerca de...</h1>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="well well-sm">
            <form>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">
                                La Directiva General del Proceso de Planeamiento Estratégico
                            </label>
                            <p class="text-justify">La Directiva General de Planeamiento Estratégico se enmarca en una visión moderna del planeamiento y la gestión pública, constituyendo una pieza fundamental para el desarrollo económico y social del país. 
                                En ese sentido, los beneficios de la presente Directiva son los siguientes:</p>
                            <p class="text-justify">a)	Constituye un cuerpo normativo integrado y flexible que orientará a los funcionarios públicos en la forma de realizar el planeamiento estratégico.</p>
                            <p class="text-justify">b)	Moderniza el planeamiento estratégico, incorporando la prospectiva y la anticipación estratégica como elementos claves en el proceso de planeamiento.</p>
                            <p class="text-justify">c)	Presenta una metodología estandarizada de planeamiento estratégico para todo el Sector Público.</p>
                            <p class="text-justify">d)	Fomenta el fortalecimiento de las capacidades de los gestores públicos en planeamiento estratégico.</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <form>
            <legend><span class="glyphicon glyphicon-globe"></span> GERENCIA REGIONAL DE PLANEAMIENTO, PRESUPUESTO Y ACONDICIONAMIENTO TERRITORIAL</legend>
            <address>
                <strong>Av. Tupac Amaru 405 - Huacho</strong><br>
                N° de RUC: 20530688390<br>
                Telefono: 232-3197 / 232-5999<br>
            </address>
            <address>
                <strong>E-mail</strong><br>
                <a href="mailto:#">cesarmv0604@gmail.com</a>
            </address>
        </form>
    </div>
</div>

@stop