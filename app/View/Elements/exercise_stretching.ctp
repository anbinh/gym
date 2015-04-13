<div class="UserIndexLeftContent">                
    <div layout="row">            
        <div class="list_program_view" class="row">
            <?php $i = 0;?>
            <?php foreach($content['exercise_list'] as $item):?>
                <?php $i++;?>
                <?php if($item['mode']==1):?>                
                    <div class="exercise_box exercise_box_editor" ng-controller="VideoController">
                        <div class="box_program_vew">                           
                            <div class="sequence_number_box">
                                <p><?php echo $i;?></p>
                            </div>
                            <div class="row no_margin" style="padding: 0 40px 0 40px;"> 
                                <?php if(!isset($is_mobile)) { ?>
                                    <video 
                                    ng-mouseover="hoverIn($event)"
                                    ng-mouseleave="hoverOut($event)"
                                    class="img-responsive" preload="none" src="<?php echo $exercises_list[(string)$item['exercise_item'][0]['exercise_id']->{'$id'}]['video_small'];?>" poster="<?php echo $exercises_list[(string)$item['exercise_item'][0]['exercise_id']->{'$id'}]['photo'];?>" width="208px" height="152px" <="" video=""></video>
                                <?php } else { ?>
                                    <img class="img-responsive"
                                                     ng-src="{{getExerciseImage('<?php echo $exercises_list[(string)$item['exercise_item'][0]['exercise_id']->{'$id'}]['photo'];?>','<?php echo $exercises_list[(string)$item['exercise_item'][0]['exercise_id']->{'$id'}]['photo_animate'];?>')}}"
                                                     ng-click="OnMobileImgClick($event,'<?php echo $exercises_list[(string)$item['exercise_item'][0]['exercise_id']->{'$id'}]['id'];?>')"
                                                >
                                <?php }?>
                            </div>
                            <div class="description">
                                <p><?php echo $exercises_list[(string)$item['exercise_item'][0]['exercise_id']->{'$id'}]['name'];?></p>
                            </div>
                            <div class="serie">
                                <p style="color:#c7c8c9; margin-right:10px; font-size:11pt;"><?php echo __('Serie')?></p> 
                                <p style="font-size:18px; font-weight:bold; line-height: 1.45; border-right:1px solid; padding-right:5px; margin-right:5px;"> <?php echo $item['exercise_item'][0]['series'];?></p>
                                <p style="color:#bcbdbe; margin-right:10px;"><?php echo __('Repetition')?></p> 
                                <p style="font-size:18px; font-weight:bold; line-height: 1.45;"> <?php echo $item['exercise_item'][0]['repeatation_from'];?> à <?php echo $item['exercise_item'][0]['repeatation_to'];?></p>
                            </div>
                        </div>                            
                    </div>
                <?php endif;?>
                <?php if($item['mode']==2):?>
                     <div class="exercise_box exercise_box_editor">
                        <div class="box_program_vew">   
                            <div class="sequence_number_box">
                                <p><?php echo $i;?></p>
                            </div>                    
                            <div class="row no_margin" style="padding: 0 10px 0 10px;"> 
                                <div class="col-xs-6 no_padding">
                                    <div class="small_box"></div>
                                </div>
                                <div class="col-xs-6 no_padding">
                                    <div class="small_box"></div>
                                </div>
                                <div class="col-xs-6 no_padding">
                                    <div class="small_box"></div>
                                </div>
                                <div class="col-xs-6 no_padding">
                                    <div class="small_box"></div>
                                </div>
                            </div>
                            <div class="serie">
                                <p style="color:#c7c8c9; margin-right:10px; font-size:11pt;"><?php echo __('Serie')?></p> 
                                <p> <?php echo $item['text'];?></p>
                            </div>                    
                        </div>                            
                    </div> 
                <?php endif;?>
                <?php if($item['mode']==4):?>
                    <div class="exercise_box exercise_box_editor">
                        <div class="box_program_vew">                           
                            <div class="sequence_number_box" style="float:left;">
                                <p><?php echo $i;?></p>
                            </div>
                            <div>
                                <div style="position:relative; padding-top:3px;">
                                    <div class="small_box" style="width:90px; float:left;"></div>                            
                                    <div>
                                        <p style="color:#c7c8c9; margin:0px; line-height:1; font-size:11pt;"><?php echo __('Serie')?></p> 
                                        <p style="font-size:18px; font-weight:bold; line-height: 1.2; margin:0;"> 10</p>
                                    </div>
                                    <div style="padding-top:5px;">
                                        <p style="color:#bcbdbe; margin:0px; line-height:1; font-size:11pt;"><?php echo __('Repetition')?></p> 
                                        <p style="font-size:18px; font-weight:bold; line-height: 1.2; margin:0;"> 15 à 20</p>
                                    </div>
                                </div>      
                                <div class="description">
                                    <p><?php echo $exercises_list[(string)$item['exercise_item'][0]['exercise_id']->{'$id'}]['name'];?></p>
                                </div>
                                <div style="position:relative;padding-left:14px; padding-top:3px;">
                                    <div class="small_box" style="width:90px; float:left;"></div>                            
                                    <div>
                                        <p style="color:#c7c8c9; margin:0px; line-height:1; font-size:11pt;"><?php echo __('Serie')?></p> 
                                        <p style="font-size:18px; font-weight:bold; line-height: 1.2; margin:0;"> 10</p>
                                    </div>
                                    <div style="padding-top:5px;">
                                        <p style="color:#bcbdbe; margin:0px; line-height:1; font-size:11pt;"><?php echo __('Repetition')?></p> 
                                        <p style="font-size:18px; font-weight:bold; line-height: 1.2; margin:0;"> 15 à 20</p>
                                    </div>
                                </div>   
                                <div class="description">
                                    <p><?php echo $exercises_list[(string)$item['exercise_item'][0]['exercise_id']->{'$id'}]['name'];?></p>
                                </div>                    
                            </div>                    
                        </div>                            
                    </div>
                <?php endif;?>
                <?php if($item['mode']==5):?>
                    <div class="exercise_box exercise_box_editor" ng-controller="VideoController">
                        <div class="box_program_vew">                           
                            <div class="sequence_number_box">
                               <p><?php echo $i;?></p>
                            </div>
                            <div class="row no_margin" style="padding: 0 40px 0 40px;"> 
                                <?php if(!isset($is_mobile)) { ?>
                                    <video 
                                    ng-mouseover="hoverIn($event)"
                                    ng-mouseleave="hoverOut($event)"
                                    class="img-responsive" preload="none" src="<?php echo $exercises_list[(string)$item['exercise_item'][0]['exercise_id']->{'$id'}]['video_small'];?>" poster="<?php echo $exercises_list[(string)$item['exercise_item'][0]['exercise_id']->{'$id'}]['photo'];?>" width="208px" height="152px" <="" video=""></video>
                                <?php } else { ?>
                                    <img class="img-responsive"
                                                     ng-src="{{getExerciseImage('<?php echo $exercises_list[(string)$item['exercise_item'][0]['exercise_id']->{'$id'}]['photo'];?>','<?php echo $exercises_list[(string)$item['exercise_item'][0]['exercise_id']->{'$id'}]['photo_animate'];?>')}}"
                                                     ng-click="OnMobileImgClick($event,'<?php echo $exercises_list[(string)$item['exercise_item'][0]['exercise_id']->{'$id'}]['id'];?>')"
                                                >
                                <?php }?>
                            </div>
                            <div class="description">
                                <p><?php echo $exercises_list[(string)$item['exercise_item'][0]['exercise_id']->{'$id'}]['name'];?></p>
                            </div>
                            <div class="serie">
                                <p style="color:#c7c8c9; margin-right:10px; font-size:11pt;"><?php echo __('Serie')?></p> 
                                <p> <?php echo __('Hold')?> <?php echo $item['exercise_item'][0]['hold'];?> <?php echo __('Seconds')?></p>
                            </div>
                        </div>                            
                    </div>
                <?php endif;?>
            <?php endforeach;?>            
                      
        </div>                        
    </div>
</div>