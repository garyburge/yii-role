<?php
$this->breadcrumbs=array(
	'Roles'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('role-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Roles</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'role-grid',
  'type'=>'striped condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
    array(
      'name'=>'name',
      'htmlOptions'=>array('style'=>'width:15%')
    ),
    array(
      'name'=>'description',
      'htmlOptions'=>array('style'=>'width:25%')
    ),
    array(
      'name'=>'bizrule',
      'htmlOptions'=>array('style'=>'width:25%')
    ),
    array(
      'name'=>'data',
      'htmlOptions'=>array('style'=>'width:20%')
    ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
      'template'=>'{update}{delete}',
      'htmlOptions'=>array('style'=>'width:5%; white-space:nowrap;')
		),
	),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
  'label'=>Yii::app()->getModule('user')->t('Create Role'),
  'icon'=>'plus-sign',
  'url'=>array('create'),
  'type'=>'primary',
  'buttonType'=>'link',
  'size'=>'small',
)); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array(
  'label'=>'Advanced Search',
  'icon'=>'search',
  'url'=>'#',
  'buttonType'=>'link',
  'size'=>'small',
  'htmlOptions'=>array('class'=>'search-button btn'),
)); ?>

<div class="search-form" style="display:none">
  <?php $this->renderPartial('_search', array(
    'model'=>$model,
  )); ?>
</div><!-- search-form -->

