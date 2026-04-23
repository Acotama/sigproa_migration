<span class="cabecera">
    <h3>Gestionar Documentos</h3>
</span>

<div id="container" class="container-fluid">
    <br>
    <input type=hidden id="uid" name="uid" value="{{ $Can->id }}"/>

    <?php
    set_time_limit(600000);
    ?>

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <!--CONVENIO-->
                    <form class="pdf_frm" method="POST">
                        <div id = "conv_message"></div>
                        <fieldset>
                            <legend>
                                <h4><b>CONVENIO / EXPEDIENTE</b></h4>
                            </legend>
                            <div class="row" id ="pdf_conv">
                                <div class="col-md-12"><input name="conv_pdf" id="conv_pdf" type="file" accept=".pdf"></div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="input-group col-md-12 col-lg-12">
                                    <span class="input-group-addon"><label for="nro_conv">Numero de convenio:</label></span>
                                    <div class=""><input name="nro_conv" id="nro_conv" type="text" class="form-control" required></div>
                                </div>
                            </div>
                            <br>
                            <div class="row text-center">
                                <button type="submit" class="btn btn-success center">Guardar</button>
                            </div>
                            <br>
                        </fieldset>
                        <input type=hidden id="uid" name="uid" value="{{ $Can['id'] }}"/>
                        <input type=hidden id="uid" name="tipo" value="conv"/>
                    </form>
                </div>


            <br>
        </div>
    </div>







    <!-- MAIN SCRIPT -->
    <script>
        //DATEPICKER INICIALIZATION
        $(".datepicker").datepicker({
            monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"],
            monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
            dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
            dateFormat: "dd-mm-yy",
            yearRange: '2000:2020',
            changeMonth: true,
            changeYear: true,
            maxDate: '+30Y',
            beforeShow: function () {
                setTimeout(function () {
                    $('.ui-datepicker').css('z-index', 99999999999999);
                }, 0);
            }
        });

        //FANCYBOX INIT
        $(".fancybox").fancybox();

    </script>


    <script>
        // LOAD PDFS TO SERVER
        $(".pdf_frm").submit(function(e){
            e.preventDefault();
            tipo = this.tipo.value;
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: '/mantcanales/fileUpload',
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                beforeSend: function(){
                    $('button').attr('disabled','disabled');
                },
                success: function (response) {
                    //console.log(formData.serialize());
                    //console.log(response.ResponseJSON);
                    $('#' + tipo.toString() + '_message').html('<div class="alert alert-success fade in"><button type="button" class="close" data-dismiss="alert">&times;</button><span>'+response.message+'</span></div>');
                    $('button').removeAttr('disabled');
                    swal(
                            'Correcto',
                            'Datos actualizados correctamente!',
                            'success'
                    );
                    cargarPdf();

                },
                error: function(response){
                    response = $.parseJSON(response.responseText);
                    $('#' + tipo.toString() + '_message').html('<div class="alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button><span>'+response.message +'</span></div>');
                    $('button').removeAttr('disabled');
                    swal(
                            'Error',
                            'Error al guardar los cambios',
                            'error'
                    );
                }
            });
            return false;
        });

        //AJAX REQUEST ON PDF UPLOAD // LOAD SERVER PDFS ->
        cargarPdf = function(){
            makeControls();
            uid = document.getElementById('uid').value;
            $.get('/mantcanales-server-pdf/' + uid.toString(), function(data) {
                $.each(data.result,function(key,value){
                    $.each(value,function(k,val){
                        console.log(value);
                        $('#a_'+ k).val(val.avance);
                        $('#f_'+ k).val(val.fecha);
                        if(val.tipo == 'conv'){
                            $('#nro_conv').val(val.nro);
                        }
                        if(val.tipo != undefined) {
                            $('#pdf_' + k).html(function () {
                                html = '';
                                c = (val.file.length);
                                $.each(val.file, function (i, v) {
                                    //nombre = v.split("_");
                                    //nombre = nombre[-1].split(".");

                                    html += '<div class=\"col-md-12\">';
                                    html += '<div class="row">' +
                                            '<div class="col-md-4">' +
                                            '<a href=\"/'+ v +'\" target=\"_blank\">' +
                                            '<i style=\"color: red;\" class=\"fa fa-file-pdf-o\" aria-hidden=\"true\"></i> Ver '+ k.toUpperCase() + ' ' + (c).toString() + '</a>' +
                                            '</div>' +
                                            '<div>' +
                                            '<a onclick="mantcanalesdeletePdf(this)" value = "'+v+'"><i value = "'+v+'" class="fa fa-times-circle fa-lg text-danger" aria-hidden="true"></i></a>' +
                                            '</div>' +
                                            '</div>';
                                    html += '</div>';
                                    c--;

                                });
                                //console.log(val.file);
                                /*if(val.tipo === 'ejec') {
                                    html += '<div class=\"row\"><div class=\"col-md-12\"><input name=\"' +val.tipo + '_pdf\" id=\"' + val.tipo + '_pdf\" type=\"file\" accept=\".pdf\"></div></div>';
                                }
                                //console.log(html);*/
                                return html;
                            });
                        }
                    });
                });
            });
        };
        makeControls = function () {
            $arrNameTipo = [
                'conv'
            ];

            $('#nro_conv').val('');//CONVENIO EXCEPION
            $.each($arrNameTipo, function (key, value) {
                $('#pdf_' + value).html('<div class="col-md-12"><input name="' + value + '_pdf" id="' + value + '_pdf" type="file" accept=".pdf" required></div>');
                $('#a_' + value).val('');
                $('#f_' + value).val('');
            });
        };

        mantcanalesdeletePdf = function(val){
            var val = (val.getAttribute('value'));
            swal({
                title: '¿Estas seguro?',
                text: "El documento será eliminado permanentemente",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No, cancelar!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: true
            }).then(function() {
                console.log(val);
                $.ajax({
                    url: "/mantcanales-delete-pdf",
                    type: 'POST',
                    data: {pdf: val,id:document.getElementById('uid').value},
                    beforeSend: function () {
                        $('button').attr('disabled','disabled');
                    },
                    success: function (data) {
                        cargarPdf();
                        $('button').removeAttr('disabled');
                        swal(
                                'Listo',
                                'Documento eliminado exitosamente',
                                'success'
                        )
                    }
                });

            }, function(dismiss) {
                // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                swal(
                        'Cancelado',
                        'Operación cancelada',
                        'error'
                )

            });
        };


        cargarPdf();
    </script>


</div>


