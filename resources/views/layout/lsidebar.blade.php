<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <!-- <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image"> -->
                <br>
                <br>
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->unapenom }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> En Linea</a>
            </div>
        </div>

        <ul class="sidebar-menu" style="max-height: 650px;padding: 0;margin: 0;overflow: scroll;overflow-x: hidden;">
            <!-- SAYHUITE =============================================== -->

            @if (Auth::user()->poi != 1 or Auth::user()->hasRole('admin') == true)

                <li class="{{ Request::is('inicio') ? 'active' : '' }} treeview">
                    <a href="{{ URL::to('/inicio') }}">
                        <i class="fa fa-dashboard"></i> <span>Inicio</span>
                    </a>
                </li>

                @if (Auth::user()->can('pi-export') ||
                        Auth::user()->can('pi-ejecucion-listar') ||
                        Auth::user()->can('pi-list') ||
                        Auth::user()->can('procompite-list') ||
                        Auth::user()->can('mantvias-list') ||
                        Auth::user()->can('mantcanales-list') ||
                        Auth::user()->can('aulaspre-list'))
                    <li class="header">Gestión de Proyectos</li>
                @endif

                @permission('pi-list')
                    <li class="{{ Request::is('piptotalpriori') ? 'active' : '' }} treeview">
                        <a href="{{ URL::to('piptotalpriori') }}">
                            <i class="fa fa-university"></i>
                            <span>Proyectos de Inversión</span>
                            <span class="pull-right-container"></span>
                        </a>
                    </li>
                @endpermission

                @permission('pi-export')
                    <li class="treeview {{ Request::is('exportar') ? 'active' : '' }}">
                        <a href="{{ URL::to('exportar') }}">
                            <i class="fa fa-edit"></i> <span>Exportar Datos</span>
                        </a>
                    </li>
                @endpermission

                {{-- Inicio Reportes Gerenciales --}}

                @permission('pir-mostrar')
                    <li class="header">Reportes Gerenciales</li>

                    <li class="<?php
                    if (Request::is('proyecto*')) {
                        echo 'active';
                    } ?> treeview">
                        <a href="#">
                            <i class="fa fa-university"></i>
                            <span>Proyectos</span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('pir-proyectoinversionagrupado')
                                <li class="{{ Request::is('proyecto/inicio') ? 'active' : '' }}"><a
                                        href="{{ URL::to('proyecto/inicio') }}"><i class="fa fa-pie-chart"
                                            aria-hidden="true"></i>Proyectos por Categoria</a></li>
                            @endpermission
                            @permission('pir-proyectoinversion')
                                <li class="{{ Request::is('proyecto/lista_proyecto') ? 'active' : '' }}"><a
                                        href="{{ URL::to('proyecto/lista_proyecto') }}"><i class="fa fa-list"
                                            aria-hidden="true"></i> Lista de Proyectos</a></li>
                            @endpermission
                        </ul>
                    </li>


                    {{-- @permission('pir-ejecucionfinanciera')
                    <li class="{{ (Request::is('actividad') ? 'active' : '')}} treeview">
                        <a href="{{URL::to('actividad')}}">
                            <i class="glyphicon glyphicon-user"></i><span>Ejecución Financiera</span>
                            <span class="pull-right-container">
                            </span>
                        </a>
                    </li>
                    @endpermission --}}

                    @permission('pir-pmi')
                        <li class="{{ Request::is('carterapmi') ? 'active' : '' }} treeview">
                            <a href="{{ URL::to('carterapmi') }}">
                                <i class="glyphicon glyphicon-user"></i><span>PMI-GRL</span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                        </li>
                    @endpermission

                    @permission('pir-formato12b')
                        <li class="<?php if (Request::is('formato12b*')) {
                            echo 'active';
                        } ?> treeview">
                            <a href="#">
                                <i class="fa fa-university"></i>
                                <span>FORMATO 12-B</span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{{ Request::is('formato12b') ? 'active' : '' }}"><a
                                        href="{{ URL::to('formato12b') }}"><i class="fa fa-pie-chart"
                                            aria-hidden="true"></i>Lista de Proyectos</a></li>

                                {{-- <li class="{{ (Request::is('formato12b/reporte') ? 'active' : '')}}"><a href="{{URL::to('formato12b/reporte')}}"><i class="fa fa-list" aria-hidden="true"></i>Reporte Formato 12-B</a></li> --}}

                            </ul>
                        </li>
                    @endpermission

                    @permission('pir-consultamigable')
                        <li class="{{ Request::is('consultamigable') ? 'active' : '' }} treeview">
                            <a href="{{ URL::to('consultamigable') }}">
                                <i class="glyphicon glyphicon-user"></i><span>Consulta Amigable</span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                        </li>
                    @endpermission

                    @permission('pir-contrataciones')
                        <li class="{{ Request::is('contratacionesps') ? 'active' : '' }} treeview">
                            <a href="{{ URL::to('contratacionesps') }}">
                                <i class="glyphicon glyphicon-user"></i><span>Contrataciones</span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                        </li>
                    @endpermission

                    @permission('pir-modificacion_presupuestal')
                        <li class="<?php
                        if (Request::is('modificacion_presupuestal/')) {
                            echo 'active';
                        } ?> treeview">
                            <a href="#">
                                <i class="glyphicon glyphicon-user"></i>
                                <span>Modificación Presupuestal</span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php
                                if (Request::is('modificacion_presupuestal/generar')) {
                                    echo 'active';
                                } ?> treeview">
                                    <a href="{{ URL::to('modificacion_presupuestal/generar') }}">
                                        <i class="fa fa-graduation-cap"></i>
                                        <span>Generar Modificación Presupuestal</span>
                                    </a>
                                </li>
                                <li class="<?php
                                if (Request::is('modificacion_presupuestal/lista')) {
                                    echo 'active';
                                } ?> treeview">
                                    <a href="{{ URL::to('modificacion_presupuestal/lista') }}">
                                        <i class="fa fa-graduation-cap"></i>
                                        <span>Lista Modificación Presupuestal</span>
                                    </a>
                                </li>
                                <li class="<?php
                                if (Request::is('modificacion_presupuestal/inicio')) {
                                    echo 'active';
                                } ?> treeview">
                                    <a href="{{ URL::to('modificacion_presupuestal/inicio') }}">
                                        <i class="fa fa-graduation-cap"></i>
                                        <span>Agregar Modificación Presupuestal</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endpermission

                    @permission('pir-noprevistas')
                        <li class="{{ Request::is('noprevistas/inicio') ? 'active' : '' }} treeview">
                            <a href="{{ URL::to('noprevistas/inicio') }}">
                                <i class="glyphicon glyphicon-user"></i><span>No Previstas</span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                        </li>
                    @endpermission

                    @permission('pir-indicadoresbrecha')
                        <li class="<?php
                        if (Request::is('indicadores/educacion') || Request::is('indicadores/salud') || Request::is('indicadores/pobresa') || Request::is('indicadores/salud/desnutricion') || Request::is('indicadores/salud/anemia') || Request::is('indicadores/salud/sis') || Request::is('indicadores/salud/hemoglobina') || Request::is('indicadores/salud/seguro') || Request::is('indicadores/vivienda')) {
                            echo 'active';
                        } ?> treeview hide">
                            <a href="#">
                                <i class="fa fa-pie-chart"></i>
                                <span>Indicadores de brechas</span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php
                                if (Request::is('indicadores/educacion')) {
                                    echo 'active';
                                } ?> treeview">
                                    <a href="#">
                                        <i class="fa fa-graduation-cap"></i>
                                        <span>Educación</span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li class="{{ Request::is('indicadores/educacion') ? 'active' : '' }}">
                                            <a href="{{ URL::to('indicadores/educacion') }}">
                                                <i class="fa fa-table"></i> <span>ECE</span>
                                                <span class="pull-right-container">
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="treeview-menu">
                                <li class="<?php
                                if (Request::is('indicadores/salud') || Request::is('indicadores/salud/desnutricion') || Request::is('indicadores/salud/anemia') || Request::is('indicadores/salud/sis') || Request::is('indicadores/salud/hemoglobina') || Request::is('indicadores/salud/seguro')) {
                                    echo 'active';
                                } ?> treeview">
                                    <a href="#">
                                        <i class="fa fa-plus-square"></i>
                                        <span>Salud</span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li class="{{ Request::is('indicadores/salud') ? 'active' : '' }}">
                                            <a href="{{ URL::to('indicadores/salud') }}">
                                                <i class="fa fa-table"></i> <span>Salud</span>
                                                <span class="pull-right-container">
                                                </span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::is('indicadores/salud/desnutricion') ? 'active' : '' }}">
                                            <a href="{{ URL::to('indicadores/salud/desnutricion') }}">
                                                <i class="fa fa-table"></i> <span>Desnutrición</span>
                                                <span class="pull-right-container">
                                                </span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::is('indicadores/salud/anemia') ? 'active' : '' }}">
                                            <a href="{{ URL::to('indicadores/salud/anemia') }}">
                                                <i class="fa fa-table"></i> <span>Anemia</span>
                                                <span class="pull-right-container">
                                                </span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::is('indicadores/salud/sis') ? 'active' : '' }}">
                                            <a href="{{ URL::to('indicadores/salud/sis') }}">
                                                <i class="fa fa-table"></i> <span>SIS</span>
                                                <span class="pull-right-container">
                                                </span>
                                            </a>
                                        </li>
                                        <!-- <li class="{{ Request::is('indicadores/salud/hemoglobina') ? 'active' : '' }}">
                                                <a href="{{ URL::to('indicadores/salud/hemoglobina') }}">
                                                <i class="fa fa-table"></i> <span>Hemoglobina</span>
                                                <span class="pull-right-container">
                                                </span>
                                                </a>
                                            </li> -->
                                        <li class="{{ Request::is('indicadores/salud/seguro') ? 'active' : '' }}">
                                            <a href="{{ URL::to('indicadores/salud/seguro') }}">
                                                <i class="fa fa-table"></i> <span>Seguro</span>
                                                <span class="pull-right-container">
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="treeview-menu">
                                <li class="<?php
                                if (Request::is('indicadores/pobreza')) {
                                    echo 'active';
                                } ?> treeview">
                                    <a href="#">
                                        <i class="fa fa-pie-chart"></i>
                                        <span>Pobreza</span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li class="{{ Request::is('indicadores/pobreza') ? 'active' : '' }}">
                                            <a href="{{ URL::to('indicadores/pobreza') }}">
                                                <i class="fa fa-table"></i> <span>Pobreza</span>
                                                <span class="pull-right-container">
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="treeview-menu">
                                <li class="<?php
                                if (Request::is('indicadores/vivienda')) {
                                    echo 'active';
                                } ?> treeview">
                                    <a href="#">
                                        <i class="fa fa-pie-chart"></i>
                                        <span>Vivienda</span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li class="{{ Request::is('indicadores/vivienda') ? 'active' : '' }}">
                                            <a href="{{ URL::to('indicadores/vivienda') }}">
                                                <i class="fa fa-table"></i> <span>Vivienda</span>
                                                <span class="pull-right-container">
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    @endpermission

                    @permission('pir-indicadoresbrecha-resumen')
                        <li class="{{ Request::is('indicadores/reporte_general') ? 'active' : '' }} treeview hide">
                            <a href="{{ URL::to('indicadores/reporte_general') }}">
                                <i class="glyphicon glyphicon-user"></i><span>Resumen de indicadores</span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                        </li>
                    @endpermission

                    @permission('pir-actaseguimiento')
                        <!-- <li class="{{ Request::is('acta/inicio') ? 'active' : '' }} treeview">
                                    <a href="{{ URL::to('acta/inicio') }}">
                                        <i class="glyphicon glyphicon-user"></i><span>Acta Seguimiento</span>
                                        <span class="pull-right-container">
                                        </span>
                                    </a>
                                </li> -->
                    @endpermission
                @endpermission

                {{-- Fin Reportes Gerenciales --}}

                @permission('gor-reportes')
                    <li class="header">Reportes GORE</li>
                    <li class="{{ Request::is('gore/goreejecutivo') ? 'active' : '' }} treeview">
                        <a href="{{ URL::to('gore/goreejecutivo') }}">
                            <i class="glyphicon glyphicon-user"></i><span>11° GORE EJECUTIVO</span>
                            <span class="pull-right-container">
                            </span>
                        </a>
                    </li>
                    <li class="<?php
                    if (Request::is('gore/goreejecutivoagenda')) {
                        echo 'active';
                    } ?> treeview">
                        <a href="#">
                            <i class="glyphicon glyphicon-user"></i>
                            <span>11° GORE EJECUTIVO AGENDA</span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ Request::is('gore/goreejecutivoagenda') ? 'active' : '' }}"><a
                                    href="{{ URL::to('gore/goreejecutivoagenda') }}"><i class="fa fa-exchange"
                                        aria-hidden="true"></i>TRANSFERENCIAS</a></li>
                        </ul>
                    </li>
                @endpermission

            @endif

            @permission('user-list')
                <li class="header">Administración</li>
                <li class="{{ Request::is('usuario*') ? 'active' : '' }} treeview">
                    <a href="{{ URL::to('usuario') }}">
                        <i class="glyphicon glyphicon-user"></i> <span>Usuarios</span>
                        <span class="pull-right-container"></span>
                    </a>
                </li>
            @endpermission

            @permission('role-list')
                <li class="{{ Request::is('roles*') ? 'active' : '' }} treeview">
                    <a href="{{ URL::to('roles') }}">
                        <i class="glyphicon glyphicon-king"></i> <span>Roles</span>
                        <span class="pull-right-container"></span>
                    </a>
                </li>
            @endpermission
            @permission('pir-siaf')
                <!-- SIAF -->
                <li class="header">SIAF</li>
                <li class="{{ Request::is('siaf*') ? 'active' : '' }} treeview">
                    <a href="{{ URL::to('siaf') }}">
                        <i class="glyphicon glyphicon-user"></i> <span>Devengados</span>
                        <span class="pull-right-container"></span>
                    </a>
                </li>
            @endpermission

            @if (Auth::user()->hasRole('admin'))
                <li class="header">Metas</li>
                <li class="{{ Request::is('metas/proyecto') ? 'active' : '' }} treeview">
                    <a href="{{ URL::to('metas/proyecto') }}">
                        <i class="fa fa-line-chart"></i> <span>Meta por Proyecto</span>
                        <span class="pull-right-container"></span>
                    </a>
                </li>
                <li class="{{ Request::is('metas/grl') ? 'active' : '' }} treeview">
                    <a href="{{ URL::to('metas/grl') }}">
                        <i class="fa fa-building"></i> <span>Meta por UEI</span>
                        <span class="pull-right-container"></span>
                    </a>
                </li>
            @endif

            <li>
                <a href="{{ URL::to('/logout') }}">
                    <i class="glyphicon glyphicon-log-out"></i> <span>Cerrar Sesión</span>
                    <span class="pull-right-container"></span>
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
