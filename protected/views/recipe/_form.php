<?php
/* @var $this RecipeController */
/* @var $model Recipe */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'recipe-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ingredients'); ?>
		<?php echo $form->textArea($model,'ingredients',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'ingredients'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'preparation'); ?>
		<?php echo $form->textArea($model,'preparation',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'preparation'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'emotional'); ?>
		<?php echo $form->dropDownList($model,'emotional', array(
			'deftig',
			'leicht',
			'süß',
			'ausgefallen/ abgefahren',
			'saisonal',
			'Sportlernahrung (viele Kohlenhydrate)',
			'Schlank im Schlaf (Hoher Eiweißanteil)',

		)); ?>
		<?php echo $form->error($model,'emotional'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rational'); ?>
		<?php echo $form->dropDownList($model,'rational', array(
			'vegetarisch',
			'vegan',
			'Mit Fleisch',
			'Mit Fisch',
		)); ?>
		<?php echo $form->error($model,'rational'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->