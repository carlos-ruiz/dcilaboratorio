<div style="overflow:auto; width:100%; height:350px;">
<h1>Contenido del modal</h1>
</div>
<script type="text/javascript">
	$("#modalCancelar").show();
	$("#modalGuardar").show();
	$("#modalTitle").text("Ejemplo de Modal");

	
</script>
<?php
$status = Status::model()->findByName("Proceso");
print_r($status);
//$orden = Ordenes::model()->findByPk(18);
// $aux=$orden->ordenTieneExamenes;
// $anterior=0;
//  foreach ($aux as $ordenExamen): 
// 	$detalleExamen=$ordenExamen->detalleExamen;
// 	$examen=$detalleExamen->examenes;
// 	if($examen->id!=$anterior){
// 		echo '<br />'.$examen->nombre;
// 	}
// 	echo '<br />'.$detalleExamen->descripcion." ".$ordenExamen->resultado." ".$detalleExamen->unidadesMedida->nombre;
// 	$anterior=$examen->id;
//  endforeach 
?>