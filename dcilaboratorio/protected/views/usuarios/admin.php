<h1>Administrar usuarios</h1>

<?php $this->renderPartial('/comunes/_comunAdmin', array('CGridViewOptions'=>array(
						'id'=>'especialidades-grid',
						'itemsCssClass'=>'table table-striped table-bordered table-hover dataTable no-footer',
						'dataProvider'=>$model->search(),
						'enablePagination' => false,
						'summaryText'=>'',//quitar contador de records
						'emptyText'=>'Sin resultados',
						//'filter'=>$model,
						'columns'=>array(
							'nombre',
							array(
								'class'=>'CButtonColumn',
							),
						),
					))); ?>
