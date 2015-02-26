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
            if($data['User']['id'] != 0)
            {
                $user = $this->User->findById($data['User']['id']);
                if($user)
                {
                    $data['User']['password'] = $user['User']['password'];
                    $data['User']['favorite_exercises'] = $user['User']['favorite_exercises'];
                    $data['User']['role'] = $user['User']['role'];
                    $data['User']['assigned_programs'] = $user['User']['assigned_programs'];
                }
            }
            else
            {
                $data['User']['password'] = "demo";
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
        }
        $this->redirect('/Users/index');
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