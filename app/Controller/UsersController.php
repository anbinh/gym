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
         
        if ($this->Cookie->check('GYM.email')) {      
            $username = $this->Cookie->read('GYM.email');          
            // Select the username from the cookie
            $password = $this->Cookie->read('GYM.password');            
            // Select the password from the cookie
            $user = $this->User->find("first",array( "conditions" => array(
                    'email' => $username,'password'=>$password))
            );
            if ($user) {
                $this->setAuthentication($user['User']);
                $this->redirect('/Programs/index');
            } else {
                
            }
        }
    }

    public function logout(){
        $auth = $this->getAuthentication();
        if($auth){
            $this->removeAuthentication();
        }
        $this->clearCookieAuthenticate();
        $this->redirect('/Users/login');
    }

    public function edit_profile(){
        $auth = $this->getAuthentication();        
        $this->set('profile',$auth);
    }

    public function save_profile() {
        if ($this->data) {
            $data=$this->data;

            $data['User']['birthday'] = $data['User']['day'] . "-" . $data['User']['month'] . "-" . $data['User']['year'];
            // save img file
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
            // save data
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

                    // set default language                    
                    if($data['User']['language'] == "French")
                    {
                        $this->setLang("fra");
                    }
                    else
                    {
                        $this->setLang("eng");
                    }
                }
            }
            else
            {
                $data['User']['password'] = md5($data['User']['password']);
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
            //pr($data);
        }
        $this->redirect('/Users/index');
        //$this->render(FALSE);
    }

    public function forget_password(){

    }

    public function change_password($user_id = null){
        if($user_id)
        {
            $user = $this->User->findById($user_id);
            if($user)
            {
                $this->setAuthentication($user['User']);
            }
            else
            {
                $this->redirect('/Users/login');
            }
        }
    }

    public function delete_account(){

    }
}