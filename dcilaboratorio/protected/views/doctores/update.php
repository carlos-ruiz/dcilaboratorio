<?php
/* @var $this DoctoresController */
/* @var $model Doctores */

$this->pageTitle="Doctores";

$this->breadcrumbs=array(
	'Doctores'=>array('index'),
	'Actualizar doctor',
);

?>

<h1>Update Doctores <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>