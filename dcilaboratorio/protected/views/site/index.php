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
	<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
	<center><img src="<?php echo Yii::app()->request->baseUrl; ?>/css/layout/img/gvia_logo_6.png" alt=""/></center>
	<br /><br />
	<center>En construcción...</center>
<?php
}
?>
