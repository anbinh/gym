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
            $locale = $_POST['locale'];

            $user = $this->checkExistUser($id);
            if(count($user) > 0) // already have this user on db
            {
                $this->setAuthentication($user['User']);
                if($user['User']['language'] == "French")
                {
                    $this->setLang("fra");
                }
                else
                {
                    $this->setLang("eng");
                }
            }
            else
            {
                // user does not exist from fb
                // add new info
                $user['User']['firstname'] =  $firstname;
                $user['User']['lastname'] =  $lastname;
                $user['User']['email'] =  $email;
                // sex
                if($gender == 'male')
                    $user['User']['sex'] =  1;
                else
                    $user['User']['sex'] = 0;
                // language
                if($locale == 'en_US')
                    $user['User']['language'] = "English";
                else
                    $user['User']['language'] = "French";
                $user['User']['login'] = $name;
                $user['User']['fb_id'] = $id;
                $user['User']['password'] = md5("demo");                
                $user['User']['address']['street'] = "";
                $user['User']['birthday'] = "";
                $user['User']['receive_promote'] = false;
                $user['User']['picture'] = "//graph.facebook.com/".$id."/picture?type=large";
                $user['User']['favorite_exercises'] = array();
                $user['User']['assigned_programs'] = array();                            
                $user['User']['actif'] = 0;
                $user['User']['date_inscription'] = date("Y-m-d H:i:s");
                $user['User']['date_member'] = date("Y-m-d H:i:s");
                $user['User']['bookmark'] = "";                                                
                $user['User']['country'] = array('code'=>'','name'=>'');
                $user['User']['role'] = USER_ROLE;

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
            if($user['User']['language'] == "French")
            {
                $this->setLang("fra");
            }
            else
            {
                $this->setLang("eng");
            }

            // check if user has to try any private page before
/*          $url = $this->getUnauthenticateUrl();
            if(!isset($url))
                $url = null;   */         
                
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
            // Add default data            
            $this->saveCurrentRegister($data);            
            $this->set(array(
                'message' => 'success',
                '_serialize' => array('message')
            ));
        }               
    }

    public function getListExerciseProgramEditor(){
        $user = $this->getAuthentication();
        $exercises_like = array();
        $isOver = false;
        if($user)
        {
            $user = $this->User->findById($user['id']);
            $user = $user['User'];
            $search = array(
                '_id' => array('$in' => $user['favorite_exercises'])
            );
            // find all exercise this user like
            $exercises_like = $this->Exercise->find('all',array('conditions'=>$search));            
        }        
        
        //$exercises_list = $this->Exercise->find('all', array('limit'=>23));
        $exercises_list = $this->filterExercise(-1, -1, 0, true);
        //list all exercises
        $exercises_list_backup = $this->Exercise->find('all');

        if(sizeof($exercises_list) < 23)
            $isOver = true;
        $this->set(array(
            'exercises_list' => $exercises_list,
            'exercises_like' => $exercises_like,
            'exercises_list_backup' =>  $exercises_list_backup,
            'isOver' => $isOver,
            '_serialize' => array('exercises_list','exercises_like','isOver', 'exercises_list_backup')
        ));
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
        $exercises_list = $this->filterExercise(-1, -1, 0, true);
        $isOver = false;
        if(sizeof($exercises_list) < 23)
            $isOver = true;
        $this->set(array(
            'exercises_list' => $exercises_list,
            'exercises_like' => $exercises_like,
            'isOver' => $isOver,
            '_serialize' => array('exercises_list','exercises_like','isOver')
        ));
    }

    public function getListExerciseLoadMore($offset, $category_id, $body_part_id){          
        $exercises_list_more = $this->filterExercise($category_id, $body_part_id, $offset, 1);
        $exercises_like = $this->getExercisesLike();

        $isOver = false;
        if(sizeof($exercises_list_more) < 23)
            $isOver =  true;
        $this->set(array(
            'exercises_list_more' => $exercises_list_more,
            'isOver' => $isOver,
            'exercises_like' => $exercises_like,
            '_serialize' => array('exercises_list_more','isOver', 'exercises_like')
        ));
    }

    public function getListExerciseByFilter($category_id, $body_part_id, $isShowAll = 1){        
        $offset = 0;                
        $exercise_list = $this->filterExercise($category_id, $body_part_id, $offset, $isShowAll);
        $exercises_like = $this->getExercisesLike();

        $isOver = false;
        if(sizeof($exercise_list) < 23)
            $isOver =  true;

        $this->set(array(
            'exercise_list' => $exercise_list, 
            'isOver' => $isOver,
            'exercises_like' => $exercises_like, 
            '_serialize' => array('exercise_list', 'isOver', 'exercises_like')
        ));
    }

    public function compare_length_body_part_id($a, $b){
         $temp1 = split('.', $a['Exercise']['bodypart_id']);
         $temp2 = split('.', $b['Exercise']['bodypart_id']);
        
        return count($temp1) > count($temp2);
    }
    public function filterExercise($category_id, $body_part_id, $offset, $isShowAll){
        if($body_part_id != -1){
            $body_part_id = 'n'.$body_part_id.'n';    
        }    
        $conditions = array('_id' =>'','Exercise.category_id'=>$category_id, 'Exercise.bodypart_id' => new MongoRegex("/$body_part_id/i"));
        // category 
        if($category_id == -1)
        {
            unset($conditions['Exercise.category_id']);
        }    
        // body part
        if($body_part_id == -1)
        {
            unset($conditions['Exercise.bodypart_id']);
        }
        // exercises like
        if($isShowAll == 1){
            unset($conditions['_id']);   
        }
        if($isShowAll == 0){
            $user = $this->getAuthentication();
            $exercises_like = array();
            if($user)
            {
                $user = $this->User->findById($user['id']);
                $user = $user['User'];
                // $search = array(
                //     '_id' => array('$in' => $user['favorite_exercises'])
                // );
                $conditions['_id'] = array('$in' => $user['favorite_exercises']);
                //$exercises_like = $this->Exercise->find('all',array('conditions'=>$search));            
            } 
        }
        //$search = array('conditions'=>$conditions, 'limit'=>23, 'page'=>$offset);        
        $search = array('conditions'=>$conditions);        
        $exercise_list = $this->Exercise->find('all', $search);
        usort($exercise_list, array('ApisController', 'compare_length_body_part_id'));
        $exercise_list = array_slice($exercise_list, $offset*24, 24);

        return $exercise_list;
    }
    public function getExercisesLike(){
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
        return $exercises_like;
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
        $lang_text = "description";
        if($lang == "fra")
        {
            $lang_text = "description_fr";
        }
        foreach($body_list as $item)
        {
            $temp['id'] = $item['BodyPart']['body_part_id'];
            $temp['name'] = $item['BodyPart'][$lang_text];
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

    
    public function saveProgramUserProfile($program_id){
        $user = $this->getAuthentication();
        if($user)
        {
            $user_id = $user['id'];
            // add new object Id
            $this->User->mongoNoSetOperator = '$addToSet';
            $susp = array(
                "id" => $user_id,
                "assigned_programs" => new MongoId($program_id)
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
    
    public function getListProgramOfUser(){
        $user = $this->getAuthentication();
        if($user){
            $user_id = $user['id'];
            $user = $this->User->findById($user_id);

            $search = array(
                '_id' => array('$in' => $user['User']['assigned_programs'])
            );
            $list_programs_of_user = $this->Program->find('all', array('conditions'=>$search));  
            // reorder list                      
            $reorder_list = array();
            foreach ($user['User']['assigned_programs'] as $key => $value) {
                foreach ($list_programs_of_user as $key1 => $value1) {
                    if($value1['Program']['id'] == $value)
                        array_push($reorder_list, $value1);
                }
            }

            $this->set(array(
                'program_order'=> $user['User']['assigned_programs'],
                'message' => $reorder_list,
                '_serialize' => array('message','program_order')
            ));
        }
        else{
            $this->set(array(
                'message' => "UnAuthentication",
                '_serialize' => array('message')
            ));
        }
    }

    public function reorderProgram()
    {
        $data = $this->request->input('json_decode',true);
        $user = $this->getAuthentication();
        if($user && $user){
            $user_id = $user['id'];
            $user = $this->User->findById($user_id);

            $array_id = array();
            foreach ($data as $key => $value) {
                array_push($array_id, new MongoId($value));
            }
            $susp = array(
                "id" => $user_id,
                "assigned_programs" => $array_id
            );
            $result = $this->User->save($susp);

            $this->set(array(                
                'message' => 'success',
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

    public function deleteAssignedProgram($assigned_programs=null){
        $user = $this->getAuthentication();
        if($user){
            $user_id = $user['id'];
            $program = $this->Program->findById($assigned_programs);
            if($program['Program']['creator_id'] == $user_id)
            {
                $program['Program']['creator_id'] = "";
                $program['Program']['author'] = "";

                if ($user['role'] == 'admin') {
                    $program['Program']['is_public'] = 0;
                }

                $this->Program->save($program);
            }
            $this->User->mongoNoSetOperator = '$pull';
            $susp = array(
                "id" => $user_id,
                "assigned_programs" => new MongoId($assigned_programs)
            );
            $result = $this->User->save($susp);
            $this->set(array(
                'message' => $result,
                'xxx'=>$program,
                '_serialize' => array('message','xxx')
            ));
        }
        else{
            $this->set(array(
                'message' => "UnAuthentication",
                '_serialize' => array('message')
            ));
        }
    }
    public function getListProgram(){
        $programs_list = $this->Program->find('all',array('conditions'=>array('is_public'=>1)));
        //$programs_list = $this->Program->find('all');
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
        // set cookie language
        $this->setCookieLanguage($language);
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
                //$this->removeAuthentication();
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

    public function GetIsAuthenticate()
    {
        $user = $this->getAuthentication();
        if($user)
        {
            $this->set(array(
                    'message' => true,
                    '_serialize' => array('message')
                ));
        }
        else
        {
            $this->set(array(
                    'message' => false,
                    '_serialize' => array('message')
                ));
        }
    }

    public function GetIsOnMobile()
    {        
        if($this->request->is('mobile'))
        {
            $this->set(array(
                    'message' => true,
                    '_serialize' => array('message')
                ));
        }
        else
        {
            $this->set(array(
                    'message' => false,
                    '_serialize' => array('message')
                ));
        }
    }

    public function saveProgramEditor(){
        $data = $this->request->input('json_decode',true);
        $program = [];

        $user = $this->getAuthentication();
        if($user)
        {
            $user = $this->User->findById($user['id']);
            $user = $user['User'];

            $objective = $this->Objective->find('first',array('conditions'=>array('objective_id'=>(int)$data['objective'])));

            $program['creation_date'] = date("Y-m-d H:i:s"); 
            $program['modification_date'] = date("Y-m-d H:i:s"); 
            $program['name'] = $objective['Objective']['description'];
            $program['author'] = $user['login'];            
            $program['level'] = '';
            $program['objective'] = $data['objective'];                        
            $program['color_code'] = '';
            $program['name_fr'] = $objective['Objective']['description_fr'];
            if($user['role'] == ADMIN_ROLE)
                $program['is_public'] = 1;    
            else
                $program['is_public'] = 0;
            $program['creator_id'] = $user['id'];
            $program['content'] = $data['tabs'];
            $program['short_text'] = $data['text'];
            $program['descriptive'] = $data['descriptive'];
            $program['id'] = "";

            // check if this is add new or edit action
            if($data['program_id'] != "")
            {
                $program['id'] = $data['program_id'];
            }


            if($data['isNewImg'] == true)
            {
                $this->setProgramEdit($program);
                $this->set(array(
                    'message' => 'success',
                    'data'=> $objective,
                    'data2' => $data,
                    '_serialize' => array('message','data','data2')
                ));
            }                
            else // update mode
            {
                $this->Program->save($program);
                if($program['id'] != "")
                    $program_id = $program['id'];
                else
                    $program_id = $this->Program->getLastInsertId();
                $this->set(array(
                    'message' => 'success',
                    'id' => $program_id,
                    '_serialize' => array('message','id')
                ));
            }                            
        }          
    }

    public function ProgramUploadFile()
    {
        $data = $this->request;
        if($data->params['form']['file']){
            $file = $data->params['form']['file'];
            if($file['name']){
                $path = $file['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $sFileName = $this->generateRandomString().'.'.$ext;
                $file_uri = '/upload/image/'.$sFileName;     

                $pathSave = $_SERVER['DOCUMENT_ROOT'].WEBROOT.$file_uri;                       
                if(move_uploaded_file($file['tmp_name'],$pathSave))                
                {
                    $program = $this->getProgramEdit();
                    $program['photo'] = $sFileName;                    
                    $this->Program->save($program);

                    if($program['id'] != "")
                        $program_id = $program['id'];
                    else
                        $program_id = $this->Program->getLastInsertId();
                    // save this program into Owner list                    
                    $user = $this->getAuthentication();
                    if($user)
                    {
                        $user_id = $user['id'];
                        // add new object Id
                        $this->User->mongoNoSetOperator = '$addToSet';
                        $susp = array(
                            "id" => $user_id,
                            "assigned_programs" => new MongoId($program_id)
                        );
                        $this->User->save($susp);                        
                    }                    

                    $this->set(array(
                        'message' => $program_id,
                        'data' => $data,
                        'path' => $pathSave,
                        '_serialize' => array('message','data','path')
                    ));
                }                
            }
        }
        else
        {
            $this->set(array(
                'message' => 'fail',
                '_serialize' => array('message')
            ));  
        }              
    }

    public function getListProgramEditor($program_id){
        $program = $this->Program->findById($program_id);
        if($program){
            $this->set(array(
                'message' => $program,
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
}