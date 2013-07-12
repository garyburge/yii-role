<?php

  class RecoveryController extends Controller {

    public $defaultAction = 'recovery';

    /**
     * Recovery password
     */
    public function actionRecovery() {
      $form = new UserRecoveryForm;
      if (Yii::app()->user->id) {
        $this->redirect(Yii::app()->controller->module->returnUrl);
      } else {
        $email = ((isset($_GET['email'])) ? $_GET['email'] : '');
        $active_key = ((isset($_GET['active_key'])) ? $_GET['active_key'] : '');
        if ($email && $active_key) {
          $form2 = new UserChangePassword;
          $find = User::model()->notsafe()->findByAttributes(array('email' => $email));
          if (isset($find) && $find->active_key == $active_key) {
            if (isset($_POST['UserChangePassword'])) {
              $form2->attributes = $_POST['UserChangePassword'];
              if ($form2->validate()) {
                $find->password = Yii::app()->controller->module->encrypting($form2->password);
                $find->active_key = Yii::app()->controller->module->encrypting(microtime() . $form2->password);
                if ($find->status == 0) {
                  $find->status = 1;
                }
                $find->save();
                Yii::app()->user->setFlash('recoveryMessage', UserModule::t('Your new password was saved'));
                $this->redirect(Yii::app()->controller->module->recoveryUrl);
              }
            }
            $this->render('changepassword', array('model' => $form2));
          } else {
            Yii::app()->user->setFlash('recoveryMessage', UserModule::t("Incorrect recovery link."));
            $this->redirect(Yii::app()->controller->module->recoveryUrl);
          }
        } else {
          if (isset($_POST['UserRecoveryForm'])) {
            $form->attributes = $_POST['UserRecoveryForm'];
            if ($form->validate()) {
              $user = User::model()->notsafe()->findbyPk($form->user_id);
              $activation_url = 'http://' . $_SERVER['HTTP_HOST'] . $this->createUrl(implode(Yii::app()->controller->module->recoveryUrl), array("active_key" => $user->active_key, "email" => $user->email));

              $subject = UserModule::t('{site_name}: Change Password Request', array(
                  '{site_name}' => Yii::app()->name,
              ));
              $message = UserModule::t('We received a request to change the password on your account at {site_name}. To change your password, just click on this link: {activation_url}', array(
                  '{site_name}' => Yii::app()->name,
                  '{activation_url}' => $activation_url,
              ));

              UserModule::sendMail($user->email, $subject, $message);

              Yii::app()->user->setFlash('recoveryMessage', UserModule::t('Please check your inbox. We sent instructions on how to change your password.'));
              $this->refresh();
            }
          }
          $this->render('recovery', array('model' => $form));
        }
      }
    }

  }