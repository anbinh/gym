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

    public function getListExercise(){
        //$exercises = $this->Exercise->find('all',array('limit' => 8));
        $user = $this->getAuthentication();
        $user = $this->User->findById($user['id']);
        $user = $user['User'];
        // find all exercise
        /*$search = array(
            '_id' => array('$nin' => $user['favorite_exercises'])
        );
        $exercises_list = $this->Exercise->find('all',array('conditions'=>$search));*/
        $exercises_list = $this->Exercise->find('all');
        // find all exercise this user like
        $search = array(
            '_id' => array('$in' => $user['favorite_exercises'])
        );
        $exercises_like = $this->Exercise->find('all',array('conditions'=>$search));
        $this->set(array(
            'exercises_list' => $exercises_list,
            'exercises_like' => $exercises_like,
            '_serialize' => array('exercises_list','exercises_like')
        ));
    }

    public function getListBodyPart(){
        $body_list = $this->BodyPart->find('all');
        $list = array();
        foreach($body_list as $item)
        {
            $temp['id'] = $item['BodyPart']['body_part_id'];
            $temp['name'] = $item['BodyPart']['description'];
            array_push($list,$temp);
        }
        $this->set(array(
            'body_list' => $list,
            '_serialize' => array('body_list')
        ));
    }

    public function detail($id){
        $exercise_item = $this->Exercise->find('first', array('conditions'=>array('id'=>$id)));
        //pr($exercise_item);
        return $this->render('exercise_item');
    }

    public function likeExerciseByUser($exercise_id)
    {
        $user = $this->getAuthentication();
        $user_id = $user['id'];
        // add new object Id
        $this->User->mongoNoSetOperator = '$addToSet';
        $susp = array(
            "id" => $user_id,
            "favorite_exercises" => new MongoId($exercise_id)
        );
        $result = $this->User->save($susp);
        $this->set(array(
            'message' => $result,
            '_serialize' => array('message')
        ));
    }

    public function unlikeExerciseByUser($exercise_id)
    {
        $user = $this->getAuthentication();
        $user_id = $user['id'];
        $this->User->mongoNoSetOperator = '$pull';
        $susp = array(
            "id" => $user_id,
            "favorite_exercises" => new MongoId($exercise_id)
        );
        $result = $this->User->save($susp);
        $this->set(array(
            'message' => $result,
            '_serialize' => array('message')
        ));
    }
}
?>