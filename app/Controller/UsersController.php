<?php
class UsersController extends AppController {


    public $components = array('RequestHandler');


    public function index() {
        $this->Session->write('user_id', '54cf959dacc46c81b036a716');
        if (!$this->Session->check('user_id')) {
            throw new NotFoundException(__('Invalid user'));
        }
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

    public function login(){
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
        }

        return $this->render('login');
    }
    public function edit_profile(){
        
    }

    public function save_profile() {
        $data = $this->request->input('json_decode',true);
        $message = $data;
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }
}