<script>
    // init variable
    var name = '<?php echo $user['firstname'].' '.$user['lastname'];?>';
    var city = '<?php echo isset($user['address']['city'])? $user['address']['city'] : '' ;?>';
    var street = '<?php echo isset($user['address']['street'])? $user['address']['street'] : '';?>';
</script>
<div layout="row">
    <div ng-controller="UserController" class="UserIndexLeftContent">
        <div layout="column" class="info_user">
            <div layout="row" class="avatar">
                <div style="padding-left:10px;"><img src="/img/images/avatar.png"/></div>
                <div layout="row" layout-align="start center" class="username">{{user.name}}</div>
            </div>
            <div layout="row" style="height:120px;">
                <div style="padding:8px 0 0 190px;" flex>
                    <div><img src="/img/images/facebook_icon.png"/> &nbsp&nbsp <img src="/img/images/twitter_icon.png"/></div>
                    <div class="fullname">{{user.name}}</div>
                    <div class="city">{{user.city}}</div>
                    <div class="language">{{user.street}}</div>
                    <div class="edit_profile"><a href="javascript:void(0);" ng-click='edit()'><?php echo __('edit')?></a></div>
                </div>
            </div>
        </div>
        <div layout="row">
            <div flex>
                <div class="my_program">
                    <div class="my_program_text" layout="row" layout-align="start center"><p><?php echo __('my program')?></p></div>
                    <div class="list_tile" class="row">
                        <div class="program_box tile_1">
                            <div><img class="delete_icon_program" style="float:right;" src="/img/images/delete_copy.png" class="img-responsive"></div>
                            <div style="text-align:center; padding-top:30px;"><img class="img_program" src="/img/images/bunnybacon.png"></div>
                            <div class="program_text_name"> SHAPE MODELING</div>
                        </div>
                        <div class="program_box tile_2">
                            <div><img class="delete_icon_program" style="float:right;" src="/img/images/delete_copy.png"></div>
                            <div style="text-align:center; padding-top:30px;"><img class="img_program" src="/img/images/bellyJelly.png"></div>
                            <div class="program_text_name"> LOOSING WEIGHT </div>
                        </div>
                        <div class="program_box tile_3">
                            <div><img class="delete_icon_program" style="float:right;" src="/img/images/delete_copy.png"></div>
                            <div style="text-align:center; padding-top:30px;"><img class="img_program" src="/img/images/burn.png"></div>
                            <div class="program_text_name"> LOOSING WEIGHT </div>
                        </div> 
                        <div class="program_box tile_1">
                            <div><img class="delete_icon_program" style="float:right;" src="/img/images/delete_copy.png" class="img-responsive"></div>
                            <div style="text-align:center; padding-top:30px;"><img class="img_program" src="/img/images/bunnybacon.png"></div>
                            <div class="program_text_name"> SHAPE MODELING</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div layout="row">
            <div flex>
                <div layout="row" class="my_program_text" layout-align="start center"><p><?php echo __('favorite exercise')?></p></div>
                <div class="list_tile" class="row">
                    <div class="program_box">
                        <div class="user_favorite_exercise_img test1" flex style="margin:5px; border:1px solid #ccc;background-image: url('/img/images/6035.jpeg')">
                            <div style="padding:5px;"><img src="/img/images/star.png"></div>
                        </div>
                    </div>
                    <div class="program_box">
                        <div class="user_favorite_exercise_img test1" flex style="margin:5px; border:1px solid #ccc;background-image: url('/img/images/6035.jpeg')">
                            <div style="padding:5px;"><img src="/img/images/star.png"></div>
                        </div>
                    </div>
                    <div class="program_box">
                        <div class="user_favorite_exercise_img test1" flex style="margin:5px; border:1px solid #ccc;background-image: url('/img/images/6035.jpeg')">
                            <div style="padding:5px;"><img src="/img/images/star.png"></div>
                        </div>
                    </div>
                    <div class="program_box">
                        <div class="user_favorite_exercise_img test1" flex style="margin:5px; border:1px solid #ccc;background-image: url('/img/images/6035.jpeg')">
                            <div style="padding:5px;"><img src="/img/images/star.png"></div>
                        </div>
                    </div>
                    <div class="program_box">
                        <div class="user_favorite_exercise_img test1" flex style="margin:5px; border:1px solid #ccc;background-image: url('/img/images/6035.jpeg')">
                            <div style="padding:5px;"><img src="/img/images/star.png"></div>
                        </div>
                    </div>
                    <div class="program_box">
                        <div class="user_favorite_exercise_img test1" flex style="margin:5px; border:1px solid #ccc;background-image: url('/img/images/6035.jpeg')">
                            <div style="padding:5px;"><img src="/img/images/star.png"></div>
                        </div>
                    </div>
                    <div class="program_box">
                        <div class="user_favorite_exercise_img test1" flex style="margin:5px; border:1px solid #ccc;background-image: url('/img/images/6035.jpeg')">
                            <div style="padding:5px;"><img src="/img/images/star.png"></div>
                        </div>
                    </div>

                </div>                
            </div>
        </div>
    </div>
    <div style="width:300px;margin-top: 60px" layout="column" class="menu-right">
        <div class="mobile_app" layout="row" layout-align="start center">
            <img src="/img/images/apple.png"/>
            <p><strong><?php echo __('mobile application')?></strong></p>
        </div>
        <div class="create_program" layout="row" layout-align="start center">
            <img src="/img/images/object_dynamique.png"/>
            <p><strong><?php echo __('create a program')?><strong></p>
        </div>
        <div class="advertising">
            <p><strong><?php echo __('advertising')?></strong></p>
            <img src="/img/images/Ad_example.jpg"/>
        </div>
    </div>
</div>