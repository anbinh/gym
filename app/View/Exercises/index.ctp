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
        <div>
            <img ng-show="isShowFilter" style="width:16px; height:16px; margin-top:20px;" src="/img/loader.gif"/>
        </div>
    </div>
    <div layout="row">
        <div flex>
            <div layout="row">
                <div flex>
                    <div class="list_tile" class="row">
                        <div id="list_exercises" >
                            <div ng-repeat="exercise in exercises_list" ng-controller="ItemExerciseController" class="exercise_box">
                                <?php echo $this->element('exercise_box_template');?>
                            </div>
                            <p style="text-align:center; font-size: 26px;" ng-show="showNoResult"> <?php echo __('No result');?></p>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        <!-- advertisement zone -->
        <?php echo $this->element('right_advs');?>        
    </div>    
    <div layout="row" ng-show="isOver" layout-align="center center">
        <div layout="column" ng-show="isOver" layout-align="center center">
            <div>
                <img ng-show="showLoader" src="/img/loader.gif"/>   
            </div>
            <div>            
                <?php if($language == 'eng') { ?>
                    <img style="cursor: pointer;" ng-click="loadmore_exercises()" src="/img/images/LOAD_MORE.jpg"/>
                <?php } else { ?>
                    <img style="cursor: pointer;" ng-click="loadmore_exercises()" src="/img/images/LOAD_MORE_FR.jpg"/>
                <?php }?>                     
            </div>    
        </div>
        <div style="width:300px;" class="menu-right"></div> 
    </div>
</div>
