<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>

    <div style="display:none;">
        <audio id="audio" controls>
            <source type="audio/mp3" src="{{ asset('slow.mp3') }}">
            <!--source type="audio/mp3" src="{{ asset('descarada.mp3') }}"-->
            <!--source type="audio/mp3" src="{{ asset('gracia.mp3') }}"-->
        </audio>
    </div>

    <div id="msg"></div>
    
    <script type="text/javascript">


        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('9d1a2ccb96d401306265', {
          cluster: 'us2',
          encrypted: true
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            spawnNotification('Error de activación de windows','alert','Error');
        });


        function spawnNotification(theBody,theIcon,theTitle) {
          var options = {
              body: theBody,
              icon: theIcon,
              silent: false,
              vibrate: true
          }
          var n = new Notification(theTitle,options);
        }

        Notification.requestPermission().then(function(result) {
          console.log(result);
        });

    </script>
</body>
</html>


