<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <style>
            .rowHeader{
                text-align: center;
                font-weight: bold;
            }
            .rowHeader .xs{
                border: 3 solid #000;
                width: 13;
                height: 30;
                word-wrap:break-word;
                vertical-align: middle;
                white-space: nowrap;
                text-align: justify;
            }
            .rowHeader .sm{
                border: 3 solid #000;
                width: 20;
                height: 30;
                word-wrap:break-word;
                vertical-align: middle;
                text-align:justify;
            }
            .rowHeader .md{
                border: 3 solid #000;
                width: 30;
                height: 30;
                word-wrap:break-word;
                vertical-align: middle;
                text-align:justify;
            }
            .rowHeader .lg{
                border: 3 solid #000;
                width: 80;
                height: 30;
                word-wrap:break-word;
                vertical-align: middle;
                text-align:justify;
            }

            .rowContent td{
                border: 3 solid #000;
                vertical-align: middle;
            }

            .rowContent .left{
                text-align: left;
            }
            .rowContent .right{
                text-align: right;
            }
            .rowContent .center{
                text-align: center;
            }

            .rowContent .justify{
                text-align: justify;
            }

        </style>
    </head>
    
        <tr>
            <td colspan="4">
                <img src="images/sys/logo1.gif" height="100%">
            </td>
            <td colspan="4">
                <img src="images/sys/sayhuite.png" height="100%">
            </td>
            <td colspan="4">
                <img src="images/sys/slogan2.gif" height="100%">
            </td>
        </tr>
        
        <tr class="rowHeader">
            <td class="xs">Identificador</td>
            <td class="lg">Nombre Proyecto</td>            
            <td class="md">Agente Economico Organizado</td>
            <td class="sm">C. Unificado</td>
            <td class="sm">Provincia</td>
            <td class="sm">Distrito</td>
            <td class="sm">Centro Poblado</td>
            <td class="sm">Co-Financiamiento GRL.</td>
            <td class="sm">Contrapartida</td>
            <td class="sm">Monto Plan Negocio</td>
            <td class="sm">Beneficiarios</td>
            <td class="sm">Fecha de Adjudicación</td>
            <td class="sm">Fecha Inicio</td>
            <td class="sm">Fecha Fin</td>
            <td class="sm">Tiempo ejecucion (días)</td>
            <td class="sm">% Avance Físico</td>
            <td class="sm">Cuenta con R.E.R</td>
            <td class="sm">Fecha de R.E.R</td>
            <td class="sm">Estado</td>
            <td class="sm">Descripción</td>
            <td class="sm">Fecha Estado</td>
            <td class="sm">Año</td>
            <td class="sm">Cuenta con Convenio (PDF)</td>
            <td class="sm">N° Convenio</td>
            <td class="sm">Cuenta con Fotos</td>
            <td class="sm">Fecha foto</td>
        </tr>

        @foreach($data as $row)
        <tr class="rowContent">
            <td class="center">
                {{ $row->id }}
            </td>
            <td class="justify">
                {{ $row->nom_proyec }}
            </td>
            <td class="justify">
                {{ $row->aeo }}
            </td>
            <td class="justify">
                {{ $row->cod_unif }}
            </td>
            <td class="right">
                {{ $row->nom_prov }}
            </td>
            <td class="right">
                {{ $row->nom_dist }}
            </td>
            <td class="right">
                {{ $row->nom_cp }}
            </td>
            <td class="right">
                {{ $row->m_pip }}
            </td>
            <td class="right">
                {{ $row->contrapartida }}
            </td>
            <td class="center">
                {{ $row->m_pip + $row->contrapartida }}
            </td>
            <td class="right">
                {{ $row->beneficiarios }}
            </td>
            <td class="right">
                {{ $row->f_adjudica }}
            </td>
            <td class="center">
                {{ $row->f_inicio_obra }}
            </td>
            <td class="center">
                {{ $row->f_fin_obra }}
            </td>
            <td class="center">
                {{ $row->t_ejec_dia }}
            </td>
            <td class="center">
                {{ $row->a_fisico }}
            </td>
            @if( $row->f_rer != '' )
            <td class="center" style="background-color:#3bcc44;">
                SI
            </td>
            @else
            <td class="center" style="background-color:#FFC7CE;">
                NO
            </td>
            @endif
            <td class="center">
                {{ $row->f_rer }}
            </td>
            
            <td class="center">
                {{ $row->est_proyec}}
            </td>
            <td class="center">
                {{ $row->situa_pro}}
            </td>
            <td class="center">
                {{ $row->fecha_situa}}
            </td>
            <td class="center">
                {{ $row->anio}}
            </td>
            @if( $row->nro_conv != '' )
            <td class="center" style="background-color:#3bcc44;">
                SI
            </td>
            @else
            <td class="center" style="background-color:#FFC7CE;">
                NO
            </td>
            @endif
            <td class="justify">
                {{ $row->nro_conv}}
            </td>
            @if( $row->ffoto != '' )
            <td class="center" style="background-color:#3bcc44;">
                SI
            </td>
            @else
            <td class="center" style="background-color:#FFC7CE;">
                NO
            </td>            
            @endif
            <td class="center">
                {{ $row->ffoto }}
            </td>


        </tr>
        @endforeach

</html>