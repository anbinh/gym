<?php
class BodyPart extends AppModel {
    //var $useDbConfig = 'Mongodb';
    var $mongoSchema = array(
        'body_part_id' => array('type'=>'number'),
        'description' => array('type'=>'String')
    );
}