<?php
class UsersController extends AppController {


    public $components = array('RequestHandler');


    public function index($user_id = null) {
        if (!$user_id) {
            throw new NotFoundException(__('Invalid user'));
        }

        $user = $this->User->findById($user_id);
        $this->set('user', $user['User']);
    }

    public function view($user_id = null) {
        if (!$this->User->exists($user_id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->findById($user_id));
    }

    public function login(){
    	
    }
}