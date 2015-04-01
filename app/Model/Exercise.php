<?php
class Exercise extends AppModel {
    //var $useDbConfig = 'Mongodb';
    var $mongoSchema = array(
        'care' => array('type'=>'String'),
        'comment' => array('type'=>'String'),
        'date_creation' => array('type'=>'Timestamp'),
        'dynamic' => array('type'=>'String'),
        'execution' => array('type'=>'String'),
        'identifiant' => array('type'=>'String'),
        'indicepop' => array('type'=>'String'),
        'name' => array('type'=>'String'),
        'posture' => array('type'=>'String'),
        'category' => array('type'=>'Array'),
        'body_building' => array('type'=>'Array'),
        'stretching' => array('type'=>'Array'),
        'cardio' => array('type'=>'Array'),
        'photo' => array('type'=>'String'),
        'video' => array('type'=>'String'),
        'video_small' => array('type'=>'String'),
        'web_player' => array('type'=>'String')
    );
}