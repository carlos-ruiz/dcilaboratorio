<?php
/* @var $this TarifasActivasController */
/* @var $model TarifasActivas */

?>

<h1>Administrar tarifas activas</h1>

<div class="text-right">
	<?php echo CHtml::link('<i class="icon-plus"></i> Nueva tarifa activa', array('tarifasActivas/create'), array('class'=>'btn')); ?>
</div>
<?php 
$this->renderPartial(
	'/comunes/_comunAdmin', 
	array(
		'model'=>$model,
		'titulo'=>'Tarifas activas',
		'columnas'=>array(
						'examen.nombre',
						'multitarifario',
						array(
							'name'=>'precio',
							'value'=>array($this, 'obtenerPrecioConFormato'),
						)
		)
	)
); 
?>