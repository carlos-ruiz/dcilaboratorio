<?php
/* @var $this UsersController */
/* @var $model Users */
$this->pageTitle="Titulos";
$this->breadcrumbs=array(
	'Titulos'=>array('admin'),
	'Nuevo',
);

?>

<h1>Nuevo Título</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>