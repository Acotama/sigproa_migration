@extends('starter')
@section('htmlhead')
<link href={{asset('icheck/skins/flat/blue.css')}} rel="stylesheet">
<script src={{asset('icheck/icheck.min.js')}}></script>
<style>
    input::-webkit-input-placeholder {
        font-weight: 700 !important;
        color: black !important;
    }
    input:-ms-input-placeholder {
        font-weight: 700 !important;
        color: black !important;
    }
    input::-ms-input-placeholder {
        font-weight: 700 !important;
        color: black !important;
    }
    input::placeholder {
        font-weight: 700 !important;
        color: black !important;
    }
</style>
@endsection
@section('body')
    <div class="text-center">
      <span style="font-weight: bold;font-size: 22px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;text-transform: uppercase;">REGISTRO DE LOS PROCEDIMIENTO DE CONTRATACIONES
      </span>
    </div>
    <br>
    <div class="col-md-12">
        <form  class="was-validated" id="frm-procedimiento" onsubmit="guardar();event.preventDefault();">
            <div class="row">
                <div class="form-group col-md-6">
                <label for="nom_pro_seleccion">NOMENCLATURA DEL PROCEDIMIENTO DE SELECCIÓN</label>
                <input type="text" class="form-control" id="nom_pro_seleccion" name="nom_pro_seleccion">
                </div>
                <div class="form-group col-md-6">
                <label for="cod_unif">CÓDIGO UNIFICADO</label>
                <input type="text" class="form-control" id="cod_unif" name="cod_unif">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                <label for="norma_aplicable">NORMATIVIDAD APLICABLE</label>
                <input type="text" class="form-control" id="norma_aplicable" name="norma_aplicable">
                </div>
                <div class="form-group col-md-3">
                <label for="objeto_contratacion">OBJETO DE LA CONTRATACIÓN</label>
                <select id="objeto_contratacion" class="form-control" name="objeto_contratacion">
                    <option value="" selected>Seleccionar...</option>
                    <option value="BIENES">BIENES</option>
                    <option value="SERVICIOS">SERVICIOS</option>
                    <option value="OBRAS">OBRAS</option>
                    <option value="CONSULTORIAS DE OBRAS">CONSULTORIAS DE OBRAS</option>
                </select>
                </div>
                <div class="form-group col-md-3">
                <label for="fecha_convocatoria">FECHA DE CONVOCATORIA</label>
                <input type="date" class="form-control" id="fecha_convocatoria" name="fecha_convocatoria">
                </div>
            </div>
            <!--REQUERIMIENTO-->
            <div class="row">
                <div class="form-group col-md-3">
                    <input type="checkbox" id="chek_requerimiento">
                    <label for="chek_requerimiento">REQUERIMIENTO</label> 
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" id="requerimiento_documento" name="requerimiento_documento" placeholder="Ingresar Documento" style="display:none;">
                </div>
                <div class="form-group col-md-2">
                    <input type="date" class="form-control" id="requerimiento_fecha" name="requerimiento_fecha" placeholder="Fecha" style="display:none;">
                </div>
            </div>
            <!--CERTIFICACION-->
            <div class="row">
                <div class="form-group col-md-3">
                    <input type="checkbox" id="chek_certificacion">
                    <label for="chek_certificacion">CERTIFICACION</label> 
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" id="certificacion_documento" name="certificacion_documento" placeholder="Ingresar Documento" style="display:none;">
                </div>
                <div class="form-group col-md-2">
                    <input type="date" class="form-control" id="certificacion_fecha" name="certificacion_fecha" placeholder="Fecha" style="display:none;">
                </div>
            </div>
            <!--APROBACION DE EXPEDIENTE-->
            <div class="row">
                <div class="form-group col-md-3">
                    <input type="checkbox" id="chek_aprob_exp">
                    <label for="chek_aprob_exp">APROBACION DE EXPEDIENTE</label> 
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" id="aprob_exp_documento" name="aprob_exp_documento" placeholder="Ingresar Documento" style="display:none;">
                </div>
                <div class="form-group col-md-2">
                    <input type="date" class="form-control" id="aprob_exp_fecha" name="aprob_exp_fecha" placeholder="Fecha" style="display:none;">
                </div>
            </div>
            <!--COMITE DE SELECCION-->
            <div class="row">
                <div class="form-group col-md-3">
                    <input type="checkbox" id="chek_com_sel">
                    <label for="chek_com_sel">COMITE DE SELECCION</label> 
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" id="com_sel_documento" name="com_sel_documento" placeholder="Ingresar Documento" style="display:none;">
                </div>
                <div class="form-group col-md-2">
                    <input type="date" class="form-control" id="com_sel_fecha" name="com_sel_fecha" placeholder="Fecha" style="display:none;">
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" id="com_sel_miembros" name="com_sel_miembros" placeholder="Ingresar Miembros" style="display:none;">
                </div>
            </div>
            <!--APROBACION DE BASES-->
            <div class="row">
                <div class="form-group col-md-3">
                    <input type="checkbox" id="chek_aprob_bases">
                    <label for="chek_aprob_bases">APROBACION DE BASES</label> 
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" id="aprob_bases_documento" name="aprob_bases_documento" placeholder="Ingresar Documento" style="display:none;">
                </div>
                <div class="form-group col-md-2">
                    <input type="date" class="form-control" id="aprob_bases_fecha" name="aprob_bases_fecha" placeholder="Fecha" style="display:none;">
                </div>
            </div>
            <!--PROCEDIMIENTOS DE SELECCION-->
            <div class="row">
                <div class="form-group col-md-3">
                    <input type="checkbox" id="chek_proc_selec">
                    <label for="chek_proc_selec">PROCEDIMIENTOS DE SELECCION</label> 
                </div>
                <div class="form-group col-md-2">
                    <select id="tipo_proc_selec" class="form-control" name="tipo_proc_selec" placeholder="Tipo" style="display:none;">
                        <option value="" selected>Seleccionar Tipo</option>
                        <option value="ADJUDICACION SIMPLIFICADA">ADJUDICACION SIMPLIFICADA</option>
                        <option value="LICITACIÓN PÚBLICA">LICITACIÓN PÚBLICA</option>
                        <option value="CONCURSO PÚBLICO">CONCURSO PÚBLICO</option>
                        <option value="COMPARACION DE PRECIOS">COMPARACION DE PRECIOS</option>
                        <option value="CONTRATACIÓN DIRECTA">CONTRATACIÓN DIRECTA</option>
                        <option value="SELECCION DE CONSULTORES INDIVIDUALES">SELECCION DE CONSULTORES INDIVIDUALES</option>
                        <option value="SUBASTA INVERSA ELECTRONICA">SUBASTA INVERSA ELECTRONICA</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" id="num_proc_selec" name="num_proc_selec" placeholder="N° Procedimiento" style="display:none;">
                </div>
            </div>
            <!--ESTADO-->
            <div class="row">
                <div class="form-group col-md-3">
                    <input type="checkbox" id="chek_estado">
                    <label for="chek_estado">ESTADO</label> 
                </div>
                <div class="form-group col-md-2">
                    <select id="estado" class="form-control" name="estado" placeholder="Estado" style="display:none;">
                        <option value="" selected>Seleccionar Tipo</option>
                        <option value="A LA ESPERA DEL REQUERIMIENTO">A LA ESPERA DEL REQUERIMIENTO</option>
                        <option value="EN ACTOS PREPARATORIOS">EN ACTOS PREPARATORIOS</option>
                        <option value="CONVOVADO">CONVOVADO</option>
                        <option value="CADJUDICADO">CADJUDICADO</option>
                        <option value="DESIERTO">DESIERTO</option>
                        <option value="CANCELADO">CANCELADO</option>
                        <option value="NULO">NULO</option>
                        <option value="CONTRATADO">CONTRATADO</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <input type="date" class="form-control" id="estado_fecha" name="estado_fecha" placeholder="Fecha" style="display:none;">
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" id="estado_obs" name="estado_obs" placeholder="Observación" style="display:none;">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                <label for="valor_ref_est">VALOR REFERENCIAL/ESTIMADO</label>
                <div class="input-group">
                <div class="input-group-addon">S/</div>
                <input type="text" class="form-control" id="valor_ref_est" name="valor_ref_est" placeholder="0.00">
                </div>
                </div>
                <div class="form-group col-md-3">
                <label for="buena_pro_est_fecha">FECHA ESTIMADA BUENA PRO</label>
                <input type="date" class="form-control" id="buena_pro_est_fecha" name="buena_pro_est_fecha">
                </div>
                <div class="form-group col-md-3">
                <label for="buena_pro_fecha_real">FECHA REAL BUENA PRO</label>
                <input type="date" class="form-control" id="buena_pro_fecha_real" name="buena_pro_fecha_real">
                </div>
                <div class="form-group col-md-3">
                <label for="buena_pro_obs">OBSERVACION BUENA PRO</label>
                <input type="text" class="form-control" id="buena_pro_obs" name="buena_pro_obs">
                </div>
            </div> 
            <div class="row">
                <div class="form-group col-md-3">
                <label for="prov_adjudicado">PROVEEDOR ADJUDICADO</label>
                <input type="date" class="form-control" id="prov_adjudicado" name="prov_adjudicado">
                </div>
                <div class="form-group col-md-3">
                <label for="valor_adjudicado">VALOR ADJUDICADO</label>
                <div class="input-group">
                <div class="input-group-addon">S/</div>
                <input type="text" class="form-control" id="valor_adjudicado" name="valor_adjudicado" placeholder="0.00">
                </div>
                </div>
            </div>
            <br>            
            <div class="row text-center">
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-primary">GUARDAR</button>
                </div>
            </div>
        </form>
    </div>
<script >
    $(document).ready(function(){
        // REQUERIMIENTO
            $('#chek_requerimiento').iCheck({
                checkboxClass: 'icheckbox_flat-blue'
            });

            $('#chek_requerimiento').on('ifChecked', function(event){
                $('#requerimiento_documento').show();
                $('#requerimiento_fecha').show();
            });

            $('#chek_requerimiento').on('ifUnchecked', function(event){
                $('#requerimiento_documento').hide();
                $('#requerimiento_fecha').hide();
            });
        // CERTIFICACION
            $('#chek_certificacion').iCheck({
                checkboxClass: 'icheckbox_flat-blue'
            });

            $('#chek_certificacion').on('ifChecked', function(event){
                $('#certificacion_documento').show();
                $('#certificacion_fecha').show();
            });

            $('#chek_certificacion').on('ifUnchecked', function(event){
                $('#certificacion_documento').hide();
                $('#certificacion_fecha').hide();
            });
        // APROBACION DE EXPEDIENTE
            $('#chek_aprob_exp').iCheck({
                checkboxClass: 'icheckbox_flat-blue'
            });

            $('#chek_aprob_exp').on('ifChecked', function(event){
                $('#aprob_exp_documento').show();
                $('#aprob_exp_fecha').show();
            });

            $('#chek_aprob_exp').on('ifUnchecked', function(event){
                $('#aprob_exp_documento').hide();
                $('#aprob_exp_fecha').hide();
            });
        // COMITE DE SELECCION
            $('#chek_com_sel').iCheck({
                checkboxClass: 'icheckbox_flat-blue'
            });

            $('#chek_com_sel').on('ifChecked', function(event){
                $('#com_sel_documento').show();
                $('#com_sel_fecha').show();
                $('#com_sel_miembros').show();
            });

            $('#chek_com_sel').on('ifUnchecked', function(event){
                $('#com_sel_documento').hide();
                $('#com_sel_fecha').hide();
                $('#com_sel_miembros').hide();
            });
        // APROBACION DE BASES
            $('#chek_aprob_bases').iCheck({
                checkboxClass: 'icheckbox_flat-blue'
            });

            $('#chek_aprob_bases').on('ifChecked', function(event){
                $('#aprob_bases_documento').show();
                $('#aprob_bases_fecha').show();
            });

            $('#chek_aprob_bases').on('ifUnchecked', function(event){
                $('#aprob_bases_documento').hide();
                $('#aprob_bases_fecha').hide();
            });
        // PROCEDIMIENTOS DE SELECCION
            $('#chek_proc_selec').iCheck({
                checkboxClass: 'icheckbox_flat-blue'
            });

            $('#chek_proc_selec').on('ifChecked', function(event){
                $('#num_proc_selec').show();
                $('#tipo_proc_selec').show();
            });

            $('#chek_proc_selec').on('ifUnchecked', function(event){
                $('#num_proc_selec').hide();
                $('#tipo_proc_selec').hide();
            });
        // ESTADO
            $('#chek_estado').iCheck({
                checkboxClass: 'icheckbox_flat-blue'
            });

            $('#chek_estado').on('ifChecked', function(event){
                $('#estado').show();
                $('#estado_fecha').show();
                $('#estado_obs').show();
            });

            $('#chek_estado').on('ifUnchecked', function(event){
                $('#estado').hide();
                $('#estado_fecha').hide();
                $('#estado_obs').hide();
            });
        // GUARDAR
            guardar = function (){
                var formdata = $("#frm-procedimiento").serialize()
                console.log(formdata);
                $.ajax({
                    url: '{{ url("/procedimiento/guardarf") }}',
                    type: 'POST',
                    data: formdata,
                    cache : false,
                    processData: false,
                    beforeSend: function () {
                    },
                    success: function(response){
                    swal({
                        title: "Guardado",
                        text: response.messages + " Datos guardados.",
                        type: "success",
                        cancelButtonClass: 'btn btn-success',
                        cancelButtonText:'ok',
                        })
                    },
                    complete: function(response) {
                        $("#frm-procedimiento")[0].reset();
                    },
                    error: function(response){
                        swal({
                        title: "Verifique el tipo de dato de celda",
                        text: "Corregir celda con fondo color rojo",
                        type: "error",
                        cancelButtonClass: 'btn btn-danger',
                        cancelButtonText:'ok',
                        })
                    }
                });
            }
    });
</script>
@stop
