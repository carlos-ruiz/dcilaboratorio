<?php
/* @var $this GruposExamenesController */
/* @var $model GruposExamenes */

?>

<h1>Actualizar grupo de exámenes <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'examenes'=>$examenes,'tiene'=>$tiene)); ?>