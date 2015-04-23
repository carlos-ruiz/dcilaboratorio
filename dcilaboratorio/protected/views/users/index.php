<?php
/* @var $this UsersController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle="Usuarios";

?>

<h1>Usuarios</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
