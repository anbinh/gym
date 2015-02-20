<div layout="row">
    <span class="musculation">Musculation</span>
    <span class="stretching">Stretching</span>
    <select>
        <option>Part</option>
    </select>
</div>
<div layout="row">
    <div ng-controller="ExerciseController" flex>
        <div layout="row">
            <div flex>
                <div class="list_tile" class="row">
                    <div ng-repeat="data in exercises_like">
                        <div class="col-sm-6 col-md-4 col-lg-3 exercise_box">
                            <div class="user_favorite_exercise_img" flex >
                                <div ng-switch="switchPoint === data.Exercise.id" ng-click="toggle(data.Exercise.id)">
                                    <div style="padding:5px;" ng-switch-when="true">
                                        <img class="img_start" src="{{ImgStartLike}}">
                                    </div>
                                    <div style="padding:5px;" ng-switch-when="false">
                                        <img class="img_start" src="{{ImgStartUnLike}}">
                                    </div>
                                </div>
                                <!-- <div ><img src="/img/images/star.png"></div>-->
                                <a href="/Exercises/detail/{{data.Exercise.id}}">
                                    <div style="padding:0 10px;"><img src="/img/images/6035.jpeg" class="img-responsive"></div>
                                    <p style="text-align:center;">sample text</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div ng-repeat="data in exercises_unlike">
                        <div class="col-sm-6 col-md-4 col-lg-3 exercise_box">
                            <div class="user_favorite_exercise_img" flex >
                                <div ng-switch="switchPoint === data.Exercise.id" ng-click="toggle(data.Exercise.id)">
                                    <div style="padding:5px;" ng-switch-when="true">
                                        <img class="img_start" src="{{ImgStartLike}}">
                                    </div>
                                    <div style="padding:5px;" ng-switch-when="false">
                                        <img class="img_start" src="{{ImgStartUnLike}}">
                                    </div>
                                </div>
                               <!-- <div ><img src="/img/images/star.png"></div>-->
                                <a href="/Exercises/detail/{{data.Exercise.id}}">
                                    <div style="padding:0 10px;"><img src="/img/images/6035.jpeg" class="img-responsive"></div>
                                    <p style="text-align:center;">sample text</p>
                                </a>
                            </div>
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