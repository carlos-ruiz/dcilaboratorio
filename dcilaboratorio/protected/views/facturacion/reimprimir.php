<h1>Facturas expedidas</h1>
<div class="text-right">
	<?php echo CHtml::link('<i class="icon-plus"></i> Nueva factura', array('facturacion/create'), array('class'=>'btn')); ?>
</div>

<?php

	$btnTemplate = '{facturar} {cancelarFactura}';

	$this->renderPartial(
		'/comunes/_comunAdmin',
		array(
			'model'=>$model,
			'titulo'=>'Facturas expedidas',
			'columnas'=>array(
				'id',
				'razon_social',
				'rfc',
				'fecha_emision',
				'fecha_certificacion',
				),
			'buttonsTemplate'=> $btnTemplate,
			)
	);

?>