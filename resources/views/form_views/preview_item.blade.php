@extends('backpack::layout')

@section('content')
<div class="box">	
	<div class="box-body">
		<div class="row">
			<div class="contenedor col-lg-12">
				<form class="cd-form floating-labels">
					<fieldset>
						<legend>{{ $item->first()->Description }}</legend>
						<label class="label-title">{{ $item->first()->ItemLookupCode }}</label>
						
						<div class="icon">
							<label class="cd-label" for="cd-name">Código:</label>
							<input class="codigo" type="text" name="cd-name" id="cd-name" value="{{ $item->first()->ItemLookupCode }}" readonly>
						</div> 

						<div class="icon">
							<label class="cd-label" for="cd-company">Descripción:</label>
							<input class="descripcion" type="text" name="cd-company" id="cd-company" value="{{ $item->first()->Description }}" readonly>
						</div>
						
						<div class="icon">
							<label class="cd-label" for="cd-email">Precios:</label>
							<table class="table table-bordered">
								<tr><th style="width:70%;">Precio Principal</th>
									<td style="text-align: right;">
										L. {{ number_format($item->first()->Price,2,'.','') }}
									</td> 
								</tr>
								<tr><th style="width:70%;">Precio A</th>
									<td style="text-align: right;">
										L. {{ number_format($item->first()->PriceA,2,'.','') }}
									</td> 
								</tr>
								<tr><th style="width:70%;">Precio B</th>
									<td style="text-align: right;">
										L. {{ number_format($item->first()->PriceB,2,'.','') }}
									</td> 
								</tr>
								<tr><th style="width:70%;">Precio C</th>
									<td style="text-align: right;">
										L. {{ number_format($item->first()->PriceC,2,'.','') }}
									</td>
								</tr>
							</table>
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
		var link = '<?php echo redirect()->getUrlGenerator()->previous();?>';
		
		$('a.return').css('display','block');
		$('a.return span i.fa').addClass('fa-reply');
		$('a.return').attr('href',link);
	</script>
@endpush
