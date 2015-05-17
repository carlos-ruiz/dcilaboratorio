<?php
/* @var $this DoctoresController */
/* @var $model Doctores */
?>

<h1>Nuevo doctor</h1>

<?php $this->renderPartial('_form', array(
	'model'=>$model,
	'contactos'=>$contactos,
	)); ?>