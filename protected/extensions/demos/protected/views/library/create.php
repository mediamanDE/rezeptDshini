<?php
$this->breadcrumbs=array(
	'Libraries'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Library', 'url'=>array('index')),
	array('label'=>'Manage Library', 'url'=>array('admin')),
);
?>

<h1>Create Library</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>