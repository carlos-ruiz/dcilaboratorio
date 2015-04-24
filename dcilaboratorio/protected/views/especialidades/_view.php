<?php
/* @var $this EspecialidadesController */
/* @var $data Especialidades */
?>

<div class="view">
	
	<tr>
		<td><?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?></td>
		<td><?php echo CHtml::encode($data->nombre); ?></td>
		<td><?php echo CHtml::encode($data->ultima_edicion); ?></td>
		<td><?php echo CHtml::encode($data->creacion); ?></td>
	</tr>

</div>