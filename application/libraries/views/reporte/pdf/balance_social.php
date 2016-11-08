<?php
$anio = $this->uri->segment(3);
$anio_anterior = $this->uri->segment(3) - 1;
$id_oficina = $this->uri->segment(4);

class PDF extends FPDF{
	// Pie de página
	function Footer(){
		// Posición: a 1,5 cm del final
		$this->SetY(-10);

		// Arial italic 8
		$this->SetFont('Helvetica','',8);

		// Número de página
		$this->Cell(0,10,utf8_decode('balancoop - página '.$this->PageNo().' de {nb}'),0,0,'C');
	}
}

$ancho_hoja = 270;
$tamanio1 = 8;
$tamanio2 = 6;
$tamanio_celdas = 6;
$fila_celdas = 6;

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
$pdf->Cell($ancho_hoja,10, utf8_decode('Balance social por indicadores - Año '.$anio),0,0,'C');

// Logo
$pdf->Image('./img/logos/'.$this->session->userdata('id_empresa').'.png',5,4,25);

// Salto de línea
$pdf->Ln(15);

//Recorremos las categorías
foreach ($this->balance_model->cargar('C', $anio, null, $id_oficina) as $categoria) {
	$pdf->SetFont('Helvetica','B',$tamanio1);
	$pdf->MultiCell($ancho_hoja, $fila_celdas, utf8_decode('CATEGORÍA'), 1, 'C', false);

	// Nombre de la categoría
	$pdf->MultiCell($ancho_hoja, $fila_celdas, utf8_decode($categoria->strNombre), 1, 'C', false);

	// Descripción de la categoría
	$pdf->SetFont('Helvetica','',$tamanio1);
	$pdf->MultiCell($ancho_hoja, $fila_celdas -2, utf8_decode($categoria->descripcion), 1, 'C', false);

	// Ahora recorreremos las dimensiones por categoría
	foreach ($this->balance_model->cargar('D', $anio, $categoria->intCodigo, $id_oficina) as $dimension) {
		//Nombre de la dimensión
		$pdf->SetFont('Helvetica','B',$tamanio1);
		$pdf->Cell(270,$fila_celdas, utf8_decode($dimension->strNombre),1,0,'L');

		// Salto de línea
		$pdf->Ln();

		// Encabezado 1
		$pdf->SetFont('Helvetica','',$tamanio1);

		// Cargamos las variables por dimensión
		foreach ($this->balance_model->cargar('V', $anio, $dimension->intCodigo, $id_oficina) as $var) {
			//Variable del reporte
			$variable = $this->balance_model->cargar_variable_reporte($var->intCodigo);

			//Se toman los valores presupuestado y real
			$presupuestado = $variable->Presupuestado;
			$real = $variable->Reales;

			//No mostraremos la variable cuando el presupuestado y el real sean 0
			if ($presupuestado != '0' || $real != '0') {
				// Encabezado 1
				$pdf->SetFont('Helvetica','B',$tamanio1);
				$pdf->Cell(130,$fila_celdas, utf8_decode(''),1,0,'L');
				$pdf->Cell(60,$fila_celdas, utf8_decode('Año '.$anio),1,0,'C');
				$pdf->Cell(60,$fila_celdas, utf8_decode('Año'.$anio_anterior),1,0,'C');
				$pdf->Cell(20,$fila_celdas, utf8_decode('Variación'),1,0,'C');

				// Salto de línea
				$pdf->Ln();

				// Encabezado año seleccionado
				$pdf->SetFont('Helvetica','',$tamanio1);
				$pdf->Cell(130,$fila_celdas, utf8_decode(''),1,0,'L');
				$pdf->Cell(22,$fila_celdas, utf8_decode('Presupuestado '),1,0,'C');
				$pdf->Cell(20,$fila_celdas, utf8_decode('Real '),1,0,'C');
				$pdf->Cell(18,$fila_celdas, utf8_decode('% '),1,0,'C');

				// Encabezado año anterior
				$pdf->Cell(22,$fila_celdas, utf8_decode('Presupuestado'),1,0,'C');
				$pdf->Cell(20,$fila_celdas, utf8_decode('Real'),1,0,'C');
				$pdf->Cell(18,$fila_celdas, utf8_decode('%'),1,0,'C');
				$pdf->Cell(20,$fila_celdas, utf8_decode('Variación'),1,0,'C');

				// Salto de línea
				$pdf->Ln();

				//Nombre de la variable
				$pdf->Cell(130,$fila_celdas, utf8_decode('   '.$variable->strNombre),1,0,'L');

				// Datos año seleccionado
				$pdf->Cell(22,$fila_celdas, utf8_decode(number_format($presupuestado, 0, '', '.')),1,0,'R');
				$pdf->Cell(20,$fila_celdas, utf8_decode(number_format($real, 0, '', '.')),1,0,'R');

				//Si hay valores en cero, entonces se aumenta a 0.001 para que no genere error
				if($real == '0') $real = '0.001';
				if($presupuestado == '0') $presupuestado = '0.001';
				
				//Se haya el porcentaje
				$porcentaje = (($real*100)/$presupuestado);
				
				//Dependiendo del valor es el color
				if ($porcentaje >= 95) {
					// Rojo
					$pdf->setFillColor($verde['r'],$verde['g'],$verde['b']); 
				}elseif($porcentaje >= 85){
					// Naranja
					$pdf->setFillColor($naranja['r'],$naranja['g'],$naranja['b']); 
				}else{
					// Rojo
					$pdf->setFillColor($rojo['r'],$rojo['g'],$rojo['b']); 
				}

				//Porcentaje
				$pdf->Cell(18,$fila_celdas, utf8_decode(number_format($porcentaje, 1, ',', '.').'%'),1,0,'R', true);

				// Salto de línea
				$pdf->Ln();
			} // if
		} // foreach variables
	} // foreach dimensiones

	// Salto de línea
	$pdf->Ln(5);
}// foreach categorias

// Se imprime el reporte
$pdf->Output('Balance_Social_'.$anio.'.pdf', 'I');
?>