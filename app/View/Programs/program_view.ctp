<script src="http://connect.facebook.net/en_US/all.js"></script>


<div layout="row" layout-align="center start">
    <div ng-controller="ProgramController" flex class="ProgramIndexLeftContent">
        <div layout="column" class="summary_program">
            <div layout="row" class="header_program" layout-wrap>
                <div flex="20"  style="padding-left:10px;">
                    <div class="program_logo_topic" style="background-color: <?php echo $programs['Program']['color_code']?>">
                        <div style="text-align:center;"><img class="img_program_view" src="/img/images/<?php echo $programs['Program']['photo']?>"></div>
                        <div class="program_view_text_name"> <?php echo ($language=='fra')?$programs['Program']['name_fr']:$programs['Program']['name'];?></div>
                    </div>
                </div>
                <div flex layout-align="end end" style="text-align: end; margin-right:15px;">                    
                    <?php if($isSaved):?>
                      <input disabled type="button" class="btn btn_save_program" value="<?php echo __('Remove from profile');?>">
                    <?php else:?>
                      <input ng-click="save_program('<?php echo $programs['Program']['id']?>');" type="button" class="btn btn_save_program" value="<?php echo __('Save');?>">
                    <?php endif;?>
                </div>
            </div>
            <div layout="row">
                <div flex id="program_header_content">
                    <div class="title_program">
                        Intentse work on the buttocks and thighs
                    </div>
                    <div class="content_program">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed no Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed no Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed no</div>
                    <div class="sharing_program_social_fb"><img src="/img/images/facebook_icon.png"/> </div>
                    <div class="sharing_program_social_twitter"><img src="/img/images/twitter_icon.png"/></div>
                    <div class="sharing_program_link"><span><a href="https://www.facebook.com/sharer/sharer.php?u=gym.miratik.com" target="_blank"><?php echo __('Share');?></a></span></div>
                </div>
            </div>
        </div>

        <div class="program_tab" layout="column">
          <md-tabs md-selected="selectedIndex" flex>
            <?php foreach($programs['Program']['content'] as $content):?>
                <md-tab label="<?php echo __("Day").' '.$content['day_number'];?>">
                  <?php echo $this->Element('exercise_stretching', array('content'=>$content));?>
                </md-tab>              
            <?php endforeach;?>
          </md-tabs>              
        </div>
    </div>   
    <div style="margin-top:52px;"> 
      <?php echo $this->element('right_advs');?>    
    </div>
</div>
