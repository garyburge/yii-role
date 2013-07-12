<?php
  $sTitle = UserModule::t('Reset Password');
  $this->pageTitle = Yii::app()->name.' - '.$sTitle;
  $this->breadcrumbs = array(
    UserModule::t('Login') => array('/user/login'),
    $sTitle,
  );
?>

<h1><?php echo $sTitle; ?></h1>

<?php if (Yii::app()->user->hasFlash('recoveryMessage')): ?>
  <?php $this->widget('bootstrap.widgets.TbAlert', array('alerts'=>array('recoveryMessage'=>array()))); ?>
<?php else: ?>

  <?php /** @var TbActiveForm $form */
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
      'id'=>'recovery-form',
      'focus'=>array($model, 'login_or_email'),
    ));
  ?>

    <?php echo $form->textFieldRow($model, 'login_or_email'); ?>
    <p class="help-block"><?php echo UserModule::t("Please enter your login or email addres."); ?></p>

    <div class="form-actions">
      <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>$sTitle)); ?>
    </div>

  <?php $this->endWidget(); ?>
<?php endif; ?>