<script src="http://connect.facebook.net/en_US/all.js"></script>
<div layout="row" layout-align="center start">
    <div ng-controller="ProgramController" flex class="ProgramIndexLeftContent">
        <div layout="column" class="summary_program">
            <div layout="row" class="header_program" layout-wrap>
                <div flex="20"  style="padding-left:10px;">
                    <div class="program_logo_topic" style="<?php echo ($programs['Program']['is_public'] == 1) ?  'background-color:'.$programs['Program']['color_code'] : 'background-image:url(/upload/image/'.$programs['Program']['photo'].');background-size: cover;'
                    ?>">
                        <div style="text-align:center;">
                            <?php if($programs['Program']['is_public'] == 1) {?>   
                                <img class="img_program_view" src="/upload/image/<?php echo $programs['Program']['photo']?>">
                            <?php }?>                
                            <div class="program_view_text_name" style="<?php echo ($programs['Program']['is_public'] == 0) ? 'margin-top: 150px;' : ''?>"> <?php echo $programs['Program']['name'];?></div>
                        </div>                        
                    </div>
                </div>
                <div flex layout-align="end end" style="text-align: end; margin-right:15px;">      
                    <?php if($isCreator): ?>
                        <input ng-click="modify_program('<?php echo $programs['Program']['id']?>');" type="button" class="btn btn_save_program" value="<?php echo __('Modify');?>">
                    <?php elseif($isSaved):?>       
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
                    <div class="title_program title_program_destop_view">
                        <?php echo $programs['Program']['descriptive'];?>
                    </div>
                    <div class="content_program"><?php echo $programs['Program']['short_text'];?></div>
                    <div class="sharing_program_social_fb"><a href="javascript:fbShare('http://gym.miratik.com/upload/image/<?php echo $programs['Program']['photo'];?>');"><img src="/img/images/facebook_icon.png"/> </a></div>
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
    // (function(d, s, id) {
    //     var js, fjs = d.getElementsByTagName(s)[0];
    //     if (d.getElementById(id))
    //         return;
    //     js = d.createElement(s);
    //     js.id = id;
    //     js.src = "//connect.facebook.net/en_US/all.js";
    //     fjs.parentNode.insertBefore(js, fjs);
    // }(document, 'script', 'facebook-jssdk'));

    // window.fbAsyncInit = function() {
    //     FB.init({
    //         appId: '577637839045306',  // Change appId 409742669131720 with your Facebook Application ID
    //         status: true,
    //         xfbml: true,
    //         cookie: true
    //     });
    //     // FB.api('/me', function(res){
    //     //     console.log(res);
    //     // })
    // };  
    FB.init({
        appId: '577637839045306',  // Change appId 409742669131720 with your Facebook Application ID
        status: true,
        xfbml: true,
        cookie: true
    });  
    var name = '';

    function fbShare(url_image){         

        FB.getLoginStatus(function(response) {
            if (response.status === 'connected'){
                FB.api('/me', function(response){
                    name = response.first_name + ' ' +response.last_name;
                    //console.log(response);
                });
            }  
            else{
                FB.login(function(response) {
                     if (response.authResponse)
                     {
                        FB.api('/me', function(response) {
                            name = response.first_name + ' ' +response.last_name;
                        });
                     }
                 });                
            }

        });
        //alert(name);
        if(name!='' && name != 'undefined undefined'){
            var content_text = name + ' is starting a program on Studiogym.com'; 
            //url_image = window.location.href + url_image;       
            FB.ui({
                method: 'feed',
                name: 'Studio Gym',
                link: window.location.href,
                picture: url_image,
                description: content_text

            },
            function(response) {
                if (response && !response.error_code) {                  
                } else {
                  name = '';
                }
            });    
        }
        
        // FB.ui({
        //   method: 'feed',
        //   link: 'https://developers.facebook.com/docs/',
        //   caption: 'An example caption',
        // }, function(response){});
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
