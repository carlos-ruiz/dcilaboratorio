<h1>Expedir facturas</h1>
<div class="text-right">
	<?php echo CHtml::link('<i class="icon-plus"></i> Nueva factura', array('facturacion/create'), array('class'=>'btn')); ?>
</div>

<?php

	$btnTemplate = '{facturar}';

	$this->renderPartial(
		'/comunes/_comunAdmin',
		array(
			'model'=>$model,
			'titulo'=>'Ordenes',
			'filtroFactura'=>$filtroFactura,
			'columnas'=>array(
				'id',
				array(
					'name'=>'Paciente',
					'value'=>array($this, 'obtenerPaciente'),
					),
				array(
					'name'=>'Datos del contribuyente',
					'value'=>array($this, 'datosFacturacionCliente'),
					),
				'fecha_captura',
				),
			'buttonsTemplate'=> $btnTemplate,
			)
	);

?>