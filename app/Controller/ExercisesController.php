<?php
App::uses('AppController', 'Controller');
class ExercisesController  extends AppController {
    public function index(){

    }

    public function test()
    {
        $program = $this->Program->findById('54cf9d82acc46c81b036a745');
        $array_id = array();
        foreach($program['Program']['content'] as $item)
        {
            foreach($item['exercise_list'] as $exercise_list)
            {
                foreach($exercise_list['exercise_item'] as $exercise)
                {
                    array_push($array_id,$exercise['exercise_id']);
                }
            }
        }
        $dups = array_unique($array_id);
        $search = array(
            '_id' => array('$in' => $dups)
        );
        $exercises_list = $this->Exercise->find('all',array('conditions'=>$search));
        $exercises_list = Set::combine($exercises_list, '{n}.Exercise.id', '{n}.Exercise');
        pr($dups);
        pr($exercises_list);
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
        }
        else{
        }
    }
}
?>