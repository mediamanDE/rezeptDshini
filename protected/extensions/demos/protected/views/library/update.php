<?php
$this->breadcrumbs=array(
	'Libraries'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Library', 'url'=>array('index')),
	array('label'=>'Create Library', 'url'=>array('create')),
	array('label'=>'View Library', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Library', 'url'=>array('admin')),
);
?>

<h1>Update Library <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>