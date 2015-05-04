<?php
/* @var $this EspecialidadesController */
/* @var $dataProvider CActiveDataProvider */
$this->breadcrumbs=array(
	'Especialidades'
);

$this->pageTitle="Especialidades";
?>

<h1>Especialidades</h1>
<div class="table-responsive">
	<table class="table table-bordered table-hover">
		<tr>
			<th>ID</th>
			<th>NOMBRE</th>
			<th>Última modificación</th>
			<th>Creación</th>
		</tr>
		<?php $this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$dataProvider,
			'itemView'=>'_view',
		)); ?>
	</table>
</div>
