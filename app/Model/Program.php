<?php
class Program extends AppModel {
    //var $useDbConfig = 'Mongodb';
    var $mongoSchema = array(
        'creation_date' => array('type'=>'Timestamp'),
        'modification_date' => array('type'=>'Timestamp'),
        'name' => array('type'=>'String'),
        'author' => array('type'=>'String'),
        'level' => array('type'=>'ObjectId'),
        'objective' => array('type'=>'String'),
        'content' => array('type'=>'Array'),
        'photo' => array('type'=>'String'),
        'color_code' => array('type'=>'String'),
        'name_fr' => array('type'=>'String'),
        'creator_id'=>array('type'=>'String'),
        'is_public'=>array('type'=>'int'),
        'short_text'=>array('type'=>'String'),
        'descriptive'=>array('type'=>'String'),
    );
    public $hasMany = array(
        'Exercise' => array(
            'className' => 'Exercise',
            'foreignKey' => 'exercise_id'
        )
    );
}