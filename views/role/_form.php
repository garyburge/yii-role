<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
  'id'=>'role-form',
  'focus'=>array($model, 'name'),
  'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block muted"><small>Fields with <span class="required">*</span> are required.</small></p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span3','maxlength'=>64)); ?>
	<?php echo $form->textAreaRow($model,'description',array('rows'=>2, 'class'=>'span5')); ?>
	<?php echo $form->textAreaRow($model,'bizrule',array('rows'=>2, 'class'=>'span5')); ?>
	<?php echo $form->textAreaRow($model,'data',array('rows'=>2, 'class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
