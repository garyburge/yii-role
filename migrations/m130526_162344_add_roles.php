<?php

class m130526_162344_add_roles extends CDbMigration
{

    protected $MySqlOptions = 'ENGINE=InnoDB CHARSET=utf8';
    private $_model;

    public function safeUp()
    {
        if (!Yii::app()->getModule('user')) {
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
        Yii::import('user.models.User');

        // create auth tables
        switch ($this->dbType()) {
            case "mysql":
                // AuthItem
                Yii::app()->db->createCommand("DROP TABLE IF EXISTS ".Yii::app()->getModule('user')->tableAuthItem)->execute();
                $this->createTable(Yii::app()->getModule('role')->tableAuthItem, array(
                    "name"=>"varchar(64) NOT NULL",
                    "type"=>"integer NOT NULL",
                    "description"=>"text",
                    "bizrule"=>"text",
                    "data"=>"text",
                ), $this->MySqlOptions);
                $this->createIndex('name', Yii::app()->getModule('user')->tableAuthItem, 'name', true);

                // AuthItemChild
                Yii::app()->db->createCommand("DROP TABLE IF EXISTS ".Yii::app()->getModule('user')->tableAuthItemChild)->execute();
                $this->createTable(Yii::app()->getModule('user')->tableAuthItemChild, array(
                    'parent'=>'varchar(64) NOT NULL',
                    'child'=>'varchar(64) NOT NULL',
                ), $this->MySqlOptions);
                $this->createIndex('parent_child', Yii::app()->getModule('user')->tableAuthItemChild, 'parent,child', true);
                $this->addForeignKey('parent', Yii::app()->getModule('user')->tableAuthItemChild, 'parent', Yii::app()->getModule('user')->tableAuthItem, 'name', 'CASCADE', 'RESTRICT');
                $this->addForeignKey('child', Yii::app()->getModule('user')->tableAuthItemChild, 'child', Yii::app()->getModule('user')->tableAuthItem, 'name', 'CASCADE', 'RESTRICT');

                // AuthAssignment
                Yii::app()->db->createCommand("DROP TABLE IF EXISTS ".Yii::app()->getModule('user')->tableAuthAssignment)->execute();
                $this->createTable(Yii::app()->getModule('user')->tableAuthAssignment, array(
                    "itemname"=>"varchar(64) NOT NULL",
                    "userid"=>"integer(11) NOT NULL", //"varchar(64) NOT NULL",
                    "bizrule"=>"text",
                    "data"=>"text",
                ), $this->MySqlOptions);
                $this->createIndex('itemname', Yii::app()->getModule('user')->tableAuthAssignment, 'itemname', false);
                $this->createIndex('userid', Yii::app()->getModule('user')->tableAuthAssignment, 'userid', false);
                $this->addForeignKey('itemname', Yii::app()->getModule('user')->tableAuthAssignment, 'itemname', Yii::app()->getModule('user')->tableAuthItem, 'name', 'CASCADE', 'RESTRICT');
                $this->addForeignKey('userid', Yii::app()->getModule('user')->tableAuthAssignment, 'userid', Yii::app()->getModule('user')->tableUsers, 'id', 'NO ACTION', 'NO ACTION');

                // relate user to AuthAssignment
                //$this->addForeignKey('id', Yii::app()->getModule('user')->tableUsers, 'id', Yii::app()->getModule('user')->tableAuthAssignment, 'userid', 'NO ACTION', 'NO ACTION');

                break;

            case "sqlite":
            default:
                // AuthItem
                $this->createTable(Yii::app()->getModule('user')->tableAuthItem, array(
                    "name"=>"varchar(64) NOT NULL",
                    "type"=>"integer NOT NULL",
                    "description"=>"text",
                    "bizrule"=>"text",
                    "data"=>"text",
                ), $this->MySqlOptions);
                $this->createIndex('name', Yii::app()->getModule('user')->tableAuthItem, 'name', true);

                // AuthItemChild
                $this->createTable(Yii::app()->getModule('user')->tableAuthItemChild, array(
                    'parent'=>'varchar(64) NOT NULL',
                    'child'=>'varchar(64) NOT NULL',
                ), $this->MySqlOptions);
                $this->createIndex('parent_child', Yii::app()->getModule('user')->tableAuthItemChild, 'parent,child', true);

                // AuthAssignment
                $this->createTable(Yii::app()->getModule('user')->tableAuthAssignment, array(
                    "itemname"=>"varchar(64) NOT NULL",
                    "userid"=>"varchar(64) NOT NULL",
                    "bizrule"=>"text",
                    "data"=>"text",
                ), $this->MySqlOptions);

                break;
        }
    }

    public function safeDown()
    {
        $this->dropTable(Yii::app()->getModule('user')->tableAuthItem);
        $this->dropTable(Yii::app()->getModule('user')->tableAuthItemChild);
        $this->dropTable(Yii::app()->getModule('user')->tableAuthAssignment);
    }

    public function dbType()
    {
        list($type) = explode(':', Yii::app()->db->connectionString);
        echo "type db: " . $type . "\n";
        return $type;
    }

}