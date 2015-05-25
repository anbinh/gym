<div class="exercise_box">
    <div class="box_program_vew">
        <div class="header_box">
            <p><?php echo $index + 1;?></p>            
        </div>        
        <div class="content_box_regular">
            <div class="content_image" layout-align="center center" layout="column">                
                <?php if(!isset($is_mobile)): ?>
                    <video 
                    ng-mouseover="hoverIn($event)"
                    ng-mouseleave="hoverOut($event)"
                    class="img-responsive" preload="none" src="<?php echo $exercises_list[$item['exercise_item'][0]['exercise_id']]['video_small'];?>" poster="<?php echo $exercises_list[$item['exercise_item'][0]['exercise_id']]['photo'];?>" width="208px" height="152px" <="" video=""></video>
                <?php else:?>
                    <img class="img-responsive"
                                     ng-src="{{getExerciseImage('<?php echo $exercises_list[$item['exercise_item'][0]['exercise_id']]['photo'];?>','<?php echo $exercises_list[$item['exercise_item'][0]['exercise_id']]['photo_animate'];?>')}}"
                                     ng-click="OnMobileImgClick($event,'<?php echo $exercises_list[$item['exercise_item'][0]['exercise_id']]['id'];?>')"
                                >
                <?php endif;?>            
            </div>
            <p class="name_exercise"><?php echo $exercises_list[$item['exercise_item'][0]['exercise_id']]['name'];?></p>
        </div>
        <div class="fotter_box" layout-align="center center" layout="row">
            <p class="serie">Serie </p>
            <p class="serie_number">
                <?php echo $item['exercise_item'][0]['series'];?>
            </p>            
            <p class="repeat">Repeation </p>
            <p class="repeat_number">
                <?php echo $item['exercise_item'][0]['repeatation_from'];?>
            </p>            
        </div>
    </div>
</div>