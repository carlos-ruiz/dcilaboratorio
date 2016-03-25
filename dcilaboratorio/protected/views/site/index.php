<?php
/* @var $this SiteController */

header('Content-Type: text/html; charset=UTF-8');
mb_internal_encoding('UTF-8');

if(Yii::app()->user->isGuest){

$form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'htmlOptions'=>array('class' => 'login-form'),
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); 

?>


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
	<div class="row">
		<div class="col-md-3"></div>
		<div  id="slider" class=" col-md-6 text-right">
			<figure>
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/layout/img/lab5.png" WIDTH=470 HEIGHT=365 alt="">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/layout/img/lab1.jpg" WIDTH=470 HEIGHT=365  alt="">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/layout/img/lab2.jpg" WIDTH=470 HEIGHT=365 alt="">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/layout/img/lab.jpg" WIDTH=470 HEIGHT=365 alt="">
			</figure>
		</div>
	</div>
	<div class="row text-center">
		<h2><?php echo $sloganActual->slogan; if(Yii::app()->user->getState('perfil')=='Administrador') { ?>
			<a href="<?php echo CController::createUrl('site/loadModalSlogan');?>" data-target="#modal" data-toggle="modal"><i class='fa fa-pencil'></i></a>
		<?php
		}
		?></h2>

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