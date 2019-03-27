@php

	$lineas_json = "[]";
	$cliente = '{"custom_text_2":"", "disponible":0.0, "first_name":""}';
	
	if(isset($id))
	{
		$pedido = $crud->model::find($id);
		$lineas = $pedido->transactionholdentries()->get()->toJson(JSON_PRETTY_PRINT);
		
		$lineas_json = $lineas;
		
		$customer = "App\Models\Customer"::find($pedido->CustomerID);
		$cliente = '{"custom_text_2":"' . $customer->CustomText2 . '", "disponible":' . $customer->saldo() . ', "first_name":"' . $customer->FirstName . '"}';
		
	}
	
@endphp

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
					<h4 class="js-title-step"></h4>
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
							
							<div class="left-inner-addon">
								<span class="hide">L.</span>
								<input type="number" class="in-price" name="ingreso-precio" id="ingreso-precio" placeholder="Agregue el precio">
							</div>
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

		<script>
			var productos_data = [];
			var productos_json = {};
			var linea_pedido_tmp = {};
			var cliente = {!! $cliente !!};
			var modal_datatable = false;
						
			class Pedido{
				
				linea_pedido = [];
				forma_pago = "";
				
				agregar_linea = function(object){
					this.linea_pedido.push(object);
					this.dibujar_filas();
					
					this.order_changed();
				};
				
				remover_linea = function(id){
					var indice = this.getObjectIndex(this.linea_pedido, "ID",id);
					this.linea_pedido.splice(indice, 1);
					
					this.order_changed();
				};
				
				dibujar_filas = function(){
					var table = $('#products-new').DataTable();
					var total = 0;
					table.rows().remove().draw();
					$('input[name="total_pedido"]').val("");
					
					$(this.linea_pedido).each(function(key,val){
						table.row.add([val.ID,val.Description,val.QuantityPurchased,'L. '+val.Price,'']).draw();
						total = total + val.QuantityPurchased * val.Price;
					});
					
					$('input[name="total_pedido"]').val(this.Moneda(total));
				};
				
				order_changed = function(){
					this.set_orderlines();
					this.reset_total_final(this.linea_pedido);
				};
				
				set_orderlines = function(){
					this.remove_orderlines();
					
					$.each(this.linea_pedido, function(index, linea){
						var id = $("<input>").attr("type", "hidden").attr("name","productos["+index+"][item_id]").val(linea.ID).addClass("attached-orderlines");
						var description = $("<input>").attr("type", "hidden").attr("name","productos["+index+"][item_description]").val(linea.Description).addClass("attached-orderlines");
						var qty = $("<input>").attr("type", "hidden").attr("name","productos["+index+"][item_qty]").val(linea.QuantityPurchased).addClass("attached-orderlines");
						var price = $("<input>").attr("type", "hidden").attr("name","productos["+index+"][item_price]").val(linea.Price).addClass("attached-orderlines");
						
						$('form').append($(id));
						$('form').append($(description));
						$('form').append($(qty));
						$('form').append($(price));
					});
				};
				
				remove_orderlines = function(){
					$(".attached-orderlines").remove();
				}
				
				reset_total_final = function(){
					var table = $('#products-new').DataTable();
					var total = 0;
					
					$('input[name="total_pedido"]').val("");
					
					$(this.linea_pedido).each(function(key,val){
						total = total + val.QuantityPurchased * val.Price;
					});
					
					$('input[name="total_pedido"]').val(this.Moneda(total));
				}
				
				reset_comment = function(){
					$(".hold-comment-input").remove();
					
					var comment_string = cliente.custom_text_2 + "/" + cliente.first_name + "/" + pedido.forma_pago;
					var comment = $("<input>").attr("type", "hidden").attr("name","HoldComment").val(comment_string.toUpperCase()).addClass("hold-comment-input");
					$('form').append($(comment));
				};
				
				Moneda = function(total) {
					if (!total || total == 'NaN') return '0.00';
					
					if (total == 'Infinity') return '&#x221e;';
					total = total.toString().replace(/\$|\,/g, '');
					
					if (isNaN(total))
					total = "0";
						
					var sign = (total == (total = Math.abs(total)));
					total = Math.floor(total * 100 + 0.50000000001);
					var cents = total % 100;
					total = Math.floor(total / 100).toString();
					
					if (cents < 10)
					cents = "0" + cents;
					
					for (var i = 0; i < Math.floor((total.length - (1 + i)) / 3) ; i++)
					total = total.substring(0, total.length - (4 * i + 3)) + ',' + total.substring(total.length - (4 * i + 3));
					
					return (((sign) ? '' : '-') + total + '.' + cents);
				};
				
				getObjectIndex = function(arr, key, val){
					for (var i = 0; i < arr.length; i++) {
					  if (arr[i][key] == val){
						return i;	  
					  }	
					}
					return -1;
				};
			}

			var pedido = new Pedido();
			pedido.linea_pedido = {!! $lineas_json !!}; 
			
			$('select[name=CustomerID]').change(function () {
				var id = $( this ).val();
				
				$.getJSON( "/admin/cliente/saldo/"+id, function(data) {
					cliente = data[0];
					var dato = format(data[0].disponible);
					$("#response").text(dato);
					
					pedido.reset_comment();
				});
				
			});

			$(".control-input-pago").change(function () {
				var radio_seleccion = $(this).data('pago');
				var forma_pago = $("input.control-input-pago:checked").data('pago');
				
				pedido.forma_pago = forma_pago;
				pedido.reset_comment();
				
				if(radio_seleccion === 'credito'){
					$('div.smart-button-container').removeClass('oculto');
				}else{
					$('div.smart-button-container').addClass('oculto');
				}
			});
			
			function format(num){
				if (!num || num == 'NaN') return '0.00';
				
				if (num == 'Infinity') return '&#x221e;';
				num = num.toString().replace(/\$|\,/g, '');
				
				if (isNaN(num))
				num = "0";
					
				var sign = (num == (num = Math.abs(num)));
				num = Math.floor(num * 100 + 0.50000000001);
				var cents = num % 100;
				num = Math.floor(num / 100).toString();
				
				if (cents < 10)
				cents = "0" + cents;
				
				for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3) ; i++)
				num = num.substring(0, num.length - (4 * i + 3)) + ',' + num.substring(num.length - (4 * i + 3));
				
				return (((sign) ? '' : '-') + num + '.' + cents);
			};
						
/*====================================================================
   ------------------------- Tabla Pedido -------------------------   
====================================================================*/
			
			$(document).ready(function(){
				
				var salesRepID = $("<input>").attr("type", "hidden").attr("name","SalesRepID").val({{ Backpack_auth()->user()->SalesRep_id }});
				if(salesRepID != ''){
					$('form').append($(salesRepID));
				}else{
					alert('No tiene un vendedor asignado a su usuario.');
					window.location.href = '/admin/dashboard';
				}
				
				
				pedido.forma_pago = $("input.control-input-pago:checked").data('pago');
					
				var table = $('#products-new').removeAttr('width').DataTable({
					scrollX:  true,
					scrollCollapse: true,
					paging:   false,
					ordering: false,
					info:     false,
					searching: false,
					responsive: true,
					fixedHeader: true,
					columnDefs: [{
						targets: -1,
						data: null,
						defaultContent: '<button id="btn-remFila" class="btn-eliminar fa fa-trash" type="button"></button>',
					},
					{
						targets: [0],
						visible: false, 
						searchable: false,
					},
					{ 
						width: "60%",
						targets: [1], 
						className: "text-center",
					},
					{ 
						width: "5%",
						targets: [2], 
						className: "text-center",
					},
					{ 
						width: "30%",
						targets: [3],
						className: "precio-column text-center",						
					},
					{ 
						width: "5%",
						targets: [4],
						className: "text-center",
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
				
				pedido.dibujar_filas();
				pedido.order_changed();
				pedido.reset_comment();
				
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
				modal_datatable.search("").draw();
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
					var digit_price = $('#ingreso-precio').val();
					
					if($('#precio-4').prop("checked")){
						
						if(digit_price != ""){
							var precio_digitado = parseFloat(digit_price).toFixed(2);
							linea_pedido_tmp.Price = precio_digitado;
						}else{
							alert('Debe agregar el precio.');
							return;
						}
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
			
			function prevPanel(panel_actual, step){
				
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
						$('.left-inner-addon span').addClass('hide');
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
					
					$("table#products tbody tr.selected").removeClass("selected");
					
					$('.cantidad_product').val("0");
		
					clearFieldStep();
					
				}, 500);
			}
			
			function clearFieldStep(){
				$('.custom-control-input').each(function(){
					$(this).prop('checked',false);   
				});
				
				$('.left-inner-addon span').addClass('hide');
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
						$('.left-inner-addon span').removeClass('hide');
						$('.left-inner-addon span').css('margin-top','20px');
					}else {
						$('.left-inner-addon span').addClass('hide');
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
				
				modal_datatable = $('#products').DataTable({
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