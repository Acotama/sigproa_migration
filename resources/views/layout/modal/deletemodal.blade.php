	<!-- DELETE MODAL -->

	<!--script type="text/javascript">
		function showDeleteModal(delete_url)
		{
			// SHOWING AJAX PRELOADER IMAGE
			//jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="assets/images/preloader.gif" /></div>');

			// LOADING THE AJAX MODAL
			jQuery('#modal_delete').modal('show', {backdrop: 'true'});
			$("#delete_link").attr("href", delete_url);

		}
	</script-->

	<div class="modal fade" tabindex="-1" data-width="760" id="modal_delete" data-backdrop="static" data-keyboard="false">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">¿Está seguro de borrar la información?</h4>
				</div>
				<div id="m-message"></div>
				<div class="modal-body">
					<div class="alert alert-danger m-b-0">
						<h4><i class="fa fa-info-circle"></i> ¡La información borrada no puede ser restaurada!</h4>
					</div>
				</div>
				<div class="modal-footer">
					<a href="javascript:;" class="btn btn-sm btn-facebook" data-dismiss="modal">Close</a>
					<a href="#" id="delete_link" class="btn btn-sm btn-danger">borrar</a>
				</div>
			</div>
	</div>