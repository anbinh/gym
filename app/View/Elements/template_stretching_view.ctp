<div class="exercise_box">
    <div class="box_program_vew">
        <div class="header_box">
            <p><?php echo $index + 1;?></p>            
        </div>
        
        <div class="content_box_stretching">
            <div class="content_box_img none_border" layout-align="center center" layout="column" ng-controller="VideoController">                
                <?php if(!isset($is_mobile)): ?>
                    <video 
                    ng-mouseover="hoverIn($event)"
                    ng-mouseleave="hoverOut($event)"
                    class="img-responsive" preload="none" src="<?php echo (($item['exercise_item'][0]['exercise_id']) != '')? $exercises_list[$item['exercise_item'][0]['exercise_id']]['video_small'] : '';?>" poster="<?php echo (($item['exercise_item'][0]['exercise_id']) != '')? $exercises_list[$item['exercise_item'][0]['exercise_id']]['photo']: '';?>" width="208px" height="152px"></video>
                <?php else:?>
                    <img class="img-responsive"
                                     ng-src="{{getExerciseImage('<?php echo (($item['exercise_item'][0]['exercise_id']) != '')? $exercises_list[$item['exercise_item'][0]['exercise_id']]['photo'] : '';?>','<?php echo (($item['exercise_item'][0]['exercise_id']) != '')? $exercises_list[$item['exercise_item'][0]['exercise_id']]['photo_animate']: '';?>')}}"
                                     ng-click="OnMobileImgClick($event,'<?php echo (($item['exercise_item'][0]['exercise_id']) != '')? $exercises_list[$item['exercise_item'][0]['exercise_id']]['id']: '';?>')"
                                >
                <?php endif;?> 
            </div>
            <div class="content_box_img none_border" layout-align="center center" layout="column" ng-controller="VideoController">
                <?php if(!isset($is_mobile)): ?>
                    <video 
                    ng-mouseover="hoverIn($event)"
                    ng-mouseleave="hoverOut($event)"
                    class="img-responsive" preload="none" src="<?php echo (($item['exercise_item'][1]['exercise_id']) != '') ? $exercises_list[$item['exercise_item'][1]['exercise_id']]['video_small'] : '';?>" poster="<?php echo (($item['exercise_item'][1]['exercise_id']) != '')? $exercises_list[$item['exercise_item'][1]['exercise_id']]['photo']: '';?>" width="208px" height="152px"></video>
                <?php else:?>
                    <img class="img-responsive"
                                     ng-src="{{getExerciseImage('<?php echo (($item['exercise_item'][1]['exercise_id']) != '')? $exercises_list[$item['exercise_item'][1]['exercise_id']]['photo'] : '';?>','<?php echo (($item['exercise_item'][1]['exercise_id']) != '')? $exercises_list[$item['exercise_item'][1]['exercise_id']]['photo_animate']: '';?>')}}"
                                     ng-click="OnMobileImgClick($event,'<?php echo (($item['exercise_item'][1]['exercise_id']) != '')? $exercises_list[$item['exercise_item'][1]['exercise_id']]['id']: '';?>')"
                                >
                <?php endif;?> 
            </div>
            <div class="content_box_img none_border" layout-align="center center" layout="column" ng-controller="VideoController">
                <?php if(!isset($is_mobile)): ?>
                    <video 
                    ng-mouseover="hoverIn($event)"
                    ng-mouseleave="hoverOut($event)"
                    class="img-responsive" preload="none" src="<?php echo (($item['exercise_item'][2]['exercise_id']) != '') ? $exercises_list[$item['exercise_item'][2]['exercise_id']]['video_small'] : '';?>" poster="<?php echo (($item['exercise_item'][2]['exercise_id']) != '')? $exercises_list[$item['exercise_item'][2]['exercise_id']]['photo']: '';?>" width="208px" height="152px"></video>
                <?php else:?>
                    <img class="img-responsive"
                                     ng-src="{{getExerciseImage('<?php echo (($item['exercise_item'][2]['exercise_id']) != '')? $exercises_list[$item['exercise_item'][2]['exercise_id']]['photo'] : '';?>','<?php echo (($item['exercise_item'][2]['exercise_id']) != '')? $exercises_list[$item['exercise_item'][2]['exercise_id']]['photo_animate']: '';?>')}}"
                                     ng-click="OnMobileImgClick($event,'<?php echo (($item['exercise_item'][2]['exercise_id']) != '')? $exercises_list[$item['exercise_item'][2]['exercise_id']]['id']: '';?>')"
                                >
                <?php endif;?> 
            </div>
            <div class="content_box_img none_border" layout-align="center center" layout="column" ng-controller="VideoController">
                <?php if(!isset($is_mobile)): ?>
                    <video 
                    ng-mouseover="hoverIn($event)"
                    ng-mouseleave="hoverOut($event)"
                    class="img-responsive" preload="none" src="<?php echo (($item['exercise_item'][3]['exercise_id']) != '')? $exercises_list[$item['exercise_item'][3]['exercise_id']]['video_small'] : '';?>" poster="<?php echo (($item['exercise_item'][3]['exercise_id']) != '')? $exercises_list[$item['exercise_item'][3]['exercise_id']]['photo']: '';?>" width="208px" height="152px"></video>
                <?php else:?>
                    <img class="img-responsive"
                                     ng-src="{{getExerciseImage('<?php echo (($item['exercise_item'][3]['exercise_id']) != '')? $exercises_list[$item['exercise_item'][3]['exercise_id']]['photo'] : '';?>','<?php echo (($item['exercise_item'][3]['exercise_id']) != '')? $exercises_list[$item['exercise_item'][3]['exercise_id']]['photo_animate']: '';?>')}}"
                                     ng-click="OnMobileImgClick($event,'<?php echo (($item['exercise_item'][3]['exercise_id']) != '')? $exercises_list[$item['exercise_item'][3]['exercise_id']]['id']: '';?>')"
                                >
                <?php endif;?> 
            </div>
        </div>
        <div class="fotter_box" layout-align="center center" layout="row">
            <?php echo $item['text'];?>
        </div>
    </div>
</div>