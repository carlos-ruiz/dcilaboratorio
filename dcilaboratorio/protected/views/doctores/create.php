<?php
/* @var $this DoctoresController */
/* @var $model Doctores */

$this->pageTitle="Doctores";

$this->breadcrumbs=array(
	'Doctores'=>array('admin'),
	'Nuevo doctor',
);
?>

<h1>Nuevo doctor</h1>

<?php $this->renderPartial('_form', array(
	'model'=>$model, 
	'contactos'=>$contactos, 
	'telefonos'=>$telefonos)); ?>