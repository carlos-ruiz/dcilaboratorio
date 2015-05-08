<?php
/* @var $this DoctoresController */
/* @var $model Doctores */

?>

<h1>Actualizar doctor: <?php echo $model->nombre.' '.$model->a_paterno.' '.$model->a_materno; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'contacto'=>$contacto)); ?>