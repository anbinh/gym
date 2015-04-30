<div ng-repeat="item in list_program_saved"
	dnd-draggable="item"    
	dnd-horizontal-list="true"
	dnd-moved="movedCallback(event, $index, item)"	
	dnd-dragstart="dragStartCallback(event, $index, item)"  	
    dnd-effect-allowed="move" 
    dnd-disable-if="isSelected == false"       
 	class="user_favorite_exercise_img exercise_box" ng-class="{exercise_box_highlight: $first}" style="background-color:{{item.Program.color_code}};">
	    <div ng-show="isEdit" style="position:absolute; right:0;"><img ng-click="delete_program(item.Program.id, $index);" class="delete_icon_program" style="float:right;" src="/img/images/delete_copy.png">
	    </div>                           
	    <div style="text-align:center;"><a href="/Programs/program_view/{{item.Program.id}}"><img class="img_program" src="/img/images/{{item.Program.photo}}"></a></div>
	    <div class="program_text_name">{{item.Program.name}}</div>
</div>