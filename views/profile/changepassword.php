<?php
$this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Change Password");
$this->breadcrumbs = array(
  UserModule::t("Profile")=>array('/user/profile'),
  UserModule::t("Change Password"),
);
?>

<h1><?php echo UserModule::t("Change password"); ?></h1>

<?php
  $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'changepassword-form',
    'focus'=>array($model, 'oldPassword'),
    'enableAjaxValidation'=>true,
    'clientOptions'=>array(
      'validateOnSubmit'=>true,
    ),
  ));
?>

  <p class="help-block muted"><small><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></small></p>
  <?php echo $form->errorSummary($model); ?>

  <?php echo $form->passwordFieldRow($model, 'oldPassword'); ?>
  <?php echo $form->passwordFieldRow($model, 'password'); ?>
  <p class="help-block muted"><?php echo UserModule::t("Minimal password length 4 symbols."); ?></p>
  <?php echo $form->passwordFieldRow($model, 'verifyPassword'); ?>

  <div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>UserModule::t("Save"))); ?>
  </div>

<?php $this->endWidget(); ?>
