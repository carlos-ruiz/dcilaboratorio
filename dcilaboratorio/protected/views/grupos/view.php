<?php
/* @var $this GruposExamenesController */
/* @var $model GruposExamenes */
?>

<h1>Grupo de examenes: <?php echo $model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'id',
		'nombre'
	),

)); ?>

<h3>Exámenes para el grupo</h3>
<table class="table table-striped table-bordered dataTable">
<?php foreach ($model->grupoTiene as $tiene) {
	echo "<tr><td>".$tiene->examen->nombre."</td></tr>";
} ?>
</table>
