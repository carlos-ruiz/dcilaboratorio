<?php
/* @var $this ProfilesController */
/* @var $model Profiles */
$this->pageTitle="Perfiles";
?>

<h1>View Profiles #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
