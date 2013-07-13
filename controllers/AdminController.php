<?php

Yii::import('user.models.*');

class AdminController extends Controller
{

    public $defaultAction = 'admin';
    private $_model;

    /**
     * @return array action filters
     */
    public function filters()
    {
        return CMap::mergeArray(parent::filters(), array(
            'accessControl', // perform access control for CRUD operations
        ));
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin', 'delete', 'create', 'update', 'view'),
                'roles'=>array('administrator'),
            ),
            array('deny', // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        // create model for searching
        $model = new User('search');

        // clear any default values
        $model->unsetAttributes();

        // if paging info available...
        if (isset($_GET['User'])) {
            $model->attributes = $_GET['User'];
        }

        $this->render('index', array(
            'model'=>$model,
        ));
    }

    /**
     * Displays a particular model.
     */
    public function actionView()
    {
        $model = $this->loadModel();
        $this->render('view', array(
            'model'=>$model,
        ));
    }

    /**
     * Creates a new model.
     */
    public function actionCreate()
    {
        // create an empty model
        $model = new User;
        $profile = new Profile;
        $role = new RoleSelectForm();

        // perform ajax validation
        $this->performAjaxValidation(array($model, $profile));

        // if form data available
        if (isset($_POST['User'])) {
            // copy form data to model
            $model->attributes = $_POST['User'];
            // set active key
            $model->active_key = Yii::app()->controller->module->encrypting(microtime() . $model->password);
            // copy profile data
            $profile->attributes = $_POST['Profile'];
            // set user id to zero for new user
            $profile->user_id = 0;
            // validate separately
            if ($model->validate() && $profile->validate()) {
                // encrypt password
                $model->password = Yii::app()->controller->module->encrypting($model->password);
                // save user
                if ($model->save(false)) {
                    // copy new user id
                    $profile->user_id = $model->id;
                    // save profile
                    $profile->save(false);
                    // copy selections
                    $role->attributes = $_POST['RoleSelectForm'];
                    // create auth assignment for this user and each selected role
                    $role->assignUser($model->id);
                }
                // redirect to admin grid
                $this->redirect(array('admin'));
            } else {
                // don't understand this
                $profile->validate();
            }
        }

        // render form
        $this->render('create', array(
            'model'=>$model,
            'profile'=>$profile,
            'role'=>$role,
        ));
    }

    /**
     * Updates a particular model.
     */
    public function actionUpdate()
    {
        // create model for this user
        $model = $this->loadModel();
        // create profile
        $profile = $model->profile;
        // create role
        $role = new RoleSelectForm($model->id);

        // do ajax validation
        $this->performAjaxValidation(array($model, $profile));

        // if form data available
        if (isset($_POST['User'])) {
            // copy user data
            $model->attributes = $_POST['User'];
            // copy profile data
            $profile->attributes = $_POST['Profile'];
            // copy role selection
            $role->attributes = (isset($_POST['RoleSelectForm']) ? $_POST['RoleSelectForm'] : array());

            // validate
            if ($model->validate() && $profile->validate()) {
                // did editor change password?
                $old_password = User::model()->notsafe()->findByPk($model->id);
                if ($old_password->password != $model->password) {
                    // encrypt new password and key
                    $model->password = Yii::app()->controller->module->encrypting($model->password);
                    $model->active_key = Yii::app()->controller->module->encrypting(microtime() . $model->password);
                }
                // save user data
                $model->save();
                // save profile data
                $profile->save();
                // create new assignments
                $role->assignUser($model->id);
                // return to admin grid
                $this->redirect(array('admin'));
            } else {
                // don't understand this
                $profile->validate();
            }
        }

        // get roles assigned to this user
        $role->getAssigned($model->id);

        $this->render('update', array(
            'model'=>$model,
            'profile'=>$profile,
            'role'=>$role,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     */
    public function actionDelete()
    {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $model = $this->loadModel();

            // begin a transaction
            $trans = Yii::app()->db->beginTransaction();

            try {
                // first, delete the auth assignments for this user
                $sql = "DELETE FROM AuthAssignment ".
                       "WHERE userid = :id ";
                Yii::app()->db->createCommand($sql)->execute(array(':id'=>$model->id));

                // next, delete profile row for this user
                $sql = "DELETE FROM profile ".
                       "WHERE user_id = ':id' ";
                Yii::app()->db->createCommand($sql)->execute(array(':id'=>$model->id));

                // lastly, delete the user record
                $model->delete();

                // commit transaction
                $trans->commit();

                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_POST['ajax'])) {
                    $this->redirect(array('/user/admin'));
                }

            } catch (CException $e) {
                // roll back transaction
                $trans->rollback();
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($validate)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($validate);
            Yii::app()->end();
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     */
    public function loadModel()
    {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = User::model()->notsafe()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }

}