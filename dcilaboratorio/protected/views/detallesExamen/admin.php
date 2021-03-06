<?php
/* @var $this DetallesExamenController */
/* @var $model DetallesExamen */

?>

<h1>Administrar configuración test</h1>
<div class="text-right">
	<?php echo CHtml::link('<i class="icon-plus"></i> Nueva configuración test', array('detallesExamen/create'), array('class'=>'btn')); ?>
</div>


<?php 
$this->renderPartial(
	'/comunes/_comunAdmin', 
	array(
		'model'=>$model,
		'titulo'=>'Resultados de examenes',
		'columnas'=>array('examenes.nombre','descripcion','unidadesMedida.nombre', 'rango_inferior','rango_promedio','rango_superior')
	)
); 

?>
