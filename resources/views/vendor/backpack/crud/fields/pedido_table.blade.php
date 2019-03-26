<div @include('crud::inc.field_wrapper_attributes') >

    <label>{!! $field['label'] !!}</label>
	
	<div class="contact-container">
		<table id="products-new" class="table table-striped" width="100%"></table>
	</div>
	
	<div class="contact-container">
		<ul class="actions">
			<li>
				<a href="#" id="contact" class="btn btn-default" data-toggle="modal" data-target="#myModal">
					Agregar producto
				</a>
			</li>
		</ul>
	</div>

	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="js-title-step">Hola</h4>
				</div>
				<div class="modal-body">
					<div class="row" data-step="1" data-title="Selección de producto.">
						<h5 class="h5-instruction">Debe seleccionar un producto de la lista.</h5>
						<hr class="hr-instruction">
						<div class="has-table-products table-responsive">
							<table id="products" class="display table table-striped" width="100%"></table>
						</div>
					</div>
					<div class="row hide" data-step="2" data-title="Cantidad de producto.">
						<h5 class="h5-instruction">Debe ingresar la cantidad de producto.</h5>
						<hr class="hr-instruction">
						<div class="has-cantidad">
							<input name="cantidad_producto" type="number" value="0" class="cantidad_product">
							<button type="button" class="decrement-btn fa fa-minus"></button>
							<button type="button" class="increment-btn fa fa-plus"></button>
						</div>
					</div>
					<div class="row hide" data-step="3" data-title="Selección de precio.">
						<h5 class="h5-instruction">Debe seleccionar el precio del producto.</h5>
						<hr class="hr-instruction">
						<div class="has-select select" id="product1">	
							<div class="custom-control custom-radio">
								<input type="radio" data-precio="Price" class="custom-control-input" id="precio-0" name="groupOfDefaultRadios">
								<label id="label-0" class="custom-control-label" for="precio-0"></label>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" data-precio="PriceA" class="custom-control-input" id="precio-1" name="groupOfDefaultRadios">
								<label id="label-1" class="custom-control-label" for="precio-1"></label>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" data-precio="PriceB" class="custom-control-input" id="precio-2" name="groupOfDefaultRadios">
								<label id="label-2" class="custom-control-label" for="precio-2"></label>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" data-precio="PriceC" class="custom-control-input" id="precio-3" name="groupOfDefaultRadios">
								<label id="label-3" class="custom-control-label" for="precio-3"></label>
							</div>
							@if(backpack_auth()->user()->digitar_precio != 0)
								<div class="custom-control custom-radio">
									<input type="radio" data-precio="Custom" class="custom-control-input" id="precio-4" name="groupOfDefaultRadios">
									<label class="custom-control-label" for="precio-4">Digitar Precio</label>
								</div>
							@endif
							
							<input type="number" class="in-price" name="ingreso-precio" id="ingreso-precio" placeholder="Agregue el precio">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default js-btn-step pull-left" data-orientation="cancel" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-warning js-btn-step hide" id="btn-warning" data-orientation="previous">Anterior</button>
					<button type="button" class="btn btn-success js-btn-step" id="btn-success" data-orientation="next">Siguiente</button>
				</div>
			</div>
		</div>
	</div>
	
    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field))

    @push('crud_fields_styles')
		<link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.dataTables.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css">
    @endpush

    @push('crud_fields_scripts')
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.11/lodash.min.js"></script>
		<script src="{{ asset('js/modal-steps.min.js') }}"></script>
		<script>
			var productos_data = [];
			var productos_json = {};
			var linea_pedido_tmp = {};
						
			class Pedido{
				
				linea_pedido = [];
				
				agregar_linea(object){
					this.linea_pedido.push(object);
					this.dibujar_filas();
				}
				
				remover_linea(id){
					var indice = this.getObjectIndex(this.linea_pedido, "ID",id);
					this.linea_pedido.splice(indice, 1);
				}
				
				dibujar_filas(){
					var table = $('#products-new').DataTable();
					var total = 0;
					table.rows().remove().draw();
					$('input[name="total_pedido"]').val("");
					
					$(this.linea_pedido).each(function(key,val){
						table.row.add([val.ID,val.Description,val.QuantityPurchased,val.Price,'']).draw();
						total = total + val.QuantityPurchased * val.Price;
					});
					
					$('input[name="total_pedido"]').val(this.Moneda(total));
				}
				
				Moneda(total) {
					return total.toFixed(2);
				}
				
				getObjectIndex(arr, key, val){
					for (var i = 0; i < arr.length; i++) {
					  if (arr[i][key] == val){
						return i;	  
					  }	
					}
					return -1;
				}
			}
			
			var pedido = new Pedido(); 
						
/*====================================================================
   ------------------------- Tabla Pedido -------------------------   
====================================================================*/
			
			$(document).ready(function(){
				  var table = $('#products-new').DataTable( {
					scrollX:  true,
					scrollCollapse: true,
					paging:   false,
					ordering: false,
					info:     false,
					searching: false,
					columnDefs: [ {
						targets: -1,
						data: null,
						defaultContent: '<button id="btn-remFila" class="btn-eliminar fa fa-times" type="button"></button>',
					},
					{
						targets: [0],
						visible: false, 
						searchable: false,
					},
					{ 
						className: "precio-column",
						targets: [3], 
					}],
					columns: [
						{ title: "ID" },
						{ title: "Descripción" },
						{ title: "Qty" },
						{ title: "Precio" },
						{ title: "Acción" },
					],
					language: {
						"emptyTable":	"No hay datos disponibles",
					},
				});
				
				$('#products-new').on("click", "button", function () {
					
					var borrar_fila_seleccionada = table.row($(this).parents('tr'));
					var fila_para_borrar = table.row($(this).parents('tr')).data();
					var id_eliminar_producto = fila_para_borrar[0];
					
					pedido.remover_linea(id_eliminar_producto);
					borrar_fila_seleccionada.remove().draw(false);
				});
				
				$('#products-new tbody').on( 'click', 'tr', function () {
					if ( $(this).hasClass('selected') ) {
						$(this).removeClass('selected');
					}
					else {
						table.$('tr.selected').removeClass('selected');
						$(this).addClass('selected');
					}
				});
			});
			
			/* --- Funcionalidad de Modal --- */ 
			$('div.contact-container ul.actions li a').mousedown(function (){
				$('div.modal-header h4.js-title-step').html('Seleccione producto.');
				$('div.modal-footer button.btn-success').css({'background-color':'#f4f4f4','border-color':'#ddd','color':'#000'});
			});
			
			$(".modal-footer .btn-success").mousedown(function (){
				var step_activo = $(".modal-body").find("div.row").not(".hide").data("step");
				var panel_actual = $('.modal-body div.row').not('.hide');
				
				if(step_activo === 1){
					var item_seleccionado = $('#products tbody').find("tr.selected").length;
					
					if(item_seleccionado == 0){
						alert("Seleccione un producto.");
						return;
					}
					
					$('div.modal-header h4.js-title-step').html('Ingrese cantidad.');
				}
				
				if(step_activo === 2){
					var qty = parseFloat($(".cantidad_product").val()); 
					if(qty <= 0)
					{
						alert("La cantidad debe ser mayor a cero.");
						return;
					}
					else{
						linea_pedido_tmp.QuantityPurchased = qty;
					}
					$('div.modal-header h4.js-title-step').html('Seleccione precio.');
					$('div.modal-footer button.btn-success').css({'background-color':'#00a65a','border-color':'#008d4c','color':'#fff'});
				}
				
				if(step_activo === 3){
					if($('#precio-4').prop("checked")){
						var precio_digitado = parseFloat($("#ingreso-precio").val()).toFixed(2);
						linea_pedido_tmp.Price = precio_digitado;
					}
				}
				
				nextPanel(panel_actual, step_activo);
			});
			
			$(".modal-footer .btn-default").click(function (){	
				resetModal();
			});
			
			$(".modal-footer .btn-warning").mousedown(function (evt){
				var step_activo = $(".modal-body").find("div.row").not(".hide").data("step");
				var panel_actual = $('.modal-body div.row').not('.hide');
				
				prevPanel(panel_actual, step_activo);
			});
			
			function nextPanel(panel_actual, step){
				if(step != 3)
				{	
					panel_actual.addClass('hide');
					panel_actual.next().removeClass('hide');
					if(step === 1){
						$('.modal-footer .btn-warning').removeClass('hide');
					}
					if(step === 2){
						$('.modal-footer .btn-success').html('Finalizar');
					}
				}
				else
				{	
					pedido.agregar_linea(linea_pedido_tmp);
					resetModal();
					$('div#myModal').modal('hide');
				}
			}
			
			function prevPanel(panel_actual, step)
			{
				if(step != 1)
				{
					panel_actual.addClass('hide');
					panel_actual.prev().removeClass('hide');
					if(step === 3){
						clearFieldStep();
						$('.modal-footer .btn-success').html('Siguiente');
						$('div.modal-header h4.js-title-step').html('Ingrese cantidad.');
						$('div.modal-footer button.btn-warning').css({'background-color':'#f4f4f4','border-color':'#ddd','color':'#000'});
						$('div.modal-footer button.btn-success').css({'background-color':'#f4f4f4','border-color':'#ddd','color':'#000'});
					}
					if(step === 2){
						$('.cantidad_product').val("0");
						$('.modal-footer .btn-warning').addClass('hide');
						$('div.modal-header h4.js-title-step').html('Seleccione producto.');
						$('div.modal-footer button.btn-success').css({'background-color':'#f4f4f4','border-color':'#ddd','color':'#000'});
					}
				}
			}
			
			function resetModal(){
				linea_pedido_tmp = {};
		
				setTimeout(function(){
					$(".modal-body").find("div.row").not(".hide").addClass("hide");
					$(".modal-body").find("div.row").first().removeClass("hide");
					$("div.has-table-products input").val("");
	
					$('.modal-footer .btn-success').html('Siguiente');
					$('.modal-footer .btn-warning').addClass('hide');
					
					//1. Limpiar el selected de la tabla de productos.
					$("table#products tbody tr.selected").removeClass("selected");
					
					//2. Establecer en 0 la cantidad
					$('.cantidad_product').val("0");
					
					//3. Quitar la seleccion de los radios, limpiar el text input y ocultarlo.
					clearFieldStep();
					
				}, 500);
			}
			
			function clearFieldStep(){
				$('.custom-control-input').each(function(){
					$(this).prop('checked',false);   
				});
	
				$('#ingreso-precio').val("");
				$('#ingreso-precio').hide();				
			}
				
			$(document).ready(function(){
				$("#search").on("keyup", function(){
					var value = $(this).val().toLowerCase();					
					$("#products tr").filter(function() {	
						$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
					});
				});
				
				$("#ingreso-precio").hide();
			
				$(".custom-control-input").change(function () {
					
					var radio_seleccionado = $(this).data('precio');
					
					if(radio_seleccionado === "Price" || radio_seleccionado === "PriceA" || radio_seleccionado === "PriceB" || radio_seleccionado === "PriceC"){
						var ID = linea_pedido_tmp.ID;
						var producto_seleccionado = _.find(productos_json, ["ID", ID]);						
						linea_pedido_tmp.Price = parseFloat(producto_seleccionado[radio_seleccionado]).toFixed(2);
					}
						
					if($('#precio-4').prop("checked")){
						$('#ingreso-precio').show();
					}else {
						$('#ingreso-precio').val("");
						$('#ingreso-precio').hide();	
					}
				});
			});
			
			var $incrementar = $('.increment-btn');
			var $disminuir = $('.decrement-btn');
			var $cantidad = $('.cantidad_product');

			$incrementar.click(function(){
				$cantidad.val( parseInt($cantidad.val()) + 1 );
			});
			
			$disminuir.click(function(){
				if($cantidad.val() > 0){
					$cantidad.val( parseInt($cantidad.val()) - 1 );
				}
			});		
			
			$.getJSON( "/admin/producto/todos", function(productos){
				productos_json = productos;
				var rows_selected = [];
				
				$.each(productos, function(key, val){
					var producto = ["",val.ID, val.Description, val.ItemLookupCode];
					productos_data.push(producto);
				});
				
				$('#products').DataTable({
					scrollY:  "40vh",
					scrollCollapse: true,
					paging:   false,
					ordering: false,
					info:     false,
					data: productos_data,
					columns: [
						{ title: "" },
						{ title: "ID" },
						{ title: "Descripción" },
						{ title: "Código" },
					],
					columnDefs: [{
						orderable: false,
						searchable: false,
						className: 'select-checkbox',
						targets:  [0],
					},{
						targets: [1],
						visible: false, 
						searchable: false,
					},
					],
					select: {
						style:    'os',
						selector: 'td:first-child'
					},
					language: {
						"search":     	"Buscar:",
						"zeroRecords":	"Ninguna coincidencia",
					},					
				});
				
				$(".select-checkbox").mouseup(function(){
					if($(this).parent().hasClass('selected')){
						linea_pedido_tmp = {};
					}
					else{
						var codigo = $(this).next().next().text();
						var seleccionado = _.find(productos_json, ["ItemLookupCode", codigo]);
						linea_pedido_tmp.ID = seleccionado.ID;
						linea_pedido_tmp.Description = seleccionado.Description;
						$('#label-0').html('Precio Principal - '+ parseFloat(seleccionado.Price).toFixed(2));
						$('#label-1').html('Precio A - '+ parseFloat(seleccionado.PriceA).toFixed(2));
						$('#label-2').html('Precio B - '+ parseFloat(seleccionado.PriceB).toFixed(2));	
						$('#label-3').html('Precio C - '+ parseFloat(seleccionado.PriceC).toFixed(2));	
					}
				});
			});	
		</script>
    @endpush
@endif