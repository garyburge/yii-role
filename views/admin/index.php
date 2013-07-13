<?php
$this->breadcrumbs = array(
    UserModule::t('Users')
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('user-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1><?php echo UserModule::t("Manage Users"); ?></h1>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'user-grid',
    'type'=>'condensed striped',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        array(
            'name'=>'id',
            'type'=>'raw',
            'value'=>'CHtml::link(CHtml::encode($data->id),array("admin/update","id"=>$data->id))',
            'htmlOptions'=>array('style'=>'width:5%;')
        ),
        array(
            'name'=>'username',
            'type'=>'raw',
            'value'=>'CHtml::link(UHtml::markSearch($data,"username"),array("admin/view","id"=>$data->id))',
            'htmlOptions'=>array('style'=>'width:15%;')
        ),
        array(
            'name'=>'email',
            'type'=>'raw',
            'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
            'htmlOptions'=>array('style'=>'width:25%;')
        ),
        array(
            'name'=>'create_at',
            'value'=>'Yii::app()->format->date($data->create_at)',
            'htmlOptions'=>array('style'=>'width:10%;')
        ),
        array(
            'name'=>'lastvisit_at',
            'value'=>'Yii::app()->format->datetime($data->lastvisit_at)',
            'htmlOptions'=>array('style'=>'width:15%;')
        ),
        array(
            'name'=>'superuser',
            'value'=>'User::itemAlias("AdminStatus", $data->superuser)',
            'filter'=>User::itemAlias("AdminStatus"),
            'htmlOptions'=>array('style'=>'width:10%;')
        ),
        array(
            'name'=>'status',
            'value'=>'User::itemAlias("UserStatus", $data->status)',
            'filter'=>User::itemAlias("UserStatus"),
            'htmlOptions'=>array('style'=>'width:10%;')
        ),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'htmlOptions'=>array('style'=>'width:10%; white-space:nowrap;')
        ),
    ),
));
?>

<?php $this->widget('bootstrap.widgets.TbButton', array('label'=>UserModule::t('Create User'), 'url'=>array('create'), 'type'=>'primary', 'size'=>'small')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('label'=>UserModule::t('Advanced Search'), 'url'=>'#', 'buttonType'=>'link', 'size'=>'small', 'htmlOptions'=>array('class'=>'search-button'))); ?>

<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model'=>$model,
    ));
    ?>
</div><!-- search-form -->

