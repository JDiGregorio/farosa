@extends('backpack::layout')

@section('header')
	<section class="content-header">
		<div class="title-list">
			<h1>
				<span class="text-capitalize">{{ $crud->entity_name_plural }}</span>	
			</h1>
		</div>
	</section>
@endsection

@section('content')
<!-- Default box -->
  <div class="row">

    <!-- THE ACTUAL CONTENT -->
    <div class="{{ $crud->getListContentClass() }}">
      <div class="">

        <div class="row m-b-10">
			<div class="col-lg-6 col-md-12">
				@if ( $crud->buttons->where('stack', 'top')->count() ||  $crud->exportButtons())
					<div class="hidden-print mt-2 mb-2 {{ $crud->hasAccess('create')?'with-border':'' }}">
						@include('crud::inc.button_stack', ['stack' => 'top'])
					</div>
				@endif
			</div>
			<div class="col-lg-6 col-md-12">
				<div id="datatable_search_stack" class="pull-left mt-2 mb-2 search"></div>
			</div>
        </div>

        {{-- Backpack List Filters --}}
        @if ($crud->filtersEnabled())
          @include('crud::inc.filters_navbar')
        @endif

        <div class="overflow-hidden">

        <table id="crudTable" class="box table table-striped table-hover display responsive nowrap m-t-0" cellspacing="0">
            <thead>
              <tr>
                @foreach ($crud->columns as $column)
                  <th
                    data-orderable="{{ var_export($column['orderable'], false) }}"
                    data-priority="{{ $column['priority'] }}"
                    data-visible-in-modal="{{ (isset($column['visibleInModal']) && $column['visibleInModal'] == false) ? 'false' : 'true' }}"
                    data-visible="{{ !isset($column['visibleInTable']) ? 'true' : (($column['visibleInTable'] == false) ? 'false' : 'true') }}"
                    data-visible-in-export="{{ (isset($column['visibleInExport']) && $column['visibleInExport'] == false) ? 'false' : 'true' }}"
                    >
                    {!! $column['label'] !!}
                  </th>
                @endforeach

                @if ( $crud->buttons->where('stack', 'line')->count() )
                  <th data-orderable="false" data-priority="{{ $crud->getActionsColumnPriority() }}" data-visible-in-export="false">Acción</th>
                @endif
              </tr>
            </thead>
            <tbody>
            </tbody>
            {{--<tfoot>
              <tr>
                 Table columns 
                @foreach ($crud->columns as $column)
                  <th>{!! $column['label'] !!}</th>
                @endforeach

                @if ( $crud->buttons->where('stack', 'line')->count() )
                  <th>{{ trans('backpack::crud.actions') }}</th>
                @endif
              </tr>
            </tfoot>--}}
          </table>

          @if ( $crud->buttons->where('stack', 'bottom')->count() )
          <div id="bottom_buttons" class="hidden-print">
            @include('crud::inc.button_stack', ['stack' => 'bottom'])

            <div id="datatable_button_stack" class="pull-right text-right hidden-xs"></div>
          </div>
          @endif

        </div><!-- /.box-body -->

      </div><!-- /.box -->
    </div>
  </div>
@endsection

@section('after_styles')
  <!-- DATA TABLES -->
  <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css">

  <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/form.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/list.css') }}">

  <!-- CRUD LIST CONTENT - crud_list_styles stack -->
  @stack('crud_list_styles')
@endsection

@section('after_scripts')
	@include('crud::inc.datatables_logic')

  <script src="{{ asset('vendor/backpack/crud/js/crud.js') }}"></script>
  <script src="{{ asset('vendor/backpack/crud/js/form.js') }}"></script>
  <script src="{{ asset('vendor/backpack/crud/js/list.js') }}"></script>

  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
  
	@push('scripts')
		<script>
			if($(location).attr('pathname') === '/admin/pedidos'){
				$('a.add-pedido').removeClass('hide');
			}
			
			if($(location).attr('pathname') === '/admin/clientes' || $(location).attr('pathname') === '/admin/productos' || $(location).attr('pathname') === '/admin/pedidos'){
				$('a.return').css('display','block');
				$('a.return span i.fa').addClass('fa-home');
				$('a.return').attr('href',"/admin/dashboard");
			}else if($(location).attr('pathname') === '/admin/user' || $(location).attr('pathname') === '/admin/role'){
				$('a.return').css('display','block');
				$('a.return span i.fa').addClass('fa-reply');
				$('a.return').attr('href',"/admin/usuarios");
			}else{
				$('a.return').css('display','block');
				$('a.return span i.fa').addClass('fa-home');
				$('a.return').attr('href',"/admin/dashboard");
			}
		</script>
	@endpush
@endsection
