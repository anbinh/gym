<?php
App::uses('AppController', 'Controller');
class ExercisesController  extends AppController {
    public function index(){

    }

    public function test()
    {

    }

    public function login_modal() {
        $this->layout = false;
    }    

    public function detail($id = null){
        if($id)
        {
            $exercise_item = $this->Exercise->find('first', array('conditions'=>array('id'=>$id)));
            //pr($exercise_item);
            $this->set('exercise',$exercise_item);
            //$this->render('exercise_item');
        }
        else{
            //$this->redirect("/Users");
            //$this->render('exercise_item');
        }
    }
}
?>