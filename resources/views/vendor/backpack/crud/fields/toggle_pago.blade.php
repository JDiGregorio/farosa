<div @include('crud::inc.field_wrapper_attributes')>
	<label>{!! $field['label'] !!}</label>
	
	<div class="switch-field">
		<input type="radio" data-pago="credito" class="control-input-pago" id="credito" name="group">
		<label id="label-0" class="custom-control-label" for="credito">Credito</label>
		<input type="radio" data-pago="contado" class="control-input-pago" id="contado" name="group">
		<label id="label-1" class="custom-control-label" for="contado">Contado</label>
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
				.switch-field {
					display: flex;
					overflow: hidden;
				}

				.switch-field input {
					position: absolute !important;
					clip: rect(0, 0, 0, 0);
					height: 1px;
					width: 1px;
					border: 0;
					overflow: hidden;
				}

				.switch-field label {
					width: 100%;
					text-transform: uppercase;
					background-color: #FFF;
					color: rgba(0, 0, 0, 0.6);
					font-size: 14px;
					line-height: 1;
					text-align: center;
					padding: 8px 16px;
					margin-right: -1px;
					border: 1px solid rgba(0, 0, 0, 0.2);
					box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
					transition: all 0.1s ease-in-out;
				}

				.switch-field label:hover {
					cursor: pointer;
				}

				.switch-field input:checked + label {
					background-color: #aba5a5;
					box-shadow: none;
				}

				.switch-field label:first-of-type {
					border-radius: 4px 0 0 4px;
				}

				.switch-field label:last-of-type {
					border-radius: 0 4px 4px 0;
				}
		 </style>
		 
      @endpush


  {{-- FIELD EXTRA JS --}}
  {{-- push things in the after_scripts section --}}

      @push('crud_fields_scripts')
		<script>
			
		</script>
      @endpush
@endif