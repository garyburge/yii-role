<hr>
<p class="muted"><?php echo UserModule::t("You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done."); ?></p>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
  'action'=>Yii::app()->createUrl($this->route),
  'method'=>'get',
  'focus'=>array($model, 'id'),
)); ?>

  <?php echo $form->textFieldRow($model, 'id'); ?>
  <?php echo $form->textFieldRow($model, 'username', array('maxlength'=>20)); ?>
  <?php echo $form->textFieldRow($model, 'email', array('class'=>'span4', 'maxlength'=>128)); ?>
  <?php echo $form->textFieldRow($model, 'activeKey', array('class'=>'span5', 'maxlength'=>128)); ?>
  <?php echo $form->textFieldRow($model, 'create_at'); ?>
  <?php echo $form->textFieldRow($model, 'lastvisit_at'); ?>
  <?php echo $form->dropDownListRow($model, 'superuser', $model->itemAlias('AdminStatus')); ?>
  <?php echo $form->dropDownListRow($model, 'status', $model->itemAlias('UserStatus')); ?>

  <div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>UserModule::t('Search'))); ?>
  </div>

<?php $this->endWidget(); ?>
