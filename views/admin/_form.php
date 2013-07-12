<?php
  $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'user-form',
    'focus'=>array($model, 'username'),
    'enableAjaxValidation'=>true,
    'htmlOptions' => array('enctype'=>'multipart/form-data'),
  ));
?>

	<p class="muted"><small><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></small></p>
	<?php echo $form->errorSummary(array($model, $profile)); ?>

  <?php echo $form->textFieldRow($model, 'username'); ?>
  <?php echo $form->passwordFieldRow($model, 'password'); ?>
  <?php echo $form->textFieldRow($model, 'email', array('class'=>'span5', 'maxlength'=>128)); ?>

  <?php
		$profileFields=$profile->getFields();
		if ($profileFields) {
			foreach($profileFields as $field) {
        echo $form->labelEx($profile,$field->varname);
        if ($widgetEdit = $field->widgetEdit($profile)) {
          echo $widgetEdit;
        } elseif ($field->range) {
          echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
        } elseif ($field->field_type=="TEXT") {
          echo CHtml::activeTextArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
        } else {
          echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
        }
        echo $form->error($profile,$field->varname);
			}
		}
  ?>

  <?php echo $form->dropDownListRow($model, 'status', User::itemAlias('UserStatus')); ?>
  <?php echo $form->dropDownListRow($model, 'superuser', User::itemAlias('AdminStatus')); ?>

  <?php echo $form->dropDownListRow($role, 'selected', CHtml::listData($role->getAllRoles(), 'value', 'text'), array('multiple'=>true, 'size'=>4)); ?>

  <div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>UserModule::t("Save"))); ?>
	</div>

<?php $this->endWidget(); ?>
