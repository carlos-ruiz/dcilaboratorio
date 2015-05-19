<?php
/* @var $this ProfilesController */
/* @var $model Profiles */

$this->pageTitle="Perfiles";
?>

<h1>Update Profiles <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>