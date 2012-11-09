<?php
/* @var $this RecipeController */
/* @var $model Recipe */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ingredients'); ?>
		<?php echo $form->textArea($model,'ingredients',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'preparation'); ?>
		<?php echo $form->textArea($model,'preparation',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'emotional'); ?>
		<?php echo $form->textField($model,'emotional'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rational'); ?>
		<?php echo $form->textField($model,'rational'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'create'); ?>
		<?php echo $form->textField($model,'create'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'update'); ?>
		<?php echo $form->textField($model,'update'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->