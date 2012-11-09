<?php
function displayServices($services) {
	$output = "";
	foreach($services as $i=>$service) $output.= ($i>0?', ':'').CHtml::encode($service->name);
	return $output;
}

function displayBooks($libraryBooks) {
	$output = "<ul>\n";
	foreach($libraryBooks as $libraryBook) {
		$output .= CHtml::tag('li',array(),CHtml::link("{$libraryBook->book->title} ($libraryBook->location)",array('book/show','id'=>$libraryBook->book->id)));
	}
	$output .= "</ul>\n";
	return $output;
}

$this->breadcrumbs=array(
	'Libraries'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Library', 'url'=>array('index')),
	array('label'=>'Create Library', 'url'=>array('create')),
	array('label'=>'Update Library', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Library', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Library', 'url'=>array('admin')),
);
?>

<h1>View Library #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		array(               // related services
            'label'=>$model->getAttributeLabel('services'),
            'type'=>'raw',
            'value'=>displayServices($model->services),
        ),
        array(               // related books
            'label'=>$model->getAttributeLabel('libraryBooks'),
            'type'=>'raw',
            'value'=>displayBooks($model->libraryBooks),
        ),
	),
)); ?>
