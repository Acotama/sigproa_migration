@extends('starter')
@section('htmlhead')

    <!-- JqueryUI -->
    <link rel="stylesheet" href="{{ asset('librerias/jquery-ui/themes/redmond/jquery-ui.min.css') }}">
    <!-- DROPZONE -->
    <link rel="stylesheet" href="{{ asset('librerias/dropzone/dropzone.min.css') }}">

    <link href="{{asset('plugins/multiselect/css/multi-select.css')}}" media="screen" rel="stylesheet" type="text/css">
    <script src="{{asset('plugins/multiselect/js/jquery.multi-select.js')}}" type="text/javascript"></script>
    <script src="{{asset('plugins/quicksearch/jquery.quicksearch.js')}}" type="text/javascript"></script>
<style>
.dt-button{
background-color: red !important;
}
.buttons-print {
  background-image: linear-gradient(to bottom, #e9e9e9 0%, #e9e9e9 100%) !important;
  color: black !important;
}
.buttons-excel {
    background-image: linear-gradient(to bottom, #e9e9e9 0%, #e9e9e9 100%) !important;
    background-color: blue !important;
    color: black !important;
}
.dtcolunm-search{
    padding: 0 !important;
    background-color: #f8fff9;
}

.table-stripedd>tbody>tr:nth-child(odd)>td,
.table-stripedd>tbody>tr:nth-child(odd)>th {
        background-color: rgb(181, 212, 230);
}

.table-hoverr tbody tr:hover td, .table-hoverr tbody tr:hover th {
    background-color: rgba(38, 255, 47, 0.11);
}

    .custon {
        width: 300px;
    }

#grl_pip_total_priori-table thead tr th{
    text-align: center;
    vertical-align: middle;
}

.sortable { list-style-type: none; margin: 0; padding: 0; width: 100%;font-size: 9px }
.sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 40px; }
.sortable li span { position: absolute; margin-left: -1.3em; }
</style>
@endsection
@section('body')

    <div class="col-md-12 main">
        <div class="row">
            <div class="container-fluid">
                <div class="row">
                    <h2 style="font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif"><center><b>EXPORTAR PROYECTOS DE INVERSIÓN PÚBLICA</b></center></h2>
                </div>
                <br>
                <div class="row"><h3>Seleccione el orden e información que desea exportar.</h3></div>
                <br>
            </div>
        </div>

        {{ Form::open(array('route' => 'rptExportarPrev')) }}
        <div class="row">
            <?php $parts = array_chunk($options['columns'],6,true);
            $selected = [
                    'nom_proyec',
                    'cod_snip',
                    'cod_unif',
                    'u_formul',
                    'u_ejec',
                    'ger_direc',
                    'sector',
                    'progr',
                    'sub_progr',
                    'm_pip',
                    'm_viab',
                    'm_exptec',
                    'etapa',
                    'sub_etapa',
                    'est_pry',
                    'situa_pro',
                    'f_etapsub',
                    'cant_meta',
                    'meta_actual',
                    'm_pim',
                    'm_pim_acu',
                    'm_deveng',
                    'm_deveng_a',
                    'f_deveng_a',
                    'f_adjudica',
                    'm_ejec',
                    'nro_contrato',
                    'f_i_obra',
                    'f_f_obra',
                    't_ejec_dia',
                    'a_fisico',
                    'f_afisico',
                    'a_financ',
                    'anio_ini_pry',
                    'anio_pic']
                    ?>
            <div class="col-md-2">
                <ul class="sortable">
                    @foreach($parts[0] as $key => $col)
                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><label><input @if(in_array($key,$selected)) checked="checked" @endif class="columns" type="checkbox" value="{{$key}}" name="columns[]"/> {{utf8_encode($col)}}</label> </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-3 col-lg-2">
                <ul class="sortable">
                    @foreach($parts[1] as $key => $col)
                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><label><input @if(in_array($key,$selected)) checked="checked" @endif class="columns" type="checkbox" value="{{$key}}" name="columns[]" /> {{utf8_encode($col)}}</label> </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-3 col-lg-2">
                <ul class="sortable">
                    @foreach($parts[2] as $key => $col)
                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><label><input @if(in_array($key,$selected)) checked="checked" @endif class="columns" type="checkbox" value="{{$key}}" name="columns[]" /> {{utf8_encode($col)}}</label> </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-3 col-lg-2">
                <ul class="sortable">
                    @foreach($parts[3] as $key => $col)
                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><label><input @if(in_array($key,$selected)) checked="checked" @endif class="columns" type="checkbox" value="{{$key}}" name="columns[]" /> {{utf8_encode($col)}}</label> </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-3 col-lg-2">
                <ul class="sortable">
                    @foreach($parts[4] as $key => $col)
                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><label><input @if(in_array($key,$selected)) checked="checked" @endif class="columns" type="checkbox" value="{{$key}}" name="columns[]" /> {{utf8_encode($col)}}</label> </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-3 col-lg-2">
                <ul class="sortable">
                    @foreach($parts[5] as $key => $col)
                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><label><input @if(in_array($key,$selected)) checked="checked" @endif class="columns" type="checkbox" value="{{$key}}" name="columns[]" /> {{utf8_encode($col)}}</label> </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <!--div class="col-md-6">
                <div>Parametros</div>
                <select id='optgroup' multiple='multiple' name="options[]">
                    @foreach($selections as $key =>$opt)
                        <optgroup label={{$key}}>
                            @foreach($opt as $item)
                                <option value='{{$key}}-{{$item}}'>{{$item}}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div-->
            <br>
            <br>
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary"><i class="fa fa-pdf"></i>Exportar a excel</button>
            </div>
        </div>
        {{ Form::close() }}
    </div>


    <!-- JQUERY UI -->
    <script src="{{ asset('librerias/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- DROPZONE -->
    <script src="{{ asset('/librerias/dropzone/dropzone.js') }}"></script>

<script>


$(function(){

    $( ".sortable" ).sortable({connectWith: ".sortable"});
        $( ".sortable" ).disableSelection();

    generate = function(t) {

        //COLUMNS
        var columns=[];
        $('input[name="columns[]"]')
        .each(function () {
                    that = this;
                if(this.checked){
                    columns.push($(this).val());
              }
        });
        //OPTIONS
        var options = $("#optgroup").val();



        $.ajax({
            url: '{{route('rptExportarPrev')}}',
            type: 'POST',
            data: {columns:columns,options:options,tipo:'piptotalpriori',format:t},
            success: function (data)
            {

            }
        });
    };

    $('#optgroup').multiSelect({
        selectableOptgroup: true,
        selectableHeader: "<input type='text' class='search-input form-control' autocomplete='on' placeholder='Buscar'>",
        selectionHeader: "<input type='text' class='search-input form-control' autocomplete='on' placeholder='Buscar'>",
        cssClass:"custom",
        afterInit: function(ms){
            var that = this,
                    $selectableSearch = that.$selectableUl.prev(),
                    $selectionSearch = that.$selectionUl.prev(),
                    selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                    selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

            that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                    .on('keydown', function(e){
                        if (e.which === 40){
                            that.$selectableUl.focus();
                            return false;
                        }
                    });

            that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                    .on('keydown', function(e){
                        if (e.which == 40){
                            that.$selectionUl.focus();
                            return false;
                        }
                    });
        },
        afterSelect: function(){
            this.qs1.cache();
            this.qs2.cache();
        },
        afterDeselect: function(){
            this.qs1.cache();
            this.qs2.cache();
        }
    });
});

</script>


@endsection

@section('script')

@endsection
