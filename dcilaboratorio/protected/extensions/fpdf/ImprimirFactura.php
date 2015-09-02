<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'FPDF.php');
class ImprimirFactura extends FPDF{

	function Header(){
        $y = 0.5;
		$this->SetFont('Arial','B',14);

	}

	function cabeceraHorizontal($model, $datosFactura, $sucursal)
	{
        $this->Image(dirname(__FILE__).DIRECTORY_SEPARATOR.'../../../css/layout/img/logoNuevo.png',16,1.7,4.3,3.3);
        $fecha = $model->fecha;

        $y = 0.5;
        $this->SetXY(1, .75);
        $this->Cell(0,2.54,'SILVIA GUERRA LAUCHINO',0,0,'C');
        $this->ln(0.5);
        $this->SetFont('Arial','B',12);
        $this->Cell(0,2.54,'RFC. GULS720801NY4',0,0,'C');
        $this->ln(0.75);
        $this->SetFont('Times','B',14);
        $this->SetXY(1.8, 2.75);
        $this->Cell(1.3, $y, 'Factura', 0, 0, 'C');
        $this->SetFont('Times','B',10);
        $this->Cell(.9, 2, 'Domicilio y Expendido en:', 0, 0, 'C');
        $this->SetX(2);
        $this->SetFont('Times','',8);
        $this->Cell(1, 3, 'Gnl.Bravo #170', 0, 0, 'C');
        $this->Cell(1, 3.7, 'Col. Chapultepec Nte. C.P. 58260', 0, 0, 'C');
        $this->Cell(-2.4, 4.4, 'Morelia, Michoacán', 0, 0, 'C');

        $this->SetXY(2.4, 3.7);
        $this->SetFont('Times','B',8);
        $this->Cell(1, 3.7, 'Lugar de expedición:', 0, 0, 'C');
        $this->SetFont('Times','',8);
        $this->Cell(3.9, 3.7, ' Morelia, Michoacán', 0, 0, 'C');
        $this->SetFont('Times','B',8);
        $this->SetXY(2.4, 4);
        $this->Cell(.6, 3.8, 'Datos del Receptor', 0, 0, 'C');
        $this->SetXY(1, 4);
        $this->Cell(2, 4.6, 'Cliente:', 0, 0, 'C');
        $this->SetXY(2, 4);
        $this->Cell(-0.2, 5.3, 'RFC:', 0, 0, 'C');
        $this->Cell(0, 5.5, 'Folio Fiscal: '.$datosFactura['uuid'], 0, 0, 'R');
        $this->ln(1.5);

        $y = 0.5;
        $this->ln(.75);
        $this->SetFont('Times','B',9);
        $this->setX(2.5);
        $this->Cell(0,0.1,$model->razon_social, 0, 1, 'L');
        $this->Cell(0,0.1,'Comprobante Digital por Internet', 0, 1, 'R');
        $this->SetFont('Times','',8);
        $this->setX(2.5);
        $this->Cell(5,0.6,strtoupper($model->rfc), 0, 1, 'L');
        $this->ln(.2);
        $this->SetFont('Times','B',8);
        $this->setX(1.5);
        $this->Cell(0,0.1,'Domicilio', 0, 1, 'L');
        $this->Cell(0,0.1,'Número de comprobante: '.$sucursal.sprintf("%03d", $model->numeroFactura), 0, 1, 'R');
        $this->SetFont('Times','',8);
        $this->setX(1.5);
        $this->Cell(2,0.6,'Calle '.$model->calle.' N° '.$model->numero, 0, 1, 'L');
        $this->Cell(0,0.1,'Forma de pago: Pago en Una sola exibición', 0, 1, 'R');
        $this->setX(1.5);
        $this->Cell(2,0.1,'Col. '.$model->colonia.' CP. '.$model->codigo_postal, 0, 1, 'L');
        $this->Cell(0,0.4,'Fecha de comprobante '.$fecha, 0, 1, 'R');
        $this->setX(1.5);
        $this->Cell(2,-0.1,$model->municipio.', '.$model->estado, 0, 1, 'L');
        $this->setX(1.5);
        $this->Cell(2,0.8,'Moneda: PESOS   Tipo de cambio: 1.00', 0, 1, 'L');
        $this->Cell(0,-1,'Fecha de certificación del CFDI '.$datosFactura['date'], 0, 1, 'R');

        $this->setX(-8.5);
        $this->SetXY(-7.5,9.5);
        $this->Cell(0,0,'Método de pago y cuenta: TARJETA', 0, 1, 'R');
        $this->setX(-7.5);

        $this->setX(-7.5);
        $this->Cell(0,.7,'Regimen Fiscal: Reg. de la PF con Act. Emp. y Prof.', 0, 1, 'R');

        $this->ln(.5);
        $this->SetFont('Arial','B',8);
        $this->SetFillColor(75, 141, 248);//Fondo azul de celda
        $this->SetTextColor(0, 0, 0); //Letra color blanco

        $this->Cell(2,$y, 'Cantidad',1, 0 , 'C', true);
        $this->Cell(2,$y, 'Unidad',1, 0 , 'C', true);
        $this->Cell(9.5,$y, 'Descripción',1, 0 , 'C', true);
        $this->Cell(3,$y, 'Precio unitario',1, 0 , 'C', true);
        $this->Cell(3,$y, 'Importe',1, 1 , 'C', true);
    }

    function contenido($model, $datosFactura){
    	$this->SetTextColor(0, 0, 0); //Letra color blanco
    	$this->SetFont('Arial','',8);

    	$y = 0.5;
        $conceptos = $model->conceptos;
        $idExamen = 0;
        $totalOrden = 0;
        $subtotal = 0;
        $duracion = 0;
        $descuento = isset($model->descuento)?$model->descuento:0;
        foreach ($conceptos as $concepto) {
            $this->Cell(2,$y, '1.00',1, 0);
            $this->Cell(2,$y, 'N/A',1, 0);
            $this->Cell(9.5,$y, $concepto->concepto,1, 0 );
            $this->Cell(3,$y, '$ '.round(($concepto->precio*(1-($descuento/100))/1.16), 2),1, 0, 'R');
            $this->Cell(3,$y, '$ '.round(($concepto->precio*(1-($descuento/100))/1.16), 2),1, 1, 'R');
            $totalOrden += ($concepto->precio*(1-($descuento/100)));
            $subtotal += round(($concepto->precio*(1-($descuento/100))/1.16), 2);
        }
        $this->setX(14.5);
        $this->SetFont('Arial','B',8);
        $this->Cell(3,$y,'Subtotal:', 0, 0, 'R');
        $this->Cell(3,$y,'$ '.$subtotal, 0, 1, 'R');
        $this->setX(14.5);
        $this->Cell(3,$y,'I.V.A. 16.00%:', 0, 0, 'R');
        $this->Cell(3,$y,'$ '.($totalOrden-$subtotal), 0, 1, 'R');
        $this->setX(14.5);
        // $this->Cell(3,$y,'Descuento:', 1, 0, 'R');
        // $this->Cell(4,$y,isset($model->descuento)?$model->descuento:'0'.'%', 1, 1, 'R');
        // $this->setX(13.5);
        // $this->Cell(3,$y,'Total con descuento:', 1, 0, 'R');
        // $this->Cell(4,$y,'$ '.$totalOrden*(1-($model->descuento/100)), 1, 1, 'R');
        // $this->setX(13.5);
        $total = $totalOrden*(1-($model->descuento/100)) + $model->costo_extra;
        $this->Cell(3,$y,'Total:', 0, 0, 'R');
        $this->Cell(3,$y,'$ '.number_format($totalOrden, 2), 0, 1, 'R');
        $this->Cell(0,$y,'IMPORTE CON LETRA', 0, 1, 'C');
        $this->Cell(0,$y,$this->numtoletras($totalOrden), 0, 1, 'C');

        $this->ln(0.5);
        $this->setX(1);

        $this->Cell(0, $y, '"Este documento es una representación impresa de un CFDI"', 0, 1, 'L');
        $this->ln();
        $this->Cell(10, $y, 'Número de serie del certificado de sello digital:', 0, 0, 'L');
        $this->Cell(10, $y, 'Número de serie del certificado de sello digital del SAT:', 0, 1, 'L');
        $this->SetFont('Arial','',8);
        $this->Cell(10, $y, $model->csd_emisor, 0, 0, 'L');
        $this->Cell(10, $y, $datosFactura['certNumber'], 0, 1, 'L');
        $this->ln();
        $this->SetFont('Arial','B',8);
        $this->Cell(10, $y, 'Cadena original del complemento de certificación digital del SAT: ', 0, 1, 'L');
        $this->SetFont('Arial','',8);
        $this->MultiCell(0, $y, $datosFactura['string'], 0, 'L', false);
        $this->setX(1);
        $this->SetFont('Arial','B',8);
        $this->Cell(0, $y, 'Sello Digital del Emisor:', 0, 1, 'L');
        $this->SetFont('Arial','',8);
        $this->MultiCell(15, $y,$datosFactura['cfdStamp'], 0, 'L', false);
        $this->SetFont('Arial','B',8);
        $this->Cell(0, $y, 'Sello digital del SAT:', 0, 1, 'L');
        $yQr = $this->getY();
        $this->SetFont('Arial','',8);
        $this->MultiCell(15, $y, $datosFactura['satStamp'], 0, 'L', false);
        $yQr2 = $this->getY();
        $yQr = ($yQr>$yQr2)?$yQr2:$yQr;
        $this->Image(dirname(__FILE__).DIRECTORY_SEPARATOR.'../../../assets/qrcodes/qr.png',17.5,$yQr,3,3);
    }

    function Footer()
    {
	   //Position at 1.5 cm from bottom
        $this->SetY(-6);
        //Arial italic 8
        $this->SetFont('Arial','I',8);
        //Page number
        $this->AliasNbPages();
        $this->Cell(0,10,'Página '.$this->PageNo()."/{nb}",0,0,'C');
    }

    //------    CONVERTIR NUMEROS A LETRAS         ---------------
    //------    Máxima cifra soportada: 18 dígitos con 2 decimales
    //------    999,999,999,999,999,999.99
    function numtoletras($xcifra)
    {
        $xarray = array(0 => "Cero",
            1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
            "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
            "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
            100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
        );
    //
        $xcifra = trim($xcifra);
        $xlength = strlen($xcifra);
        $xpos_punto = strpos($xcifra, ".");
        $xaux_int = $xcifra;
        $xdecimales = "00";
        if (!($xpos_punto === false)) {
            if ($xpos_punto == 0) {
                $xcifra = "0" . $xcifra;
                $xpos_punto = strpos($xcifra, ".");
            }
            $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
            $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
        }

        $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
        $xcadena = "";
        for ($xz = 0; $xz < 3; $xz++) {
            $xaux = substr($XAUX, $xz * 6, 6);
            $xi = 0;
            $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
            $xexit = true; // bandera para controlar el ciclo del While
            while ($xexit) {
                if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                    break; // termina el ciclo
                }

                $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
                $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
                for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                    switch ($xy) {
                        case 1: // checa las centenas
                            if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas

                            } else {
                                $key = (int) substr($xaux, 0, 3);
                                if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                    $xseek = $xarray[$key];
                                    $xsub = $this->subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                    if (substr($xaux, 0, 3) == 100)
                                        $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                                }
                                else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                    $key = (int) substr($xaux, 0, 1) * 100;
                                    $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 0, 3) < 100)
                            break;
                        case 2: // checa las decenas (con la misma lógica que las centenas)
                            if (substr($xaux, 1, 2) < 10) {

                            } else {
                                $key = (int) substr($xaux, 1, 2);
                                if (TRUE === array_key_exists($key, $xarray)) {
                                    $xseek = $xarray[$key];
                                    $xsub = $this->subfijo($xaux);
                                    if (substr($xaux, 1, 2) == 20)
                                        $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3;
                                }
                                else {
                                    $key = (int) substr($xaux, 1, 1) * 10;
                                    $xseek = $xarray[$key];
                                    if (20 == substr($xaux, 1, 1) * 10)
                                        $xcadena = " " . $xcadena . " " . $xseek;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 1, 2) < 10)
                            break;
                        case 3: // checa las unidades
                            if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada

                            } else {
                                $key = (int) substr($xaux, 2, 1);
                                $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                                $xsub = $this->subfijo($xaux);
                                $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                            } // ENDIF (substr($xaux, 2, 1) < 1)
                            break;
                    } // END SWITCH
                } // END FOR
                $xi = $xi + 3;
            } // ENDDO

            if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
                $xcadena.= " DE";

            if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
                $xcadena.= " DE";

            // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
            if (trim($xaux) != "") {
                switch ($xz) {
                    case 0:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN BILLON ";
                        else
                            $xcadena.= " BILLONES ";
                        break;
                    case 1:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN MILLON ";
                        else
                            $xcadena.= " MILLONES ";
                        break;
                    case 2:
                        if ($xcifra < 1) {
                            $xcadena = "CERO PESOS $xdecimales/100 M.N.";
                        }
                        if ($xcifra >= 1 && $xcifra < 2) {
                            $xcadena = "UN PESO $xdecimales/100 M.N. ";
                        }
                        if ($xcifra >= 2) {
                            $xcadena.= " PESOS $xdecimales/100 M.N. "; //
                        }
                        break;
                } // endswitch ($xz)
            } // ENDIF (trim($xaux) != "")
            // ------------------      en este caso, para México se usa esta leyenda     ----------------
            $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
        } // ENDFOR ($xz)
        return trim($xcadena);
    }

    // END FUNCTION

    function subfijo($xx)
    { // esta función regresa un subfijo para la cifra
        $xx = trim($xx);
        $xstrlen = strlen($xx);
        if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
            $xsub = "";
        //
        if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
            $xsub = "MIL";
        //
        return $xsub;
    }

    // END FUNCTION
}
