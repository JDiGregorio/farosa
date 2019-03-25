<a class="btn btn-default reload-permissions">Refrescar Permisos</a>

@push('crud_list_scripts')
	<script type="text/javascript">
		jQuery(document).ready(function($){
		  $("a.reload-permissions").click(function(){
			$(function() {
				$.ajax({
					type: "GET",
					url: "crear-permisos",
					success: function(data) {
						new PNotify({
								title: 'Proceso ejecutado',
								text: 'Se refrescaron los permisos correctamente',
								type: "success"
							});
					},
					error: function(xhr, status) {
						new PNotify({
								title: 'Proceso fracaso',
								text: 'Proceso no se pudo ejecutar correctamente',
								type: "error"
							});
					}
				});
			});
		  });
		});
		
	</script>
@endpush