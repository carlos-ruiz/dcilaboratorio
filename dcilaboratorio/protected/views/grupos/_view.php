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
		<a class="update" title="Actualizar" href="/techinc/dcilaboratorio/grupos/update/<?php echo $data->id;?>"><span><i class="icon-pencil"></i></span> </a> 
		<a class="delete" title="Borrar" href="/techinc/dcilaboratorio/grupos/delete/<?php echo $data->id;?>"><span><i class="icon-delete">X</i></span></a>
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

