<div class="user_favorite_exercise_img" flex >
    <div class="img_star_container">
        <img class="img_star"
             ng-src="{{getImage()}}"
             ng-click="toggleSelection()"
            >
    </div>
    <?php if(!isset($is_mobile)) { ?>
    <a href="/Exercises/detail?id={{exercise.Exercise.id}}">
        <div style="padding:0 30px;">
            <ui-video
                video="exercise"
                ng-mouseover="hoverIn($event)"
                ng-mouseleave="hoverOut($event)" >
            </ui-video>
        </div> 
    </a>
    <?php } else { ?>
        <div style="padding:0 30px;">
            <img class="img-responsive"
                 ng-src="{{getExerciseImage()}}"
                 ng-click="OnMobileImgClick($event)"
            >
        </div>
    <?php } ?> 
    <a href="/Exercises/detail?id={{exercise.Exercise.id}}">
        <p class="exercise_name">{{exercise.Exercise.name}}</p>
        <ul class="list-inline list_body_part">
           <li ng-repeat="body_part in exercise.Exercise.muscle">{{body_part.name}}</li>
        </ul>                                                                   
    </a>                     
</div>