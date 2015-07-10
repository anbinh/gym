<?php
App::uses('Controller', 'Controller');

class AppController extends Controller {

    public $components = array('Session', 'RequestHandler', 'Cookie');
    public $helpers = array('Form', 'Html', 'Js', 'Time');
    public $uses = array('User','BodyPart','Exercise','Program','Objective','TextResource');

    var $language, $availableLanguages;
    public $auth_user;
    public function beforeFilter() {
        parent::beforeFilter();
        // check if the request is 'mobile', includes phones, tablets, etc.
        if ($this->request->is('mobile')) {
            $this->set('is_mobile', true);
        }

        // check current language
        if($this->Cookie->check('GYM.language'))
        {
            $this->language = $this->Cookie->read('GYM.language');
        }
        else
        {
            if($this->Session->check('Config.language')) { // Check for existing language session
                $this->language = $this->Session->read('Config.language'); // Read existing language
            } else {
                $this->language = Configure::read('defaultLanguage'); // No language session => get default language from Config file
            }
        }   
            
        //pr($this->getAuthentication());

        $this->setLang($this->language); // call protected method setLang with the lang shortcode
        $this->set('language',$this->language); // send $this->language value to the view

        if($this->params['controller'] == 'Exercises')
        {
            $this->set('curr_page', 'Exercises');
        }elseif($this->params['controller'] == 'Programs')
        {
            $this->set('curr_page', 'Programs');
        }elseif($this->params['controller'] == 'Users' && ($this->params['action'] != 'index' || $this->params['action'] != '')){
            $this->set('curr_page', 'Users');
        }


        if($this->params['controller'] != 'Apis' && $this->params['controller'] != 'Aptitudes' && $this->params['controller'] != 'Privacies'){
            if($this->params['controller'] == 'Users' && $this->params['action'] == 'change_password' && count($this->params['pass']) > 0)
            {

            }
            else
            {
                if($this->params['controller'] != 'Users' || ($this->params['action'] != 'login' && $this->params['action'] != 'signup'))
                {
                    if($this->params['action'] != 'registerByUsername' && $this->params['action'] != 'loginByEmailAndPassword' && $this->params['action'] != 'forget_password')
                    {
                        $auth_user = $this->getAuthentication();
                        //pr($auth_user);
                        if($auth_user == null) {
                            $is_register = $this->getCurrentRegister();
                            if($is_register == null && $this->params['controller'] != 'Exercises' && $this->params['controller'] != 'Programs')
                            {                               
                                $this->redirect('/Users/login');                                
                            }                        
                        }
                        else {
                            $this->set('auth_user',$auth_user);
                        }
                    }                    
                }   
            }
        }
    }

    protected function setLang($lang) { // protected method used to set the language
        $this->Session->write('Config.language', $lang); // write our language to session
        $this->setCookieLanguage($lang);
        Configure::write('Config.language', $lang); // tell CakePHP that we're using this language        
    }

    function getAuthentication(){
        return $this->Session->read('LOGIN_USER');
    }

    function setAuthentication($user){
        $this->Session->write('LOGIN_USER',$user);
    }

    function removeAuthentication() {
        $this->Session->write('LOGIN_USER' ,null);
    }

    function saveCurrentRegister($data) {
        $this->Session->write('GYM_CURRENT_REGISTER',$data);
    }

    function getCurrentRegister() {
        return $this->Session->read('GYM_CURRENT_REGISTER');
    }

    function saveUnauthenticateUrl($url) {
        $this->Session->write('GYM_UNAUTHENTICATE_URL',$url);
    }

    function getUnauthenticateUrl() {
        return $this->Session->read('GYM_UNAUTHENTICATE_URL');
    }

    function generateRandomString ($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    function setCookieAuthenticate($email,$encriptPass)
    {
        $this->Cookie->write('GYM.email', $email, false);
        $this->Cookie->write('GYM.password', $encriptPass, false);
    }

    function setCookieLanguage($lang)
    {
        $this->Cookie->write('GYM.language', $lang, false);        
    }

    function clearCookieAuthenticate()
    {
        $this->Cookie->destroy();
    }

    function getProgramEdit(){
        return $this->Session->read('PROGRAM_EDIT');
    }

    function setProgramEdit($program){
        $this->Session->write('PROGRAM_EDIT',$program);
    }
}
