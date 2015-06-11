<div class="exercise_box" ng-if="item.mode == 3" 
    dnd-draggable="item"    
    dnd-horizontal-list="true"    
    dnd-dragstart="dragStartCallback1(event, $index, item)"     
    dnd-effect-allowed="move"
    dnd-disable-if="!isEdit"
>
    <div class="box_program_vew">
        <div class="header_box">
            <p>{{$index+1}}</p>
            <img ng-click="click_icon_option($event);" src="/img/images/icon_option.png" ng-show="isEdit">
            <ul class="option_program_editor">
                <li ng-click="change_type_exercise('1', $index)">Regular</li>
                <li ng-click="change_type_exercise('2', $index)">Stretching</li>
                <li ng-click="change_type_exercise('4', $index)">With notes</li>
                <li ng-click="change_type_exercise('5', $index)">Only text</li>
                <li ng-if="tab.exercise_list.length > 1" ng-click="delete_exercise($index)">Delete</li>
            </ul>
        </div>   
        <div style="position:absolute; top:10px;">
            <div style="width:225px;" ng-model="model_temp1" ng-init="model_temp1.Exercise = item.exercise_item[0].Exercise" data-drop="true" jqyoui-droppable="{multiple:true, onDrop: 'dropCallback(model_temp1, $index, 3, 0)', onOver: 'overCallback()', onOut: 'outCallback()'}" class="content_box_super_set">
                <div class="content_box_img" layout-align="center center" layout="column">
                    <img ng-click="delete_exercise_drop( 0, $index, 3, $event);" ng-show="model_temp1.Exercise != null && isEdit ? true : false" class="icon_delete_superset_1" src="/img/images/delete_copy.png">
                    <video ng-mouseover="hoverIn($event)" ng-mouseleave="hoverOut($event)" class="img-responsive" preload="none" src="{{model_temp1.Exercise.video}}" poster="{{model_temp1.Exercise != null ? model_temp1.Exercise.photo : '/img/images/drag_exercise.png'}}" <="" video=""></video>
                </div>
                <div class="content_box_main" layout="column">
                    Serie
                    <input ng-model="item.exercise_item[0].series" class="serie2" type="text">
                    Repetition
                    <input ng-model="item.exercise_item[0].repeatation_from" class="repeat2" type="text">
                </div>
                <p class="name_exercise">{{model_temp1.Exercise.name}}</p>
            </div>
            <div style="width:225px;" ng-model="model_temp2" ng-init="model_temp2.Exercise = item.exercise_item[1].Exercise" data-drop="true" jqyoui-droppable="{multiple:true, onDrop: 'dropCallback(model_temp2, $index, 3, 1)', onOver: 'overCallback()', onOut: 'outCallback()'}" class="content_box_super_set">
                <div class="content_box_img" layout-align="center center" layout="column">
                    <img ng-click="delete_exercise_drop(1, $index, 3, $event);" ng-show="model_temp2.Exercise != null && isEdit ? true : false" class="icon_delete_superset_2" src="/img/images/delete_copy.png" >
                    <video ng-mouseover="hoverIn($event)" ng-mouseleave="hoverOut($event)" class="img-responsive" preload="none" src="{{model_temp2.Exercise.video}}" poster="{{model_temp2.Exercise != null ? model_temp2.Exercise.photo : '/img/images/drag_exercise.png'}}" <="" video=""></video>
                </div>
                <div class="content_box_main" layout="column">
                    Serie
                    <input ng-model="item.exercise_item[1].series" class="serie2" type="text" ng-disabled="!isEdit">
                    Repetition
                    <input ng-model="item.exercise_item[1].repeatation_from" class="repeat2" type="text" ng-disabled="!isEdit">
                </div>
                <p class="name_exercise">{{model_temp2.Exercise.name}}</p>
            </div>
        </div>     
    </div>
</div>