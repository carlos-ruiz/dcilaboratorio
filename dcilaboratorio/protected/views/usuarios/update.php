<?php
/* @var $this UsersController */
/* @var $model Users */

?>

<h1>Actualizar usuario: <?php echo $model->usuario; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>