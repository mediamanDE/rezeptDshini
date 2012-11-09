<?php
/* @var $this RationalController */
/* @var $model Rational */

$this->breadcrumbs=array(
	'Rationals'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Rational', 'url'=>array('index')),
	array('label'=>'Manage Rational', 'url'=>array('admin')),
);
?>

<h1>Create Rational</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>