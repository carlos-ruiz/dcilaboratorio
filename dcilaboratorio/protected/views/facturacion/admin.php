<h1>Expedir facturas</h1>

<?php

	$btnTemplate = '{view}';

	$this->renderPartial(
		'/comunes/_comunAdmin',
		array(
			'model'=>$model,
			'titulo'=>'Ordenes',
			'columnas'=>array(
				'id',
				array(
					'name'=>'Paciente',
					'value'=>array($this, 'obtenerPaciente'),
					),
				array(
					'name'=>'Datos del cliente',
					'value'=>array($this, 'datosFacturacionCliente'),
					),
				'fecha_captura',
				),
			'buttonsTemplate'=> $btnTemplate,
			)
	);

?>