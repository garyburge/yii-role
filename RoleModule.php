<?php

/**
 * Yii-Role module
 *
 * @author Gary Burge <garyburge@garyburge.com>
 * @link http://garyburge.com/
 * @license http://www.opensource.org/licenses/bsd-license.php
 * @version $Id: RoleModule.php 132 2011-10-30 10:45:01Z mishamx $
 */
class RoleModule extends CWebModule
{
    /**
     * auth assignment table name
     * @var string $tableAuthAssignment
     */
    public $tableAuthAssignment = '{{AuthAssignment}}';
    /**
     * auth item table name
     * @var string $tableAuthItem
     */
    public $tableAuthItem = '{{AuthItem}}';
    /**
     * auth item to child table name
     * @var string $tableAuthItemChild
     */
    public $tableAuthItemChild = '{{AuthItemChild}}';
    /**
     * roles
     * @var array array of role names assigned to this user
     */
    protected static $_roles;

    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'role.models.*',
        ));
    }

    /**
     * has role
     * @param string $itemname is the itemname of the role assigned to this user
     * @return boolean true if 'itemname' is assigned to this user
     */
    public function hasRole($itemname)
    {
        if (!$this->_roles) {
            $sql = "SELECT itemname FROM ".self::tableAuthAssignment." ".
                   "WHERE userid = :userid ".
                   "ORDER by itemname ";
            $rows = Yii::app()->db->createCommand($sql)->queryAll(true, array(':userid'=>Yii::app()->user->id));
            if (null !== $rows) {
                // unwrap into single dimension array
                self::_$roles = array();
                foreach ($rows => $row) {
                    self::$roles[] = $row['itemname'];
                }
            }
        }

        return (!$this->_roles ? false : in_array($itemname, self::$_roles));
    }

    /**
     * @param $str
     * @param $params
     * @param $dic
     * @return string
     */
    public static function t($str = '', $params = array(), $dic = 'role')
    {
        if (Yii::t("RoleModule", $str) == $str)
            return Yii::t("RoleModule." . $dic, $str, $params);
        else
            return Yii::t("RoleModule", $str, $params);
    }

}
