<?php
/* @var $this ExamenesController */
/* @var $model Examenes */

?>

<h1>Actualizar examen: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>