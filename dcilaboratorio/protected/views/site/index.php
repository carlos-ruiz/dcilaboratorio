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


		<h3 class="form-title" style="color:#1e90ff !important;">Iniciar sesión</h3>
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
		<?php echo CHtml::submitButton('Entrar',array('class'=>'btn blue-stripe uppercase')); ?>
			<?php echo $form->checkBox($model,'rememberMe'); ?>
			<?php echo $form->label($model,'rememberMe',array('class'=>'rememberme check', 'style'=>'color: black !important;')); ?>
			<?php echo $form->error($model,'rememberMe'); ?>
		</div>

<?php $this->endWidget(); 

}
else{
?>


<div  class=" col-md-6 ">	
		<h3  class="heading text-center" style="color:#1e90ff ">Nuestras sucursales</h3>
		
	
	<div class="row">			
		<h5  class="heading" style="color:#1e90ff ">Unidad Chapultepec</h5>
		Gral. Nocolás Bravo No. 170 Col. Chapultepec Norte .P 58260
		<br />Tel. Fax. (443) 232 0166
		<br />Lunes a Sábado de 07:00 a 20:00 hrs. 
		<br /> Domingo 08:00 a 14:00 hrs.
	</div>
	<div class="row">			
		<h5  class="heading" style="color:#1e90ff ">Unidad Cancerología</h5>
		Francisco M. Díaz No. 145 Col. Ex Gobernador Gildardo Magaña .P 58149
		<br />Tel. Fax. (443) 232 01 65
		<br />Lunes a Sábado de 07:00 a 15:00 hrs. 
	</div>
	<div class="row">			
		<h5  class="heading" style="color:#1e90ff ">Unidad Amado Nervo</h5>
		Amado Nervo No. 392-4 Col. Centro .P 58000
		<br />Tel. Fax. (443) 326 98 91
		<br />Lunes a Sábado de 07:00 a 15:00 hrs. 
	</div>

		
	</div>
	

<div  id="slider" class=" col-md-6 text-right">
<figure>

<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/layout/img/lab5.png"  alt="">
<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/layout/img/lab1.jpg" WIDTH=450 HEIGHT=365  alt="">
<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/layout/img/lab2.jpg" WIDTH=450 HEIGHT=365 alt="">
<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/layout/img/lab.jpg" WIDTH=450 HEIGHT=365 alt="">
</figure>
</div>


	
<?php
}
?>
<style type="text/css">
	
	@keyframes slidy {
0% { left: 0%; }
20% { left: 0%; }
25% { left: -100%; }
45% { left: -100%; }
50% { left: -200%; }
70% { left: -200%; }
75% { left: -300%; }
95% { left: -300%; }
100% { left: -400%; }
}

body { margin: 0; } 
div#slider { overflow: hidden; }
div#slider figure img { width: 20%; float: left; }
div#slider figure { 
  position: relative;
  width: 500%;
  margin: 0;
  left: 0;
  text-align: left;
  font-size: 0;
  animation: 30s slidy infinite; 
}
</style>