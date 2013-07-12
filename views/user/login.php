<?php
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
$this->breadcrumbs=array(
	UserModule::t("Login"),
);
?>

<h1><?php echo UserModule::t("Login"); ?></h1>

<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>
  <?php $this->widget('bootstrap.widgets.TbAlert', array('alerts'=>array('loginMessage'=>array()))); ?>
<?php endif; ?>

<p class="help-block"><?php echo UserModule::t("Please fill out the following form with your login credentials:"); ?></p>

<?php /** @var TbActiveForm $form */
  $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'login-form',
    'focus'=>array($model, 'username'),
  ));
?>

	<p class="muted"><small><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></small></p>
  <?php $form->errorSummary($model); ?>

  <?php echo $form->textFieldRow($model, 'username'); ?>
  <?php echo $form->passwordFieldRow($model, 'password'); ?>
  <?php echo $form->checkBoxRow($model, 'rememberMe'); ?>
  <p class="help-block"><?php echo CHtml::link(UserModule::t("Register"), Yii::app()->getModule('user')->registrationUrl); ?> | <?php echo CHtml::link(UserModule::t("Lost Password?"), Yii::app()->getModule('user')->recoveryUrl); ?></p>

  <div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>UserModule::t("Login"))); ?>
  </div>

<?php $this->endWidget(); ?>

