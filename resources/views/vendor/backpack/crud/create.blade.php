@extends('backpack::layout')

@section('header')
	<section class="content-header">
		<div class="title-list">
			<h1>
				<span class="text-capitalize">{{ $crud->entity_name }}</span>
			</h1>
		</div>
	</section>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12 mb-0">
		<!-- Default box -->

		@include('crud::inc.grouped_errors')

		  <form method="post"
		  		action="{{ url($crud->route) }}"
				@if ($crud->hasUploadFields('create'))
				enctype="multipart/form-data"
				@endif
		  		>
		  {!! csrf_field() !!}
		  <div class="col-lg-12 pad">

		    <!-- <div class="row display-flex-wrap"> -->
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content', [ 'fields' => $crud->getFields('create'), 'action' => 'create' ])
		      @else
		      	@include('crud::form_content', [ 'fields' => $crud->getFields('create'), 'action' => 'create' ])
		      @endif
		    <!-- </div> -->
		    <div class="box-footer">

                @include('crud::inc.form_save_buttons')

		    </div><!-- /.box-footer-->
		  </div><!-- /.box -->
		  </form>
	</div>
</div>
@endsection

@push('scripts')
	<script>
		if($(location).attr('pathname') === '/farosa/public/admin/pedidos/create'){
			$('a.return').css('display','block');
			$('a.return span i.fa').addClass('fa-reply');
			$('a.return').attr('href',"/farosa/public/admin/pedidos");
		}else if($(location).attr('pathname') === '/farosa/public/admin/user/create' || $(location).attr('pathname') === '/farosa/public/admin/role/create'){
			$('a.return').css('display','block');
			$('a.return span i.fa').addClass('fa-reply');
			$('a.return').attr('href',"/farosa/public/admin/usuarios");
		}else{
			$('a.return').css('display','block');
			$('a.return span i.fa').addClass('fa-home');
			$('a.return').attr('href',"/farosa/public/admin/dashboard");
		}
	</script>
@endpush
