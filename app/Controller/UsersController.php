<?php
class UsersController extends AppController {


    public $components = array('RequestHandler');


    public function index() {
        /*if (!$this->Session->check('user_id')) {
            throw new NotFoundException(__('Invalid user'));
        }*/
        $user_id = $this->Session->read('user_id');
        $user = $this->User->findById($user_id);
        $this->set('user', $user['User']);        
    }

    public function view($user_id = null) {
        if (!$this->User->exists($user_id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->findById($user_id));
    }

    public function signup(){
        if(isset($_POST['id'])){
            $id = $_POST['id'];       
            $name = $_POST['name'];               
            $gender = $_POST['gender'];       
            $link = $_POST['link']; 
            $locale = $_POST['locale'];          

            if($this->checkExistUser($id))
            {

            }
            else
            {
                // user doesnot exist from fb
                // add new info
            }

            $this->Session->write('user_id', '1');
            $this->Session->write('name', $name);
            return new CakeResponse(array('body'=> json_encode(array('val'=>$id)),'status'=>200));
        }
    }    

    public function checkExistUser($fb_id)
    {
        // check fb_id from db
        return true;
    }

    public function logout(){
        if($this->Session->check('user_id')){
            $this->Session->delete('user_id');
            $this->removeAuthentication();
        }
        return $this->render('signup');
    }

    public function edit_profile(){
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
            //pr($profile);
            $this->set('profile',$profile);
        }
        else // edit user mode
        {

        }
    }

    public function save_profile() {
        $data = $this->request->input('json_decode',true);
        if(isset($data['id']))
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
        $this->User->save($user);
        if(isset($data['id']))
            $this->Session->write('user_id', $this->User->getLastInsertId());
        $this->setAuthentication($this->User->getLastInsertId());
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

    function saveCurrentRegister($data) {
        $this->Session->write('GYM_CURRENT_REGISTER',$data);
    }

    function getCurrentRegister() {
        return $this->Session->read('GYM_CURRENT_REGISTER');
    } 
}