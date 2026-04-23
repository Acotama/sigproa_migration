<span class="cabecera">
    <h3 class="text-center"><b>IMPORTAR EXCEL</b></h3>
</span>
<div id="container" >
    <div class="modal-body">
        <div class="row">
            <form method="POST" enctype="multipart/form-data" novalidate="novalidate"
                style="border-color:#ddd;border-width: 1px;border-style: solid;padding: 20px 15px 15px;" id="form_import">
                <div class="form-group">
                    <label for="anio_import">Año</label>
                    <select  id="anio_import" name="anio" class="form-control">
                        <!-- <option value="">Seleccione Año</option>  -->
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022" selected>2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="archivo">Seleccionar Excel</label>
                    <input type="file" name="file" class="custom-file-input" id="archivo" accept=".xls, .xlsx">
                </div>
                <div class="row text-center">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-lg">Formato <i class="fa fa-eye"></i></button>
                    <button type="submit" class="btn btn-primary upload">Importar</button>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="alert alert-success alert-dismissible" style="margin-top: 20px;display:none;padding-right: 10px;" id="panel_mensaje_correcto">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="padding-right: 18px;">×</button>
                <h5><i class="fa fa-ban"></i> Atencion!</h5>
                <div style="max-height:100px;overflow-y:auto;">
                    <ul id="mensaje_correcto"></ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="alert alert-danger alert-dismissible" style="margin-top: 20px;display:none;" id="panel_mensaje_error">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="fa fa-ban"></i> Alerta!</h5>
                <ul id="mensaje_error"></ul>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal container fade bs-example-modal-lg" tabindex="-1" style="display: none;" data-backdrop="static">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">
                <b>Formato del Excel para la Modificacion Presupuestal</b>
            </h4>
        </div>
        <div class="modal-body">
            <img src="{{asset('/modificacion_presupuestal/formato_mp.png')}}" class="img-responsive">
            <div class="row col-md-12 text-center" style="margin-top:10px">
                <a class="btn btn-success" href="{{asset('/modificacion_presupuestal/descargar_mod_pres.xlsx')}}" download="Formato de MP">
                    Descargar <i class="fa fa-download"></i>
                </a>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>

<div class="pie">
<script>
    $(document).ready(function () {
        
        $('#form_import').validate({
            rules: {
                anio: {
                    required: true,
                },
                file:{
                    required: true,
                    // extension: "xls|xlsx"
                }
            },
            messages: {
                anio: {
                    required: "Seleccione un año",
                },
                file: {
                    required: "Seleccione archivo",
                },
            },
            errorElement: 'span',
            debug: true,
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form){
                $("#panel_mensaje_correcto").hide();
                $("#panel_mensaje_error").hide();
                var formData = new FormData();
                var files = $('#archivo')[0].files[0];
                // var files = $('#archivo').val();
                var anio = $("#anio_import option:selected").val();
                formData.append('anio',anio);
                formData.append('file',files);
                $.ajax({
                    url: "{{asset('/modificacion_presupuestal/importar')}}",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                }).done(function (response) {
                    html="";
                    if(response.msg.length > 0){
                        $.each(response.msg,function(key,value){
                            html += "<li>" + value +"</li>"
                        });
                        $("#mensaje_correcto").html(html);
                        $("#panel_mensaje_correcto").show();
                    }
                    
                }).fail(function( jqXHR, textStatus ) {
                    if(jqXHR.status == 500){
                        html="";
                        $.each(jqXHR.responseJSON.msg,function(key,value){
                            html += "<li>" + value +"</li>"
                        });
                        $("#mensaje_error").html(html);
                        $("#panel_mensaje_error").show();
                    }else if(jqXHR.status == 400){
                        console.log("Error de Transaccion");
                    }else{
                        console.log("Error...");
                    }
                }).always(function() {

                });
                return false;
            }
        });

        modalimportar = function(){
            modaltype='modal_simple';
            $modal = $('#' + modaltype);
            $.ajax({
                url: '{{ asset("/modificacion_presupuestal/modal_importar") }}',
                type: 'POST',
                beforeSend: function () {
                    $("#cargando").show();
                },
                success: function (response) {
                    $('#' + modaltype + ' .modal-title').html($(response).filter('.cabecera'));
                    $('#' + modaltype + ' .modal-body').html($(response).filter('#container'));
                    $('#' + modaltype + ' .modal-footer').append($(response).filter('.pie'));
                    $('#' + modaltype).modal('show');
                },
                complete: function(response) {
                    $("#cargando").hide();
                },
            });
        }

    });
</script>
