<?php
/* @var $this UsersController */
/* @var $model Users */

?>

<h1>Administrar usuarios</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'users-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		'usuario',
		/*
		'photo',
		'log',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<script type="text/javascript">
$(document).ready(function(){
	$("table").dataTable();
});
</script>
