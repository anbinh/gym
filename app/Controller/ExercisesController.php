<?php
App::uses('AppController', 'Controller');
class ExercisesController  extends AppController {
    //var $layout = "template";
    public function index(){
        $conditions = array('muscle.0' => array('$exists'=>true));
        $exercises = $this->Exercise->find('all',array('conditions'=>$conditions));
            //pr($exercises);
        $this->set('exercises', $exercises);
    }

    public function detail($id){    
    	$exercise_item = $this->Exercise->find('first', array('conditions'=>array('id'=>$id)));
    	//pr($exercise_item);
    	return $this->render('exercise_item');
    }
}
?>