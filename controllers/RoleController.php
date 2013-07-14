<?php

class RoleController extends Controller
{

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // administrator access
                'actions'=>array('index', 'create', 'update', 'delete'),
                'roles'=>array('admin'),
            ),
            array('deny', // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        // create model initialized for searching
        $model = new Role('search');
        // clear any default values
        $model->unsetAttributes();
        // if pagination data available...
        if (isset($_GET['Role'])) {
            // copy to model
            $model->attributes = $_GET['Role'];
        }

        // render grid
        $this->render('index', array(
            'model'=>$model,
        ));
    }

    /**
     * Creates a new model.
     */
    public function actionCreate()
    {
        // create empty model
        $model = new Role;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        // if form data available...
        if (isset($_POST['Role'])) {
            $model->attributes = $_POST['Role'];
            // validate, then save data
            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }

        // render form
        $this->render('create', array(
            'model'=>$model,
        ));
    }

    /**
     * Updates a particular model.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        // create model for this role
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        // if form data available...
        if (isset($_POST['Role'])) {
            $model->attributes = $_POST['Role'];
            // validate, then save data
            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }

        // render form
        $this->render('update', array(
            'model'=>$model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        // we only allow deletion via POST request
        if (Yii::app()->request->isPostRequest) {
            // delete the record
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

//  /**
//   * Lists all models.
//   */
//  public function actionIndex()
//  {
//    $dataProvider = new CActiveDataProvider('Role');
//    $this->render('index', array(
//      'dataProvider'=>$dataProvider,
//    ));
//  }
//  /**
//   * Displays a particular model.
//   * @param integer $id the ID of the model to be displayed
//   */
//  public function actionView($id)
//  {
//    $this->render('view', array(
//      'model'=>$this->loadModel($id),
//    ));
//  }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Role::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'role-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}

