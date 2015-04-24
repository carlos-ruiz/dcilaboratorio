<?php
/* @var $this UsersController */
/* @var $model Users */

?>

<h1>Modificar Usuario <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>