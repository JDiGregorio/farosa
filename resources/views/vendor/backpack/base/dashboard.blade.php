@extends('backpack::layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
			<div class="row div-margin">
				<div class="col-md-6 col-xs-6">
					<a class="div-padding" href="{{ backpack_url('clientes') }}">
						<div class="div-item-menu">
							<div class="div-icon" style="background-image: url('/img/clientes.png');"></div>
							<h1 class="title-icon">Clientes</h1>
						</div>
					</a>
				</div>
				<div class="col-md-6 col-xs-6">
					<a class="div-padding" href="{{ backpack_url('productos') }}">
						<div class="div-item-menu">
							<div class="div-icon" style="background-image: url('/img/producto.png');"></div>
							<h1 class="title-icon">Productos</h1>
						</div>
					</a>
				</div>
				<div class="col-md-6 col-xs-6">
					<a class="div-padding" href="{{ backpack_url('pedidos') }}" id="link-pedido">
						<div class="div-item-menu">
							<div class="div-icon" style="background-image: url('/img/pedido.png');"></div>
							<h1 class="title-icon">Pedidos</h1>
						</div>
					</a>
				</div>
				@if(Backpack_auth()->user()->tipo_user == 1)
					<div class="col-md-6 col-xs-6">
						<a class="div-padding" href="{{ backpack_url('user') }}">
							<div class="div-item-menu">
								<div class="div-icon" style="background-image: url('/img/usuarios.png');"></div>
								<h1 class="title-icon">Usuarios</h1>
							</div>
						</a>
					</div>
				@endif
				<div class="col-md-6 col-xs-6">
					<a class="div-padding" href="{{ url(config('backpack.base.route_prefix', 'admin').'/logout') }}">
						<div class="div-item-menu">
							<div class="div-icon" style="background-image: url('/img/salir.png');"></div>
							<h1 class="title-icon">Salir</h1>
						</div>
					</a>
				</div>				
			</div>
        </div>
    </div>
@endsection

@push('scripts')
	<script>
		$('div a').css('cursor','pointer');
	</script>
@endpush