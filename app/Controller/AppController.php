<?php
App::uses('Controller', 'Controller');

class AppController extends Controller {

    public $components = array('Session');
    public $helpers = array('Html', 'Form', 'Text');

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

        if($this->params['controller'] != 'Users' || $this->params['action'] != 'signup'){
            if($this->params['action'] != 'registerByUsername')
            {
                $auth_user = $this->getAuthentication();
                if($auth_user == null) {
                    $is_register = $this->getCurrentRegister();
                    if($is_register == null)
                        $this->redirect('/Users/signup');
                }
                else {
                    $this->set('auth_user',$auth_user);
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
}
