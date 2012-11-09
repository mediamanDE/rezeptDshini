<?php
/* @var $this EmotionalController */
/* @var $model Emotional */

$this->breadcrumbs=array(
	'Emotionals'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Emotional', 'url'=>array('index')),
	array('label'=>'Create Emotional', 'url'=>array('create')),
	array('label'=>'Update Emotional', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Emotional', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Emotional', 'url'=>array('admin')),
);
?>

<h1>View Emotional #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'create',
		'update',
	),
)); ?>
