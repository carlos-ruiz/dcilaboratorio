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
		'usuario.usuario',
		'especialidad.nombre',
		array(
            'label'=>'Unidades responsables',
            'type'=>'raw',
            'value'=>$this->obtenerUnidadesResponsables($model, $this),
        ),
	),
)); ?>

<h3>Datos del contacto</h3>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'correo_electronico',
		array(
            'label'=>'Consultorio',
            'type'=>'raw',
            'value'=>$this->obtenerTelefonoConsultorio($model, $this),
        ),
        array(
            'label'=>'Celular',
            'type'=>'raw',
            'value'=>$this->obtenerTelefonoCelular($model, $this),
        ),
        array(
            'label'=>'Casa',
            'type'=>'raw',
            'value'=>$this->obtenerTelefonoCasa($model, $this),
        ),			
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

<h5>Datos del domicilio</h5>

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