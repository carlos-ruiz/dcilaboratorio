<?php
/* @var $this ExamenesController */
/* @var $model Examenes */

?>

<h1>Administrar exámenes</h1>

<?php $this->renderPartial('/comunes/_comunAdmin', array('CGridViewOptions'=>array(
						'id'=>'examenes-grid',
						'itemsCssClass'=>'table table-striped table-bordered table-hover dataTable no-footer',
						'dataProvider'=>$model->search(),
						'enablePagination' => false,
						'summaryText'=>'',//quitar contador de records
						'emptyText'=>'Sin resultados',
						//'filter'=>$model,
						'columns'=>array(
							'clave',
							'nombre',
							'descripcion',
							'duracion_dias',
							array(
								'class'=>'CButtonColumn',
							),
						),
					))); 

					?>


