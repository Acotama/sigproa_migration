@extends('starter')
@section('htmlhead')

@endsection
@section('body')
<style>
      img.centered {
        margin: auto !important;
        padding-bottom: 10px;
        color: transparent !important;
        width: 22px;
        height: 22px;
        display: flex;
        align-items: center;
        font-size: 12px;
        position: relative;
        bottom: 4px;
        left: 6px;
    }

    button {
      border: 2px solid #0598df;
      background: #fff;
      color: #0598df;
      text-transform: uppercase;
      cursor: pointer;
      margin: 5px 0;
      display: inline-block;
      -webkit-transition: all .3s;
      transition: all .3s;
      font-weight: normal;
      padding: 10px 10px;
      font-size: 14px;
    }

    button:hover {
      background: #0598df;
      color: #fff;
    }

    button:focus {
      outline: none;
    }
</style>
<!-- <button class="btn-customize" onclick="loadReport()">Customize cells</button> -->

<!-- <button onclick="saveReport()">Datos</button> -->
<!-- <button onclick="exportData('excel')">Datos</button> -->

<form action="/procedimiento/guardar" method="post" enctype="multipart/form-data">
    <input type="file" name="archivo">
    <input type="submit" value="Importar">
</form>
<h4>{{isset($msg)?$msg:'' }}</h4>

@stop
