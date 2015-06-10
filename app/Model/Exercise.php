<?php
App::uses('CakeSession', 'Model/Datasource');
class Exercise extends AppModel {
    //var $useDbConfig = 'Mongodb';
    var $mongoSchema = array(                        
        'identifiant' => array('type'=>'String'),                    
        'category_id' => array('type'=>'String'),
        'name_fr' => array('type'=>'String'),
        'name_eng' => array('type'=>'String'), 
        'bodypart_id' => array('type'=>'String'),
        'bodypart_fr' => array('type'=>'String'),
        'bodypart_eng' => array('type'=>'String'),
        'muscles_id' => array('type'=>'String'),
        'muscles_fr' => array('type'=>'String'),
        'muscles_eng' => array('type'=>'String'),
        'posture_fr' => array('type'=>'String'),
        'posture_eng' => array('type'=>'String'),
        'execution_fr' => array('type'=>'String'),
        'execution_eng' => array('type'=>'String'),
        'care_fr' => array('type'=>'String'),
        'care_eng' => array('type'=>'String'),        
        'equipment_fr' => array('type'=>'String'),        
        'equipment_eng' => array('type'=>'String'),        
        'type' => array('type'=>'String'),        
        'similar' => array('type'=>'String'),                    
        'photo' => array('type'=>'String'),
        'video' => array('type'=>'String'),
        'photo_animate' => array('type'=>'String'),
        'web_player' => array('type'=>'String'),
        'other' => array('type'=>'String')
    );

    public function afterFind($results, $primary = false) {        
        $lang = CakeSession::read('Config.language');               
        foreach ($results as $key => $val) {
            if($lang == 'fra')
            {
                $results[$key]['Exercise']['name'] = $val['Exercise']['name_fr'];                
                $results[$key]['Exercise']['bodypart'] = $val['Exercise']['bodypart_fr'];
                $results[$key]['Exercise']['muscles'] = $val['Exercise']['muscles_fr'];
                $results[$key]['Exercise']['posture'] = $val['Exercise']['posture_fr'];
                $results[$key]['Exercise']['execution'] = $val['Exercise']['execution_fr'];
                $results[$key]['Exercise']['care'] = $val['Exercise']['care_fr'];
                $results[$key]['Exercise']['equipment'] = $val['Exercise']['equipment_fr'];                
            }
            else
            {
                $results[$key]['Exercise']['name'] = $val['Exercise']['name_eng'];
                $results[$key]['Exercise']['bodypart'] = $val['Exercise']['bodypart_eng'];
                $results[$key]['Exercise']['muscles'] = $val['Exercise']['muscles_eng'];
                $results[$key]['Exercise']['posture'] = $val['Exercise']['posture_eng'];
                $results[$key]['Exercise']['execution'] = $val['Exercise']['execution_eng'];
                $results[$key]['Exercise']['care'] = $val['Exercise']['care_eng'];                
                $results[$key]['Exercise']['equipment'] = $val['Exercise']['equipment_eng'];                            
            } 

            unset($results[$key]['Exercise']['name_fr']);
            unset($results[$key]['Exercise']['bodypart_fr']);
            unset($results[$key]['Exercise']['muscles_fr']);
            unset($results[$key]['Exercise']['posture_fr']);
            unset($results[$key]['Exercise']['execution_fr']);
            unset($results[$key]['Exercise']['care_fr']);
            unset($results[$key]['Exercise']['equipment_fr']);  

            unset($results[$key]['Exercise']['name_eng']);
            unset($results[$key]['Exercise']['bodypart_eng']);
            unset($results[$key]['Exercise']['muscles_eng']);
            unset($results[$key]['Exercise']['posture_eng']);
            unset($results[$key]['Exercise']['execution_eng']);
            unset($results[$key]['Exercise']['care_eng']);
            unset($results[$key]['Exercise']['equipment_eng']);                           
        }
        return $results;
    }
}