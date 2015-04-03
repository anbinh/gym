<?php
App::uses('CakeEmail', 'Network/Email');
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

    public function getUserProfileAndExerciseById($user_id)
    {
        $user = $this->User->findById($user_id);
        $search = array(
            '_id' => array('$in' => $user['User']['favorite_exercises'])
        );
        $exercises_like = $this->Exercise->find('all',array('conditions'=>$search));
        $this->set(array(
            'user' => $user['User'],
            'exercises_like' => $exercises_like,
            '_serialize' => array('user','exercises_like')
        ));
    }

    public function getRegisterUser()
    {
        $auth = $this->getCurrentRegister();
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

    public function signup(){
        if(isset($_POST['id'])){
            $id = $_POST['id'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $gender = $_POST['gender'];
            $email = $_POST['email'];
            $name = $_POST['name'];
//            $link = $_POST['link'];
//            $locale = $_POST['locale'];

            $user = $this->checkExistUser($id);
            if(count($user) > 0) // already have this user on db
            {
                $this->setAuthentication($user['User']);
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
                $user['User']['login'] = $name;
                $user['User']['fb_id'] = $id;
                $user['User']['password'] = md5("demo");
                $user['User']['language'] = "";
                $user['User']['address']['street'] = "";
                $user['User']['birthday'] = "";
                $user['User']['receive_promote'] = false;
                $user['User']['picture'] = "//graph.facebook.com/".$id."/picture?type=large";
                $user['User']['favorite_exercises'] = array();
                $user['User']['role'] = array();
                $user['User']['assigned_programs'] = array();
                $this->User->save($user);
                $user['User']['id'] = $this->User->getLastInsertId();
                $this->setAuthentication($user['User']);
            }
            $this->set(array(
                'message' => $user,
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

    public function loginByEmailAndPassword(){
        $data = $this->request->input('json_decode',true);
        $user = $this->User->find("first",array( "conditions" => array(
                'email' => $data['email'],'password'=>md5($data['password'])))
        );
        if($user)
        {
            $this->setAuthentication($user['User']);
            $this->setCookieAuthenticate($data['email'],md5($data['password']));
            $this->set(array(
                'message' => 'success',
                'id' => $user['User']['id'],
                '_serialize' => array('message','id')
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

    public function registerByUsername()
    {
        $data = $this->request->input('json_decode',true);
        $message = $data;
        // validate email
        $user = $this->User->find("first",array( "conditions" => array(
                'email' => $data['email']))
        );
        if($user)
        {            
            $this->set(array(
                'message' => 'This Email existed !',
                '_serialize' => array('message')
            ));
        }
        else
        {
            $this->saveCurrentRegister($data);
            $this->set(array(
                'message' => 'success',
                '_serialize' => array('message')
            ));
        }               
    }

    public function getListExercise(){
        //$exercises = $this->Exercise->find('all',array('limit' => 8));
        $user = $this->getAuthentication();
        $exercises_like = array();
        if($user)
        {
            $user = $this->User->findById($user['id']);
            $user = $user['User'];
            $search = array(
                '_id' => array('$in' => $user['favorite_exercises'])
            );
            $exercises_like = $this->Exercise->find('all',array('conditions'=>$search));            
        }  
        // find all exercise
        /*$search = array(
            '_id' => array('$nin' => $user['favorite_exercises'])
        );
        $exercises_list = $this->Exercise->find('all',array('conditions'=>$search));*/
        
        // find all exercise this user like
        $exercises_list = $this->Exercise->find('all');
        $this->set(array(
            'exercises_list' => $exercises_list,
            'exercises_like' => $exercises_like,
            '_serialize' => array('exercises_list','exercises_like')
        ));
    }

    public function getListExerciseLike(){        
        $user = $this->getAuthentication();
        $exercises_like = array();
        if($user)
        {
            $user = $this->User->findById($user['id']);
            $user = $user['User'];
            $search = array(
                '_id' => array('$in' => $user['favorite_exercises'])
            );
            $exercises_like = $this->Exercise->find('all',array('conditions'=>$search));            
        }    
        $this->set(array(
            'exercises_like' => $exercises_like,
            '_serialize' => array('exercises_like')
        ));
    }

    public function getListBodyPart(){
        $lang = $this->Session->read('Config.language');
        $body_list = $this->BodyPart->find('all');
        $list = array();
        foreach($body_list as $item)
        {
            $temp['id'] = $item['BodyPart']['body_part_id'];
            $temp['name'] = $item['BodyPart']['description'];
            if($lang == "fr")
            {
                $temp['name'] = $item['BodyPart']['description_fr'];
            }
            array_push($list,$temp);
        }
        $this->set(array(
            'body_list' => $list,
            '_serialize' => array('body_list')
        ));
    }

    public function likeExerciseByUser($exercise_id)
    {
        $user = $this->getAuthentication();
        if($user)
        {
            $user_id = $user['id'];
            // add new object Id
            $this->User->mongoNoSetOperator = '$addToSet';
            $susp = array(
                "id" => $user_id,
                "favorite_exercises" => new MongoId($exercise_id)
            );
            $result = $this->User->save($susp);
            $this->set(array(
                'message' => $result,
                '_serialize' => array('message')
            ));
        }
        else{
            $this->set(array(
                'message' => "UnAuthentication",
                '_serialize' => array('message')
            ));
        }
        
    }

    public function unlikeExerciseByUser($exercise_id)
    {
        $user = $this->getAuthentication();
        if($user)
        {
            $user_id = $user['id'];
            $this->User->mongoNoSetOperator = '$pull';
            $susp = array(
                "id" => $user_id,
                "favorite_exercises" => new MongoId($exercise_id)
            );
            $result = $this->User->save($susp);
            $this->set(array(
                'message' => $result,
                '_serialize' => array('message')
            ));
        }
        else
        {
            $this->set(array(
                'message' => "UnAuthentication",
                '_serialize' => array('message')
            ));
        }        
    }

    public function loginByFbId($fb_id)
    {
        $user = $this->checkExistUser($fb_id);
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
                'message' => 'Fail',
                '_serialize' => array('message')
            ));
        }
    }

    public function getListProgram(){
        $programs_list = $this->Program->find('all');
        $this->set(array(
            'programs_list' => $programs_list,
            '_serialize' => array('programs_list')
        ));
    }

    public function getListObjective(){
        $lang = $this->Session->read('Config.language');
        $objective_list = $this->Objective->find('all');
        $list = array();
        foreach($objective_list as $item)
        {
            $temp['id'] = $item['Objective']['objective_id'];
            $temp['name'] = $item['Objective']['description'];
            if($lang == "fra")
                $temp['name'] = $item['Objective']['description_fr'];
            array_push($list,$temp);
        }
        $this->set(array(
            'objective_list' => $list,
            '_serialize' => array('objective_list')
        ));
    }

    public function toggleLanguage($language)
    {
        $this->Session->write('Config.language',$language);
        $this->set(array(
            'message' => "success",
            '_serialize' => array('message')
        ));
    }

    public function getMenuHeaderFile()
    {
        $lang = $this->Session->read('Config.language');
        $file = new File('MenuHeaderEng.json');
        if($lang == "fra")
            $file = new File('MenuHeaderFra.json');
        $json = $file->read(true, 'r');
        $json2array = json_decode($json);
        $this->set(array(
            'data' => $json2array,
            'lang' => $lang,
            '_serialize' => array('data','lang')
        ));
    }

    public function resetPassword(){
        $data = $this->request->input('json_decode',true);
        $email = $data['email'];
        // validate email
        $user = $this->User->find("first",array( "conditions" => array(
                'email' => $email))
        );
        if($user)
        {
            $this->sendEmailResetPassword($user['User']['id'],$email,$user['User']['login']);
            $this->set(array(
                'message' => 'success',
                '_serialize' => array('message')
            ));
        }
        else
        {
            if($this->Session->read('Config.language') == 'fra')
            {
                $this->set(array(
                    'message' => 'Aucun compte trouve. Reessayer',
                    '_serialize' => array('message')
                ));
            }
            else
            {
                $this->set(array(
                    'message' => 'That account does not exist. </br> Please try again.',
                    '_serialize' => array('message')
                ));
            }
        }
    }

    public function sendEmailResetPassword($token,$mail,$username){
        //$mail = 'valentino.nguyen.92@gmail.com';
        //$mail = 'valentino_rossi_26892@yahoo.com';
        $email = new CakeEmail('gmail');
        $email->emailFormat('html');
        $email->to($mail);
        $lang = $this->Session->read('Config.language');
        if($lang == 'fra')
        {
            $email->subject('Réinitialiser votre mot de passe Studiogym');
            $email->template('email_template_fra')->viewVars(['link' => 'http://'. $_SERVER['SERVER_NAME'] . '/Users/change_password/'.$token,'name'=>$username]);
        }
        else
        {
            $email->subject('Reset your Studiogym password');
            $email->template('email_template')->viewVars(['link' => 'http://'. $_SERVER['SERVER_NAME'] . '/Users/change_password/'.$token,'name'=>$username]);
        }
        $email->send();
    }

    public function changePassword(){
        $data = $this->request->input('json_decode',true);
        $user = $this->getAuthentication();

        if($data && $user){
            $password = $data['password'];        

            $user['password'] = md5($password);

            $save['User'] = $user;

            $this->User->save($save);

            $this->set(array(
                'message' => 'success',
                '_serialize' => array('message')
            ));
        }  
        else{
            $this->set(array(
                'message' => 'fail',
                '_serialize' => array('message')
            )); 
        }     
    }

    public function deleteAccount(){
        $data = $this->request->input('json_decode', true);
        $email = $data['email'];

        $user = $this->getAuthentication();

        if($data && $user){
            $checkEmail = $this->User->find("first", array('conditions'=>array('email'=>$email)));

            if(count($checkEmail)==0 || $user["email"]!=$email){
                $this->set(array(
                    'message' => "email_does_not_match",
                    '_serialize' => array('message')
                ));
            }else{
                $this->User->delete($checkEmail['User']['id']);
                $this->removeAuthentication();
                $this->set(array(
                    'message' => 'success',
                    '_serialize' => array('message')
                ));
            }             
        }else{
            $this->set(array(
                'message' => 'fail',
                '_serialize' => array('message')
            ));
        }
    }

    public function getExerciseDetail($exercise_id)
    {
        $exercise = $this->Exercise->findById($exercise_id);
        if($exercise)
        {
            $isVote = 0;
            $user = $this->getAuthentication();
            if($user)
            {

                $user = $this->User->findById($user['id']);
                $key = array_search($exercise_id, $user['User']['favorite_exercises']);
                if($key > 0)
                    $isVote = 1;
                $this->set(array(
                    'message' => 'success',
                    'exercise'=> $exercise,
                    'isVote'=>$isVote,
                    '_serialize' => array('message','exercise','isVote')
                ));
            }
            else
            {
                $this->set(array(
                    'message' => 'NoUserLogin',
                    'exercise'=> $exercise,
                    'isVote'=>$isVote,
                    '_serialize' => array('message','exercise','isVote')
                ));
            }
        }
    }
}