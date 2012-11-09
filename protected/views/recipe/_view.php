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
		<div class="portlet-content">
			<?php foreach($data->emotional as $emotional) { ?>
				<span> <?php echo CHtml::encode($emotional->title)."  ";?> </span>
			<?php }?>
		</div>



	<b><?php echo CHtml::encode($data->getAttributeLabel('rational')); ?>:</b>
		<div class="portlet-content">
			<?php foreach($data->rational as $rational) { ?>
				<span> <?php echo CHtml::encode($rational->title)."  ";?> </span>
			<?php }?>
		</div>
	
	<?php 
		$selectedRational = array(); 
		foreach($data->rational as $rational) array_push($selectedRational, $rational->id);
	?>
	
		
	<br />

</div>