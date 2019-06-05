@extends('backpack::layout')

@section('content')
<div class="box">	
	<div class="box-body">
		<div class="row">
			<div class="contenedor col-lg-12">
				<form class="cd-form floating-labels">
					<fieldset>
						<legend>{{ $customer->first()->FirstName }}</legend>
						<label class="label-title">{{ $customer->first()->AccountNumber }}</label>
						
						<div class="icon">
							<label class="cd-label" for="cd-code">Código:</label>
							<input class="codigo" type="text" name="cd-code" id="cd-code" value="{{ $customer->first()->AccountNumber }}" readonly>
						</div> 

						<div class="icon">
							<label class="cd-label" for="cd-name">Nombre:</label>
							<input class="nombre" type="text" name="cd-name" id="cd-name" value="{{ $customer->first()->FirstName }}" readonly>
						</div>
						
						<div class="icon left-inner-addon">
							<label class="cd-label" for="cd-acount">Cuenta por Pagar:</label>
							<span>L.</span>
							<input class="input-dinero" type="text" name="cd-acount" id="cd-acount" value="{{ number_format($customer->first()->AccountBalance,2) }}" readonly>
						</div>
						
						<div class="icon left-inner-addon">
							<label class="cd-label" for="cd-limit">Limite:</label>
							<span>L.</span>
							<input class="input-dinero" type="text" name="cd-limit" id="cd-limit" value="{{ number_format($customer->first()->CreditLimit,2) }}" readonly>
						</div>
						
						<div class="icon left-inner-addon">
							<label class="cd-label" for="cd-available">Disponible:</label>
							<span>L.</span>
							<input class="input-dinero" type="text" name="cd-available" id="cd-available" value="{{ number_format($disponible,2) }}" readonly>
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
		var link = '/admin/clientes';
		
		$('a.return').css('display','block');
		$('a.return span i.fa').addClass('fa-reply');
		$('a.return').attr('href',link);
	</script>
@endpush
