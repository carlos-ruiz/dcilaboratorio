<?php
/* @var $this MultirangosController */
/* @var $model Multirangos */

$this->breadcrumbs=array(
	'Multirangoses'=>array('index'),
	'Manage',
);

?>

<h1>Administrar Multirangos</h1>
<div class="text-right">
	<?php echo CHtml::link('<i class="icon-plus"></i> Nuevo multirango', array('multirangos/create'), array('class'=>'btn')); ?>
</div>
<?php 

$this->renderPartial(
	'/comunes/_comunAdmin', 
	array(
		'model'=>$model,
		'titulo'=>'Multirangos',
		'columnas'=>array(
			'nombre',
			'rango_inferior',
			'rango_superior',
		),
		
	)
); 
?>
