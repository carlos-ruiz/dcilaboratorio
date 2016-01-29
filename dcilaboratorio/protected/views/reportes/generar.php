<?php
/* @var $this UsersController */
/* @var $model Users */
?>

<h1>Reportes</h1>
<div class="col-md-12">
	<div class="col-md-9">
	<?php print_r($resultadosMostrar); ?>
	<?= '<br/><br/>' ?>
	<?php print_r($resultados); ?>
		<div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">Resultados</div>
            </div>
            <div class="portlet-body flip-scroll">
                <table class="table table-bordered table-striped table-condensed flip-content">
                    <thead class="flip-content">
                        <tr>
                            <?php foreach ($resultadosMostrar as $resultadoMostrar) { ?>
                                <th><?= utf8_decode($resultadoMostrar['nombre']) ?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <?php 
                        foreach ($resultados as $resultado) { 
                            $orden = Ordenes::model()->findByPk($resultado['id']);
                            if (isset($orden)) { ?>
                            <tr>

                        <?php   foreach ($resultadosMostrar as $resultadoMostrar) { 
                                    if ($resultadoMostrar['id']=='day') {
                                        echo "<td>dia</td>";
                                    }
                                    if ($resultadoMostrar['id']=='month') {
                                        echo "<td>dia</td>";
                                    }
                                    if ($resultadoMostrar['id']=='year') {
                                        echo "<td>dia</td>";
                                    }
                                    if ($resultadoMostrar['id']=='week') {
                                        echo "<td>dia</td>";
                                    }
                                    if ($resultadoMostrar['id']=='hr') {
                                        echo "<td>dia</td>";
                                    }
                                    if ($resultadoMostrar['id']=='folio') {
                                        echo "<td>$orden->id</td>";
                                    }
                                    if ($resultadoMostrar['id']=='idp') {
                                        echo "<td>dia</td>";
                                    }
                                    if ($resultadoMostrar['id']=='namep') {
                                        echo "<td>dia</td>";
                                    }
                                    if ($resultadoMostrar['id']=='ur') {
                                        echo "<td>dia</td>";
                                    }
                                    if ($resultadoMostrar['id']=='dr') {
                                        echo "<td>dia</td>";
                                    }
                                    if ($resultadoMostrar['id']=='exam') {
                                        echo "<td>dia</td>";
                                    }
                                    if ($resultadoMostrar['id']=='cost') {
                                        echo "<td>dia</td>";
                                    }
                                    if ($resultadoMostrar['id']=='discp') {
                                        echo "<td>dia</td>";
                                    }
                                    if ($resultadoMostrar['id']=='disa') {
                                        echo "<td>dia</td>";
                                    }
                                    if ($resultadoMostrar['id']=='tarifa') {
                                        echo "<td>dia</td>";
                                    }
                                } ?>
                            </tr>
                        <?php
                            }
                        } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
	</div>
	<div class="col-md-3">
		<?php $this->renderPartial("_form",array('model'=>$model)); ?>
	</div>
</div>
