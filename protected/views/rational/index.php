<?php
/* @var $this RationalController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Rationals',
);

$this->menu=array(
	array('label'=>'Create Rational', 'url'=>array('create')),
	array('label'=>'Manage Rational', 'url'=>array('admin')),
);
?>

<h1>Rationals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
