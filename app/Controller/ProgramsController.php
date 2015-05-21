<?php
App::uses('AppController', 'Controller');
class ProgramsController  extends AppController {
   
    public function index(){
    	//$programs = $this->Program->find('all');

    	//pr($programs);
    }

    public function login_modal() {
        $this->layout = false;
    }

    public function program_view($id=null){
        if($id != null)
        {
            //pr($this->Exercise->findById('551e9f9670711fb269285cd2'));
            $programs = $this->Program->findById($id);                    
            $this->set('isSaved', $this->check_program_is_saved($id));
            $this->set('isCreator', $this->check_user_is_creator($programs));
            $this->set('programs', $programs);

            //pr($programs);
            $exercise_list = array();
            foreach ($programs['Program']['content'] as $key => $item) {
                foreach ($item['exercise_list'] as $key1 => $item1) {
                    foreach ($item1['exercise_item'] as $key2 => $item2) {
                        array_push($exercise_list, $item2['exercise_id']);
                    } 
                } 
            } 
            //(string)$item2['exercise_id']->{'$id'}
            $exercise_list = array_values(array_unique($exercise_list));            
            $search = array(
                '_id' => array('$in' => $exercise_list)
            );
            $exercises_list = $this->Exercise->find('all',array('conditions'=>$search));
            $exercises_list = Set::combine($exercises_list, '{n}.Exercise.id', '{n}.Exercise');
            $this->set('exercises_list',$exercises_list);            
        }
        else
        {
            $this->redirect('/Programs/index');
        }
        
    }

    public function check_user_is_creator($program)
    {
        $user = $this->getAuthentication();
        if($user)
        {            
            $user = $this->User->findById($user['id']);
            if($program['Program']['creator_id'] == $user['User']['id'] && in_array($program['Program']['id'], $user['User']['assigned_programs']))            
                return true;            
            else
                return false;
        }
        else
            return false;
    }

    public function check_program_is_saved($program_id){
        $user = $this->getAuthentication();
        if($user)
        {
            $user_id = $user['id'];
            $user = $this->User->findById($user_id);

            if(in_array($program_id, $user['User']['assigned_programs'])){
                return true;
            }
            return false;            
        }
        else{
            return false;
        }
    }
    public function program_editor(){
    	$user = $this->getAuthentication();
        if(!$user)
        {
             $this->redirect('/Users/login');
        }        
    }
    public function blank_page(){
        
    }
}
?>