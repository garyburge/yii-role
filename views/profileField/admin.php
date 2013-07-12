<?php
  $this->breadcrumbs = array(
    UserModule::t('Profile Fields')=>array('admin'),
    UserModule::t('Manage'),
  );

  Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    $('.search-form #id').focus();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('profile-field-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1><?php echo UserModule::t('Manage Profile Fields'); ?></h1>

<?php
  $this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'profile-field-grid',
    'type'=>'striped condensed',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
      array(
        'name'=>'id',
        'htmlOptions'=>array('style'=>'width:5%;'),
      ),
      array(
        'name'=>'varname',
        'header'=>'Name',
        'type'=>'raw',
        'value'=>'UHtml::markSearch($data,"varname")',
        'htmlOptions'=>array('style'=>'width:10%;'),
      ),
      array(
        'name'=>'title',
        'value'=>'UserModule::t($data->title)',
        'htmlOptions'=>array('style'=>'width:15%;'),
      ),
      array(
        'name'=>'field_type',
        'header'=>'Type',
        'value'=>'$data->field_type',
        'filter'=>ProfileField::itemAlias("field_type"),
        'htmlOptions'=>array('style'=>'width:10%;'),
      ),
      array(
        'name'=>'field_size',
        'header'=>'Size',
        'htmlOptions'=>array('style'=>'width:5%; text-align:right;'),
      ),
      //'field_size_min',
      array(
        'name'=>'required',
        'value'=>'ProfileField::itemAlias("required",$data->required)',
        'filter'=>ProfileField::itemAlias("required"),
        'htmlOptions'=>array('style'=>'width:20%;'),
      ),
      //'match',
      //'range',
      //'error_message',
      //'other_validator',
      //'default',
      array(
        'name'=>'position',
        'htmlOptions'=>array('style'=>'width:10%; text-align:right;'),
      ),
      array(
        'name'=>'visible',
        'value'=>'ProfileField::itemAlias("visible",$data->visible)',
        'filter'=>ProfileField::itemAlias("visible"),
      ),
      //*/
      array(
        'class'=>'bootstrap.widgets.TbButtonColumn',
        'htmlOptions'=>array('style'=>'white-space:nowrap;'),
      ),
    ),
  ));
?>

<?php $this->widget('bootstrap.widgets.TbButton', array('label'=>UserModule::t('Advanced Search'), 'url'=>'#', 'buttonType'=>'link', 'size'=>'small', 'htmlOptions'=>array('class'=>'search-button'))); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array('label'=>UserModule::t('Create Profile Field'), 'url'=>array('create'), 'type'=>'primary', 'size'=>'small')); ?>

<div class="search-form" style="display:none">
  <?php
    $this->renderPartial('_search', array(
      'model'=>$model,
    ));
  ?>
</div><!-- search-form -->

