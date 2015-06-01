<?php
/* @var $this UnidadesResponsablesController */
/* @var $model UnidadesResponsables */

?>

<h1>Unidad Responsable: <?php echo $model->nombre; ?></h1>
<h3>Datos Generales</h3>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'nombre',
		'clave',
		'responsable_sanitario',
		'responsable_administrativo',
		'sugerencias',
		array(
            'label'=>'Teléfono',
            'type'=>'raw',
            'value'=>$this->obtenerTelefono($model, $this),
        ),
	),
)); ?>

<h4>Horario de consulta</h4>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'hora_inicial',
		'hora_final',			
	),
)); ?>

<h4>Datos del domicilio</h4>

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
