<?php
App::uses('AppController', 'Controller');
class ExercisesController  extends AppController {
    public function index(){

    }

    public function test()
    {
        $temp = $this->Exercise->find('all', array('conditions'=>array('muscle <>'=>null)));
        pr($temp);
    }

    public function login_modal() {
        $this->layout = false;
    }    

    public function detail(){
        if($this->params['url']['id'])
        {
            $id = $this->params['url']['id'];
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