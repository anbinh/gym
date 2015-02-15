<?php
App::uses('AppController', 'Controller');
class ExercisesController  extends AppController {
    //var $layout = "template";
    public function index(){
    	$exercises = $this->Exercise->find('all');
    	$this->set('exercises', $exercises);
    }
}
?>