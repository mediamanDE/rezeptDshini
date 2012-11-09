<?php
/* @var $this EmotionalController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Emotionals',
);

$this->menu=array(
	array('label'=>'Create Emotional', 'url'=>array('create')),
	array('label'=>'Manage Emotional', 'url'=>array('admin')),
);
?>

<h1>Emotionals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
