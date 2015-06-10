<?php
App::uses('CakeSession', 'Model/Datasource');
class TextResource extends AppModel {
    //var $useDbConfig = 'Mongodb';
    var $mongoSchema = array(
        'text_id' => array('type'=>'number'),
        'text_eng' => array('type'=>'String'),
        'text_fra' => array('type'=>'String')
    );

    public function afterFind($results, $primary = false) {
    	//$lang = 'fra';
        $lang = CakeSession::read('Config.language');            	
	    foreach ($results as $key => $val) {
            if($lang == 'fra')
            {
                $results[$key]['TextResource']['name'] = $val['TextResource']['name_fr'];
            }
            else
            {
                $results[$key]['TextResource']['name'] = $val['TextResource']['name_eng'];
            }                    	       
	    }
	    return $results;
	}
}