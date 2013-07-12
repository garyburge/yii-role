<?php
  $this->breadcrumbs = array(
    UserModule::t("Users"),
  );
  if (UserModule::isAdmin()) {
    //$this->layout = '//layouts/column2';
    $this->menu = array(
      array('label' => UserModule::t('Manage Users'), 'url' => array('/user/admin')),
      array('label' => UserModule::t('Manage Profile Fields'), 'url' => array('profileField/admin')),
    );
  }
?>

<h1><?php echo UserModule::t('List Users'); ?></h1>

<?php
  $this->widget('bootstrap.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'type'=>'striped condensed',
    'columns' => array(
      array(
        'name'=>'id',
        'htmlOptions'=>array('style'=>'width:5%;'),
      ),
      (UserModule::isAdmin() ? array('name'=>'status', 'value'=>'User::itemAlias("UserStatus", $data->status)') : ''),
      (UserModule::isAdmin() ? array('name'=>'superuser', 'value'=>'User::itemAlias("AdminStatus", $data->superuser)') : ''),
      array(
        'name' => 'username',
        'type' => 'raw',
        'value' => 'CHtml::link(CHtml::encode($data->username),array("user/view","id"=>$data->id))',
      ),
      (UserModule::isAdmin() ? array('name'=>'email', 'type'=>'raw', 'value'=>'CHtml::link(UHtml::markSearch($data, "email"), "mailto:".$data->email)') : ''),
      array(
        'name'=>'created',
        'type'=>'date',
      ),
      array(
        'name'=>'lastvisit',
        'type'=>'datetime',
      ),
    ),
  ));
?>

<?php
  $this->widget('bootstrap.widgets.TbButtonGroup', array(
    'buttons'=>$this->menu,
  ));
?>
