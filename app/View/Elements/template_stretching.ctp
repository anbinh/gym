<div class="exercise_box" ng-if="item.mode == 2">
    <div class="box_program_vew">
        <div class="header_box">
            <p>{{$index+1}}</p>
            <img ng-click="click_icon_option($event);" src="/img/images/icon_option.png" ng-show="isEdit">
            <ul class="option_program_editor">
                <li ng-click="change_type_exercise('1', $index)">Regular</li>
                <li ng-click="change_type_exercise('3', $index)">Super-set</li>
                <li ng-click="change_type_exercise('4', $index)">With notes</li>
                <li ng-click="change_type_exercise('5', $index)">Only text</li>
                <li ng-click="delete_exercise($index)">Delete</li>
            </ul>
        </div>
        
        <div class="content_box_stretching">
            <div ng-model="model_temp1" ng-init="model_temp1.Exercise = item.exercise_item[0].Exercise" data-drop="true" jqyoui-droppable="{multiple:true, onDrop: 'dropCallback(model_temp1, $index, 2, 0)', onOver: 'overCallback()', onOut: 'outCallback()'}" class="content_box_img" layout-align="center center" layout="column">
                <img ng-click="delete_exercise_drop(0, $index, 2);" ng-show="model_temp1.Exercise != null && isEdit ? true : false" class="icon_delete_stretching" src="/img/images/delete_copy.png">
                <video ng-mouseover="hoverIn($event)" ng-mouseleave="hoverOut($event)" class="img-responsive" preload="none" src="{{model_temp1.Exercise.video}}" poster="{{model_temp1.Exercise != null ? model_temp1.Exercise.photo : '/img/images/drag_exercise.png'}}" <="" video=""></video>
            </div>
            <div ng-model="model_temp2" ng-init="model_temp2.Exercise = item.exercise_item[1].Exercise" data-drop="true" jqyoui-droppable="{multiple:true, onDrop: 'dropCallback(model_temp2, $index, 2, 1)', onOver: 'overCallback()', onOut: 'outCallback()'}" class="content_box_img" layout-align="center center" layout="column">
                <img ng-click="delete_exercise_drop(1, $index, 2);" ng-show="model_temp2.Exercise != null && isEdit ? true : false" class="icon_delete_stretching" src="/img/images/delete_copy.png">
                <video ng-mouseover="hoverIn($event)" ng-mouseleave="hoverOut($event)" class="img-responsive" preload="none" src="{{model_temp2.Exercise.video}}" poster="{{model_temp2.Exercise != null ? model_temp2.Exercise.photo : '/img/images/drag_exercise.png'}}" <="" video=""></video>
            </div>
            <div ng-model="model_temp3" ng-init="model_temp3.Exercise = item.exercise_item[2].Exercise" data-drop="true" jqyoui-droppable="{multiple:true, onDrop: 'dropCallback(model_temp3, $index, 2, 2)', onOver: 'overCallback()', onOut: 'outCallback()'}" class="content_box_img" layout-align="center center" layout="column">
                <img ng-click="delete_exercise_drop(2, $index, 2);" ng-show="model_temp3.Exercise != null && isEdit ? true : false" class="icon_delete_stretching" src="/img/images/delete_copy.png">
                <video ng-mouseover="hoverIn($event)" ng-mouseleave="hoverOut($event)" class="img-responsive" preload="none" src="{{model_temp3.Exercise.video}}" poster="{{model_temp3.Exercise != null ? model_temp3.Exercise.photo : '/img/images/drag_exercise.png'}}" <="" video=""></video>
            </div>
            <div ng-model="model_temp4" ng-init="model_temp4.Exercise = item.exercise_item[3].Exercise" data-drop="true" jqyoui-droppable="{multiple:true, onDrop: 'dropCallback(model_temp4, $index, 2, 3)', onOver: 'overCallback()', onOut: 'outCallback()'}" class="content_box_img" layout-align="center center" layout="column">
                <img ng-click="delete_exercise_drop(3, $index, 2);" ng-show="model_temp4.Exercise != null && isEdit ? true : false" class="icon_delete_stretching" src="/img/images/delete_copy.png">
                <video ng-mouseover="hoverIn($event)" ng-mouseleave="hoverOut($event)" class="img-responsive" preload="none" src="{{model_temp4.Exercise.video}}" poster="{{model_temp4.Exercise != null ? model_temp4.Exercise.photo : '/img/images/drag_exercise.png'}}" <="" video=""></video>
            </div>
        </div>
        <div class="fotter_box" layout-align="center center" layout="row">
            Serie
            <input ng-model="item.exercise_item[0].series" class="serie1" type="text" ng-disabled="!isEdit">
            Repeation
            <input ng-model="item.exercise_item[0].repeatation_from" class="repeat1" type="text" ng-disabled="!isEdit">
        </div>
    </div>
</div>