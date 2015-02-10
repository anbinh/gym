<?php
class UsersController extends AppController {


    public $components = array('RequestHandler');


    public function index() {

        $auth = $this->getAuthentication();
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
        $this->redirect('/Users/signup');
    }

    public function edit_profile(){

        $auth = $this->getAuthentication();
        if($auth)
        {

            $profile = $auth;
        }
        else
        {
            $profile = $this->getCurrentRegister();
            // register mode
            if($profile)
            {
                $fullname = explode(" ",$profile['fullname']);
                if(count($fullname) > 1)
                {
                    $profile['firstname'] = $fullname[0];
                    $profile['lastname'] = $fullname[1];
                }
                else
                    $profile['firstname'] = $profile['fullname'];
            }
            
        $this->set('profile',$profile);
    }

    public function save_profile() {
        $data = $this->request->input('json_decode',true);
        if($data['id'] != 0)
            $user['User']['id'] = $data['id'];
        //$user['User']['id'] = '54da0cf7d5251d8417000029';
        $user['User']['login'] =  $data['username'];
        $user['User']['birthday'] =  $data['birthday'];
        $user['User']['email'] =  $data['email'];
        $user['User']['firstname'] =  $data['firstname'];
        $user['User']['lastname'] =  $data['lastname'];
        $user['User']['password'] =  md5('demo');
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