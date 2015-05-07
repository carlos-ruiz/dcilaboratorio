<?php
/* @var $this UnidadesMedidaController */
/* @var $model UnidadesMedida */

?>

<h1>Actualizar unidad de medida: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>