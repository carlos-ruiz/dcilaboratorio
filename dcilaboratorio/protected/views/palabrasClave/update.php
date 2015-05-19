<?php
/* @var $this PalabrasClaveController */
/* @var $model PalabrasClave */

?>

<h1>Actualizar palabra clave: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>