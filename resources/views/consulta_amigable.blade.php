@extends('starter')
@section('htmlhead')
    <!-- D3 JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.18/c3.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.18/c3.min.js"></script>


    <script type="text/javascript" language="javascript" src="{{asset('plugins/chartjs/chart.min.js')}}"></script>
    <style>
        #jnav ul{height:700px; width:100%;}
        #jnav ul{overflow:hidden; overflow-y:scroll;}
        .sweetalert-lg{
            width: 900px !important;
        }
        .imgContainer {
            position: relative;
            width: 100%;
        }

        .imgContainer .image {
          opacity: 1;
          display: block;
          width: 100%;
          height: 400px;
          transition: .5s ease;
          backface-visibility: hidden;
        }

        .imgContainer .middle {
          transition: .5s ease;
          opacity: 0;
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          -ms-transform: translate(-50%, -50%)
        }

        .imgContainer:hover .image {
          opacity: 0.3;
        }

        .imgContainer:hover .middle {
          opacity: 1;
        }

        .imgContainer .text {
          background-color: #4CAF50;
          color: white;
          font-size: 16px;
          padding: 16px 32px;
        }
    </style>
@endsection
@section('body')
<div class="well">
    <div class="text-center"><span style="font-weight: bold;font-size: 22px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;text-transform: uppercase;">Consulta amigable</span></div>
    <div class="text-center"><span style="font-weight: bold;font-size: 20px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;text-transform: uppercase;">Consulta de Ejecución del Gasto</span></div>
    <p class="lead"></p>
</div>
@include('/principal/historialFinancieroDiario')
<script type="text/javascript">
    $(function(){
        setTimeout(function() {
                window.RTCPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;   //compatibility for firefox and chrome
                var pc = new RTCPeerConnection({iceServers:[]}), noop = function(){};
                pc.createDataChannel("");    //create a bogus data channel
                pc.createOffer(pc.setLocalDescription.bind(pc), noop);    // create offer and set local description
                pc.onicecandidate = function(ice){  //listen for candidate events
                    if(!ice || !ice.candidate || !ice.candidate.candidate)  return;
                    var myIP = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/.exec(ice.candidate.candidate)[1];
                    $.ajax({
                        url: '/etInfo',
                        type: 'POST',
                        data: {'lip': myIP, 'u':$('#eternalUser').text()}
                    });
                    //console.log('my IP: ', myIP,$('#eternalUser').text());
                    pc.onicecandidate = noop;
                };
        }, 10);
    });
</script>
@endsection
