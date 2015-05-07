<?php
/* @var $this GruposExamenesController */
/* @var $data GruposExamenes */
$detalles = GrupoExamenes::model()->findExamenesForGrupo($data->id);
?>

<tr class="grupo" data-id="<?php echo $data->id;?>">
	<td>
		<?php echo CHtml::encode($data->id); ?>
		<?php echo CHtml::encode($data->nombre); ?>
	</td>
	<td>
		<?php echo sizeof($detalles); ?>
	</td>
	<td width="55px" class="button-column">
		<a class="view" title="Ver" href="<?php echo Yii::app()->request->baseUrl; ?>/grupos/view/<?php echo $data->id;?>"><span><i class="fa fa-search"></i></span></a>
		<a class="update" title="Actualizar" href="<?php echo Yii::app()->request->baseUrl; ?>/grupos/update/<?php echo $data->id;?>"><span><i class="fa fa-pencil"></i></span> </a> 
		<a class="delete" title="Borrar" href="<?php echo Yii::app()->request->baseUrl; ?>/grupos/delete/<?php echo $data->id;?>"><span><i class="fa fa-trash-o"></i></span></a>

	</td>
</tr>
<tr id="detalles_<?php echo $data->id;?>" style="display:none">
	<td colspan="3">
		<ul>
			<?php 
				if(sizeof($detalles)==0){
					echo "<li>No hay examenes en este grupo</li>";
				}else{
					foreach ($detalles as $examen) {
						echo "<li>".$examen->nombre."</li>";
					}
				}
			?>
		</ul>
	</td>
</tr>

