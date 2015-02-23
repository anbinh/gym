<?php
App::uses('AppController', 'Controller');
class ProgramsController  extends AppController {
   
    public function index(){
    	$programs = $this->Program->find('all');

    	pr($programs);
    }
}
?>