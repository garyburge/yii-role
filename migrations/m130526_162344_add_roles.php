<?php

class m130526_162344_add_roles extends CDbMigration
{

    protected $MySqlOptions = 'ENGINE=InnoDB CHARSET=utf8';
    private $_authItem;
    private $_adminUsername;
    private $_adminUserId;
    private $_user;
    private $_authAssignment;

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

        // create auth tables
        switch ($this->dbType()) {
            case "mysql":
                // AuthItem
                Yii::app()->db->createCommand("DROP TABLE IF EXISTS " . Yii::app()->getModule('role')->tableAuthItem)->execute();
                $this->createTable(Yii::app()->getModule('role')->tableAuthItem, array(
                    "name"=>"varchar(64) NOT NULL",
                    "type"=>"integer NOT NULL",
                    "description"=>"text",
                    "bizrule"=>"text",
                    "data"=>"text",
                ), $this->MySqlOptions);
                $this->createIndex('name', Yii::app()->getModule('role')->tableAuthItem, 'name', true);

                // AuthItemChild
                Yii::app()->db->createCommand("DROP TABLE IF EXISTS " . Yii::app()->getModule('role')->tableAuthItemChild)->execute();
                $this->createTable(Yii::app()->getModule('role')->tableAuthItemChild, array(
                    'parent'=>'varchar(64) NOT NULL',
                    'child'=>'varchar(64) NOT NULL',
                ), $this->MySqlOptions);
                $this->createIndex('parent_child', Yii::app()->getModule('role')->tableAuthItemChild, 'parent,child', true);
                $this->addForeignKey('parent', Yii::app()->getModule('role')->tableAuthItemChild, 'parent', Yii::app()->getModule('role')->tableAuthItem, 'name', 'CASCADE', 'RESTRICT');
                $this->addForeignKey('child', Yii::app()->getModule('role')->tableAuthItemChild, 'child', Yii::app()->getModule('role')->tableAuthItem, 'name', 'CASCADE', 'RESTRICT');

                // AuthAssignment
                Yii::app()->db->createCommand("DROP TABLE IF EXISTS " . Yii::app()->getModule('role')->tableAuthAssignment)->execute();
                $this->createTable(Yii::app()->getModule('role')->tableAuthAssignment, array(
                    "itemname"=>"varchar(64) NOT NULL",
                    "userid"=>"integer(11) NOT NULL",
                    "bizrule"=>"text",
                    "data"=>"text",
                ), $this->MySqlOptions);
                $this->createIndex('itemname', Yii::app()->getModule('role')->tableAuthAssignment, 'itemname', false);
                $this->createIndex('userid', Yii::app()->getModule('role')->tableAuthAssignment, 'userid', false);
                $this->addForeignKey('itemname', Yii::app()->getModule('role')->tableAuthAssignment, 'itemname', Yii::app()->getModule('role')->tableAuthItem, 'name', 'CASCADE', 'CASCADE');
                $this->addForeignKey('user', Yii::app()->getModule('role')->tableAuthAssignment, 'userid', Yii::app()->getModule('user')->tableUsers, 'id', 'CASCADE', 'CASCADE');
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
                    "userid"=>"varchar(64) NOT NULL",
                    "bizrule"=>"text",
                    "data"=>"text",
                ), $this->MySqlOptions);

                break;
        }

        // create models
        Yii::import('role.models.Role');
        Yii::import('role.models.AuthItem');
        Yii::import('role.models.AuthAssignment');
        Yii::import('user.models.User');

        $this->_authItem = new AuthItem;
        $this->_authAssignment = new AuthAssignment;
        $this->_user = new User;

        if (in_array('--interactive=0', $_SERVER['argv'])) {
          $this->_authItem->name = 'admin';
          $this->_adminUsername = 'administrator';
        } else {
          $this->readStdinAuthItem('Name of administrator role', 'name', 'admin');
          $this->readStdinAdminUserId("Default administrator's username", 'administrator');
        }

        // get user id of administrator
        if (null === ($row = $this->_user->find('username = :username', array(':username'=>$this->_adminUsername)))) {
            echo "\n\nError: Unable to locate any user with username = '".$this->_adminUsername."'";
            return false;
        }
        $this->_adminUserId = $row['id'];

        // create AuthItem row
        $this->insert(Yii::app()->getModule('role')->tableAuthItem, array(
            'name'=>$this->_authItem->name,
            'type'=>CAuthItem::TYPE_ROLE,
            'description'=>null,
            'bizrule'=>null,
        ));

        // assign to administrator
        CDbAuthAssignment::assign($this->_authItem->name, $this->_adminUserId);

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

    private function readStdin($prompt, $valid_inputs, $default = '')
    {
        while (!isset($input) || (is_array($valid_inputs) && !in_array($input, $valid_inputs)) || ($valid_inputs == 'is_file' && !is_file($input))) {
            echo $prompt;
            $input = strtolower(trim(fgets(STDIN)));
            if (empty($input) && !empty($default)) {
                $input = $default;
            }
        }
        return $input;
    }

    private function readStdinAuthItem($prompt, $field, $default = '')
    {
        while (!isset($input) || !$this->_authItem->validate(array($field))) {
            echo $prompt . (($default) ? " [$default]" : '') . ': ';
            $input = (trim(fgets(STDIN)));
            if (empty($input) && !empty($default)) {
                $input = $default;
            }
            $this->_authItem->setAttribute($field, $input);
        }
        return $input;
    }

    private function readStdinAdminUserId($prompt, $default = '')
    {
        while (!isset($input)) {
            echo $prompt . (($default) ? " [$default]" : '') . ': ';
            $input = (trim(fgets(STDIN)));
            if (empty($input) && !empty($default)) {
                $input = $default;
            }
            $this->_adminUsername = $input;
        }
        return $input;
    }

}