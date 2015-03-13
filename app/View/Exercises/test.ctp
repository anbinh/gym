<div ng-controller="TestController">
    <div layout="row">
        <div flex>
            <div layout="row">
                <div flex>
                    <div class="list_tile" class="row">
                        <div ng-repeat="exercise in tests" ng-controller="TestRepeatController">
                            <div class="exercise_box">
                                <div class="user_favorite_exercise_img" flex >
                                    <div class="img_star_container">
                                        <img class="img_star"
                                             ng-src="{{getImage()}}"
                                             ng-click="toggleSelection()"
                                            >
                                    </div>
                                    <div style="padding:0 10px;">
                                        <ui-video ng-click="playVideo($event)"
                                                  video="exercise"
                                                  ng-mouseover="hoverIn($event)"
                                                  ng-mouseleave="hoverOut()" >

                                        </ui-video>
                                    </div>
                                    <p style="text-align:center;">{{exercise.id}}</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>