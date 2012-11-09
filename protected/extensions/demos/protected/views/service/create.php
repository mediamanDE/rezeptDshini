<?php
$this->breadcrumbs=array(
	'Services'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Service', 'url'=>array('index')),
	array('label'=>'Manage Service', 'url'=>array('admin')),
);
?>

<h1>Create Service</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>