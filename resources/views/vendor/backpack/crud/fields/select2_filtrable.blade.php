
<!-- select2 -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')
    <?php 
		$entity_model = $crud->model; 
		$builder = $field['model'];
		$mods = False;
		
		if(isset($field['whereIn']))
		{
			$builder = $builder::whereIn($field['whereIn'][0], $field['whereIn'][1]);
			$mods = True;
		}
		
		if(isset($field['filter']))
		{
			$builder = isset($field['whereIn']) ? $builder->where([$field['filter']]) : $builder::where([$field['filter']]);
			$mods = True;
		}
		
		$entries = $mods ? $builder->get() : $builder::all();
	?>
	
    <select
        name="{{ $field['name'] }}"
        style="width: 100%"
        @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2_field'])
        >
		
		<option value selected disabled hidden>Seleccione</option>

            @if (isset($field['model']))
                @foreach ($entries as $connected_entity_entry)
                    <option value="{{ $connected_entity_entry->getKey() }}"
                        @if ( ( old($field['name']) && old($field['name']) == $connected_entity_entry->getKey() ) || (isset($field['value']) && $connected_entity_entry->getKey()==$field['value']))
                             selected
                        @endif
                    >{{ $connected_entity_entry->{$field['attribute']} }}</option>
                @endforeach
            @endif
    </select>

    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>


@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    @push('crud_fields_styles')
        <!-- include select2 css-->
        <link href="{{ asset('vendor/adminlte/bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    @endpush

    @push('crud_fields_scripts')
        <!-- include select2 js-->
        <script src="{{ asset('vendor/adminlte/bower_components/select2/dist/js/select2.min.js') }}"></script>
        <script>
            jQuery(document).ready(function($) {
                // trigger select2 for each untriggered select2 box
                $('.select2_field').each(function (i, obj) {
                    if (!$(obj).hasClass("select2-hidden-accessible"))
                    {
                        $(obj).select2({
                            theme: "bootstrap"
                        });
                    }
                });
            });
        </script>
    @endpush

@endif