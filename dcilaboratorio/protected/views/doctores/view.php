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
		'direccion.estado.nombre',
		'direccion.municipio.nombre',
		'direccion.colonia',
		'direccion.calle',
		'direccion.numero_ext',
		'direccion.num_int',		
		'direccion.codigo_postal',			
	),
)); ?>

<?php $user = Usuarios::model()->findByPk(Yii::app()->user->id); 

	if(Yii::app()->user->getState('perfil')=="Doctor") { ?>
	<br />
	<a class="btn blue red-stripe" href="<?php echo Yii::app()->controller->createUrl('/doctores/update',array('id'=>Yii::app()->user->getState('id_persona'))); ?>">
		Cambiar
	</a> <br /> <br />
<?php } ?>
