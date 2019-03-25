@extends('backpack::layout')

@section('header')
	<section class="content-header">
		<div class="title-list">
			<h1>
				<span class="text-capitalize">Usuarios</span>	
			</h1>
		</div>
	</section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
			<div class="row">
				<div class="col-md-6 col-xs-6 div-left">
					<a href="{{ backpack_url('user') }}">
						<div class="div-item-menu">
							<div class="div-icon" style="background-image: url('/farosa/public/img/clientes.png');"></div>
							<h1 class="title-icon">Usuarios</h1>
						</div>
					</a>
				</div>
				<div class="col-md-6 col-xs-6 div-right">
					<a href="{{ backpack_url('role') }}">
						<div class="div-item-menu">
							<div class="div-icon" style="background-image: url('/farosa/public/img/producto.png');"></div>
							<h1 class="title-icon">Roles</h1>
						</div>
					</a>
				</div>			
			</div>
        </div>
    </div>
@endsection

@push('scripts')
	<script>
		if($(location).attr('pathname') === '/admin/usuarios'){
			$('a.return').css('display','block');
			$('a.return span i.fa').addClass('fa-home');
			$('a.return').attr('href',"/admin/dashboard");
		}
	</script>
@endpush
