<script>
    if (Boolean(localStorage.getItem("sidebar-toggle-collapsed"))) {
        $("body").addClass('sidebar-collapse')
    }

    $('.sidebar-toggle').click(function() {
        console.log("click");
        event.preventDefault();
        if (Boolean(localStorage.getItem("sidebar-toggle-collapsed"))) {
            localStorage.setItem("sidebar-toggle-collapsed", "");
        } else {
            localStorage.setItem("sidebar-toggle-collapsed", "1");
        }
    });
</script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('plugins/fastclick/fastclick.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/app.min.js') }}"></script>
<!-- SlimScroll 1.3.0 -->
<script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- ChartJS 1.0.1 >
<script src="{{ asset('plugins/chartjs/Chart.min.js') }}"></script-->

<script src="{{ asset('dist/js/demo.min.js') }}"></script>

<!-- BootStrap MODAL PLUGIN -->
<script src="{{ asset('plugins/bootstrap-addon/js/bootstrap-modal.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-addon/js/bootstrap-modalmanager.min.js') }}"></script>

<!-- SWEET ALERT -->
<script src="{{ asset('plugins/sweetalert/sweetalert2.min.js') }}"></script>

<!-- FANCYBOX -->
<script type="text/javascript" src="{{asset('plugins/fancybox/source/jquery.fancybox.pack.js')}}"></script>

<!-- INTRO JS -->
<script type="text/javascript" language="javascript" src="{{asset('plugins/introjs/intro.min.js')}}"></script>

<!-- SELECT2 -->
<script type="text/javascript" language="javascript" src="{{asset('plugins/select2/select2.full.min.js')}}"></script>

<!-- PICK A DATE -->
<script type="text/javascript" src="{{ asset('/plugins/pickadate/compressed/picker.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/pickadate/compressed/picker.date.js') }}"></script>

<script type="text/javascript" src="{{asset('plugins/jquery-validate/jquery-validate.min.js')}}" ></script>
<!-- JQUERY VALIDATE > 
<script type="text/javascript" src="{{asset('plugins/jquery-validate/jquery-validate.min.js')}}" ></script-->
<!-- JqGRID >
<script type="text/javascript" language="javascript" src="{{asset('plugins/jqgrid/jquery.jqgrid.min.js')}}"></script>
<script type="text/javascript" language="javascript" src="{{asset('plugins/jqgrid/plugins/ui.multiselect.js')}}"></script>
<script type="text/javascript" language="javascript" src="{{asset('plugins/jqgrid/plugins/jquery.contextmenu.js')}}"></script-->
<!--script type="text/javascript" language="javascript" src="{{asset('plugins/jqgrid/jquery.jqgrid.src.js')}}"></script-->
<!--script type="text/javascript" src="{{ asset('plugins/jquery-tree/js/jquery.tree.js') }}"></script-->

@if (Auth::user())
  <script>
    $(function() {

      $.ajax({
          url: '{{ url("/actualizar") }}',
          method: 'POST',
          data: {url : $(location).attr('pathname')},
          tryCount : 0,
          retryLimit : 3,
          beforeSend: function () {
          },
          success: function(response){
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
              if(XMLHttpRequest.status == 400){
                  console.log("Error de Transaccion");
              }                           
          }
      });

      setInterval(function checkSession() {
        $.get('/check-session', function(data) {
          // if session was expired
          if (data.guest) {
            // redirect to login page
            //location.assign('/');

            // or, may be better, just reload page
            location.reload();
          }
          else {
            console.log('online');
          }
        }).fail(function() {
            location.reload();
          });
      }, 60000); // every minute

      /*var slowLoad = window.setTimeout( function() {
          alert( "Conección a internet lenta Detectada" );
      }, 20 );

      document.addEventListener( 'load', function() {
          window.clearTimeout( slowLoad );
      }, false );*/


    });

    $(document).ready(function () {
        $('body').fadeIn(500).removeClass('hide');
        $('.datepicker').on('mousedown',function(event){ event.preventDefault(); });
    });
  </script>
  <!--script>
            $(window).load(function(){
                $('#dvLoading').fadeOut(2000);
            });
  </script-->
@endif


@yield('script')


<!--script type="text/javascript" async="async" defer="defer" data-cfasync="false" src="https://mylivechat.com/chatinline.aspx?hccid=33014054"></script-->
