<?php
  $this->breadcrumbs = array(
    UserModule::t('Users')=>array('admin'),
    $model->username,
  );
?>

<h1><?php echo UserModule::t('View User') . ' "' . $model->username . '"'; ?></h1>

<?php
  $attributes = array(
    'id',
    array(
      'name'=>'status',
      'value'=>User::itemAlias("UserStatus", $model->status),
    ),
    array(
      'name'=>'superuser',
      'value'=>User::itemAlias("AdminStatus", $model->status),
    ),
    'username',
    'email',
  );

  $profileFields = ProfileField::model()->forOwner()->sort()->findAll();
  if ($profileFields) {
    foreach ($profileFields as $field) {
      array_push($attributes, array(
        'label'=>UserModule::t($field->title),
        'name'=>$field->varname,
        'type'=>'raw',
        'value'=>(($field->widgetView($model->profile)) ? $field->widgetView($model->profile) : (($field->range) ? Profile::range($field->range, $model->profile->getAttribute($field->varname)) : $model->profile->getAttribute($field->varname))),
      ));
    }
  }

  array_push($attributes, array(
    'name'=>'create_at',
    'type'=>'date',
  ));
  array_push($attributes, array(
    'name'=>'lastvisit_at',
    'type'=>'datetime',
  ));

  $this->widget('bootstrap.widgets.TbDetailView', array(
    'type'=>'condensed striped',
    'data'=>$model,
    'attributes'=>$attributes,
  ));
?>
