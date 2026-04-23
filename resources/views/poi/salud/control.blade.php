@extends('starter')
@section('htmlhead')
<style>

    .dt-center {
        text-align: center;
    }

    /*REWRITING TEXTBOX STYLES */
    /* TEXTBOX */    
  

    #poisalud-table tr{
        border-top: 1px solid black !important;
        border-bottom: : 1px solid black !important;
    }

    select {
      width: 200px;
      max-width: 100%; /* So it doesn't overflow from it's parent */
    }

    textarea {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;

        width: 100%;
    }

    option {
      /* wrap text in compatible browsers */
      -moz-white-space:pre-wrap; 
      -o-white-space:pre-wrap; 
      white-space:pre-wrap; 

      /* hide text that can't wrap with an ellipsis */
      overflow: hidden;
      text-overflow:ellipsis;

      /* add border after every option */
      border-bottom: 1px solid #DDD;
    }
    /*.ui-jqgrid .loading
    {
        left: 45%;
        top: 45%;
        background: url(ajax-loader.gif);
        background-position-x: 50%;
        background-position-y: 50%;
        background-repeat: no-repeat;
        height: 20px;
        width: 20px;
    }*/

    table { 
        border-collapse: collapse !important; 
    }    

    .input-group-addon{
        background-color: rgb(51, 122, 183) !important;
        color:white !important;
        border: 0px !important;        
        border-radius: 4px 0px 0px 4px !important;
    }
    .form-control{
        background-color: rgba(51, 122, 183, 0.32)!important;
        border:0px;        
        border-radius: 0px 4px 4px 0px !important;
    }
    .form-control[disabled], .form-control[readonly], fieldset[disabled]{
        background-color: rgba(51, 122, 183, 0.32)!important;
        font-size: 12px;
        border-radius: 0px 4px 4px 0px !important;        
    }

    .loader {
        border: 16px solid #f3f3f3; /* Light grey */
        border-top: 16px solid #3498db; /* Blue */
        border-radius: 50%;    
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;    
        position: fixed;
        z-index: 99999;
        top: 25%;
        left: 45%;
    }

    .select2-container .select2-selection--single{
        height: 34px !important;
    }

    .select2-container--default .select2-selection--single, .select2-selection .select2-selection--single{
        padding: 14px 12px !important;
    }

    @-webkit-keyframes spin {
              0% { -webkit-transform: rotate(0deg); }
              100% { -webkit-transform: rotate(360deg); }
            }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    #containerDt{
        position: relative !important;
    }

    /* Mi estilo */

    /* Style the buttons that are used to open and close the accordion panel */
    button.accordion {
        background-color: #eee;
        color: #444;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        text-align: left;
        border: none;
        outline: none;
        transition: 0.4s;
    }

    /* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
    button.accordion.active, button.accordion:hover {
        background-color: #ccc;
    }

    /* Style the accordion panel. Note: hidden by default */
    div.panel {
        padding: 0 18px;
        background-color: white;
        display: none;
    }

    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    th, td {
    padding: 15px;
    }


    .cell{
        border-style: solid;
        border-width: 2px;
        height: 50px;
        width: 50px;
        border-color: black;
    }

</style>

@endsection
@section('body')
<div class="table-responsive">
   <table>
        <thead>
            <tr>
                <th style='background-color:#3c8dbc;color:white;'>Intervención</th>     
                <?php
                    for($i=1;$i<60;$i++){                        
                        if($Paciente->edad_meses == $i){                            
                            echo "<th style='background-color:#00a65a;color:white;'>MES ".$i."<br> <label class='label label-warning' style='font-size:12px'>Mes Actual</label></th>";
                        } else {
                            echo "<th style='background-color:#3c8dbc;color:white;'>MES ".$i."</th>";
                        }
                    }
                ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>CONTROL DE CRECIMIENTO</td>
            <?php                
                for($i=1;$i<60;$i++){
                    $flag = false;
                    $html = "<td>";
                    foreach($crecimiento as $cred){
                        if($cred->mes == $i){
                            $html .= "<label class='label label-default'>Planificado ".$cred->denom."</label>";
                            $flag = true;
                        }
                    }
                    
                    foreach($atcrecimiento as $atcred){
                        if($atcred->edad_meses == $i){
                            switch ($atcred->estado) {
                                case 'realizado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-success'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;
                                case 'no realizado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-danger'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;
                                case 'aplazado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-warning'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;                                
                            }                            
                            $flag = true;
                        }
                    }
                    if($flag == false){
                        $html .= "";
                    }

                    $html .=  "</td>";

                    echo $html;
                }
            ?>
            </tr>
             <tr>
                <td>SUPLEMENTACION CON HIERRO EN GOTAS</td>
            <?php                
                for($i=1;$i<60;$i++){
                    $flag = false;
                    $html = "<td>";
                    foreach($hierrogotas as $cred){
                        if($cred->mes == $i){
                            $html .= "<label class='label label-default'>Planificado ".$cred->denom."</label>";
                            $flag = true;
                        }
                    }
                    
                    foreach($athierrogotas as $atcred){
                        if($atcred->edad_meses == $i){
                            switch ($atcred->estado) {
                                case 'realizado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-success'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;
                                case 'no realizado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-danger'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;
                                case 'aplazado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-warning'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;                                
                            }                            
                            $flag = true;
                        }
                    }
                    if($flag == false){
                        $html .= "";
                    }

                    $html .=  "</td>";

                    echo $html;
                }
            ?>
            </tr>
             <tr>
                <td>SUPLEMENTACION MULTIMICRONUTRIENTES</td>
            <?php                
                for($i=1;$i<60;$i++){
                    $flag = false;
                    $html = "<td>";
                    foreach($multimicronutrientes as $cred){
                        if($cred->mes == $i){
                            $html .= "<label class='label label-default'>Planificado ".$cred->denom."</label>";
                            $flag = true;
                        }
                    }
                    
                    foreach($atmultimicronutrientes as $atcred){
                        if($atcred->edad_meses == $i){
                            switch ($atcred->estado) {
                                case 'realizado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-success'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;
                                case 'no realizado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-danger'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;
                                case 'aplazado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-warning'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;                                
                            }                            
                            $flag = true;
                        }
                    }
                    if($flag == false){
                        $html .= "";
                    }

                    $html .=  "</td>";

                    echo $html;
                }
            ?>
            </tr>
             <tr>
                <td>DOSAJE DE HEMOGLOBINA</td>
            <?php                
                for($i=1;$i<60;$i++){
                    $flag = false;
                    $html = "<td>";
                    foreach($hemoglobina as $cred){
                        if($cred->mes == $i){
                            $html .= "<label class='label label-default'>Planificado ".$cred->denom."</label>";
                            $flag = true;
                        }
                    }
                    
                    foreach($athemoglobina as $atcred){
                        if($atcred->edad_meses == $i){
                            switch ($atcred->estado) {
                                case 'realizado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-success'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;
                                case 'no realizado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-danger'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;
                                case 'aplazado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-warning'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;                                
                            }                            
                            $flag = true;
                        }
                    }
                    if($flag == false){
                        $html .= "";
                    }

                    $html .=  "</td>";

                    echo $html;
                }
            ?>
            </tr>
            <tr>
                <td>VACUNA PENTAVALENTE</td>
            <?php                
                for($i=1;$i<60;$i++){
                    $flag = false;
                    $html = "<td>";
                    foreach($vpentavalente as $cred){
                        if($cred->mes == $i){
                            $html .= "<label class='label label-default'>Planificado ".$cred->denom."</label>";
                            $flag = true;
                        }
                    }
                    
                    foreach($atvpentavalente as $atcred){
                        if($atcred->edad_meses == $i){
                            switch ($atcred->estado) {
                                case 'realizado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-success'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;
                                case 'no realizado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-danger'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;
                                case 'aplazado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-warning'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;                                
                            }                            
                            $flag = true;
                        }
                    }
                    if($flag == false){
                        $html .= "";
                    }

                    $html .=  "</td>";

                    echo $html;
                }
            ?>
            </tr>
            <tr>
                <td>VACUNA IPV</td>
            <?php                
                for($i=1;$i<60;$i++){
                    $flag = false;
                    $html = "<td>";
                    foreach($vipv as $cred){
                        if($cred->mes == $i){
                            $html .= "<label class='label label-default'>Planificado ".$cred->denom."</label>";
                            $flag = true;
                        }
                    }
                    
                    foreach($atvipv as $atcred){
                        if($atcred->edad_meses == $i){
                            switch ($atcred->estado) {
                                case 'realizado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-success'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;
                                case 'no realizado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-danger'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;
                                case 'aplazado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-warning'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;                                
                            }                            
                            $flag = true;
                        }
                    }
                    if($flag == false){
                        $html .= "";
                    }

                    $html .=  "</td>";

                    echo $html;
                }
            ?>
            </tr>            
            <tr>
                <td>VACUNA ROTAVIRUS</td>
            <?php                
                for($i=1;$i<60;$i++){
                    $flag = false;
                    $html = "<td>";
                    foreach($vrotavirus as $cred){
                        if($cred->mes == $i){
                            $html .= "<label class='label label-default'>Planificado ".$cred->denom."</label>";
                            $flag = true;
                        }
                    }
                    
                    foreach($atvrotavirus as $atcred){
                        if($atcred->edad_meses == $i){
                            switch ($atcred->estado) {
                                case 'realizado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-success'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;
                                case 'no realizado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-danger'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;
                                case 'aplazado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-warning'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;                                
                            }                            
                            $flag = true;
                        }
                    }
                    if($flag == false){
                        $html .= "";
                    }

                    $html .=  "</td>";

                    echo $html;
                }
            ?>
            </tr>
            <tr>
                <td>VACUNA ANTIPOLIO ORAL</td>
            <?php                
                for($i=1;$i<60;$i++){
                    $flag = false;
                    $html = "<td>";
                    foreach($vantipolio as $cred){
                        if($cred->mes == $i){
                            $html .= "<label class='label label-default'>Planificado ".$cred->denom."</label>";
                            $flag = true;
                        }
                    }
                    
                    foreach($atvantipolio as $atcred){
                        if($atcred->edad_meses == $i){
                            switch ($atcred->estado) {
                                case 'realizado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-success'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;
                                case 'no realizado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-danger'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;
                                case 'aplazado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-warning'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;                                
                            }                            
                            $flag = true;
                        }
                    }
                    if($flag == false){
                        $html .= "";
                    }

                    $html .=  "</td>";

                    echo $html;
                }
            ?>
            </tr>
            <tr>
                <td>VACUNA NEUMOCOCO</td>
            <?php                
                for($i=1;$i<60;$i++){
                    $flag = false;
                    $html = "<td>";
                    foreach($vneumococo as $cred){
                        if($cred->mes == $i){
                            $html .= "<label class='label label-default'>Planificado ".$cred->denom."</label>";
                            $flag = true;
                        }
                    }
                    
                    foreach($atvneumococo as $atcred){
                        if($atcred->edad_meses == $i){
                            switch ($atcred->estado) {
                                case 'realizado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-success'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;
                                case 'no realizado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-danger'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;
                                case 'aplazado':
                                    $html .= "<br><label onclick='loadfrmShowAtencion(".$atcred->id_atencion_usuario.");' class='label label-warning'>". strtoupper($atcred->estado." ".$atcred->denom) ." DOSIS </label>";
                                    break;                                
                            }                            
                            $flag = true;
                        }
                    }
                    if($flag == false){
                        $html .= "";
                    }

                    $html .=  "</td>";

                    echo $html;
                }
            ?>
            </tr>
            
        </tbody>
    </table>
</div>

@section('script')
    <script type="text/javascript">
        
    loadfrmShowAtencion = function(id_atencion){
        console.log(id_atencion);      
          $.ajax({
                url: '/poi/salud/intervencion/show',
                type: 'POST',
                data: {id_atencion: id_atencion},
                beforeSend: function () {
                    $("#loader").show();
                },
                success: function (response) {
                    $('#modal_simple .modal-title').html($(response).filter('.cabecera'));
                    $('#modal_simple .modal-body').html($(response).filter('#container'));
                    $('#modal_simple .modal-footer').append($(response).filter('.pie'));
                    $('#modal_simple').modal('show', {backdrop: 'true'});
                },
                complete: function(response) {
                    $("#loader").hide();                     
                    //fireDZ(id);
                    cargarImg(id_atencion);
                    //FANCYBOX INIT
                    $(".fancybox").fancybox();                        
                },
                error: function(response){
                    $("#loader").hide();
                }
            });
        }

    cargarImg = function(id){
        var imguid = id;
        $.get('/poi/salud/img/get/' + imguid.toString(), function(data) {
            $('.modal-scrollable #poi').html('');
            //console.log(data.taller_img.length);
            if(data.atencion_img.length != 0){
                $.each(data.atencion_img, function (key, value) {

                    url = '/images' + value.url + "/" + value.nombre;
            $('.modal-scrollable #poi')
            .append('<div class="container col-lg-3 col-sm-6 col-md-4 col-xs-12">'
                        +'<div style="border:1px solid;border-radius:2%;margin-right:8px;margin-top:12px;">'
                            +'<a class="fancybox" rel="group" href="'+ url +'">'
                                +'<img width=100% height=150px src="'+ url +'" alt="" />'
                            +'</a>'
                            +'<div style="height:35px;text-align:left;background-color:rgba(208, 206, 206, 0.83);">'
                                +'<span style="font-weight:bold">&nbsp&nbspFecha: ' + value.created_at + '</span>'
                            +'</div>'
                            +'<div style="height:35px;text-align:left;background-color:rgba(208, 206, 206, 0.83);">'                                    
                                + '<!--button style="float:right" onclick = "deleteImg('+value.id+','+imguid
                                +')" class="btn btn-danger"><i class="fa fa-trash"></i></button--> '
                            +'</div>'
                        +'</div>'
                    +'</div>');
                });

            } else {
                $('.modal-scrollable #poi').append('<h4>No hay imágenes disponibles</h4>');
            }

        });
    };


    </script>
@endsection

@endsection