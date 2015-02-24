<?php
class ApisController extends AppController {


    public $components = array('RequestHandler');


    public function getUserProfileById($user_id)
    {
        $user = $this->User->findById($user_id);
        $this->set(array(
            'user' => $user['User'],
            '_serialize' => array('user')
        ));
    }

    public function getRegisterUser()
    {
        $auth = $this->getAuthentication();
        $this->set(array(
            'user' => $auth,
            '_serialize' => array('user')
        ));
    }

    public function postSaveUserProfile() {
        $data = $this->request->input('json_decode',true);
        if($data['id'] != 0)
        {
            $user['User']['id'] = $data['id'];
            $user_old = $this->User->findById($data['id']);
            if(isset($user_old['User']['favorite_exercises']))
                $user['User']['favorite_exercises'] = $user_old['User']['favorite_exercises'];
            else
                $user['User']['favorite_exercises'] = array();
            if(isset($user_old['User']['role']))
                $user['User']['role'] = $user_old['User']['role'];
            else
                $user['User']['role'] = array();
            if(isset($user_old['User']['assigned_programs']))
                $user['User']['assigned_programs'] = $user_old['User']['assigned_programs'];
            else
                $user['User']['assigned_programs'] = array();
        }
        $user['User']['login'] =  $data['username'];
        $user['User']['birthday'] =  $data['birthday'];
        $user['User']['email'] =  $data['email'];
        $user['User']['firstname'] =  $data['firstname'];
        $user['User']['lastname'] =  $data['lastname'];
        $user['User']['password'] =  md5('miratik');
        $user['User']['sex'] =  $data['gender'];
        $user['User']['address']['street'] =  $data['address'];
        $user['User']['language'] =  $data['language'];
        $user['User']['receive_promote'] =  $data['receive_promote'];
        $this->User->save($user);

        if($data['id'] == 0)
        {
            $user['User']['id'] = $this->User->getLastInsertId();
            $this->saveCurrentRegister(null);
        }
        $this->setAuthentication($user['User']);
        $data = $this->data;
        $this->set(array(
            'message' => $data,
            '_serialize' => array('message')
        ));
    }
}