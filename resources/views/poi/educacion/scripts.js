    var table = $('#poitaller-table').DataTable({            
            lengthMenu: [[10, 25, 50,1000], [10, 25, 50, 1000]],
            processing: true,
            serverSide: true,
            orderCellsTop: true,
            autoWidth: false,
            stateSave: false,
            order: [[ 2, "desc" ]],
            /*initComplete : function() {
                alert('asd');
                var input = $('#poitaller-table_filter input').unbind(),
                    self = this.api(),
                    $searchButton = $('<button>')
                               .text('search')
                               .click(function() {
                                  self.search(input.val()).draw();
                               }),
                    $clearButton = $('<button>')
                               .text('clear')
                               .click(function() {
                                  input.val('');
                                  $searchButton.click(); 
                               }) 
                $('#poitaller-table_filter').append($searchButton, $clearButton);
            },*/           
            dom: 'lpBrtip',
            /*"createdRow": function( row, data, dataIndex ) {                
                $(row).addClass( data['state'] );
                
            },*/
            responsive: {
                details: {
                    type: 'column'
                }
            },
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i>',
                    className: '',
                    exportOptions: {
                            modifier: {
                                   page: 'current'
                                }
                            }
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print fa-lg" aria-hidden="true"></i>',
                    exportOptions: {
                            modifier: {
                                   page: 'current'
                                }
                            }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"><i>',
                    exportOptions: {
                            modifier: {
                                   page: 'current'
                                }
                            }
                }
            ],
            ajax: {
                url: '{{ url("poi/educacion/filter-data") }}',
                type: 'POST',
                data: function (d) {                                        
                    d.sector = window.location.href.split("/")[window.location.href.split("/").length - 1];                    
                    d.inicio          = $('#dateB').val();
                    d.search['value'] = $('#txtSearch').val();
                    d.fin             = $('#dateE').val();
                    d.estado          = $('#cboEstado :selected').val();
                },
                /*dataSrc: function(json){

                    /*$.each(json.legend,function($key,$val){
                        $('#'+$key).html('<span style="color: green;"><b>'+$val+'</b><span>');
                    });

                    return json.data;
                    return '';
                }*/
            },
            columnDefs: [
                {
                    className: 'control',
                    orderable: false,                    
                    targets:   0
                },
                { className: "dt-center", targets: "_all"},
                /*{
                    orderable: false,
                    targets:   2,
                    render: function (data, type, full, meta) {
                        
                        
                    }
                },*/
                {
                    orderable: false,
                    targets:   2,
                    render: function (data, type, full, meta) {
                        
                        f_programada = data;
                        if ( f_programada ){
                            //TODAY
                            var currentTime = new Date();
                            var month = currentTime.getMonth() + 1;
                            var day = currentTime.getDate();
                            var year = currentTime.getFullYear();

                            if(month<10){
                                month = '0'+month;
                            }
                            if(day<10){
                                day = '0'+day;
                            }
                            console.log(full);
                            var today = year+'-'+month+'-'+day;  
                            var today1 = year+'-'+month+'-'+day;  
                            var f_programada1 = f_programada.split('-');

                            var today = new Date(today);
                            var f_programada = new Date(f_programada);
                            var timeDiff = ( f_programada.getTime() - today.getTime() );

                            diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

                            console.log(diffDays);

                            if( diffDays == 0 ){
                                f_programada = '<label class="label label-success">Hoy</label>';
                            } else if( diffDays == 1 ){
                                f_programada = '<label class="label label-primary">Mañana</label>';
                            } else if( diffDays > 1 ){
                                f_programada = '<label class="label label-primary">  '+ f_programada1[2]+'-'+f_programada1[1]+'-'+f_programada1[0] + '</label> ';
                            } else if( diffDays == -1 ){
                                f_programada = '<label class="label label-default">Ayer</label> ';
                            } else if( diffDays < 1 ){
                                f_programada = '<label class="label label-default">  '+ f_programada1[2]+'-'+f_programada1[1]+'-'+f_programada1[0] + '</label> ';
                            }

                            //return f_programada;

                            if( full['state'] == "complete" ){
                                f_programada += '<br><label class="label label-success">Completo</label> ';
                            } else if( full['state'] == "passed" ) {
                                f_programada += '<br><label class="label label-danger">Incompleto</label> ';
                            } else if( full['state'] == "reprogramed" ) {
                                f_programada += '<br><label class="label label-warning">Reprogramado</label> ';
                            } else {
                                f_programada += '<br><label class="label label-warning">Planificado</label> ';
                            }
                            
                            return f_programada;
                        } else {
                            return '<label class="label label-default">No Programado</label>';
                        } 
                    }
                },
                @permission('poi-publicar-taller'){
                    orderable: false,
                    targets:   -1,
                    render: function (data, type, full, meta) {
                        chk = '';
                        if (data === '1') {                            
                            return "<label class='label label-success'>Publicada</label>";
                        }
                        var tChk;
                            if( meta.row == 0){
                                tChk = 'data-step="7" data-intro="Cuando los datos esten completos, publiquela"';
                            }
                        return '<input class=\"form-input stateSayhuite\" '+tChk+' type=\"checkbox\" onchange=\"publicar(this)\" name="' + full['id'] + '" ' + chk + '>';
                    }
                },@endpermission
                {
                    render: function (data, type, full, meta) {
                        return "<div class='text-wrap width-100'>" + data + "</div>";
                    },
                    targets: 5
                },
                {
                    orderable: false,
                    targets:   7,
                    render: function (data, type, full, meta) {
                        
                        eImg = 'loadfrmImg("' + data + '")';
                        eView = 'loadModal("/poi/educacion/show","full-width","1","' + data + '")';
                        eDelete = 'deleteTaller("'+ data +'")';
                        eEdit = 'loadModal("/poi/educacion/edit","modal_wide","1","' + data + '")';

                        var tImg;
                        var tView;
                        var tEdit;
                        var tDelete;

                        if(meta.row == 0){
                            tEdit = 'data-step="3" data-intro="Edite programación"';
                            tView = 'data-step="4" data-intro="Vea datos relacionados a una programación"';
                            tImg = 'data-step="5" data-intro="Agregue Foto de ejecución de la programación"';
                            tDelete = 'data-step="6" data-intro="Borre una programación"';    
                        }

                        var bEdit = "";
                        var bView = "";
                        var bDelete = "";
                        var bImg = "";

                        @permission('poi-publicar-taller')
                        bEdit = "<button class='btn btn-primary' "+ tEdit +" onclick = "+ eEdit +"><i class='fa fa-pencil'></i></button> ";
                        @endpermission
                        bView = "<button class='btn btn-info' "+ tView +" onclick = "+ eView +"><i class='fa fa-eye'></i></button> ";
                        bImg = "<button class='btn btn-warning' "+ tImg +" onclick = "+ eImg +"><i class='fa fa-image'></i></button> ";
                        @permission('poi-publicar-taller')
                        bDelete = "<button class='btn btn-danger' "+ tDelete +" onclick = "+ eDelete +"><i class='fa fa-trash'></i></button>";
                        @endpermission

                        return bEdit + bView + bImg + bDelete;
                    }
                }
               
               
            ],
            language:
            {
                "sProcessing":     "<img src='/images/sys/pplp.gif' width='70px' height='70px'>",
                "sLengthMenu":     "Mostrar _MENU_",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando _START_ al _END_ de _TOTAL_ registros",
                "sInfoEmpty":      "Vacio",
                "sInfoFiltered":   "(filtrado de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
            ,
            columns: [
                {data: '', name: 'accion', orderable: false, searchable: false, width: '1%'},                
                {data: 'activ_operativa', name: 'activ_operativa', width: '30%'},                
                {data: 'fecha', name: 'fecha', width: '7%', orderable: true},
                {data: 'codigo_taller', name: 'codigo_taller', width: '5%'},
                {data: 'nom_dist', name: 'nom_dist', width: '8%'},
                {data: 'ejecutora', name: 'ejecutora', width: '8%'},
                {data: 'nombre_usuario', name: 'nombre_usuario', width: '10%'},
                //{data: 'descripcion', name: 'descripcion', width: '22%'},
                //{data: 'created_at', name: 'created_at', width: '10%'},
                {data: 'id', name: 'accion', orderable: false, searchable: false , width: '12%'},
                @permission('poi-publicar-taller'){data: 'publicada', name: 'poi_taller_usuario.publicada', width: '5%'}@endpermission
            ],
            initComplete: function (data) {
                
            }
        });

        reloadTable = function (){
           table.ajax.reload( null, false ); 
        }

        /*$("#txtSearch").bind('keypress', function(){

        });*/

        $(".dateSearch").change(function (){
           reloadTable();
        });

        $("#cboEstado").change(function (){
           reloadTable();
        });

        $.fn.dataTable.ext.errMode = 'none';


        function addCommas(nStr){
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }



            //EVENTOS

        //-- LISTENERS

        //OPEN MODAL ADD
        $("#btnAdd").click(function(e){
            e.preventDefault();
            $("#modal_add").modal('show', {backdrop: 'true'}).fadeIn('fast');
        });

        $('#modal_add').on('shown.bs.modal', function() {
            $("#txtDescripcion").focus();
        })

        $("#frmAddTaller").submit(function(frm){
            frm.preventDefault();
            var formData = $(frm).serialize();
            console.log(formData);
            $.ajax({
                url: "/poi/educacion/add",
                type: 'POST',
                data: $("#frmAddTaller").serialize(),
                timeout: 4000,
                beforeSend: function () {
                     $("#loader").show();                 
                },
                success: function (response) {
                    $('.validation-message').remove();
                        swal(
                            'Guardado',
                            'Los cambios se guardaron exitosamente!',
                            'success'
                            );
                        table.ajax.reload( null, false );
                        setTimeout(function(){
                            $('#modal_add').modal('hide');
                            $("#tbl_PoiTaller").trigger("reloadGrid", { fromServer: true});
                        },1000);

                },
                complete: function(response) {
                    $("#loader").hide();
                },
                error: function(jqXHR,error, errorThrown){
                   html = "";
                   if(jqXHR.status&&jqXHR.status==400){
                        data = $.parseJSON(jqXHR.responseText); 
                        if (data.error === 1){
                            li = "";
                            $('.validation-message').remove();
                            $.each(data.messages, function( index, value ) {
                                li += "<li>"+ value +"</li>";
                            });

                            $("#frmAddTaller .m-message").prepend('<div class="validation-message alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>' + li + '</div>');
                            $(".modal-scrollable").animate({ scrollTop: 0 }, 'slow');
                            $("#m_message").focus();
                        } 
                   }else{
                        html += "Ha ocurrido un error, verifique su conección a internet o comuniquese con el administrador";
                   }
                }
            });
        }); //FIN MODAL ADD
        
        //-- LOAD MODAL
        loadModal = function(url,modaltype,CRUD,opc) {
            $modal = $('#' + modaltype);
            //clean errors
            $(".m-message").html('<div></div>');
            switch (CRUD) {
                //WITH ID [SHOW]
                case '1':
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {'id': opc},
                        beforeSend: function () {
                            $("#loader").show();  
                        },
                        success: function (response) {
                            $('#' + modaltype + ' .modal-title').html($(response).filter('.cabecera'));
                            $('#' + modaltype + ' .modal-body').html($(response).filter('#container'));
                            $('#' + modaltype + ' .modal-footer').append($(response).filter('.pie'));
                            $('#' + modaltype).modal('show', {backdrop: 'true'});
                        },
                        complete: function(response) {
                            $("#loader").hide();
                                
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
                                    beforeShow: function(input, obj) {
                                        //$(input).after($(input).datepicker('widget'));
                                        setTimeout(function(){
                                            $('.ui-datepicker').css('z-index', 99999999999999);
                                        }, 0);
                                    }
                                });
                                $("#frmEditTaller").submit(function (e){
                                    e.preventDefault();                
                                    $.ajax({
                                        url: "/poi/update",
                                        type: 'POST',
                                        data: $("#frmEditTaller").serialize(),
                                        timeout: 4000,
                                        beforeSend: function () {
                                            $(':input[type="submit"]').prop('disabled', true);
                                            $("#loader").show();
                                        },
                                        success: function (response) {
                                            $('.modal-scrollable .validation-message').remove();
                                                swal(
                                                    'Guardado',
                                                    'Los cambios se guardaron exitosamente!',
                                                    'success'
                                                    );
                                                table.ajax.reload( null, false );
                                                setTimeout(function(){
                                                    $('#modal_wide').modal('hide');
                                                    $("#tbl_PoiTaller").trigger("reloadGrid", { fromServer: true});
                                                },1000);

                                        },
                                        complete: function(response) {
                                            $("#loader").hide();
                                            $(':input[type="submit"]').prop('disabled', false);
                                        },
                                        error: function(jqXHR,error, errorThrown){
                                           html = "";
                                           if(jqXHR.status&&jqXHR.status==400){
                                                data = $.parseJSON(jqXHR.responseText); 
                                                if (data.error === 1){
                                                    li = "";
                                                    $('.modal-scrollable .validation-message').remove();
                                                    $.each(data.messages, function( index, value ) {
                                                        li += "<li>"+ value +"</li>";
                                                    });

                                                    $(".modal-scrollable .m-message").prepend('<div class="validation-message alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>' + li + '</div>');
                                                    $(".modal-scrollable").animate({ scrollTop: 0 }, 'slow');
                                                    $("#m_message").focus();
                                                } 
                                           }else{
                                                html += "Ha ocurrido un error, verifique su conección a internet o comuniquese con el administrador";
                                           }
                                        }
                                    });
                                });
                        }
                    });
                    break;
            }
        }

        $("#cboActividad").bind('change',function(ele){

            //console.log($(ele).text());
            Actividad = ele;
            $.ajax({
                url: '/ActividadOperativa/ActividadOperativaxActividad',
                method: 'POST',
                data: {idActividad :$("#cboActividad :selected").val()},
                tryCount : 0,
                retryLimit : 3,
                beforeSend: function(){
                    $("#loader").show();
                },
                success: function(response){
                    html = "<option value=0>-- Seleccionar --</option>";
                    $.each(response,function(key,value){
                        html += "<option value="+key+">"+value+"</option>";
                    });
                    $("#cboActividadOperativa").html(html);
                },
                complete: function(response) {
                    $("#loader").hide();                    
                },
                error: function(jqXHR, textStatus, errorThrown){
                    if (textStatus == 'timeout') {
                        this.tryCount++;
                        if (this.tryCount <= this.retryLimit) {
                            //try again
                            $.ajax(this);
                            return;
                        }            
                        return;
                    }
                    if (jqXHR.status == 500) {
                        //handle error
                    } else {
                        //handle error
                    }
                }                
            });
        });

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
            beforeShow: function(input, obj) {
                //$(input).after($(input).datepicker('widget'));
                setTimeout(function(){
                    $('.ui-datepicker').css('z-index', 99999999999999);
                }, 0);
            }
        });


        
        $("#btnFindDNI").click(function(){

            dni = $("#txtDni").val();

            if ( dni.length < 8 ){
                return false;
            }

            $.ajax({
                url: '/getPoiUserbyDNI/'+ dni,
                type: 'GET',
                timeout:4000,
                tryCount : 0,
                retryLimit : 3,
                beforeSend: function(){
                    $("#loader").show();                    
                    $("#btnFindDNI").prop('disabled',true);
                },
                success: function(response){                                
                    if( response['usuario'] ){                    
                        nombre = response['usuario'].nombres + ', ' + response['usuario'].apellidos;
                        intervencion = response['usuario'].intervencion;
                        ejecutoras = response['usuario'].ejecutora;
                        idU = response['usuario'].idusuario;

                        $("#lblNombres").text(nombre);
                        $("#lblEjecutora").text(ejecutoras);
                        $("#lblIntervencion").text(intervencion);
                        $("#idUsuario").val(idU);
                    }

                    if( response['actividad'] ){
                        var html = "<option value = 0>-- Seleccionar --</option>";
                        $.each(response['actividad'], function($key,$value){
                            html += "<option value = "+$key+">"+$value+"</option>";
                        });

                        $("#cboActividad").html(html);
                    }
                    
                    $("#btnFindDNI").prop('disabled',false);
                },
                complete: function(response) {
                    $("#loader").hide();
                    $("#btnFindDNI").prop('disabled',false);
                },
                error: function(jqXHR, textStatus, errorThrown){
                    if (textStatus == 'timeout') {
                        this.tryCount++;
                        if (this.tryCount <= this.retryLimit) {
                            //try again
                            $.ajax(this);
                            return;
                        }            
                        return;
                    }
                    if (jqXHR.status == 500) {
                        //handle error
                    } else {
                        //handle error
                    }
                    $("#btnFindDNI").prop('disabled',false);
                }
            });    
        });


        publicar = function(elem){
            //$(elem).prop('disabled', true);
            that = elem;
            //console.log(elem);
            if(that.checked){
                st = 1;
                nemesis = false;
            } else {
                st = 0;
                nemesis = true;
            }


            swal({
                title: '¿Estas seguro?',
                text: "Se mostrara publicamente la información de este taller",
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
                $.ajax({
                    url: "/poi/publicar",
                    type: 'POST',
                    data: {st: st, uid: that.name},
                    success: function (data) {
                        swal(
                        'Listo',
                        'Se ha publicado información del taller',
                        'success'
                        )

                        table.ajax.reload( null, false );
                    },
                    error: function(jqXHR,error, errorThrown){
                       html = "";
                       if(jqXHR.status&&jqXHR.status==403){
                            data = $.parseJSON(jqXHR.responseText);                             
                            swal(
                                    'Error',
                                    data.message,
                                    'error'
                            )
                       }else{
                            html += "Ha ocurrido un error, verifique su conección a internet o comuniquese con el administrador";
                       }
                       $(that).prop('checked',nemesis);
                    }
                });
                
            }, function(dismiss) {
                // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                $(that).prop('checked',nemesis);
                swal(
                        'Cancelado',
                        'Operación cancelada',
                        'error'
                )

            }).catch(swal.noop);
        };

        deleteTaller = function(id){
            console.log(id);
            swal({
                title: '¿Estas seguro?',
                text: "Se eliminará la programación",
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

                $.ajax({
                    url: "/poi/delete",
                    type: 'POST',
                    data: {id: id},
                    success: function (data) {
                        swal(
                        'Listo',
                        'Se elimino la programación',
                        'success'
                        )

                        table.ajax.reload( null, false );
                    },
                    error: function(jqXHR,error, errorThrown){
                       html = "";
                       if(jqXHR.status&&jqXHR.status==403){
                            data = $.parseJSON(jqXHR.responseText);                             
                            swal(
                                    'Error',
                                    data.message,
                                    'error'
                            )
                       }else{
                            html += "Ha ocurrido un error, verifique su conección a internet o comuniquese con el administrador";
                       }
                       //$(that).prop('checked',nemesis);
                    }
                });
                
            }, function(dismiss) {
                // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                //$(that).prop('checked',nemesis);
                swal(
                        'Cancelado',
                        'Operación cancelada',
                        'error'
                )

            }).catch(swal.noop);  
        };

        loadfrmImg = function(id){
              $.ajax({
                        url: '/poi/educacion/img',
                        type: 'POST',
                        data: {'id': id},
                        beforeSend: function () {
                            $("#loader").show();  
                        },
                        success: function (response) {
                            $('#full-width .modal-title').html($(response).filter('.cabecera'));
                            $('#full-width .modal-body').html($(response).filter('#container'));
                            $('#full-width .modal-footer').append($(response).filter('.pie'));
                            $('#full-width').modal('show', {backdrop: 'true'});
                        },
                        complete: function(response) {
                            $("#loader").hide();
                            fireDZ(id);
                            cargarImg(id);
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
            $.get('/poi/getServerImg/' + imguid.toString(), function(data) {
                $('#full-width #poi').html('');
                //console.log(data.taller_img.length);
                if(data.taller_img.length != 0){
                    $.each(data.taller_img, function (key, value) {

                        url = '/images' + value.url + "/" + value.nombre;
                $('#full-width #poi')
                .append('<div class="container col-lg-3 col-sm-6 col-md-4 col-xs-12">'
                            +'<div style="border:1px solid;border-radius:2%;margin-right:8px;margin-top:12px;">'
                                +'<a class="fancybox" rel="group" href="'+ url +'">'
                                    +'<img width=100% height=150px src="'+ url +'" alt="" />'
                                +'</a>'
                                +'<div style="height:35px;text-align:left;background-color:rgba(208, 206, 206, 0.83);">'
                                    +'<span style="font-weight:bold">&nbsp&nbspFecha: ' + value.created_at + '</span>'
                                +'</div>'
                                +'<div style="height:35px;text-align:left;background-color:rgba(208, 206, 206, 0.83);">'                                    
                                    + '<button style="float:right" onclick = "deleteImg('+value.id+','+imguid
                                    +')" class="btn btn-danger"><i class="fa fa-trash"></i></button> '
                                    <?php
                                        if( Auth::user()->hasRole('admin') or Auth::user()->hasRole('adminpoi') ){
                                    ?>
                                    + '<button style="float:right" onclick = "showImgData('+value.id+')" class="btn btn-info"><i class="fa fa-eye"></i></button>'
                                    <?php
                                        }
                                    ?>
                                +'</div>'
                            +'</div>'
                        +'</div>');
                    });

                } else {
                    $('#full-width #poi').append('<h4>No hay imágenes disponibles</h4>');
                }

            });
        };

        deleteImg = function($id, $idtaller){
            var id = $id;
            swal({
                title: '¿Estas seguro?',
                text: "Se eliminara esta imagen",
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
                $.ajax({
                    url: "/poi/img/eliminar",
                    type: 'POST',
                    data: {id: id},
                    success: function (data) {
                        cargarImg($idtaller);

                        swal(
                            'Listo',
                            'Se ha eliminado la imagen',
                            'success'
                        )

                        table.ajax.reload( null, false );
                    },
                    error: function(e){
                        swal(
                        'Error',
                        'Error al eliminar la imagen',
                        'error'
                        )
                    }
                });
               
            }, function(dismiss) {                
                
                swal(
                        'Cancelado',
                        'Operación cancelada',
                        'error'
                )

            }).catch(swal.noop);
        };

        showImgData = function($id){
           $.ajax({
                        url: '/poi/img/meta',
                        type: 'POST',
                        data: {'id': $id},
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
                        }
                    });   
        };
        dzoneclick = function(){
            $('#dzone').trigger('click');
        };
        fireDZ = function(id){
            var id = id;
            var counter = 0;
            var actual = 0;
            var cleanUp = true;    ;
          $("#full-width #dzone").dropzone({

                uploadMultiple: true,
                autoProcessQueue: false,
                maxFiles: 1,
                parallelUploads: 1,
                maxFilesize: 250,
                acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
                previewsContainer: '#dropzonePreviewAntes',
                previewTemplate: document.querySelector('#preview-template').innerHTML,
                addRemoveLinks: true,
                dictRemoveFile: 'Quitar',
                //dictFileTooBig: 'La imagen es mayor a 8MB',
                dictRemoveFileConfirmation: "¿Estas seguro que deseas quitar esta imagen?",
                // The setting up of the dropzone
                createImageThumbnails: true,
                maxThumbnailFilesize: 100,

                init:function() {
                    var dzuid = id;
                    //var uid = document.getElementById('uid').value;

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
                        btnState(actual);
                    });

                this.on("addedfile", function(file) {
                        actual++;
                        console.log(file);
                        btnState(actual);
                    });
                this.on("maxfilesexceeded", function(){
                        swal(
                                'Error',
                                'Solo Puede subir una imagen!',
                                'error'
                        );    
                    });
                    indx = 0;
                this.on("sendingmultiple", function(file, xhr, formData){
                        var csrf_token = $('meta[name="csrf-token"]').attr('content');
                        var uid = id;
                        var nDate = new Date(file[0].lastModified)

                        

                    var datestring = nDate.getFullYear() + "-" +                                          
                                        ("0"+(nDate.getMonth()+1)).slice(-2) + "-" +
                                        ("0" + nDate.getDate()).slice(-2) + " " +    
                                        ("0" + nDate.getHours()).slice(-2) + ":" + 
                                        ("0" + nDate.getMinutes()).slice(-2) + ":" + 
                                        ("0" + nDate.getSeconds()).slice(-2);

                    console.log(JSON.stringify(file[0]));
                    formData.append('uid',id);
                    formData.append('fecha',datestring);
                    formData.append('cdata', [file[0].lastModifiedDate,file[0].name,file[0].lastModified]  );
                    formData.append('_token', csrf_token);                        
                });
                this.on("error", function(file){if (!file.accepted) this.removeFile(file);});
                this.on("removedfile", function(file) {
                    actual--;
                    btnState(actual);
                });
            },
            error: function(file, response) {
                $('.validation-message').remove();
                if(response.error){
                    if(response.messages){                            
                        var li = "";
                        $.each(response.messages, function( index, value ) {
                            li += "<li>"+ value +"</li>";
                        });
                        $('#message').prepend('<div class="validation-message alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>' + li + '</div>');
                            
                        swal(
                            'Error',
                            'Error al subir la imagen, intentelo nuevamente!',
                            'error'
                        );
                    } else if(response.message){
                        $('.validation-message').remove();
                        var li = "";

                        $('#message').prepend('<div class="validation-message alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>' + response.message + '</div>');                            
                            
                        swal(
                            'Error',
                            response.message,
                            'error'
                        );
                    }
                }
            },
            success: function(file,response) {
                $('.validation-message').remove();
                var myDropzone = this;
                $('.serverfilename', file.previewElement).val(response.filename);
                counter++;
                $("#photoCounterAntes").text( "(" + counter + ")");

                //$('#message').html('<div class=\'alert alert-success fade in\'>La imagen se Guardó Exitosamente</div>');
                cargarImg(id);
                cleanUp = false;
                myDropzone.removeAllFiles();
                swal(
                        'Correcto',
                        'La imágen se guardó correctamente',
                        'success'
                );
                //$("#poitaller-table").ajax.reload();              
            }
        });
    };

    function btnState(actual){
        if( actual > 0 ){
            $('#submit-all').show();
            $('#btnAddPhoto').css('display','none');
        }else{
            $('#submit-all').css('display','none');
            $('#btnAddPhoto').show();
        }                
    }


    var createExcelFromGrid = function(gridID,filename) {
        var excluidos = ['act','est','estado_pic','chkSayhuite'];
        var grid = $('#' + gridID);
        var rowIDList = grid.getDataIDs();
        var row = grid.getRowData(rowIDList[0]);
        var colNames = [];
        var i = 0;
        for(var cName in row) {
            colNames[i++] = cName; // Capture Column Names
        }
        //console.log(colNames);
        var html = "data:application/vnd.ms-excel,<table>";

            html += "<thead><tr>";
                for(var i = 0 ; i<colNames.length ; i++ ) {
                    if( excluidos.indexOf(colNames[i]) == -1 ){
                        html += "<td>";
                        html += colNames[i]; // Create a CSV delimited with ;
                        html += "</td>";
                    }
                }
            html += "</tr></thead>";
        for(var j=0;j<rowIDList.length;j++) {
            html += "<tr>";
            row = grid.getRowData(rowIDList[j]); // Get Each Row
            for(var i = 0 ; i<colNames.length ; i++ ) {
                //console.log(colNames[i], excluidos.indexOf(colNames[i]) != -1);
                if( excluidos.indexOf(colNames[i]) == -1 ){
                    html += "<td>";
                    html += row[colNames[i]]; // Create a CSV delimited with ;
                    html += "</td>";
                }
            }
            html += "</tr>";
        }
        //alert(html);
        html += '</table>';
        //console.log(html);
        var a         = document.createElement('a');
        a.id = 'ExcelDL';
        a.href        = html;
        a.download    = filename ? filename + ".xls" : 'DataList.xls';
        document.body.appendChild(a);
        a.click(); // Downloads the excel document
        document.getElementById('ExcelDL').remove();
    }

    
    
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    $("#cboDistrito").select2({
            dropdownParent: $("#modal_add"),
            ajax: {
                url: "/listDistritoByName",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                  return {
                    q: params.term, // search term
                    u: $("#idUsuario").val()
                  };
                },
                processResults: function (data, params) {
                  // parse the results into the format expected by Select2
                  // since we are using custom formatting functions we do not need to
                  // alter the remote JSON data, except to indicate that infinite
                  // scrolling can be used
                  //params.page = params.page || 1;                                    
                  return {
                    results: $.map(data, function ($key,$val) {
                        return {
                            text: $key,
                            slug: $key,
                            id: $val
                        }
                    })
                    /*pagination: {
                      more: (params.page * 30) < data.total_count
                    }*/
                  };
                },
                cache: true
              },
              escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
              minimumInputLength: 3
              //templateResult: formatRepo, // omitted for brevity, see the source of this page
              //templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
    });        

   

 