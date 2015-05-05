<?php
/* @var $this GruposExamenesController */
/* @var $dataProvider CActiveDataProvider */

?>

<h1>Grupos Examenes</h1>
<?php echo CHtml::link('Nuevo Grupo',array('create'), array('class'=>'btn green'));  ?>
<table class="table table-hover">
<thead>
	<tr>
		<th>Nombre</th>
		<th>Número Examenes</th>
		<th>Acciones</th>
	</tr>
</thead>
	<tbody>
		<?php $this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$dataProvider,
			'itemView'=>'_view',
		)); ?>
	</tbody>
</table>

<script type="text/javascript">
	$(".grupo").click(function(){
		$("#detalles_"+$(this).data('id')).toggle(500);
	});
</script>