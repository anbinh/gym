<?php
App::uses('Controller', 'Controller');

class AppController extends Controller {

    public $components = array('Session', 'RequestHandler', 'Cookie');
    public $helpers = array('Form', 'Html', 'Js', 'Time');
    public $uses = array('User','BodyPart','Exercise','Program','Objective');

    var $language, $availableLanguages;
    public $auth_user;
    public function beforeFilter() {
        parent::beforeFilter();
        if($this->Session->check('Config.language')) { // Check for existing language session
            $this->language = $this->Session->read('Config.language'); // Read existing language
        } else {
            $this->language = Configure::read('defaultLanguage'); // No language session => get default language from Config file
        }

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

        if($this->params['controller'] != 'Apis'){
            if($this->params['controller'] != 'Users' || ($this->params['action'] != 'login' && $this->params['action'] != 'signup')){
                if($this->params['action'] != 'registerByUsername' && $this->params['action'] != 'loginByEmailAndPassword')
                {
                    $auth_user = $this->getAuthentication();
                    if($auth_user == null) {
                        $is_register = $this->getCurrentRegister();
                        if($is_register == null && $this->params['controller'] != 'Exercises')
                            $this->redirect('/Users/login');
                    }
                    else {
                        $this->set('auth_user',$auth_user);
                    }
                }

            }
        }
    }

    protected function setLang($lang) { // protected method used to set the language
        $this->Session->write('Config.language', $lang); // write our language to session
        Configure::write('Config.language', 'eng'); // tell CakePHP that we're using this language
    }

    public function changeLang($lang)
    {
        $this->Session->write('Config.language',$lang);
        return $this->redirect('/');
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

    function generateRandomString ($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}
