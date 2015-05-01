<?php
//app/Config/bootstrap.php
CakePlugin::load('Mongodb');


// app/Config/database.php
class DATABASE_CONFIG {
    public $default = array(
        'datasource' => 'Mongodb.MongodbSource',
        'host' => 'localhost',
        'database' => 'gym',
        'login' => 'miratik',
        'password' => 'miratik',
        'port' => 27017,
        'prefix' => '',
        'persistent' => 'true',        
    );

    // To make sure all tests are passing create the following entry in app/Config/database.php
    public $test = array(
        'datasource' => 'Mongodb.MongodbSource',
        'database' => 'test_mongo',
        'host' => 'localhost',
        'port' => 27017,
    ); 
}