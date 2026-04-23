	<!-- LARGE MODAL -->

	<!--script type="text/javascript">
		function showMessageModal(url)
		{
			// SHOWING AJAX PRELOADER IMAGE
			//jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="assets/images/preloader.gif" /></div>');

			// LOADING THE AJAX MODAL
			jQuery('#modal-message').modal('show', {backdrop: 'true'});

			// SHOW AJAX RESPONSE ON REQUEST SUCCESS
			$.ajax({
				url: url,
				success: function(response)
				{
					jQuery('#modal-message .modal-body').html(response);
				}
			});
		}
	</--script-->

{{--<div class="modal fade modal-wide" id="modal_wide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">--}}
	{{--<div class="modal-dialog" style="width: 80%">--}}
		{{--<div class="modal-content">--}}
			{{--<div class="modal-header">--}}
				{{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
				{{--<h4 id="myModalLabel" class="modal-title">--}}
					{{--<!-- TITULO -->--}}
				{{--</h4>--}}
			{{--</div>--}}
			{{--<div class="modal-body text-center">--}}
					{{--<!-- CUERPO -->--}}
			{{--</div>--}}
			{{--<div class="modal-footer">--}}
					{{--<!-- PIE -->--}}
			{{--</div>--}}
		{{--</div><!-- /.modal-content -->--}}
	{{--</div><!-- /.modal-dialog -->--}}
{{--</div><!-- /.modal -->--}}

<div id="modal_wide_pry" class="modal container fade" tabindex="-1" data-focus-on="input:first" data-backdrop="static" data-keyboard="false">
	<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Full Width</h4>
			  </div>
			  <div class="m-message"></div>
			  <div class="modal-body">

			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			  </div>
	</div>
</div>
