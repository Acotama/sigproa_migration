<span class="cabecera">

        <h3 class="text-center">Proyectos pendientes de reconocimiento</h3>
        <h4 class="text-center">Seleccione los proyectos que pertenecen a su gerencia</h4>


</span>

<div id="container" class="container-fluid">
            <div class="container col-md-12">
                <div class="row">
                    <h4>Gerencia: </h4><select class="selectpicker" id="ger_actual">@foreach($ger as $g)<option>{{ $g }}</option>@endforeach</select>                </div>
                <div class="row table-responsive">
                    <table class="table table-stripped" style="min-height: 400px">
                        <thead>
                        <tr>
                            <th>SNIP</th>
                            <th>UNIFICADO</th>
                            <th>Proyecto</th>
                            <th width="20%">Etapa</th>
                            <th width="20%">Sub - Etapa</th>
                            <th></th>
                        </tr>
                        </thead>

                        @foreach($data as $d)
                            <tr id="selectpi-{{$d->id}}">
                                <td>{{$d->cod_snip}}</td>
                                <td>{{$d->cod_unif}}</td>
                                <td>{{$d->nom_proyec}}</td>
                                <td><select style="width: 167px;" class="form-control chosen" onchange="subEtapa(this)" id="etapa_{{$d->id}}"><option value="">Seleccionar</option>@foreach($etapa as $e)<option value="{{$e['etapa']}}">{{$e['etapa']}}</option> @endforeach</select></td>
                                <td><select style="width: 167px;" class="form-control chosen" id="sub_etapa_{{$d->id}}"></select></td>
                                <td><button type="button" class="btn btn-success" id="{{$d->id}}" onclick="selectPi(this)"><i class="fa fa-check"></i></button></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <br>                
            </div>


            <script>

                function selectPi(e){
                    id = e.id;
                    etapa = $('#etapa_'+e.id).val();
                    subetapa = $('#sub_etapa_'+e.id).val();
                    ger   = $('#ger_actual').val();

                    if(etapa === ''  || subetapa === ''){
                        /*swal(
                                'Atención',
                                'Seleccione la etapa actual del proyecto',
                                'info'
                        );*/
                        return false;
                    }

                    //console.log(id,etapa,subetapa,ger);


                    swal({
                        title: 'Confirmar',
                        text: "El proyecto se agregara a la lista de proyectos por actualizar",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si',
                        cancelButtonText: 'No, cancelar!',
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger',
                        buttonsStyling: true
                    }).then(function () {
                        $.ajax({
                            url: '/piptotalpriori/selectpi-update',
                            type: 'POST',
                            data: {uid:id,etapa:etapa,ger:ger,subetapa:subetapa},
                            async: false,
                            cache: false,
                            //contentType: false,
                            //processData: false,
                            beforeSend: function () {
                                $('button').attr('disabled', 'disabled');
                            },
                            success: function (response) {
                                $('button').removeAttr('disabled');
                                swal(
                                        'Correcto',
                                        'El proyecto se ha agregado a su gerencia',
                                        'success'
                                );
                                $('#selectpi-'+id).remove();
                                table.ajax.reload();
                            },
                            error: function (response) {
                                $('button').removeAttr('disabled');
                                response = $.parseJSON(response.responseText);
                                swal(
                                        'Error',
                                        'Error, comuniquese con el administrador',
                                        'error'
                                );
                            }
                        });
                    }, function (dismiss) {
                        // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                        $(that).prop('checked', nemesis);
                        swal(
                                'Cancelado',
                                'Operación cancelada',
                                'error'
                        )

                    }).catch(swal.noop);



                    return false;
                }

                setTimeout(function () {
                    $(".chosen").chosen({
                    });
                },300);

                function subEtapa(e) {
                    cid = e.id;
                    console.log(cid)
                    $("#" + cid + " option:selected").each(function () {
                        var id = $(this).val();
                        console.log(id);
                        if (id == "") {
                            id = 0;
                        }
                        $.ajax({
                            url: "{{URL::to('/piptotalpriori/combosubetapa')}}/" + id,
                            success: function (data)
                            {
                                $("#sub_" + cid).html(data);
                                console.log(data);
                                $("#sub_" + cid).trigger("chosen:updated");
                            }
                        });
                    });
                }

            </script>



</div>


<div class="pie">

</div>




