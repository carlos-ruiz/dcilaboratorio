<?php
/* @var $this GruposExamenesController */
/* @var $model GruposExamenes */

?>

<h1>Actualizar perfil/p. perfiles: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'examenes'=>$examenes)); ?>