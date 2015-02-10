<script>
    // init variable
    var name = '<?php echo $user['firstname'].' '.$user['lastname'];?>';
    var city = '<?php echo isset($user['address']['city'])? $user['address']['city'] : '' ;?>';
    var street = '<?php echo $user['address']['street'];?>';
</script>
<div ng-controller="UserController">
    <div layout="column" class="info_user">
        <div layout="row"  class="avatar">
            <div style="padding-left:10px;"><img src="/img/images/avatar.png"/></div>
            <div layout="row" layout-align="start center" class="username">{{user.name}}</div>
        </div>
        <div layout="row" style="height:120px;">
            <div style="padding:8px 0 0 180px;" flex>
                <div><img src="/img/images/facebook_icon.png"/> &nbsp&nbsp <img src="/img/images/twitter_icon.png"/></div>
                <div class="fullname">{{user.name}}</div>
                <div class="city">{{user.city}}</div>
                <div class="language">{{user.street}}</div>
                <div class="edit_profile"><a href="#"><?php echo __('edit')?></a></div>
            </div>
            <div style="width:300px;">
                <div class="mobile_app" layout="row" layout-align="start center" style="border-top:0;">
                    <img src="/img/images/apple.png"/>
                    <p><strong><?php echo __('mobile application')?></strong></p>
                </div>
                <div class="create_program" layout="row" layout-align="start center" style="border-bottom:0;">
                    <img src="/img/images/object_dynamique.png"/>
                    <p><strong><?php echo __('create a program')?><strong></p>
                </div>
            </div>
        </div>
    </div>
    <div layout="row">
        <div flex>
            <div class="my_program">
                <div class="my_program_text" layout="row" layout-align="start center"><p><?php echo __('my program')?></p></div>
                <div layout="row" layout-sm="column" class="list_tile">
                    <div layout="column" flex class="tile_1">
                        <div><img style="float:right;" src="/img/images/delete_copy.png"></div>
                        <div style="text-align:center; padding-top:10px;"><img style="height:150px;" src="/img/images/bunnybacon.png"></div>
                        <div style="text-align:center; font-size:12px; font-weght:bold;"> SHAPE MODELING</div>
                    </div>
                    <div layout="column" flex class="tile_2">
                        <div><img style="float:right;" src="/img/images/delete_copy.png"></div>
                        <div style="text-align:center; padding-top:10px;"><img src="/img/images/bellyJelly.png"></div>
                        <div style="text-align:center; font-size:12px;"> LOOSING WIEGHT </div>
                    </div>
                    <div layout="column" flex class="tile_3">
                        <div><img style="float:right;" src="/img/images/delete_copy.png"></div>
                        <div style="text-align:center; padding-top:10px;"><img src="/img/images/burn.png"></div>
                        <div style="text-align:center; font-size:12px;"> LOOSING WIEGHT </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="width:300px;">
                <p style="margin:5px;"><strong><?php echo __('advertising')?></strong></p>
                <img src="/img/images/Ad_example.jpg"/>
        </div>
    </div>
    <div layout="row">
        <div flex>
            <div layout="row" layout-align="start center" style="height:40px; padding-left: 10px;"><p style="font-size:14px; margin:0;"><?php echo __('favorite exercise')?></p></div>
            <div layout="row" layout-sm="column" style="height:240px;">
                <div layout="column" flex style="margin:5px; border:1px solid #ccc;">
                    <div style="padding:5px;"><img src="/img/images/star.png"></div>
                </div>
                <div layout="column" flex style="margin:5px; border:1px solid #ccc;">
                    <div style="padding:5px;"><img src="/img/images/star.png"></div>
                </div>
                <div layout="column" flex style="margin:5px; border:1px solid #ccc;">
                    <div style="padding:5px;"><img src="/img/images/star.png"></div>
                </div>
            </div>
        </div>
        <div style="width:300px;"></div>
    </div>
</div>