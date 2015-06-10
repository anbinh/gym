<?php
App::uses('AppController', 'Controller');
class ExercisesController  extends AppController {
    public function index(){

    }

    public function test()
    {
        //$this->request->data['TextResource']['test'] = "eng";
        $text = $this->Exercise->findById('55785b80707134de101bb30e');
        pr($text);
        $this->set('exercise',$text);
        //$programs_list = $this->Program->find('all',array('conditions'=>array('is_public'=>1)));
        //pr($programs_list);
        /*$objective = $this->Objective->find('first',array('conditions'=>array('objective_id'=>(int)'6')));
        pr($objective);*/
    }

    public function login_modal() {
        $this->layout = false;
    }    

    public function detail(){
        if($this->params['url']['id'])
        {
            $id = $this->params['url']['id'];
            $exercise_item = $this->Exercise->find('first', array('conditions'=>array('id'=>$id)));
            /*pr($exercise_item);*/
            $this->set('exercise',$exercise_item);
        }
        else{
        }
    }
}
?>