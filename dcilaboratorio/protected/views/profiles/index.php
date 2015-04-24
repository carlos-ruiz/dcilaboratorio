<?php
/* @var $this ProfilesController */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle="Perfiles";
?>

<h1>Profiles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
