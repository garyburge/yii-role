<?php
$this->breadcrumbs=array(
	'Roles'=>array('index'),
	'Update',
);
?>

<h1>Update Role "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>