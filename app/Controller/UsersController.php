<?php

class UsersController extends AppController {


    public $components = array('RequestHandler');


    public function index() {
        $auth = $this->getAuthentication();
        //$auth = $this->User->findById("54cf959dacc46c81b036a729");
        //$auth = $auth['User'];
        if (!$auth) {
            throw new NotFoundException(__('Invalid user'));

        }
        $this->set('user', $auth);
    }

    public function signup(){
        
    }

    public function view($user_id = null) {
        if (!$this->User->exists($user_id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->findById($user_id));
    }

    public function login() {
        $this->removeAuthentication();
    }

    public function logout(){

        $auth = $this->getAuthentication();
        if($auth){
            $this->removeAuthentication();
        }
        $this->redirect('/Users/login');
    }

    public function edit_profile(){

        $auth = $this->getAuthentication();
        /*else {
            $profile = $this->getCurrentRegister();
            // register mode
            if ($profile) {
                $fullname = explode(" ", $profile['fullname']);
                if (count($fullname) > 1) {
                    $profile['firstname'] = $fullname[0];
                    $profile['lastname'] = "";
                    foreach($fullname as $key => $value)
                    {
                        if($key == 0)
                            continue;
                        $profile['lastname'] .= $value." ";
                    }
                } else
                    $profile['firstname'] = $profile['fullname'];
            }
        }*/
        $this->set('profile',$auth);
    }

    public function save_profile() {
        if ($this->data) {
            $data=$this->data;

            $data['User']['birthday'] = $data['User']['day'] . "-" . $data['User']['month'] . "-" . $data['User']['year'];
            if($_FILES){
                if($_FILES['picture']['name']){
                    $path = $_FILES['picture']['name'];
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $sFileName = $this->generateRandomString().'.'.$ext;
                    $file_uri = '/upload/image/'.$sFileName;
                    $data['User']['picture'] = $file_uri;
                    //move_uploaded_file($_FILES['picture']['tmp_name'],$_SERVER['DOCUMENT_ROOT'].'/app/webroot'.$file_uri);
                    move_uploaded_file($_FILES['picture']['tmp_name'],$_SERVER['DOCUMENT_ROOT'].$file_uri);
                }
            }
            else{
                if($data['User']['picture'] == "")
                    unset($data['User']['picture']);
            }
            if($data['User']['id'] != 0)
            {
                $user = $this->User->findById($data['User']['id']);
                if($user)
                {
                    $data['User']['password'] = $user['User']['password'];
                    if(!isset($user['User']['favorite_exercises']))
                    {
                        $data['User']['favorite_exercises'] = array();
                        $data['User']['role'] = array();
                        $data['User']['assigned_programs'] = array();
                    }
                    else
                    {
                        $data['User']['favorite_exercises'] = $user['User']['favorite_exercises'];
                        $data['User']['role'] = $user['User']['role'];
                        $data['User']['assigned_programs'] = $user['User']['assigned_programs'];
                    }
                    if(!$_FILES)
                        $data['User']['picture'] = $user['User']['picture'];
                }
            }
            else
            {
                //$data['User']['password'] = md5($data['User']['password']);
                $data['User']['favorite_exercises'] = array();
                $data['User']['role'] = array();
                $data['User']['assigned_programs'] = array();
            }
            if(isset($data['User']['receive_promote']))
                $data['User']['receive_promote'] = true;
            else
                $data['User']['receive_promote'] = false;

            $this->User->save($data);
            if($data['User']['id'] == 0)
                $data['User']['id'] = $this->User->getLastInsertId();
            $this->setAuthentication($data['User']);
            pr($data);
        }
        $this->redirect('/Users/index');
        //$this->render(FALSE);
    }

    public function forget_password(){

    }
}