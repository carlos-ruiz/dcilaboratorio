<?php
if($model->isNewRecord){
	$model->ultima_edicion='0000-00-00 00:00:00';
	$model->usuario_ultima_edicion=Yii::app()->user->id;
	$model->creacion=date('Y-m-d H:i:s');
	$model->usuario_creacion=Yii::app()->user->id;
	
}
else{
	$model->ultima_edicion=date('Y-m-d H:i:s');
	$model->usuario_ultima_edicion=Yii::app()->user->id;
}
?>

<?php echo $form->hiddenField($model,'ultima_edicion'); ?>
<?php echo $form->hiddenField($model,'usuario_ultima_edicion'); ?>
<?php echo $form->hiddenField($model,'creacion'); ?>
<?php echo $form->hiddenField($model,'usuario_creacion'); ?>