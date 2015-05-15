<?php
/* @var $this EspecialidadesController */
/* @var $model Especialidades */

?>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			 <?php echo $titulo; ?>
		</div>
		<div class="tools">
		</div>
	</div>
	<div class="portlet-body">
		<div id="sample_1_wrapper" class="dataTables_wrapper">
			<div class="row">
				<div class="col-md-12">
					<?php 
			 		
					array_push($columnas, array(
											    'class'=>'CButtonColumn',
											    //'template'=>'{email}{down}{delete}',
											    'buttons'=>array
											    (
											        'activar' => array
											        (
											            'label'=>'<span class="icon-plus"></span>',
											            'visible'=>'isset($data->activo) && $data->activo ==0',
											            //'url'=>'Yii::app()->controller->createUrl("delete",array("id"=>"")).$data->id',
											            'options'=>array(  // this is the 'html' array but we specify the 'ajax' element
											            	'class'=>'activar',
											            	'title'=>'Reactivar',
													        

       													),
											            //'imageUrl' =>'false',
											        ),
											        'view'=>array(
											        	'label'=>'<span class="icon-eyeglasses"></span>',
								        				'visible'=>'(isset($data->activo) && $data->activo == 1) || !isset($data->activo)',
								        				'imageUrl'=>false,
											        ),
											        'update'=>array(
											        	'label'=>'<span class="fa fa-pencil"></span>',
								        				'visible'=>'(isset($data->activo) && $data->activo == 1) || !isset($data->activo)',
								        				'imageUrl'=>false,
											        ),
											        'borrar'=>array(
											        	'label'=>'<span class="fa fa-trash"></span>',
								        				'visible'=>'!isset($data->activo)',
								        				'url'=>'"#"',
								        				'imageUrl'=>false,
								        				'options'=>array(  // this is the 'html' array but we specify the 'ajax' element
								        					'class'=>'borrar',
								        					'title'=>'Eliminar',
       													),
								        			),
								        			'desactivar'=>array(
											        	'label'=>'<span class="fa fa-trash"></span>',
								        				'visible'=>'(isset($data->activo) && $data->activo == 1)',
								        				'url'=>'"#"',
								        				'imageUrl'=>false,
								           				'options'=>array(  // this is the 'html' array but we specify the 'ajax' element
								        					'class'=>'desactivar',
								        					'title'=>'Desactivar',
       													),
								        			),
											    ),
											    'template'=>'{activar} {view} {update} {borrar} {desactivar}',
											));

					$this->widget('zii.widgets.grid.CGridView',array(
						'id'=>'especialidades-grid',
						'rowHtmlOptionsExpression'=>'array("id"=>"row_".$data->id,"data-id"=>$data->id)',
						'enableSorting'=>false,
						'itemsCssClass'=>'table table-striped table-bordered table-hover',
						'dataProvider'=>$model->search(),
						'showTableOnEmpty'=>false,
						'enablePagination' => false,
						'selectableRows'=>0,
						'summaryText'=>'',//quitar contador de records
						'emptyText'=>'Sin '.strtolower($titulo). ' que mostrar',
						//'filter'=>$model,
						'columns'=>$columnas,
					));?>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">

	function activarFuncionesDeBorrado(){
		$(".borrar").click(function(ev){
			ev.preventDefault();
			idModel=$(this).parent().parent().data('id');
			$.post("<?php echo Yii::app()->controller->createUrl('delete'); ?>/"+idModel+"",function(data){
				$("#row_"+idModel).hide(400);
				$("#row_"+idModel).html(" ");
			});
		});

		$(".activar").click(function(ev){
			ev.preventDefault();
			idModel=$(this).parent().parent().data('id');
			column = $(this).parent();
			$.post("<?php echo Yii::app()->controller->createUrl('delete'); ?>/"+idModel+"",function(data){
				column.html('<a class="view" title="<span class=&quot;icon-eyeglasses&quot;></span>" href="<?php echo Yii::app()->controller->createUrl("view"); ?>/'+idModel+'"><span class="icon-eyeglasses"></span></a> <a class="update" title="<span class=&quot;fa fa-pencil&quot;></span>" href="#"><span class="fa fa-pencil"></span></a>  <a class="desactivar" title="Desactivar" href="#"><span class="fa fa-trash"></span></a>');
				$(".desactivar").click(function(ev){
					ev.preventDefault();
					idModel=$(this).parent().parent().data('id');
					column = $(this).parent();
					$.post("<?php echo Yii::app()->controller->createUrl('delete'); ?>/"+idModel+"",function(data){
						column.html('<a class="activar" title="Reactivar" href="#"><span class="icon-plus"></span></a>');
						//activarFuncionesDeBorrado();
					});
				});
			});
		});
		$(".desactivar").click(function(ev){
			ev.preventDefault();
			idModel=$(this).parent().parent().data('id');
			column = $(this).parent();
			$.post("<?php echo Yii::app()->controller->createUrl('delete'); ?>/"+idModel+"",function(data){
				column.html('<a class="activar" title="Reactivar" href="#"><span class="icon-plus"></span></a>');
				$(".activar").click(function(ev){
					ev.preventDefault();
					idModel=$(this).parent().parent().data('id');
					column = $(this).parent();
					$.post("<?php echo Yii::app()->controller->createUrl('delete'); ?>/"+idModel+"",function(data){
						column.html('<a class="view" title="<span class=&quot;icon-eyeglasses&quot;></span>" href="<?php echo Yii::app()->controller->createUrl("view"); ?>/'+idModel+'"><span class="icon-eyeglasses"></span></a> <a class="update" title="<span class=&quot;fa fa-pencil&quot;></span>" href="#"><span class="fa fa-pencil"></span></a>  <a class="desactivar" title="Desactivar" href="#"><span class="fa fa-trash"></span></a>');
						//activarFuncionesDeBorrado();
					});
				});
			});
		});
		

	}
		
	$(document).ready(function(){
		activarFuncionesDeBorrado();

		if($('table')!=null){
			$('table').dataTable({
				'dom':'<"table-search"f>tipr',
				'lengthChange':false,
				'pageLength':20,
				"order": [],
				"language":{
					"emptyTable":     "Sin <?php echo $titulo;?> que mostrar",
				    "info":           "Mostrando _START_ a _END_ de _TOTAL_",
				    "infoEmpty":      "Mostrando 0 a 0 de 0",
				    "infoFiltered":   "(filtrando de _MAX_ registros)",
				    "infoPostFix":    "",
				    "thousands":      ",",
				    "lengthMenu":     "Mostrando _MENU_ registros",
				    "loadingRecords": "Cargando...",
				    "processing":     "Procesando...",
				    "search":         "Buscar:",
				    "zeroRecords":    "No se encontraron resultados",
				    "paginate": {
				        "first":      "Inicio",
				        "last":       "Fin",
				        "next":       "Siguiente",
				        "previous":   "Anterior"
				    },
				    "aria": {
				        "sortAscending":  ": Activar orden ascendente",
				        "sortDescending": ": Activar orden descendente"
				    }
				}
				
			});
		}
	});


		
	

</script>
