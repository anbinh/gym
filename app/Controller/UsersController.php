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

    public function view($user_id = null) {
        if (!$this->User->exists($user_id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->findById($user_id));
    }

    public function login() {

    }

    public function loginByEmailAndPassword(){
        $data = $this->request->input('json_decode',true);
        $user = $this->User->find("first",array( "conditions" => array(
                'email' => $data['email'],'password'=>md5($data['password'])))
        );
        if($user)
        {
            $this->setAuthentication($user['User']);
            $this->set(array(
                'message' => 'success',
                '_serialize' => array('message')
            ));
        }
        else
        {
            $this->set(array(
                'message' => 'Email or Password does not match !',
                '_serialize' => array('message')
            ));
        }

    }

    public function signup(){
        $this->Session->delete('user_id');
        if(isset($_POST['id'])){
            $id = $_POST['id'];       
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $gender = $_POST['gender'];
            $email = $_POST['email'];
            $link = $_POST['link']; 
            $locale = $_POST['locale'];          

            $user_ = $this->checkExistUser($id);
            if(count($user_) > 0) // already have this user on db
            {
                $this->setAuthentication($user_['User']);
            }
            else
            {
                // user does not exist from fb
                // add new info
                $user['User']['firstname'] =  $firstname;
                $user['User']['lastname'] =  $lastname;
                $user['User']['email'] =  $email;
                if($gender == 'male')
                    $user['User']['sex'] =  1;
                else
                    $user['User']['sex'] = 0;
                $user['User']['fb_id'] = $id;
                $this->User->save($user);
                $user['User']['id'] = $this->User->getLastInsertId();
                $this->setAuthentication($user['User']);
            }
            $this->set(array(
                'message' => $user_,
                '_serialize' => array('message')
            ));
        }

    }    

    public function checkExistUser($fb_id)
    {
        // check fb_id from db
        $user = $this->User->find('first',array(
            'conditions' => array('User.fb_id' => $fb_id)
        ));
        return $user;
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
        if($auth)
        {

            $profile = $auth;
        }
        else {
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
        }
            
        $this->set('profile',$profile);
    }

    public function save_profile() {
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
        $message = 'Save Profile Success';
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }

    public function registerByUsername()
    {
        $data = $this->request->input('json_decode',true);
        $message = $data;
        $this->saveCurrentRegister($data);
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }
}