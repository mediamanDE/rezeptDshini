<?php
/* @var $this RationalController */
/* @var $model Rational */

$this->breadcrumbs=array(
	'Rationals'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Rational', 'url'=>array('index')),
	array('label'=>'Create Rational', 'url'=>array('create')),
	array('label'=>'Update Rational', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Rational', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Rational', 'url'=>array('admin')),
);
?>

<h1>View Rational #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'create',
		'update',
	),
)); ?>
