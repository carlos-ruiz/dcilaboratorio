<?php
/* @var $this GruposExamenesController */
/* @var $model GruposExamenes */
?>



<h1>Administrar grupos de exámenes</h1>
<div class="text-right">
	<?php echo CHtml::link('<i class="icon-plus"></i> Nuevo grupo de examenes', array('grupos/create'), array('class'=>'btn')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'grupos-examenes-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nombre',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
