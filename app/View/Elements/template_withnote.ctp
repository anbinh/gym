<div ng-model="model_temp" ng-init="model_temp.Exercise = item.exercise_item[0].Exercise" data-drop="true" jqyoui-droppable="{multiple:true, onDrop: 'dropCallback(model_temp, $index, 4, 0)', onOver: 'overCallback()', onOut: 'outCallback()'}" class="exercise_box" ng-if="item.mode == 4"
    dnd-draggable="item"    
    dnd-horizontal-list="true"    
    dnd-dragstart="dragStartCallback1(event, $index, item)"     
    dnd-effect-allowed="move"
    dnd-disable-if="!isEdit"
>
    <div class="box_program_vew">
        <div class="header_box">
            <p>{{$index+1}}</p>
            <img ng-click="click_icon_option($event);" ng-click src="/img/images/icon_option.png" ng-show="isEdit">
            <ul class="option_program_editor">
                <li ng-click="change_type_exercise('1', $index)">Regular</li>
                <li ng-click="change_type_exercise('2', $index)">Stretching</li>
                <li ng-click="change_type_exercise('3', $index)">Super-set</li>
                <li ng-click="change_type_exercise('5', $index)">Only text</li>
                <li ng-if="tab.exercise_list.length > 1" ng-click="delete_exercise($index)">Delete</li>
            </ul>
        </div>        
        <div class="content_box_regular">
            <div class="content_image" layout-align="center center" layout="column">
                <img ng-click="delete_exercise_drop(0, $index, 4);" ng-show="model_temp.Exercise != null && isEdit ? true : false" class="icon_delete_regular" src="/img/images/delete_copy.png">
                <video ng-mouseover="hoverIn($event)" ng-mouseleave="hoverOut($event)" class="img-responsive" preload="none" src="{{model_temp.Exercise.video}}" poster="{{model_temp.Exercise != null ? model_temp.Exercise.photo : '/img/images/drag_exercise.png'}}" <="" video=""></video>
                <div>{{model_temp.Exercise == null ? 'DRAG EXERCISE' : ''}}</div>
            </div>
            <p class="name_exercise">{{model_temp.Exercise.name}}</p>
        </div>
        <div class="fotter_box" layout-align="center center" layout="row">
            <input ng-model="item.text" style="width:185px" type="text" ng-disabled="!isEdit">
        </div>
    </div>
</div>