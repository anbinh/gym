<div class="user_favorite_exercise_img" ng-class="{exercise_box_highlight: $first}" style="background-color:{{item.Program.color_code}};">
    <div ng-show="isEdit" style="position:absolute; right:0;"><img ng-click="delete_program(item.Program.id, $index);" class="delete_icon_program" style="float:right;" src="/img/images/delete_copy.png">
    </div>                           
    <div style="text-align:center;"><a href="/Programs/program_view/{{item.Program.id}}"><img class="img_program" src="/img/images/{{item.Program.photo}}"></a></div>
    <div class="program_text_name">{{item.Program.name}}</div>
</div>