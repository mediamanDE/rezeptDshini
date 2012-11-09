<?php
/* @var $this RecipeController */
/* @var $data Recipe */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ingredients')); ?>:</b>
	<?php echo CHtml::encode($data->ingredients); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('preparation')); ?>:</b>
	<?php echo CHtml::encode($data->preparation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('emotional')); ?>:</b>
	<?php echo CHtml::encode($data->emotional); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rational')); ?>:</b>
	<?php echo CHtml::encode($data->rational); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create')); ?>:</b>
	<?php echo CHtml::encode($data->create); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('update')); ?>:</b>
	<?php echo CHtml::encode($data->update); ?>
	<br />

	*/ ?>

</div>