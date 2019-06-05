@extends('backpack::layout')

@section('content')
<div class="box">	
	<div class="box-body">
		<div class="row">
			<div class="contenedor col-lg-12">
				<form class="cd-form floating-labels">
					<fieldset>
						<legend>{{ $cliente }}</legend>
						<label class="label-title" data-tipo="{{ $tipo_pago }}">Forma de pago: {{ $tipo_pago }}</label>
						
						<div id="disponible" class="icon left-inner-addon oculto">
							<label class="cd-label" for="cd-acount">Credito disponible:</label>
							<span>L.</span>
							<input class="input-dinero" type="text" name="cd-acount" id="cd-acount" value="{{ $disponible }}" readonly>
						</div>
						
						<div class="icon table-responsive">
							<label class="cd-label" for="cd-email">Productos:</label>
							<table class="table table-bordered products">
								<thead>
									<tr>
										<th style="font-size: 1.4rem;padding: 10px 5px;">Descripción</th>
										<th style="font-size: 1.4rem;padding: 10px 5px;">Qty</th>
										<th style="font-size: 1.4rem;padding: 10px 5px;text-align: center;">Precio</th>
									</tr>
								</thead>
								<tbody>
									@foreach($productos as $producto)
										<tr>
											<td style="font-size: 1.4rem;">
												{{ $producto->Description }}
											</td>
											<td style="font-size: 1.4rem;text-align: center;">
												{{ number_format($producto->QuantityPurchased) }}
											</td> 
											<td style="font-size: 1.4rem;text-align: right;">
												L. {{ number_format($producto->FullPrice,2,'.','') }}
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						
						<div class="icon left-inner-addon">
							<label class="cd-label" for="cd-acount">Total:</label>
							<span>L.</span>
							<input class="input-dinero" type="text" name="cd-acount" id="cd-acount" value="{{ number_format($total, 2, '.', ',') }}" readonly>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection


@section('after_styles')
	<link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
	<link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/show.css') }}">
@endsection

@section('after_scripts')
	<script src="{{ asset('vendor/backpack/crud/js/crud.js') }}"></script>
	<script src="{{ asset('vendor/backpack/crud/js/show.js') }}"></script>
@endsection

@push('scripts')
	<script>
		var tipo_pago = $(".label-title").data('tipo');
		
		if(tipo_pago === "CREDITO"){
			$("div#disponible").removeClass('oculto');
		}else{
			$("div#disponible").addClass('oculto');
		}
		
		$('table.products').css('border','1px solid #ccc');
		
		var link = '<?php echo redirect()->getUrlGenerator()->previous();?>';
		
		$('a.return').css('display','block');
		$('a.return span i.fa').addClass('fa-reply');
		$('a.return').attr('href',link);
	</script>
@endpush
