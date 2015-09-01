<h1>Paciente: <?php echo $model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'nombre',
		'a_paterno',
		'a_materno',
		'fecha_nacimiento',
		'email',
		'telefono',
	),
)); ?>
<br />
<?php $user = Usuarios::model()->findByPk(Yii::app()->user->id); 
	if(Yii::app()->user->getState('perfil')=="Paciente") { ?>
	<a class="btn blue red-stripe" href="<?php echo Yii::app()->controller->createUrl('/pacientes/update',array('id'=>$user->ordenFacturacion->id_pacientes)); ?>">
		Cambiar
	</a>
<?php } ?>