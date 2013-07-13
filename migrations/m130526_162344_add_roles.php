<?php

class m130526_162344_add_roles extends CDbMigration
{

    protected $MySqlOptions = 'ENGINE=InnoDB CHARSET=utf8';
    private $_model;

    public function safeUp()
    {
        if (!Yii::app()->getModule('role')) {
            echo "\n\nAdd to console.php :\n"
            . "'modules'=>array(\n"
            . "...\n"
            . "    'role'=>array(\n"
            . "        ... # copy settings from main config\n"
            . "    ),\n"
            . "...\n"
            . "),\n"
            . "\n";
            return false;
        }
        Yii::import('role.models.Role');

        // create auth tables
        switch ($this->dbType()) {
            case "mysql":
                // AuthItem
                Yii::app()->db->createCommand("DROP TABLE IF EXISTS ".Yii::app()->getModule('role')->tableAuthItem)->execute();
                $this->createTable(Yii::app()->getModule('role')->tableAuthItem, array(
                    "name"=>"varchar(64) NOT NULL",
                    "type"=>"integer NOT NULL",
                    "description"=>"text",
                    "bizrule"=>"text",
                    "data"=>"text",
                ), $this->MySqlOptions);
                $this->createIndex('name', Yii::app()->getModule('role')->tableAuthItem, 'name', true);

                // AuthItemChild
                Yii::app()->db->createCommand("DROP TABLE IF EXISTS ".Yii::app()->getModule('role')->tableAuthItemChild)->execute();
                $this->createTable(Yii::app()->getModule('role')->tableAuthItemChild, array(
                    'parent'=>'varchar(64) NOT NULL',
                    'child'=>'varchar(64) NOT NULL',
                ), $this->MySqlOptions);
                $this->createIndex('parent_child', Yii::app()->getModule('role')->tableAuthItemChild, 'parent,child', true);
                $this->addForeignKey('parent', Yii::app()->getModule('role')->tableAuthItemChild, 'parent', Yii::app()->getModule('role')->tableAuthItem, 'name', 'CASCADE', 'RESTRICT');
                $this->addForeignKey('child', Yii::app()->getModule('role')->tableAuthItemChild, 'child', Yii::app()->getModule('role')->tableAuthItem, 'name', 'CASCADE', 'RESTRICT');

                // AuthAssignment
                Yii::app()->db->createCommand("DROP TABLE IF EXISTS ".Yii::app()->getModule('role')->tableAuthAssignment)->execute();
                $this->createTable(Yii::app()->getModule('role')->tableAuthAssignment, array(
                    "itemname"=>"varchar(64) NOT NULL",
                    "roleid"=>"integer(11) NOT NULL", //"varchar(64) NOT NULL",
                    "bizrule"=>"text",
                    "data"=>"text",
                ), $this->MySqlOptions);
                $this->createIndex('itemname', Yii::app()->getModule('role')->tableAuthAssignment, 'itemname', false);
                $this->createIndex('roleid', Yii::app()->getModule('role')->tableAuthAssignment, 'roleid', false);
                $this->addForeignKey('itemname', Yii::app()->getModule('role')->tableAuthAssignment, 'itemname', Yii::app()->getModule('role')->tableAuthItem, 'name', 'CASCADE', 'RESTRICT');
                $this->addForeignKey('roleid', Yii::app()->getModule('role')->tableAuthAssignment, 'roleid', Yii::app()->getModule('role')->tableRoles, 'id', 'NO ACTION', 'NO ACTION');

                // relate role to AuthAssignment
                //$this->addForeignKey('id', Yii::app()->getModule('role')->tableRoles, 'id', Yii::app()->getModule('role')->tableAuthAssignment, 'roleid', 'NO ACTION', 'NO ACTION');

                break;

            case "sqlite":
            default:
                // AuthItem
                $this->createTable(Yii::app()->getModule('role')->tableAuthItem, array(
                    "name"=>"varchar(64) NOT NULL",
                    "type"=>"integer NOT NULL",
                    "description"=>"text",
                    "bizrule"=>"text",
                    "data"=>"text",
                ), $this->MySqlOptions);
                $this->createIndex('name', Yii::app()->getModule('role')->tableAuthItem, 'name', true);

                // AuthItemChild
                $this->createTable(Yii::app()->getModule('role')->tableAuthItemChild, array(
                    'parent'=>'varchar(64) NOT NULL',
                    'child'=>'varchar(64) NOT NULL',
                ), $this->MySqlOptions);
                $this->createIndex('parent_child', Yii::app()->getModule('role')->tableAuthItemChild, 'parent,child', true);

                // AuthAssignment
                $this->createTable(Yii::app()->getModule('role')->tableAuthAssignment, array(
                    "itemname"=>"varchar(64) NOT NULL",
                    "roleid"=>"varchar(64) NOT NULL",
                    "bizrule"=>"text",
                    "data"=>"text",
                ), $this->MySqlOptions);

                break;
        }
    }

    public function safeDown()
    {
        $this->dropTable(Yii::app()->getModule('role')->tableAuthItem);
        $this->dropTable(Yii::app()->getModule('role')->tableAuthItemChild);
        $this->dropTable(Yii::app()->getModule('role')->tableAuthAssignment);
    }

    public function dbType()
    {
        list($type) = explode(':', Yii::app()->db->connectionString);
        echo "type db: " . $type . "\n";
        return $type;
    }

}