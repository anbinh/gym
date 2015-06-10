<?php
App::uses('CakeSession', 'Model/Datasource');
class Exercise extends AppModel {
    //var $useDbConfig = 'Mongodb';
    var $mongoSchema = array(
        'care' => array('type'=>'String'),
        'comment' => array('type'=>'String'),
        'date_creation' => array('type'=>'Timestamp'),
        'dynamic' => array('type'=>'String'),
        'execution' => array('type'=>'String'),
        'identifiant' => array('type'=>'String'),
        'indicepop' => array('type'=>'String'),
        'name' => array('type'=>'String'),
        'posture' => array('type'=>'String'),
        'category' => array('type'=>'Array'),
        'body_building' => array('type'=>'Array'),
        'stretching' => array('type'=>'Array'),
        'cardio' => array('type'=>'Array'),
        'photo' => array('type'=>'String'),
        'video' => array('type'=>'String'),
        'video_small' => array('type'=>'String'),
        'web_player' => array('type'=>'String')
    );

    public function afterFind($results, $primary = false) {
        //$lang = 'fra';
        $lang = CakeSession::read('Config.language');               
        foreach ($results as $key => $val) {
            if($lang == 'fra')
            {
                $results[$key]['TextResource']['name'] = $val['TextResource']['name_fr'];                
                $results[$key]['TextResource']['bodypart'] = $val['TextResource']['bodypart_fr'];
                $results[$key]['TextResource']['muscles'] = $val['TextResource']['muscles_fr'];
                $results[$key]['TextResource']['posture'] = $val['TextResource']['posture_fr'];
                $results[$key]['TextResource']['execution'] = $val['TextResource']['execution_fr'];
                $results[$key]['TextResource']['care'] = $val['TextResource']['care_fr'];
                $results[$key]['TextResource']['equipment'] = $val['TextResource']['equipment_fr'];                
            }
            else
            {
                $results[$key]['TextResource']['name'] = $val['TextResource']['name_eng'];
                $results[$key]['TextResource']['bodypart'] = $val['TextResource']['bodypart_eng'];
                $results[$key]['TextResource']['muscles'] = $val['TextResource']['muscles_eng'];
                $results[$key]['TextResource']['posture'] = $val['TextResource']['posture_eng'];
                $results[$key]['TextResource']['execution'] = $val['TextResource']['execution_eng'];
                $results[$key]['TextResource']['care'] = $val['TextResource']['care_eng'];                
                $results[$key]['TextResource']['equipment'] = $val['TextResource']['equipment_eng'];                            
            } 

            unset($results[$key]['TextResource']['name_fr']);
            unset($results[$key]['TextResource']['bodypart_fr']);
            unset($results[$key]['TextResource']['muscles_fr']);
            unset($results[$key]['TextResource']['posture_fr']);
            unset($results[$key]['TextResource']['execution_fr']);
            unset($results[$key]['TextResource']['care_fr']);
            unset($results[$key]['TextResource']['equipment_fr']);  

            unset($results[$key]['TextResource']['name_eng']);
            unset($results[$key]['TextResource']['bodypart_eng']);
            unset($results[$key]['TextResource']['muscles_eng']);
            unset($results[$key]['TextResource']['posture_eng']);
            unset($results[$key]['TextResource']['execution_eng']);
            unset($results[$key]['TextResource']['care_eng']);
            unset($results[$key]['TextResource']['equipment_eng']);                           
        }
        return $results;
    }
}