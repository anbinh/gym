<?php
App::uses('AppController', 'Controller');
class ExercisesController  extends AppController {
    //var $layout = "template";
    public function index(){
    	$exercises = $this->Exercise->find('all');
    	$this->set('exercises', $exercises);
    }

    public function detail($id){    
    	$exercise_item = $this->Exercise->find('first', array('conditions'=>array('id'=>$id)));
    	//pr($exercise_item);
    	return $this->render('exercise_item');
    }
}
?>