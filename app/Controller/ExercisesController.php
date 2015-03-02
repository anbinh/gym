<?php
App::uses('AppController', 'Controller');
class ExercisesController  extends AppController {
    public function index(){

    }

    public function test($id)
    {
        $conditions = array('body_building.bodypart' => $id);
        $exercises_list = $this->Exercise->find('all',array('conditions'=>$conditions));
        $this->set(array(
            'exercises_list' => $exercises_list,
            '_serialize' => array('exercises_list')
        ));
    }

    public function login_modal() {
        $this->layout = false;
    }    

    public function detail($id){
        $exercise_item = $this->Exercise->find('first', array('conditions'=>array('id'=>$id)));
        //pr($exercise_item);
        return $this->render('exercise_item');
    }
}
?>