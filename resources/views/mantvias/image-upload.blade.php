<span class="cabecera">
    <h3>Actualizar imagenes</h3>
    <h4>(5 imágenes mínimo)</h4>
</span>

    <div id="container" class="container-fluid">
        <br>
        <input type=hidden id="uid" name="uid" value="{{ $id }}"/>

        <?php
        set_time_limit(600000);
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="jumbotron how-to-create" style="background-color: rgb(209,227,243)">
                    <div id='message'></div>
                    <div class='row col-md-12'>
                        <label>Tiempo de toma de imagenes</label><br>
                    </div>
                    <div class="row">
                        <div class="col-md-1"><input type="radio" name="tipo" value="antes"> ANTES<br></div>
                        <!--div class="col-md-1"><input type="radio" name="tipo" value="durante"> DURANTE<br></div-->
                        <div class="col-md-1"><input type="radio" name="tipo" value="despues"> DESPUES<br></div>
                    </div>
                    <br>

                    <div class="row col-md-12">
                        <label>Fecha de toma de las imagenes anexadas</label><br>
                        <input type=text id="fecha" name="fecha" class="datepicker"/><br><br>
                    </div>
                    <br/>
                    <br/>
                    <br/>

                    <h3><span id="counter"></span></h3>

                    {!! Form::open(['action' => 'MantViasController@imgUpload', 'class' => 'dropzone', 'files'=>true, 'id'=>'dzone']) !!}

                    <div class="dz-message">

                    </div>

                    <div class="fallback">
                        <input name="file" type="file" multiple/>
                    </div>

                    <div class="dropzone-previews" id="dropzonePreviewAntes"></div>

                    <h4 style="text-align: center;color:#428bca;">Arrastra las imagenes a esta área <span
                                class="glyphicon glyphicon-open-file"></span></h4>

                    <button id="submit-all">Guardar</button>
                    {!! Form::close() !!}

                </div>

            </div>
        </div>

        <!-- Dropzone Preview Template -->
        <div id="preview-template" style="display: none;">

            <div class="dz-preview dz-file-preview">
                <div class="dz-image"><img data-dz-thumbnail=""></div>
                <input type="hidden" class="serverfilename"/>

                <div class="dz-details">
                    <div class="dz-size"><span data-dz-size=""></span></div>
                    <div class="dz-filename"><span data-dz-name=""></span></div>
                </div>
                <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>
                <div class="dz-error-message"><span data-dz-errormessage=""></span></div>

                <div class="dz-success-mark">

                </div>

                <div class="dz-error-mark">

                </div>

            </div>
        </div>
        <!-- End Dropzone Preview Template -->

        <!-- BOXES -->

        <h3>ANTES</h3><span id="foto_antes"></span>

        <div id="antes"></div>
        <!--h3>DURANTE</h3><span id="foto_durante"></span>

        <div id="durante"></div-->

        <h3>DESPUES</h3><span id="foto_despues"></span>

        <div id="despues"></div>














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

        <!-- ========================================= LIBS ======================================= -->

        <script>

            Dropzone.autoDiscover = false;
            // or disable for specific dropzone:
            // Dropzone.options.myDropzone = false;

            $(function() {
                $('#submit-all').attr('disabled','disabled').addClass('btn btn-alert');
                var counter = 0;
                var actual = 0;
                var cleanUp = true;

                $('#fecha').change(function(){
                    btnState();
                });
                $('#fecha').keyup(function(){
                    console.log(actual + counter);
                    btnState();
                });

                $("#dzone").dropzone({

                    uploadMultiple: true,
                    autoProcessQueue: false,
                    maxFiles: 8,
                    parallelUploads: 8,
                    maxFilesize: 250,
                    acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
                    previewsContainer: '#dropzonePreviewAntes',
                    previewTemplate: document.querySelector('#preview-template').innerHTML,
                    addRemoveLinks: true,
                    dictRemoveFile: 'Quitar',
                    //dictFileTooBig: 'La imagen es mayor a 8MB',
                    dictRemoveFileConfirmation: "¿Estas seguro que deseas borrar esta imagen?",
                    // The setting up of the dropzone
                    createImageThumbnails: true,
                    maxThumbnailFilesize: 100,

                    init:function() {
                        uid = document.getElementById('uid').value;

                        var submitButton = document.querySelector("#submit-all");
                        myDropzone = this; // closure

                        submitButton.addEventListener("click", function(event) {
                            event.preventDefault();
                            if($('#fecha').val() !== '') {
                                myDropzone.processQueue(); // Tell Dropzone to process all queued files.
                            } else{
                                $('#submit-all').attr('disabled','disabled').addClass('btn btn-alert');
                            }

                        });

                        $('input[type=radio][name=tipo]').change(function() {
                            cleanUp = false;
                            btnState();
                        });
                        this.on("addedfile", function() {
                            actual++;
                            console.log(actual);
                            btnState();
                        });
                        this.on("maxfilesexceeded", function(){
                            alert("Limite de Imagenes Excedido");
                        });
                        indx = 0;
                        this.on("sendingmultiple", function(file, xhr, formData){
                            var csrf_token = $('meta[name="csrf-token"]').attr('content');
                            uid= document.getElementById('uid').value;
                            console.log(uid);
                            formData.append('tipo',$('input[name=tipo]:checked').val());
                            formData.append('uid',uid);
                            formData.append('fecha',$('#fecha').val());
                            formData.append('_token', csrf_token);
                            formData.append('cantidad', counter);
                        });
                        this.on("error", function(file){if (!file.accepted) this.removeFile(file);});
                        this.on("removedfile", function(file) {
                            if(cleanUp) {
                                $.ajax({
                                    type: 'POST',
                                    url: 'upload/delete',
                                    data: {
                                        id: $('.serverfilename', file.previewElement).val(),
                                        uid: document.getElementById('uid').value,
                                        _token: $('#csrf-token').val()
                                    },
                                    dataType: 'html',
                                    success: function (data) {
                                        var rep = JSON.parse(data);
                                        if (rep.code === 200) {
                                            counter--;
                                            $("#photoCounterAntes").text("(" + counter + ")");
                                        }

                                    }
                                });
                            }
                            counter--;
                            btnState();

                        } );

                    },
                    error: function(file, response) {
                        $('#message').html('<div class=\'alert alert-danger fade in\'>Error al guardar las imagenes, intentelo nuevamente</div>');
                        cleanUp = false;
                        myDropzone.removeAllFiles();
                        swal(
                                'Error',
                                'Error al subir las imagenes, intentelo nuevamente!',
                                'error'
                        );
                    },
                    success: function(file,response) {
                        var myDropzone = this;
                        $('.serverfilename', file.previewElement).val(response.filename);
                        counter++;
                        $("#photoCounterAntes").text( "(" + counter + ")");

                        $('#message').html('<div class=\'alert alert-success fade in\'>Las imagenes se Guardaron Exitosamente</div>');
                        cargarImg();
                        cleanUp = false;
                        myDropzone.removeAllFiles();
                        swal(
                                'Correcto',
                                'Las imagenes se guardaron correctamente',
                                'success'
                        );

                    }
                });



                function btnState(){
                    if($('#fecha').val() !== '' && actual + counter >= 4 && $('input[name=tipo]').is(':checked')===true ){
                        $('#submit-all').removeAttr('disabled').addClass('btn btn-success');
                    }else{
                        $('#submit-all').attr('disabled','disabled').addClass('btn btn-alert');
                    }
                    console.log($('input[name=tipo]').is(':checked'));
                    console.log($('#fecha').val());

                }

            });

            //AJAX REQUEST ON IMAGE UPLOAD ->
            cargarImg = function(){
                uid = document.getElementById('uid').value;
                $.get('mantvias/server-images/' + uid.toString(), function(data) {
                    $('#antes').html('');
                    $('#despues').html('');

                    if(data.antes.length != 0){
                        $.each(data.antes, function (key, value) {

                            url = value.url;
                            $('#antes').append('<a style="margin-right:8px" class="fancybox" rel="group" href="'+url+'"><img width=150px height=150px src="'+url+'" alt="" /></a>');

                            //$('#antes').append('<img class=\'fancybox\' src=\''+ url +'\'  data-big=\' '+ url +' \' style=\'border-width:0px;width:280px; height:280px;\'>');
                            $('#foto_antes').text(' Fecha: ' + value.fecha);
                        });

                    } else {
                        $('#antes').append('<h4>No hay imagenes disponibles</h4>');
                    }

                    if(data.despues !=''){
                        $.each(data.despues, function (key, value) {

                            url = value.url;
                            $('#despues').append('<a style="margin-right:8px" class="fancybox" rel="group" href="'+url+'"><img width=150px height=150px src="'+url+'" alt="" /></a>&nbsp;&nbsp');
                            $('#foto_despues').text(' Fecha: ' + value.fecha);
                        });
                    } else {
                        $('#despues').append('<h4>No hay imagenes disponibles</h4>');
                    }
                });
            };


            cargarImg();

        </script>


    </div>


