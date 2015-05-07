<?php
/* @var $this DetallesExamenController */
/* @var $model DetallesExamen */

?>

<h1>Actualizar resultado de examen: <?php echo $model->descripcion; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>