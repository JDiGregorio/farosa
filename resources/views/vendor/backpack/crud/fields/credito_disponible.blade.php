<div @include('crud::inc.field_wrapper_attributes')>

		<div class="smart-button-container">
			<div class="smart-button">
				<div class="icon-container" id="color">
					<i class="fa fa-money" aria-hidden="true"></i>
				</div>
				<div class="info-container">
					<div class="info-label"><span>Credito disponible</span></div>
					<div class="info-qty">L. <span id="response">0.00</span></div>
				</div>
			</div>
		</div>

	
		{{-- HINT --}}
		@if (isset($field['hint']))
			<p class="help-block">{!! $field['hint'] !!}</p>
		@endif
    </div>	


@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))
  {{-- FIELD EXTRA CSS  --}}
  {{-- push things in the after_styles section --}}

		@push('crud_fields_styles')
			<style>
				.smart-button-container
				{
					text-align: right;
					border: 1px solid #ccc;
					border-radius: 5px;
					-webkit-border-radius: 5px;
				}
				
				.smart-button{
					display: flex;
					width: 100%;
					border: 1px solid #efefef;
					margin-left: auto;
				}
				
				.icon-container{
					width: 50px;
					padding: 10px 15px;
					margin-top: 6.5px;
				}
				
				.icon-container i{
					font-size: 36px;
					color: #d73925;
				}
				
				.info-container{
					width: 100%;
					padding: 10px 0px;
				}
				
				.info-qty{
					width: 100%;
					text-align: right;
					padding-right: 25px;
					font-size: 22px;
					font-weight: 700;
					color: #00b200;
					line-height: 30px;
				}
				
				.info-label{
					text-align: right;
					padding-right: 25px;
					margin: 0;
					font-weight: 700;
					font-size: 14px;
					padding-bottom: 0px;
					color: #999;
				}
			</style>
		@endpush


  {{-- FIELD EXTRA JS --}}
  {{-- push things in the after_scripts section --}}


@endif