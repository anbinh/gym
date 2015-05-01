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
                        <a href="/Users">
                            <input type="button" class="btn btn_save_program btn_remove_from_profile" value="<?php echo __('Remove from profile');?>">
                        </a>
                    <?php else:?>
                        <a href="javascript:void(0);">
                            <input ng-click="save_program('<?php echo $programs['Program']['id']?>');" type="button" class="btn btn_save_program" value="<?php echo __('Save');?>">
                        </a>
                    <?php endif;?>
                </div>
            </div>
            <div layout="row">
                <div flex id="program_header_content">
                    <div class="title_program">
                        Intentse work on the buttocks and thighs
                    </div>
                    <div class="content_program">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed no Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed no Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed no</div>
                    <div class="sharing_program_social_fb"><a href="javascript:fbShare('http://gym.miratik.com/Programs/program_view/<?php echo $programs['Program']['id'];?>', 'Studio Gym', '', '/img/images/<?php echo $programs['Program']['photo']?>', 520, 350)"><img src="/img/images/facebook_icon.png"/> </a></div>
                    <div class="sharing_program_social_twitter"><a class="twitter popup" href="http://twitter.com/share"><img src="/img/images/twitter_icon.png"/></a></div>
                    <div class="sharing_program_link"><span>Share</span></div>
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
<script>
    function fbShare(url, title, descr, image, winWidth, winHeight) {
        var winTop = (screen.height / 2) - (winHeight / 2);
        var winLeft = (screen.width / 2) - (winWidth / 2);
        window.open('http://www.facebook.com/sharer.php?s=100&p[title]=' + title + '&p[summary]=' + descr + '&p[url]=' + url + '&p[images][0]=' + image, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
    }
    $('.popup').click(function(event) {
        var width  = 575,
            height = 400,
            left   = ($(window).width()  - width)  / 2,
            top    = ($(window).height() - height) / 2,
            url    = this.href,
            opts   = 'status=1' +
                     ',width='  + width  +
                     ',height=' + height +
                     ',top='    + top    +
                     ',left='   + left;
        
        window.open(url, 'twitter', opts);
     
        return false;
      });       
</script>
