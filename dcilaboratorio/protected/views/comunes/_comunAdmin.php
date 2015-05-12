<?php
/* @var $this EspecialidadesController */
/* @var $model Especialidades */

?>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-globe"></i> <?php echo $titulo; ?>
		</div>
		<div class="tools">
		</div>
	</div>
	<div class="portlet-body">
		<div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
			<div class="row">
				<div class="col-md-12">
					
					<?php 
					array_push($columnas, array(
								'class'=>'CButtonColumn',
							));
					$this->widget('zii.widgets.grid.CGridView',array(
						'id'=>'especialidades-grid',
						'enableSorting'=>false,
						'itemsCssClass'=>'table table-striped table-bordered table-hover dataTable no-footer',
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
	$(document).ready(function(){
		if($('table')!=null){
			$('table').dataTable({
				'dom':'<"table-search"f>tipr',
				'lengthChange':false,
				'pageLength':20,
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
