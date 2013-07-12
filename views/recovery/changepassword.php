<?php
$sTitle = UserModule::t('Change Password');
$this->pageTitle=Yii::app()->name . ' - '.$sTitle;
$this->breadcrumbs=array(
	UserModule::t('Login') => array('/user/login'),
	$sTitle,
);
?>

<h1><?php echo $sTitle; ?></h1>

<?php /** @var TbActiveForm $form */
  $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'changepassword-form',
    'focus'=>array($model, 'password'),
  ));
?>

	<p class="hint"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
  <?php echo $form->errorSummary($model); ?>

  <?php echo $form->passwordFieldRow($model, 'password'); ?>
	<p class="help-block"><?php echo UserModule::t("Minimal password length 4 symbols."); ?></p>
  <?php echo $form->passwordFieldRow($model, 'verifyPassword'); ?>

  <div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>UserModule::t('Save'))); ?>
  </div>

<?php $this->endWidget(); ?>
