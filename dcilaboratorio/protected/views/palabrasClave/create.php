<?php
/* @var $this PalabrasClaveController */
/* @var $model PalabrasClave */

$this->breadcrumbs=array(
	'Palabras Claves'=>array('admin'),
	'Nueva',
);

?>

<h1>Nueva Palabra Clave</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>