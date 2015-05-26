<div ng-model="content" class="exercise_box" ng-if="item.mode == 5" 
    >
    <div class="box_program_vew"
        dnd-draggable="item"    
        dnd-horizontal-list="true"
        dnd-moved="movedCallback1(event, $index, item)" 
        dnd-dragstart="dragStartCallback1(event, $index, item)"     
        dnd-effect-allowed="move"
        dnd-disable-if="!isEdit">
        <div class="header_box">
           <p>{{$index+1}}</p>
            <img ng-click="click_icon_option($event);" src="/img/images/icon_option.png" ng-show="isEdit">
            <ul class="option_program_editor">
                <li ng-click="change_type_exercise('1', $index)">Regular</li>
                <li ng-click="change_type_exercise('2', $index)">Stretching</li>
                <li ng-click="change_type_exercise('3', $index)">Super-set</li>
                <li ng-click="change_type_exercise('4', $index)">With notes</li>
                <li ng-if="tab.exercise_list.length > 1" ng-click="delete_exercise($index)">Delete</li>
            </ul>
        </div>        
        <textarea class="content_only_text" style="text-align:center;resize:none;" type="text" ng-model="item.text" ng-disabled="!isEdit"></textarea>
    </div>
</div>