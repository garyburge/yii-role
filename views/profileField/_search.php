<?php
  $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'focus'=>array($model, 'id'),
  ));
?>

  <hr>
  <p class="muted"><small><?php echo UserModule::t("You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done."); ?></small></p>

  <div class="row">
    <div class="span5">
      <?php echo $form->textFieldRow($model, 'id', array('id'=>'id')); ?>
      <?php echo $form->textFieldRow($model, 'varname', array('class'=>'span4', 'maxlength'=>50)); ?>
      <?php echo $form->textFieldRow($model, 'title', array('class'=>'span4', 'maxlength'=>255)); ?>
      <?php echo $form->dropDownListRow($model, 'field_type', CMap::mergeArray(array(''=>''), ProfileField::itemAlias('field_type'))); ?>
      <?php echo $form->textFieldRow($model, 'field_size'); ?>
      <?php echo $form->textFieldRow($model, 'field_size_min'); ?>
      <?php echo $form->dropDownListRow($model, 'required', CMap::mergeArray(array(''=>''), ProfileField::itemAlias('required'))); ?>
      <?php echo $form->textFieldRow($model, 'match', array('class'=>'span5', 'maxlength'=>255)); ?>
    </div><!-- .span6 -->
    <div class="span6">
      <?php echo $form->textFieldRow($model, 'range', array('class'=>'span4', 'maxlength'=>255)); ?>
      <?php echo $form->textFieldRow($model, 'error_message', array('class'=>'span6', 'maxlength'=>255)); ?>
      <?php echo $form->textFieldRow($model, 'other_validator', array('class'=>'span6', 'maxlength'=>5000)); ?>
      <?php echo $form->textFieldRow($model, 'default', array('class'=>'span4', 'maxlength'=>255)); ?>
      <?php echo $form->textFieldRow($model, 'widget', array('class'=>'span4', 'maxlength'=>255)); ?>
      <?php echo $form->textFieldRow($model, 'widgetparams', array('class'=>'span5', 'maxlength'=>5000)); ?>
      <?php echo $form->textFieldRow($model, 'position', array('class'=>'span2')); ?>
      <?php echo $form->dropDownListRow($model, 'visible', CMap::mergeArray(array(''=>''), ProfileField::itemAlias('visible'))); ?>
    </div><!-- .span6 -->
  </div><!-- .form -->

  <div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>UserModule::t('Search'))); ?>
  </div>

<?php $this->endWidget(); ?>
