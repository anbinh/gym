<?php
App::uses('Controller', 'Controller');

class AppController extends Controller {

    public $components = array('Session');
    public $helpers = array('Html', 'Form', 'Text');

    var $language, $availableLanguages;

    public function beforeFilter() {
        parent::beforeFilter();
        if($this->Session->check('Config.language')) { // Check for existing language session
            $this->language = $this->Session->read('Config.language'); // Read existing language
        } else {
            $this->language = Configure::read('defaultLanguage'); // No language session => get default language from Config file
        }

        $this->setLang($this->language); // call protected method setLang with the lang shortcode
        $this->set('language',$this->language); // send $this->language value to the view
        $this->availableLanguages = Configure::read('availableLanguages'); // get available languages from Config file
        $this->set('availableLanguages', $this->availableLanguages); // send $this->availableLanguages value to the view
    }

    protected function setLang($lang) { // protected method used to set the language
        $this->Session->write('Config.language', $lang); // write our language to session
        Configure::write('Config.language', 'eng'); // tell CakePHP that we're using this language
    }
}
