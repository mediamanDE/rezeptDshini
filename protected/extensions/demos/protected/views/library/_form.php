<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'library-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	
	<?php 
	$selected_services = array(); 
	foreach($model->services as $service) array_push($selected_services, $service->id);
	?>
	<div class="row">
		<?php echo CHtml::label($model->getAttributeLabel('services'),'Services'); ?>
		<div class="portlet-content">
		<?php echo CHtml::checkBoxList('Services', $selected_services, CHtml::listData(Service::model()->findAll(),'id','name'),array('template'=>'{input} {label}','labelOptions'=>array('style'=>'display:inline;'))); ?>
		<?php echo $form->error($model,'services'); ?>
		</div>
	</div>
	
	<div class="row">
		<div class="portlet-content">
		<table>
			<caption><?php echo CHtml::encode($model->getAttributeLabel('libraryBooks')); ?></caption>
			<thead>
				<tr>
					<th><?php echo CHtml::encode(LibraryBook::model()->getAttributeLabel('bookISBN')); ?>
					</th>
					<th><?php echo CHtml::encode(LibraryBook::model()->getAttributeLabel('location')); ?>
					</th>
					<th>Actions
					</th>
				</tr>
			</thead>
			<tbody>
			
			<?php if (is_array($model->libraryBooks)) {  ?>
			<?php  foreach ($model->libraryBooks as $idx=>$libraryBook) { ?>
				<tr>
					<td>
					<?php 
					$this->widget('CAutoComplete',
						array(
							'model'=>$libraryBook,
							'attribute'=>"[$idx]bookISBN",
							'url'=>array('book/bookLookup'),
							'htmlOptions'=>array('size'=>22,'maxlength'=>22),
							'methodChain'=>'.result(function(event,item){$(this).val(item[1]);})'
						)
					); 
					?>
					<?php echo CHtml::error($libraryBook,"bookISBN"); ?></td>
					<td><?php echo CHtml::activeTextField($libraryBook,"[$idx]location",array('size'=>22,'maxlength'=>22)); ?>
					<?php echo CHtml::error($libraryBook,"location"); ?></td>
					<td><?php echo CHtml::linkButton('Delete',array(
				      	  'submit'=>'',
				      	  'params'=>array('deletebook'=>'1','idx'=>$idx),
				      	  'confirm'=>"Do you really want to delete this book ?")); ?>
					</td>
				</tr>
				<?php } ?>
				<?php } ?>
			</tbody>
		</table>
		<?php echo CHtml::submitButton('Add a book',array('name'=>'addbook')); ?>
		</div>
	</div>
	
	<div class="row">
		<div class="portlet-content">
		<table>
			<caption><?php echo CHtml::encode($model->getAttributeLabel('libraryComments')); ?></caption>
			<thead>
				<tr>
					<th><?php echo CHtml::encode(LibraryBook::model()->getAttributeLabel('comment')); ?>
					</th>
					<th>Actions
					</th>
				</tr>
			</thead>
			<tbody>
			
			<?php if (is_array($model->libraryComments)) {  ?>
			<?php  foreach ($model->libraryComments as $idx=>$libraryComment) { ?>
				<tr>
					<td><?php echo $libraryComment->id ? CHtml::activeHiddenField($libraryComment,"[$idx]id") : ""; ?><?php echo CHtml::activeTextArea($libraryComment,"[$idx]comment"); ?>
					<?php echo CHtml::error($libraryComment,"comment"); ?></td>
					<td><?php echo CHtml::linkButton('Delete',array(
				      	  'submit'=>'',
				      	  'params'=>array('deletecomment'=>'1','idx'=>$idx),
				      	  'confirm'=>"Do you really want to delete this comment ?")); ?>
					</td>
				</tr>
				<?php } ?>
				<?php } ?>
			</tbody>
		</table>
		<?php echo CHtml::submitButton('Add a comment',array('name'=>'addcomment')); ?>
		</div>
	</div>
	
	<div class="row buttons">
		
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->