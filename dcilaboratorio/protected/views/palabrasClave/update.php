<?php
/* @var $this PalabrasClaveController */
/* @var $model PalabrasClave */

$this->breadcrumbs=array(
	'Palabras Claves'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Modificar',
);
?>

<h1>Modificar Palabra Clave: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>