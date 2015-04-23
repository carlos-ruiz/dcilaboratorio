<?php
/* @var $this SiteController */

header('Content-Type: text/html; charset=UTF-8');
mb_internal_encoding('UTF-8');
if(Yii::app()->user->isGuest){
?>

<?php 
}
?>

<?php
if(Yii::app()->user->isGuest){
 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'htmlOptions'=>array('class' => 'login-form'),
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>


		<h3 class="form-title" style="color:red !important;">Iniciar sesión</h3>
		<div class="alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span>
			Introduce usuario y contraseña </span>
		</div>


		<div class="form-group ">
			<?php echo $form->labelEx($model,'usuario', array('class'=>'control-label visible-ie8 visible-ie9')); ?>
			<?php echo $form->textField($model,'usuario',array('size'=>60,'maxlength'=>200, 'class'=>'form-control form-control-solid placeholder-no-fix', 'placeholder'=>'Usuario')); ?>
			<?php echo $form->error($model,'usuario', array('class'=>'help-block')); ?>
		</div>

		<div class="form-group ">
			<?php echo $form->labelEx($model,'contrasena', array('class'=>'control-label visible-ie8 visible-ie9')); ?>
			<?php echo $form->passwordField($model,'contrasena',array('class'=>'form-control form-control-solid placeholder-no-fix', 'type'=>'password', 'placeholder'=>'Contraseña')); ?>
			<?php echo $form->error($model,'contrasena', array('class'=>'help-block')); ?>

		</div>

		<div class="form-actions" style="color:black !important;">
		<?php echo CHtml::submitButton('Entrar',array('class'=>'btn green uppercase')); ?>
			<?php echo $form->checkBox($model,'rememberMe'); ?>
			<?php echo $form->label($model,'rememberMe',array('class'=>'rememberme check', 'style'=>'color: black !important;')); ?>
			<?php echo $form->error($model,'rememberMe'); ?>
		</div>

<?php $this->endWidget(); 

}
else{
?>
	<h1>Bienvenido <?php echo Yii::app()->user->name; ?></h1>
	<div id="chartdiv" style="width: 100%; height: 600px; background-color: #FFFFFF;" ></div>

	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<script type="text/javascript">
		$(document).ready(function(){
			AmCharts.makeChart("chartdiv",
				{
					"type": "pie",
					"pathToImages": "http://cdn.amcharts.com/lib/3/images/",
					"balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
					"depth3D": 10,
					"innerRadius": 90,
					"radius": 162,
					"pullOutEffect": "elastic",
					"startDuration": 2,
					"startEffect": "easeOutSine",
					"labelRadius": 10,
					"titleField": "source",
					"valueField": "value",
					"fontSize": 12,
					"theme": "default",
					"allLabels": [],
					"balloon": {},
					"titles": [],
					"dataProvider": [
						{
							"source": "Rótulo",
							"value": "1473"
						},
						{
							"source": "Guardia",
							"value": 229
						},
						{
							"source": "El norte",
							"value": 56
						},
						{
							"source": "Website",
							"value": 91
						},
						{
							"source": "Recomendado",
							"value": 223
						},
						{
							"source": "Otro",
							"value": 153
						},
						{
							"source": "Facebook",
							"value": "6"
						},
						{
							"source": "Portales externos",
							"value": "42"
						},
						{
							"source": "AMPI",
							"value": "0"
						},
						{
							"source": "Periódico",
							"value": "4"
						}
					]
				}
			);
		});
	</script>
<?php
}
?>
