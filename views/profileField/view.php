<?php
$this->breadcrumbs = array(
	UserModule::t('Profile Fields')=>array('admin'),
	UserModule::t($model->title),
);
?>

<h1><?php echo UserModule::t('View Profile Field #').$model->varname; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
  'type'=>'striped condensed',
	'data'=>$model,
	'attributes'=>array(
		'id',
		'varname',
		'title',
		'field_type',
		'field_size',
		'field_size_min',
		'required',
		'match',
		'range',
		'error_message',
		'other_validator',
		'widget',
		'widgetparams',
		'default',
		'position',
		'visible',
	),
)); ?>
