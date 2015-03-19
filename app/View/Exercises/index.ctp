<script src="http://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
    var  id = '<?php echo isset($auth_user['id']) ? $auth_user['id'] : "0"  ?>';
</script>
<div ng-controller="ExerciseController">
    <div layout="row">
        <md-button class="exercise_filter" ng-click="muscleClick()">
            <span  ng-class="{ bottomline: isMuscleSelected }">
                <?php echo __('Musculation')?>
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
        <select class="input_select input_location" ng-model="selectedBodyPartItem" ng-change="changedValue(selectedBodyPartItem)">
            <option value=""><?php echo __('Part')?></option>
            <option ng-repeat="item in body_part_items" value="{{item.id}}">{{item.name}}</option>
        </select>
    </div>
    <div layout="row">
        <div flex>
            <div layout="row">
                <div flex>
                    <div class="list_tile" class="row">
                        <div ng-repeat="exercise in exercises_list" ng-controller="ItemExerciseController">
                            <div class="exercise_box">
                                <div class="user_favorite_exercise_img" flex >
                                    <div class="img_star_container">
                                        <img class="img_star"
                                             ng-src="{{getImage()}}"
                                             ng-click="toggleSelection()"
                                            >
                                    </div>
                                    <a href="/Exercises/detail?id={{exercise.Exercise.id}}">
                                        <div style="padding:0 10px;">
                                            <ui-video
                                                video="exercise"
                                                ng-mouseover="hoverIn($event)"
                                                ng-mouseleave="hoverOut($event)" >
                                            </ui-video></div>
                                        <p style="text-align:center;">{{exercise.Exercise.care}}</p>
                                    </a>
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
</div>
