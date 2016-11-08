<?
class PDF extends FPDF{

	// Pie de página
	function Footer(){
		// Posición: a 1,5 cm del final
		$this->SetY(-10);

		// Arial italic 8
		$this->SetFont('Helvetica','',8);

		// Número de página
		$this->Cell(0,10,'Balancoop - página '.$this->PageNo().' de {nb}',0,0,'C');
	}
}

/**
 * Se toman los valores que vienen por URL
 */
$anio = $this->uri->segment(3);
$anio_anterior = $this->uri->segment(3) - 1;
$id_oficina = $this->uri->segment(4);

/**
 * Se determinan algunas medidas necesarias
 */
$ancho_hoja = 270;
$tamanio1 = 8;
$tamanio2 = 6;
$tamanio_celdas = 6;
$fila_celdas = 6;

// Se consultan las metas de colores de la empresa para pintar los porcentajes
$colores = $this->balance_model->metas_porcentajes();

/**
 * Colores
 */
$rojo = array('r' => '240', 'g' => '23', 'b' => '23');
$verde = array('r' => '61', 'g' => '146', 'b' => '58');
$naranja = array('r' => '255', 'g' => '116', 'b' => '28');

// Creación del objeto de la clase heredada
$pdf = new PDF('L','mm','Letter');

//Se definen las margenes
$pdf->SetMargins(5, 5, 5);

//Anadir pagina
$pdf->AliasNbPages();
$pdf->AddPage();

// Salto de línea
$pdf->Ln(4);
		
//Título
$pdf->SetFont('Helvetica','B', '14');
$pdf->Cell($ancho_hoja,10, 'Balance social por indicadores - Año '.$anio,0,0,'C');

// Logo
$pdf->Image('./img/logos/'.$this->session->userdata('id_empresa').'.png',5,4,25);

// Salto de línea
$pdf->Ln(15);

//Recorremos las categorías
foreach ($this->balance_model->cargar('C', $anio, '0', $id_oficina) as $categoria) {
	// Nombre de la categoría
	$pdf->SetFont('Helvetica','B',$tamanio1);
	$pdf->MultiCell($ancho_hoja, $fila_celdas, utf8_decode($categoria->strNombre), 1, 'L', false);

	// Descripción de la categoría
	$pdf->SetFont('Helvetica','',$tamanio1);
	$pdf->MultiCell($ancho_hoja, $fila_celdas-2, utf8_decode($categoria->descripcion), 1, 'L', false);

	// Ahora recorreremos las dimensiones por categoría
	foreach ($this->balance_model->cargar('D', $anio, $categoria->intCodigo, $id_oficina) as $dimension) {
		// Encabezado 1
		$pdf->SetFont('Helvetica','B',$tamanio1);
		$pdf->Cell(130,$fila_celdas*2, utf8_decode("     ".$dimension->strNombre),1,0,'L');
		$pdf->Cell(60,$fila_celdas, 'Año '.$anio,1,0,'C');
		$pdf->Cell(60,$fila_celdas, 'Año '.$anio_anterior,1,0,'C');
		$pdf->Cell(20,$fila_celdas, 'Variación',1,0,'C');

		// Salto de línea
		$pdf->Ln();

		// Encabezado año seleccionado
		$pdf->SetFont('Helvetica','',$tamanio1);
		$pdf->Cell(130,$fila_celdas, utf8_decode(''),0,0,'L');
		$pdf->Cell(22,$fila_celdas, utf8_decode('Presupuestado '),1,0,'C');
		$pdf->Cell(20,$fila_celdas, utf8_decode('Real '),1,0,'C');
		$pdf->Cell(18,$fila_celdas, utf8_decode('% '),1,0,'C');

		// Encabezado año anterior
		$pdf->Cell(22,$fila_celdas, utf8_decode('Presupuestado'),1,0,'C');
		$pdf->Cell(20,$fila_celdas, utf8_decode('Real'),1,0,'C');
		$pdf->Cell(18,$fila_celdas, utf8_decode('%'),1,0,'C');
		$pdf->Cell(20,$fila_celdas, 'Variación',1,0,'C');

		// Salto de línea
		$pdf->Ln();

		// Cargamos las variables por dimensión
		foreach ($this->balance_model->cargar('V', $anio, $dimension->intCodigo, $id_oficina) as $var) {
			//Variable del reporte
			$pdf->SetFont('Helvetica','',$tamanio1);			
			
			// Se cargan datos de la variable
			$variable = $this->balance_model->cargar_variable_reporte($var->intCodigo);
			
			// Se toma el modo de ingreso
			$modo_ingreso = $variable->modo_ingreso;

			// Se toma el valor presupuestado
			$presupuestado = $variable->Presupuestado;
			
			// Si el modo de ingreso es manual
			if($modo_ingreso == '1'){
				//Se toman el valor real
				$valor_real = $variable->Reales;
				
				//Nombre de la variable
				$pdf->Cell(130,$fila_celdas, utf8_decode(substr('         '.$var->strNombre, 0, 103)),1,0,'L');
				
				/***************************************
				 *********** Año seleccionado **********
				 **************************************/

				/****************************
				**** Presupuestado y real ***
				****************************/
				$pdf->Cell(22,$fila_celdas, number_format($presupuestado, 0, '', '.'),1,0,'R');
				$pdf->Cell(20,$fila_celdas, number_format($valor_real, 0, '', '.'),1,0,'R');
				
				/****************************
				**** Cuando es cero ***
				****************************/
				if($presupuestado == '0' && $valor_real == '0'){
					$porcentaje = "100";
				}elseif($presupuestado != '0' && $valor_real == '0'){
					$porcentaje = "0";
				}elseif($presupuestado == '0' && $valor_real != '0'){
					$porcentaje = "100";
				}else{
					$porcentaje = ($valor_real*100)/$presupuestado;
				}
				
				// Si es mayor al porcentaje medio
				if ($porcentaje > $colores->porcentaje_medio) {
					// Verde
					$pdf->setFillColor($verde['r'],$verde['g'],$verde['b']); 
				}
				if($porcentaje >= $colores->porcentaje_bajo && $porcentaje < $colores->porcentaje_medio){
					// Naranja
					$pdf->setFillColor($naranja['r'],$naranja['g'],$naranja['b']); 
				}
				if($porcentaje < $colores->porcentaje_bajo){
					// Rojo
					$pdf->setFillColor($rojo['r'],$rojo['g'],$rojo['b']); 
				} // if
				
				/****************************
				********* Porcentaje ********
				****************************/
				$pdf->Cell(18,$fila_celdas, number_format($porcentaje, 0, ',', '.').' %',1,0,'R', true);




				/*********************************
				 *********** Año anterior ********
				 *********************************/


				$pdf->Cell(22,$fila_celdas, 0,1,0,'R');
				// $pdf->Cell(20,$fila_celdas, number_format($valor_real_anterior, 0, '', '.'),1,0,'R');
			}else{
				// Como es filtro, se toma el valor del filtro
				$id_filtro = $variable->fuente;
				
				//echo "Filtro ".$id_filtro.", ".$filtro->Total_Campos."campos.<br>";
				
				// Nombre de variable
				$pdf->Cell(130,$fila_celdas, utf8_decode(substr('         '.$var->strNombre, 0, 103)),1,0,'L');
				
				// Si el filtro no es 0
				if($id_filtro != "0"){
					// Se consultan todos los datos del filtro
					$filtro = $this->filtro_model->cargar_informacion_filtro($id_filtro);
					
					// Si tiene campos
					if($filtro->Total_Campos != 0){
						/************************************************************************************************************
						************************************* Variable para filtros de asociado *************************************
						************************************************************************************************************/
						// Se consultan campos, nombres, condiciones y al final el filtro completo
						$campos = $this->crm_model->listar_campos($id_filtro);
						$nombres_campos = $this->crm_model->listar_nombres_campos($id_filtro);
						$condiciones = $this->crm_model->listar_condiciones($id_filtro);
						$condiciones_oficina = $condiciones." AND asociados.id_Oficina = ".$id_oficina; // Se adiciona el id de oficina a las condiciones
						$relaciones = $this->crm_model->listar_relaciones($id_filtro);

						/*-------------------------- Año actual --------------------------*/
						
						$datos = $this->crm_model->listar_crm($campos, $relaciones, $condiciones_oficina);
						
						// Se cuentan los datos y ese será el valor real
						$valor_real = count($datos);
						
						/***************************************
						 *********** Año seleccionado **********
						 **************************************/


						/****************************
						**** Presupuestado y real ***
						****************************/
						$pdf->Cell(22,$fila_celdas, number_format($presupuestado, 0, '', '.'),1,0,'R');
						$pdf->Cell(20,$fila_celdas, number_format($valor_real, 0, '', '.'),1,0,'R');
						
						/****************************
						**** Cuando es cero ***
						****************************/
						if($presupuestado == '0' && $valor_real == '0'){
							$porcentaje = "100";
						}elseif($presupuestado != '0' && $valor_real == '0'){
							$porcentaje = "0";
						}elseif($presupuestado == '0' && $valor_real != '0'){
							$porcentaje = "100";
						}else{
							$porcentaje = ($valor_real*100)/$presupuestado;
						}
				
						// Dependiendo del valor del porcentaje, es el color
						if ($porcentaje > $colores->porcentaje_medio) {
							// Verde
							$pdf->setFillColor($verde['r'],$verde['g'],$verde['b']); 
						}
						if($porcentaje >= $colores->porcentaje_bajo && $porcentaje < $colores->porcentaje_medio){
							// Naranja
							$pdf->setFillColor($naranja['r'],$naranja['g'],$naranja['b']); 
						}
						if($porcentaje < $colores->porcentaje_bajo){
							// Rojo
							$pdf->setFillColor($rojo['r'],$rojo['g'],$rojo['b']); 
						} // if
						
						/****************************
						********* Porcentaje ********
						****************************/
						$pdf->Cell(18,$fila_celdas, number_format($porcentaje, 0, ',', '.').' %',1,0,'R', true);

						/*********************************
						 *********** Año anterior ********
						 *********************************/


						$pdf->Cell(22,$fila_celdas, 0,1,0,'R');
						// $pdf->Cell(20,$fila_celdas, number_format($valor_real_anterior, 0, '', '.'),1,0,'R');
					}else{
						/************************************************************************************************************
						************************************* Variable para filtros de producto *************************************
						************************************************************************************************************/				
						
						// Se consultan datos del filtro de producto
						$filtro_producto = $this->filtro_model->cargar_filtro_producto($id_filtro);
						
						/***************************************
						 *********** Año seleccionado **********
						 **************************************/

						// Obtengo los datos ejecutando el filtro
						$datos_producto = $this->crm_model->consultar_productos_asociado($filtro_producto->id_producto, $filtro_producto->contiene, $filtro_producto->id_genero, $id_oficina, $anio);
					
						// Se cuentan los datos y ese será el valor real
						$valor_real = count($datos_producto);
					
						/****************************
						**** Presupuestado y real ***
						****************************/
						$pdf->Cell(22,$fila_celdas, number_format($presupuestado, 0, '', '.'),1,0,'R');
						$pdf->Cell(20,$fila_celdas, number_format($valor_real, 0, '', '.'),1,0,'R');
						
						/****************************
						**** Cuando es cero ***
						****************************/
						if($presupuestado == '0' && $valor_real == '0'){
							$porcentaje = "100";
						}elseif($presupuestado != '0' && $valor_real == '0'){
							$porcentaje = "0";
						}elseif($presupuestado == '0' && $valor_real != '0'){
							$porcentaje = "100";
						}else{
							$porcentaje = ($valor_real*100)/$presupuestado;
						}
						
						// Dependiendo del valor del porcentaje, es el color
						if ($porcentaje > $colores->porcentaje_medio) {
							// Verde
							$pdf->setFillColor($verde['r'],$verde['g'],$verde['b']); 
						}
						if($porcentaje >= $colores->porcentaje_bajo && $porcentaje < $colores->porcentaje_medio){
							// Naranja
							$pdf->setFillColor($naranja['r'],$naranja['g'],$naranja['b']); 
						}
						if($porcentaje < $colores->porcentaje_bajo){
							// Rojo
							$pdf->setFillColor($rojo['r'],$rojo['g'],$rojo['b']); 
						} // if
					
						/****************************
						********* Porcentaje ********
						****************************/
						$pdf->Cell(18,$fila_celdas, number_format($porcentaje, 0, ',', '.').' %',1,0,'R', true);

						


						/*********************************
						 *********** Año anterior ********
						 *********************************/

						// Obtengo los datos ejecutando el filtro
						$datos_producto = $this->crm_model->consultar_productos_asociado($filtro_producto->id_producto, $filtro_producto->contiene, $filtro_producto->id_genero, $id_oficina, $anio_anterior);
						
						// Se cuentan los datos y ese será el valor real
						$valor_real_anterior = count($datos_producto);

						/****************************
						**** Presupuestado y real ***
						****************************/
						$pdf->Cell(22,$fila_celdas, 0,1,0,'R');
						$pdf->Cell(20,$fila_celdas, number_format($valor_real_anterior, 0, '', '.'),1,0,'R');
						

						$pdf->Cell(18,$fila_celdas, '',1,0,'R');
						$pdf->Cell(20,$fila_celdas, $valor_real - $valor_real_anterior,1,0,'R');
					}
				}
			}

			// Salto de línea
			$pdf->Ln();
		} // foreach variables
	} // foreach dimensiones

	// Salto de línea
	$pdf->Ln(5);
}// foreach categorias

// Se imprime el reporte
$pdf->Output('Balance social '.$anio.'.pdf', 'I');
?>