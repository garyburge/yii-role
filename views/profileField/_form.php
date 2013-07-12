<?php
  $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'profile-field-form',
    'focus'=>array($model, ($model->isNewRecord ? 'varname' : 'title')),
  ));
?>

	<p class="muted"><small><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></small></p>
	<?php echo $form->errorSummary($model); ?>

  <?php echo $form->textFieldRow($model, 'varname', ($model->isNewRecord ? array('maxlength'=>50) : array('maxlength'=>50, 'readonly'=>true, 'disabled'=>true, 'class'=>'uneditable-input'))); ?>
	<p class="help-block"><?php echo UserModule::t("Allowed lowercase letters and digits."); ?></p>

  <?php echo $form->textFieldRow($model, 'title'); ?>
  <p class="help-block"><?php echo UserModule::t('Field name on the language of "sourceLanguage".'); ?></p>

  <?php echo $model->isNewRecord ?
    $form->dropDownListRow($model, 'field_type', ProfileField::itemAlias('field_type'), array('maxlength'=>50, 'id'=>'field_type')) :
    $form->textFieldRow($model, 'field_type', array('maxlength'=>50, 'id'=>'field_type', 'readonly'=>true, 'disabled'=>true, 'class'=>'uneditable-input'));
  ?>
  <p class="help-block"><?php echo UserModule::t('Field type column in the database.'); ?></p>

  <?php echo $form->textFieldRow($model, 'field_size', ($model->isNewRecord ? array('class'=>'span2') : array('class'=>'span2', 'readonly'=>true, 'disabled'=>true))); ?>
  <p class="help-block"><?php echo UserModule::t('Field size column in the database.'); ?></p>

  <?php echo $form->textFieldRow($model, 'field_size_min', array('class'=>'span2')); ?>
  <p class="help-block"><?php echo UserModule::t('The minimum value of the field (form validator).'); ?></p>

  <?php echo $form->dropDownListRow($model, 'required', ProfileField::itemAlias('required')); ?>
  <p class="help-block"><?php echo UserModule::t('Required field (form validator).'); ?></p>

  <?php echo $form->textFieldRow($model, 'match', array('class'=>'span4', 'maxlength'=>255)); ?>
  <p class="help-block"><?php echo UserModule::t("Regular expression (example: '/^[A-Za-z0-9\s,]+$/u')."); ?></p>

  <?php echo $form->textFieldRow($model, 'range', array('class'=>'span6', 'maxlength'=>5000)); ?>
  <p class="help-block"><?php echo UserModule::t('Predefined values (example: 1;2;3;4;5 or 1==One;2==Two;3==Three;4==Four;5==Five).'); ?></p>

  <?php echo $form->textFieldRow($model, 'error_message', array('class'=>'span6', 'maxlength'=>255)); ?>
  <p class="help-block"><?php echo UserModule::t('Error message when you validate the form.'); ?></p>

  <?php echo $form->textFieldRow($model, 'other_validator', array('class'=>'span6', 'maxlength'=>255)); ?>
  <p class="help-block"><?php echo UserModule::t('JSON string (example: {example}).',array('{example}'=>CJavaScript::jsonEncode(array('file'=>array('types'=>'jpg, gif, png'))))); ?></p>

  <?php echo $form->textFieldRow($model, 'default', ($model->isNewRecord ? array('class'=>'span5', 'maxlength'=>255) : array('class'=>'span5', 'maxlength'=>255, 'readonly'=>true, 'disabled'=>true))); ?>
  <p class="help-block"><?php echo UserModule::t('The value of the default field (database).'); ?></p>

  <?php list($widgetsList) = ProfileFieldController::getWidgets($model->field_type); ?>
  <?php echo $form->dropDownListRow($model, 'widget', $widgetsList, array('id'=>'widgetlist')); ?>
  <p class="help-block"><?php echo UserModule::t('Widget name.'); ?></p>

  <?php echo $form->textFieldRow($model, 'widgetparams', array('class'=>'span6', 'maxlength'=>5000, 'id'=>'widgetparams')); ?>
  <p class="help-block"><?php echo UserModule::t('JSON string (example: {example}).',array('{example}'=>CJavaScript::jsonEncode(array('param1'=>array('val1','val2'),'param2'=>array('k1'=>'v1','k2'=>'v2'))))); ?></p>

  <?php echo $form->textFieldRow($model, 'position', array('class'=>'span2')); ?>
  <p class="help-block"><?php echo UserModule::t('Display order of fields.'); ?></p>

  <?php echo $form->textFieldRow($model, 'visible', ProfileField::itemAlias('visible')); ?>

  <div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save')))); ?>
  </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<div id="dialog-form" title="<?php echo UserModule::t('Widget parametrs'); ?>">
	<form>
	<fieldset>
		<label for="name">Name</label>
		<input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all" />
		<label for="value">Value</label>
		<input type="text" name="value" id="value" value="" class="text ui-widget-content ui-corner-all" />
	</fieldset>
	</form>
</div>
