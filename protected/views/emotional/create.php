<?php
/* @var $this EmotionalController */
/* @var $model Emotional */

$this->breadcrumbs=array(
	'Emotionals'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Emotional', 'url'=>array('index')),
	array('label'=>'Manage Emotional', 'url'=>array('admin')),
);
?>

<h1>Create Emotional</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>