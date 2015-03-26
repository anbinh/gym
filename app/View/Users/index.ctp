<script>
    // init variable
    var  id = '<?php echo isset($user['id']) ? $user['id'] : 0  ?>';
</script>
<div layout="row" layout-align="center start">
    <div flex ng-controller="UserController" class="UserIndexLeftContent">
        <div layout="column" class="info_user">
            <div layout="row" class="avatar">
                <div style="padding-left:10px;"><img class="img_avatar" ng-src="{{user.picture}}"/></div>
                <div layout="row" layout-align="start center" class="username">{{user.login}}</div>
            </div>
            <div layout="row" style="height:120px;">
                <div style="padding:8px 0 0 190px;" flex>
                    <!-- <div><img src="/img/images/facebook_icon.png"/> &nbsp&nbsp <img src="/img/images/twitter_icon.png"/></div> -->
                    <div class="fullname">{{user.firstname}} {{user.lastname}}</div>
                    <div class="city">{{user.language}}</div>
                    <div class="language">{{user.address.street}}</div>
                    <div class="edit_profile"><a class="edit_text" href="javascript:void(0);" ng-click='edit()'><?php echo __('edit')?></a></div>
                </div>
            </div>
        </div>
        <div layout="row">
            <div flex style="padding-bottom: 10px; border-bottom: 1px solid #ccc;">
                <div class="my_program">
                    <div class="my_program_text" layout="row" layout-align="start center"><div class="arrow_click" ng-class="isProgramShow ? 'arrow_down' : 'arrow_right'" ng-click="toggleMyProgram()"></div><p><?php echo __('my program')?></p>
                        <a class="edit_text" ng-click="editProgram()" style="padding-left:10px;" href="#"> <?php echo __('edit')?></a></div>
                    <div ng-show="isProgramShow" class="list_tile" class="row">
                        <div class="exercise_box">
                            <div class="user_favorite_exercise_img tile_1 exercise_box_highlight" >
                                <div ng-show="isEdit"><img class="delete_icon_program" style="float:right;" src="/img/images/delete_copy.png"></div>                           
                                <div style="text-align:center;"><img class="img_program" src="/img/images/bunnybacon.png"></div>
                                <div class="program_text_name"> SHAPE MODELING</div>
                            </div>                            
                        </div>
                        <div class="exercise_box">
                            <div class="user_favorite_exercise_img tile_2 none_border"  >    
                                <div ng-show="isEdit"><img class="delete_icon_program" style="float:right;" src="/img/images/delete_copy.png"></div>                          
                                <div style="text-align:center;"><img class="img_program" src="/img/images/bellyJelly.png"></div>
                                <div class="program_text_name"> LOOSING WEIGHT </div>
                            </div>
                        </div>
                        <div class="exercise_box">
                            <div class="user_favorite_exercise_img tile_3 none_border"  >     
                                <div ng-show="isEdit"><img class="delete_icon_program" style="float:right;" src="/img/images/delete_copy.png"></div>                         
                                <div style="text-align:center;"><img class="img_program" src="/img/images/burn.png"></div>
                                <div class="program_text_name"> LOOSING WEIGHT </div>
                            </div>
                        </div>
                        <div class="exercise_box">
                            <div class="user_favorite_exercise_img tile_1 none_border"  >       
                                <div ng-show="isEdit"><img class="delete_icon_program" style="float:right;" src="/img/images/delete_copy.png"></div>                     
                                <div style="text-align:center;"><img class="img_program" src="/img/images/bunnybacon.png"></div>
                                <div class="program_text_name"> SHAPE MODELING</div>
                            </div>                            
                        </div>                       
                    </div>
                </div>
            </div>
        </div>
        <div layout="row">
            <div flex>
                <div layout="row" class="my_program_text" layout-align="start center"><div class="arrow_click" ng-class="isExerciseShow ? 'arrow_down' : 'arrow_right'" ng-click="toggleExercise()"></div><p><?php echo __('favorite exercise')?></p></div>
                <div ng-show="isExerciseShow" class="list_tile" class="row">
                    <div ng-repeat="exercise in exercises_list" ng-controller="ItemExerciseController">
                        <div class="exercise_box">
                            <div class="user_favorite_exercise_img" flex >
                                <div class="img_star_container">
                                    <img class="img_star"
                                         ng-src="{{getImage()}}"
                                         ng-click="toggleSelection()"
                                        >
                                </div>
                                <a href="/Exercises/detail/{{exercise.Exercise.id}}">
                                    <div style="padding:0 10px;"><img src="/img/images/6035.jpeg" class="img-responsive"></div>
                                    <p style="text-align:center;">{{exercise.Exercise.care}}</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
    <div style="margin-top:52px;">
        <?php echo $this->element('right_advs');?>        
    </div>    
</div>