@include('base_checklist')
<!-- checklist_rows -->
<div class="form-group col-md-12 checklist_rows table-responsive" @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')
	
    <?php 
		$entity_model = $crud->getModel(); 
		
		$request_field_array = $field;
		
		$datos_procesados = procesarAtributo($request_field_array);
		
		$columnas = $datos_procesados['columnas']; 
		$filas = $datos_procesados['filas']; 
		$datos_key_value = $datos_procesados['data_ordenada'];  // key-value pair ordenado
		
		$tituloPrimeraColumna = isset( $request_field_array['nombre_entidad'] ) ? $request_field_array['nombre_entidad'] : '';
		
		$plucked = ends_with(Route::currentRouteAction(), '@create') ? [] : $plucked = $field['value']->pluck('id', 'id')->toArray();
	?>
		@foreach ($filas as $fila)
			@foreach ($columnas as $columna)
				<input type="hidden" 
						id="hd-{{ $field['name'] }}-{{ $datos_key_value[$fila.'--'.$columna] }}"
						name="{{ $field['name'] }}[]" 
						value="{{ $datos_key_value[$fila.'--'.$columna] }}"
											
						@unless( ( old( $field["name"] ) && in_array($datos_key_value[$fila.'--'.$columna], old( $field["name"])) ) || (isset($field['value']) && in_array($datos_key_value[$fila.'--'.$columna], $plucked)))
							disabled="disabled"
						@endunless >
			@endforeach
		@endforeach
		
		<table id="tb{{ $request_field_array['name'] }}" class="table table-striped table-bordered" width="100%" cellspacing="0" style="">
			<thead>
				<tr>
					<th>{{ $tituloPrimeraColumna }}</th>
					@foreach ($columnas as $encabezado)
						<th>
							{{ ucfirst($encabezado) }}
						</th>
					@endforeach
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>{{ $tituloPrimeraColumna }}</th>
					@foreach ($columnas as $encabezado)
						<th>
							{{ ucfirst($encabezado) }}
						</th>
					@endforeach
				</tr>
			</tfoot>
			<tbody>
				@foreach ($filas as $fila)
					<tr>
						<td>{{ ucfirst($fila) }}</td>
						@foreach ($columnas as $columna)
							<td>
								<div class="checkbox">
									<label>
										<input type="checkbox"
										id="vs-{{ $field['name'] }}-{{ $datos_key_value[$fila.'--'.$columna] }}"
										name="vis-{{ $field['name'] }}[]"
										onclick="setHidden( 'vs-{{ $field['name'] }}-{{ $datos_key_value[$fila.'--'.$columna] }}', 'hd-{{ $field['name'] }}-{{ $datos_key_value[$fila.'--'.$columna] }}' )" 
										value="{{ $datos_key_value[$fila.'--'.$columna] }}"
										
										@if( ( old( $field["name"] ) && in_array($datos_key_value[$fila.'--'.$columna], old( $field["name"])) ) || (isset($field['value']) && in_array($datos_key_value[$fila.'--'.$columna], $plucked)))
										checked = "checked"
										@endif > 
									</label>
								</div>
							</td>
						@endforeach
					</tr>
				@endforeach
			</tbody>
		</table>
    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
	<link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
    @endpush
	
	{{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
	<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js" type="text/javascript"></script>

	<script>
		jQuery(document).ready(function() {
			$('#tb{{ $request_field_array['name'] }}').DataTable();
		} );
		
		function setHidden( fuente, destino ) {
			if (jQuery( '#' + fuente ).prop('checked')) {
				document.getElementById(destino).removeAttribute( 'disabled' )
			}
			else {
				document.getElementById(destino).setAttribute( 'disabled', 'disabled' )
			}
		}
	</script>

    @endpush
	
	
@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}