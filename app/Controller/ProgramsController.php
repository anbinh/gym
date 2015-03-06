<?php
App::uses('AppController', 'Controller');
class ProgramsController  extends AppController {
   
    public function index(){
    	$programs = $this->Program->find('all');

    	//pr($programs);
    }
    public function program_view($id=null){
        $programs = $this->Program->findById($id);
        // pr($programs);
        $this->set('programs', $programs);
    }
}
?>