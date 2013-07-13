<?php

class RoleSelectForm extends CFormModel
{
  /**
   *
   * @var array selected roles for a user
   */
  public $selected = array();

  /**
   *
   * @var integer id of user for which roles are selected
   */
  public $userid = 0;

  /**
   * @return void
   */
  public function __construct($userid=0)
  {
    $this->userid = $userid;
  }

  /**
   * @return array list of validation rules
   */
  public function rules()
  {
    return array(
      //array('selected', 'required', 'on'=>'insert,update'),
      array('selected', 'safe'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels()
  {
    return array(
      'selected'=>'Assigned Roles',
    );
  }


  /**
   * @return array array of value->text pairs for select tag
   */
  public function getAllRoles()
  {
    $roles = array();
    $items = Yii::app()->getAuthManager()->getAuthItems(CAuthItem::TYPE_ROLE); //CAuthItem::TYPE_ROLE);
    foreach($items as $item) {
      $roles[] = array('value'=>$item->name, 'text'=>$item->name);
    }
    return $roles;
  }

  /**
   * @return void
   */
  public function getAssigned($userid)
  {
    $this->selected = array();
    $items = Yii::app()->getAuthManager()->getAuthItems(CAuthItem::TYPE_ROLE, $userid); //CAuthItem::TYPE_ROLE);
    foreach($items as $item) {
      $this->selected[] = $item->name;
    }
  }

  /**
   * @return void
   */
  public function assignUser($userid)
  {
    //Role::model()->assignUser($userid, $this->selected);

    // begin transaction
    $tr = Yii::app()->db->beginTransaction();

    // try-catch
    try {
      // delete all current roles for this user
      foreach(Yii::app()->getAuthManager()->getAuthAssignments($userid) as $assignment) {
        Yii::app()->getAuthManager()->revoke($assignment->itemname, $userid);
      }

      // create new auth assignment for selected roles
      foreach($this->selected as $role) {
        Yii::app()->getAuthManager()->assign($role, $userid, null, null);
      }

      // commit transaction
      $tr->commit();

    } catch(CException $e) {
      $tr->rollback();
      throw new CException($e);
    }
  }

}
