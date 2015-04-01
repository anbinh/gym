<script src="http://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
    var  id = '<?php echo isset($auth_user['id']) ? $auth_user['id'] : "0"  ?>';
</script>
<div ng-controller="ExerciseController">
    <div layout="row" layout="center start" style="height:60px; padding-left:23px;">
        <div style="padding-top:20px;">
            <img src="/img/images/icon_search.png">
        </div>
        <md-button class="exercise_filter" ng-click="muscleClick()">
            <span  ng-class="{ bottomline: isMuscleSelected }">
                <?php echo __('Bodybuilding')?>
            </span>
        </md-button>
        <md-button class="exercise_filter" ng-click="stretchingClick()">
            <span  ng-class="{ bottomline: isStretchingSelected }">
                <?php echo __('Stretching')?>
            </span>
        </md-button>
        <md-button class="exercise_filter" ng-click="cardioClick()">
            <span  ng-class="{ bottomline: isCardioSelected }">
                <?php echo __('Cardio')?>
            </span>
        </md-button>
        <select style="margin:12px; padding-right:60px;" class="input_select input_location select_custom" ng-model="selectedBodyPartItem" ng-change="changedValue(selectedBodyPartItem)">
            <option value=""><?php echo __('Part')?></option>
            <option ng-repeat="item in body_part_items" value="{{item.id}}">{{item.name}}</option>
        </select>
    </div>
    <div layout="row">
        <div flex>
            <div layout="row">
                <div flex>
                    <div class="list_tile" class="row">
                        <div id="list_exercises" >
                            <div ng-repeat="exercise in exercises_list" ng-controller="ItemExerciseController" class="exercise_box">
                                <div class="user_favorite_exercise_img" flex >
                                    <div class="img_star_container">
                                        <img class="img_star"
                                             ng-src="{{getImage()}}"
                                             ng-click="toggleSelection()"
                                            >
                                    </div>
                                    <a href="/Exercises/detail?id={{exercise.Exercise.id}}">
                                        <div style="padding:0 30px;">
                                            <ui-video
                                                video="exercise"
                                                ng-mouseover="hoverIn($event)"
                                                ng-mouseleave="hoverOut($event)" >
                                            </ui-video></div>
                                        <p class="exercise_name">{{exercise.Exercise.name}}</p>                                    
                                    </a>   
                                    <ul class="list-inline list_body_part">
                                       <li ng-repeat="body_part in exercise.Exercise.muscle">{{body_part.name}}</li>
                                    </ul>                                                                                                
                                </div>
                            </div>
                        </div>
                        <div id="loadmore" >
                            <div ng-repeat="exercise in list_loadmore" on-finish-render="ngRepeatFinished" ng-controller="ItemExerciseController" class="exercise_box loadmore">
                                <div class="user_favorite_exercise_img" flex >
                                    <div class="img_star_container">
                                        <img class="img_star"
                                             ng-src="{{getImage()}}"
                                             ng-click="toggleSelection()"
                                            >
                                    </div>
                                    <a href="/Exercises/detail?id={{exercise.Exercise.id}}">
                                        <div style="padding:0 30px;">
                                            <ui-video
                                                video="exercise"
                                                ng-mouseover="hoverIn($event)"
                                                ng-mouseleave="hoverOut($event)" >
                                            </ui-video></div>
                                        <p class="exercise_name">{{exercise.Exercise.name}}</p>                                    
                                    </a>   
                                    <ul class="list-inline list_body_part">
                                       <li ng-repeat="body_part in exercise.Exercise.muscle">{{body_part.name}}</li>
                                    </ul>                                                                                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- advertisement zone -->
        <?php echo $this->element('right_advs');?>        
    </div>    
    <div layout="row" layout-align="center center">
        <div>
            <input ng-click="loadmore_exercises()" type="button" class="btn btn-primary" value="load more">            
        </div>       
        <div style="width:300px;"></div> 
    </div>
</div>
