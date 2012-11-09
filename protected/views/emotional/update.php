<?php
/* @var $this EmotionalController */
/* @var $model Emotional */

$this->breadcrumbs=array(
	'Emotionals'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Emotional', 'url'=>array('index')),
	array('label'=>'Create Emotional', 'url'=>array('create')),
	array('label'=>'View Emotional', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Emotional', 'url'=>array('admin')),
);
?>

<h1>Update Emotional <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>