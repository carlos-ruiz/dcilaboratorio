<?php
/* @var $this TitulosFormController */
/* @var $model TitulosForm */

?>

<h1>Actualizar título: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
