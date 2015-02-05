<?php
class UsersController extends AppController {

    public function index() {
        $user = $this->User->find('all');

        $this->set('user', $user);
    }

}