<?php
/* @var $this UsersController */
/* @var $model Users */

?>

<h1>Administrar usuarios</h1>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-globe"></i>Usuarios
		</div>
		<div class="tools">
		</div>
	</div>
	<div class="portlet-body">
		<div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
			<div class="row">
				<div class="col-md-12">
					<div class="btn-group tabletools-dropdown-on-portlet">
						<!--
						<a class="btn btn-sm default DTTT_button_pdf" id="ToolTables_sample_1_0"><span>PDF</span>
							<div style="position: absolute; left: 0px; top: 0px; width: 44px; height: 28px; z-index: 99;">
								<embed id="ZeroClipboard_TableToolsMovie_1" src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf" loop="false" menu="false" quality="best" bgcolor="#ffffff" width="44" height="28" name="ZeroClipboard_TableToolsMovie_1" align="middle" allowscriptaccess="always" allowfullscreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="id=1&amp;width=44&amp;height=28" wmode="transparent">
							</div>
						</a>
						<a class="btn btn-sm default DTTT_button_csv" id="ToolTables_sample_1_1"><span>CSV</span>
							<div style="position: absolute; left: 0px; top: 0px; width: 43px; height: 28px; z-index: 99;">
								<embed id="ZeroClipboard_TableToolsMovie_2" src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf" loop="false" menu="false" quality="best" bgcolor="#ffffff" width="43" height="28" name="ZeroClipboard_TableToolsMovie_2" align="middle" allowscriptaccess="always" allowfullscreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="id=2&amp;width=43&amp;height=28" wmode="transparent">
							</div>
						</a>
						<a class="btn btn-sm default DTTT_button_xls" id="ToolTables_sample_1_2"><span>Excel</span>
							<div style="position: absolute; left: 0px; top: 0px; width: 51px; height: 28px; z-index: 99;">
								<embed id="ZeroClipboard_TableToolsMovie_3" src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf" loop="false" menu="false" quality="best" bgcolor="#ffffff" width="51" height="28" name="ZeroClipboard_TableToolsMovie_3" align="middle" allowscriptaccess="always" allowfullscreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="id=3&amp;width=51&amp;height=28" wmode="transparent">
							</div>
						</a>
						<a class="btn btn-sm default DTTT_button_print" id="ToolTables_sample_1_3" title="View print view"><span>Print</span>
						</a>
						-->
					</div>

					<?php $this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'users-grid',
						'itemsCssClass'=>'table table-striped table-bordered table-hover dataTable no-footer',
						'dataProvider'=>$model->search(),
						'enablePagination' => false,
						'summaryText'=>'',//quitar contador de records
						'emptyText'=>'Sin resultados',
						//'filter'=>$model,
						'columns'=>array(
							'usuario',
							'perfil.nombre',
							/*
							'photo',
							'log',
							*/
							array(
								'class'=>'CButtonColumn',
							),
						),
					)); ?>
				</div>
			</div>
		</div>
	</div>
</div>



<script type="text/javascript">
$(document).ready(function(){
	$("table").dataTable();
});
</script>
