<?php
/* @var $this RationalController */
/* @var $model Rational */

$this->breadcrumbs=array(
	'Rationals'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Rational', 'url'=>array('index')),
	array('label'=>'Create Rational', 'url'=>array('create')),
	array('label'=>'View Rational', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Rational', 'url'=>array('admin')),
);
?>

<h1>Update Rational <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>