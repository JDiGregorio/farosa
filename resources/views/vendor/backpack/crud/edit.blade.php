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
<div class="row m-t-20">
	<div class="{{ $crud->getEditContentClass() }}">
		<!-- Default box -->

		@include('crud::inc.grouped_errors')

		  <form method="post"
		  		action="{{ url($crud->route.'/'.$entry->getKey()) }}"
				@if ($crud->hasUploadFields('update', $entry->getKey()))
				enctype="multipart/form-data"
				@endif
		  		>
		  {!! csrf_field() !!}
		  {!! method_field('PUT') !!}
		  <div class="col-md-12">
		  	@if ($crud->model->translationEnabled())
		    <div class="row m-b-10">
		    	<!-- Single button -->
				<div class="btn-group pull-right">
				  <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    {{trans('backpack::crud.language')}}: {{ $crud->model->getAvailableLocales()[$crud->request->input('locale')?$crud->request->input('locale'):App::getLocale()] }} &nbsp; <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				  	@foreach ($crud->model->getAvailableLocales() as $key => $locale)
					  	<li><a href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}?locale={{ $key }}">{{ $locale }}</a></li>
				  	@endforeach
				  </ul>
				</div>
		    </div>
		    @endif
		    <div class="row display-flex-wrap">
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content', ['fields' => $fields, 'action' => 'edit'])
		      @else
		      	@include('crud::form_content', ['fields' => $fields, 'action' => 'edit'])
		      @endif
		    </div><!-- /.box-body -->

            <div class="">

                @include('crud::inc.form_save_buttons')

		    </div><!-- /.box-footer-->
		  </div><!-- /.box -->
		  </form>
	</div>
</div>
@endsection

@push('scripts')
	<script>
		var link = '<?php echo redirect()->getUrlGenerator()->previous();?>'
		
		$('a.return').css('display','block');
		$('a.return span i.fa').addClass('fa-reply');
		$('a.return').attr('href',link);
	</script>
@endpush
