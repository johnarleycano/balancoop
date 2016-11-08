<?php
	$tipo = $_FILES['archivo']['type'];
	$tamanio = $_FILES['archivo']['size'];
	$archivotmp = $_FILES['archivo']['tmp_name'];
	$respuesta = new stdClass();
	
	if( $tipo == 'application/vnd.ms-excel'){
	
	
		
		$archivo = "../../../archivos/campanas.csv";
	
		if(move_uploaded_file($archivotmp, $archivo) ){
	 		$respuesta->estado = true;		
		} else {
    		$respuesta->estado = false;
			$respuesta->mensaje = "El archivo no se pudo subir al servidor, intentalo mas tarde";
		}
	
		
		if($respuesta->estado){
		
			//$lineas = file('archivos/alumno.csv');

			$respuesta->mensaje = "";
			$respuesta->estado = true;
			/*
			$conexion = new mysqli('localhost','usuario','password','basedatos',3306);
			foreach ($lineas as $linea_num => $linea)
			{
				$datos = explode(",",$linea);
				$matricula = trim($datos[0]);
				$paterno = trim($datos[1]);
				$materno = trim($datos[2]);
				$nombre = trim($datos[3]);
			
	    		$consulta = "INSERT INTO tblalumno(matricula,paterno, materno, nombre) VALUES('$matricula','$paterno','$materno','$nombre');";			
				if(!$conexion->query($consulta)){			
					$respuesta->estado = false;
					$respuesta->mensaje .= "El alumno $paterno $materno $nombre no se guardo, verifica la información \n"; 				
				}
			}
			*/
		}
		
		if($respuesta->estado == true)
			$respuesta->mensaje = "Todos los registros se guardaron correctamente\n";
	}
	else {
		$respuesta->mensaje = "Solo se admiten archivos .csv, vuelvelo a intentar\n";
	}
	echo json_encode($respuesta);
?>