<?php
/* @var $this RecipeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Recipes',
);

$this->menu=array(
	array('label'=>'Create Recipe', 'url'=>array('create')),
	array('label'=>'Manage Recipe', 'url'=>array('admin')),
);
?>

<h1>Recipes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
