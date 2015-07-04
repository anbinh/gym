<?php
class User extends AppModel {
    //var $useDbConfig = 'Mongodb';
    var $mongoSchema = array(
        'actif' => array('type'=>'number'),
        'birthday' => array('type'=>'Timestamp'),
        'date_inscription' => array('type'=>'Timestamp'),
        'date_member' => array('type'=>'Timestamp'),
        'email' => array('type'=>'String'),
        'firstname' => array('type'=>'String'),
        'lastname' => array('type'=>'String'),
        'login' => array('type'=>'String'),
        'password' => array('type'=>'String'),
        'sex' => array('type'=>'String'),
        'address' => array('type'=>'Object'),
        'country' => array('type'=>'Object'),
        'bookmark' => array('type'=>'Object'),
        'role' => array('type'=>'String'),
        'favorite_exercises' => array('type'=>'Array'),
        'assigned_programs' => array('type'=>'Array'),
        'language' => array('type'=>'String'),
        'receive_promote' => array('type'=>'Bool'),
        'fb_id' => array('type'=>'String'),
        'picture' => array('type'=>'String'),
    );
}