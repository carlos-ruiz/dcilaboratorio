<?php
/* @var $this GruposExamenesController */
/* @var $model GruposExamenes */

?>
<h1>Nuevo grupo de exámenes</h1>
<?php $this->renderPartial('_form', array('model'=>$model,'examenes'=>$examenes,'tiene'=>$tiene)); ?>