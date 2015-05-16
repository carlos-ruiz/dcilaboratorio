<?php
/* @var $this DoctoresController */
/* @var $model Doctores */

?>

<h1>Doctor: <?php echo $model->nombre,' '. $model->a_paterno.' '.$model->a_materno ?></h1>
<h3>Datos Generales</h3>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'usuarios.usuario',
		'especialidades.nombre',
		'porcentaje',	
		'unidadTieneDoctores.id_uniad_responsable.nombre'
	),
)); ?>

<h3>Datos del contacto</h3>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'correo_electronico',
		'telefono',
		'celular',
		'casa',				
	),
)); ?>
<h5>Horario de consulta</h5>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'hora_consulta_de',
		'hora_consulta_hasta',			
	),
)); ?>

<h5>Dactos del domicilio</h5>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'estado',
		'colonia',
		'ciudad',
		'calle',
		'numero_ext',
		'numero_int',		
		'codigo_postal',			
	),
)); ?>


<?php /*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'usuarios.usuario',
		'titulos.nombre',
		'nombre',
		'a_paterno',
		'a_materno',
		'especialidades.nombre',
		'correo_electronico',
		'hora_consulta_de',
		'hora_consulta_hasta',
		'porcentaje',
		'calle',
		'ciudad',
		'colonia',
		'estado',
		'codigo_postal',
		'numero_ext',
		'numero_int',	
	),
)); */?>