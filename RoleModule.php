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

    public $tableAuthAssignment = '{{AuthAssignment}}';
    public $tableAuthItem = '{{AuthItem}}';
    public $tableAuthItemChild = '{{AuthItemChild}}';

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
