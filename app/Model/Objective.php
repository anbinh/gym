<?php
class Objective extends AppModel {
    //var $useDbConfig = 'Mongodb';
    var $mongoSchema = array(
        'objective_id' => array('type'=>'number'),
        'description' => array('type'=>'String')
    );
}