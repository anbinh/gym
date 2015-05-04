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
                        <input ng-click="remove_program('<?php echo $programs['Program']['id']?>')" type="button" class="btn btn_remove_from_profile" value="<?php echo __('Remove from profile');?>">                        
                        <input style="display:none;" ng-click="save_program('<?php echo $programs['Program']['id']?>');" type="button" class="btn btn_save_program" value="<?php echo __('Save');?>">                        
                    <?php else:?>                        
                        <input ng-click="save_program('<?php echo $programs['Program']['id']?>');" type="button" class="btn btn_save_program" value="<?php echo __('Save');?>">
                        <input style="display:none;" ng-click="remove_program('<?php echo $programs['Program']['id']?>')" type="button" class="btn btn_remove_from_profile" value="<?php echo __('Remove from profile');?>">                        
                    <?php endif;?>
                </div>
            </div>
            <div layout="row">
                <div flex id="program_header_content">
                    <div class="title_program">
                        Intentse work on the buttocks and thighs
                    </div>
                    <div class="content_program">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed no Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed no Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed no</div>
                    <div class="sharing_program_social_fb"><a href="javascript:fbShare1('http://gym.miratik.com/img/images/bunnybacon.png');"><img src="/img/images/facebook_icon.png"/> </a></div>
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
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    window.fbAsyncInit = function() {
        FB.init({
            appId: '577637839045306',  // Change appId 409742669131720 with your Facebook Application ID
            status: true,
            xfbml: true,
            cookie: true
        });
        // FB.api('/me', function(res){
        //     console.log(res);
        // })
    };    
    function fbShare1(url_image){  
        var content_text = 'Jocelyn is starting a program on Studiogym.com'; 
        //url_image = window.location.href + url_image;
        FB.ui({
            method: 'feed',
            name: 'Studio Gym',
            link: window.location.href,
            picture: url_image,
            description: content_text
        });
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
