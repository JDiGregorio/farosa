<?php
	function procesarAtributo($request_field_array){
		$columnas = []; 
		$filas = []; 
		$datos_key_value = []; // key-value pair para poder sort it con las filas y columnas 
		
		foreach ( $request_field_array['model']::get()->toArray() as $item ) {
			$expl = explode("-", $item[$request_field_array['attribute']], 2);
			
			array_push( $columnas, $expl[0] );
			array_push( $filas, $expl[1] );
			$datos_key_value[$expl[1].'--'.$expl[0]] = $item['id'] ;
		}
		$columnas = array_values( array_unique( $columnas  ) );
		$filas = array_values( array_unique( $filas  ) );
		sort( $columnas );
		sort( $filas  );
		ksort( $datos_key_value  );
		
		$data['columnas'] = $columnas;
		$data['filas'] = $filas;
		$data['data_ordenada'] = $datos_key_value;
		
		return $data;
	}
	
?>