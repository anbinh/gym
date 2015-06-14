<div class="exercise_box">
    <div class="box_program_vew">
        <div class="header_box">
            <p><?php echo $index + 1;?></p>            
        </div>                   
        <div class="content_box_regular">
            <div class="content_image none_border" layout-align="center center" layout="column" ng-controller="VideoController">                
                <?php if(isset($item['exercise_item'][0])) if(!isset($is_mobile)): ?>
                    <video 
                    ng-mouseover="hoverIn($event)"
                    ng-mouseleave="hoverOut($event)"
                    class="img-responsive" preload="none" src="<?php echo (($item['exercise_item'][0]['exercise_id']) != '')? $exercises_list[$item['exercise_item'][0]['exercise_id']]['video'] : '';?>" poster="<?php echo (($item['exercise_item'][0]['exercise_id']) != '')? $exercises_list[$item['exercise_item'][0]['exercise_id']]['photo']: '';?>" width="208px" height="152px"></video>
                <?php else:?>
                    <img class="img-responsive"
                                     ng-src="{{getExerciseImage('<?php echo (($item['exercise_item'][0]['exercise_id']) != '')? $exercises_list[$item['exercise_item'][0]['exercise_id']]['photo'] : '';?>','<?php echo (($item['exercise_item'][0]['exercise_id']) != '')? $exercises_list[$item['exercise_item'][0]['exercise_id']]['photo_animate']: '';?>')}}"
                                     ng-click="OnMobileImgClick($event,'<?php echo (($item['exercise_item'][0]['exercise_id']) != '')? $exercises_list[$item['exercise_item'][0]['exercise_id']]['id']: '';?>')"
                                >
                <?php endif;?>            
            </div>
            <p class="name_exercise"><?php echo ($item['exercise_item'][0]['exercise_id'] != null)? $exercises_list[$item['exercise_item'][0]['exercise_id']]['name'] : ''?></p>
        </div>
        <div class="fotter_box" layout-align="center center" layout="row">
            <p class="serie"><?php echo __('Sets');?> </p>
            <p class="serie_number">
                <?php echo $item['exercise_item'][0]['series'];?>
            </p>            
            <p class="repeat"><?php echo __('Repetitions');?> </p>
            <p class="repeat_number">
                <?php echo $item['exercise_item'][0]['repeatation_from'];?>
            </p>            
        </div>
    </div>
</div>