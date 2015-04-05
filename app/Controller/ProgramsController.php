<?php
App::uses('AppController', 'Controller');
class ProgramsController  extends AppController {
   
    public function index(){
    	$programs = $this->Program->find('all');

    	//pr($programs);
    }
    public function program_view($id=null){
        $programs = $this->Program->findById($id);         
        $this->set('isSaved', $this->check_program_is_saved($id));
        $this->set('programs', $programs);
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
    	//$list_exercise = $this->Exercise->find('all');

    }
}
?>