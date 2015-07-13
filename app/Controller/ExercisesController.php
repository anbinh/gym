<?php
App::uses('AppController', 'Controller');
class ExercisesController  extends AppController {
    public function index(){

    }

    public function test()
    {
        $test = $this->getListExerciseByFilter(-1,1);
        pr($test);
    }

    public function getListExerciseByFilter($category_id, $body_part_id){        

        $offset = 2;        
        if($body_part_id != -1){
            $body_part_id = 'n'.$body_part_id.'n';    
        }        
        pr($category_id);
        pr($body_part_id);
        $exercise_list = $this->filterExercise($category_id, $body_part_id, $offset);

        return $exercise_list;
    }

    public function compare_length_body_part_id($a, $b){
         $temp1 = split('.', $a['Exercise']['bodypart_id']);
         $temp2 = split('.', $b['Exercise']['bodypart_id']);
        
        return count($temp1) > count($temp2);
    }
    public function filterExercise($category_id, $body_part_id, $offset){
        $conditions = array('Exercise.category_id'=>$category_id, 'Exercise.bodypart_id' => new MongoRegex("/$body_part_id/i"));
    
        // category 
        if($category_id == -1)
        {
            unset($conditions['Exercise.category_id']);
        }    
        // body part
        if($body_part_id == -1)
        {
            unset($conditions['Exercise.bodypart_id']);
        }
        
        //$search = array('conditions'=>$conditions, 'limit'=>23, 'page'=>$offset);        
        $search = array('conditions'=>$conditions);        
        $exercise_list = $this->Exercise->find('all', $search);
        usort($exercise_list, array('ExercisesController', 'compare_length_body_part_id'));
        //$exercise_list = array_slice($exercise_list, $offset*23, 23);

        return $exercise_list;
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