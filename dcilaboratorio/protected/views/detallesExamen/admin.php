<?php
/* @var $this DetallesExamenController */
/* @var $model DetallesExamen */
?>

<h1>Administrar resultados de exámenes</h1>
<div class="text-right">
	<?php echo CHtml::link('<i class="icon-plus"></i> Nuevo resultado de examen', array('detallesExamen/create'), array('class'=>'btn')); ?>
</div>

<?php $this->renderPartial('/comunes/_comunAdmin', array('CGridViewOptions'=>array(
						'id'=>'edetalles-examen-grid',
						'itemsCssClass'=>'table table-striped table-bordered table-hover dataTable no-footer',
						'dataProvider'=>$model->search(),
						'enablePagination' => false,
						'summaryText'=>'',//quitar contador de records
						'emptyText'=>'Sin resultados',
						//'filter'=>$model,
						'columns'=>array(
							'examenes.nombre',
							'descripcion',
							'unidadesMedida.nombre',
							array(
								'class'=>'CButtonColumn',
							),
						),
					))); 

					?>
