<?php
/* @var $this DoctoresController */
/* @var $model Doctores */

$this->pageTitle="Doctores";
?>

<h1>Administrar doctores</h1>

<?php echo CHtml::button('Nuevo doctor', array('class'=>'btn btn-sm green','submit'=>array('doctores/create'))); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'doctores-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nombre',
		'a_paterno',
		'a_materno',
		'correo_electronico',
		'hora_consulta_de',
		/*
		'hora_consulta_hasta',
		'porcentaje',
		'calle',
		'ciudad',
		'colonia',
		'estado',
		'codigo_postal',
		'numero_ext',
		'numero_int',
		'id_especialidades',
		'id_titulos',
		'id_usuarios',
		'ultima_edicion',
		'usuario_ultima_edicion',
		'creacion',
		'usuario_creacion',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
