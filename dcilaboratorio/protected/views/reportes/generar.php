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
                            <th width="20%"> Code </th>
                            <th> Company </th>
                            <th class="numeric"> Price </th>
                            <th class="numeric"> Change </th>
                            <th class="numeric"> Change % </th>
                            <th class="numeric"> Open </th>
                            <th class="numeric"> High </th>
                            <th class="numeric"> Low </th>
                            <th class="numeric"> Volume </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> AAC </td>
                            <td> AUSTRALIAN AGRICULTURAL COMPANY LIMITED. </td>
                            <td class="numeric"> &nbsp; </td>
                            <td class="numeric"> -0.01 </td>
                            <td class="numeric"> -0.36% </td>
                            <td class="numeric"> $1.39 </td>
                            <td class="numeric"> $1.39 </td>
                            <td class="numeric"> &nbsp; </td>
                            <td class="numeric"> 9,395 </td>
                        </tr>
                        <tr>
                            <td> AAD </td>
                            <td> ARDENT LEISURE GROUP </td>
                            <td class="numeric"> $1.15 </td>
                            <td class="numeric"> +0.02 </td>
                            <td class="numeric"> 1.32% </td>
                            <td class="numeric"> $1.14 </td>
                            <td class="numeric"> $1.15 </td>
                            <td class="numeric"> $1.13 </td>
                            <td class="numeric"> 56,431 </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
	</div>
	<div class="col-md-3">
		<?php
			$this->renderPartial("_form",array('model'=>$model));
		?>
	</div>
</div>
