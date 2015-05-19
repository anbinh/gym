<div class="exercise_box" ng-if="item.mode == 2">
    <div class="box_program_vew">
        <div class="header_box">
            <p>1</p>
            <img ng-click="click_icon_option()" src="/img/images/icon_option.png">
        </div>
        <ul ng-show="showOptionChooseTypeExercise" class="option_program_editor">
            <li ng-click="change_type_exercise('1')">Regular</li>
            <li ng-click="change_type_exercise('3')">Super-set</li>
            <li ng-click="change_type_exercise('4')">With notes</li>
            <li ng-click="change_type_exercise('5')">Only text</li>
            <li ng-click="delete_exercise()">Delete</li>
        </ul>
        <div class="content_box_stretching">
            <div ng-model="model_temp1" data-drop="true" jqyoui-droppable="{multiple:true, onDrop: 'dropCallback(0)', onOver: 'overCallback()', onOut: 'outCallback()'}" class="content_box_img" layout-align="center center" layout="column">
                <img ng-click="delete_exercise_drop(0);" ng-show="model_temp1 != null ? true : false" class="icon_delete_stretching" src="/img/images/delete_copy.png">
                <video ng-mouseover="hoverIn($event)" ng-mouseleave="hoverOut($event)" class="img-responsive" preload="none" src="{{model_temp1.Exercise.video}}" poster="{{model_temp1 != null ? model_temp1.Exercise.photo : '/img/images/drag_exercise.png'}}" <="" video=""></video>
            </div>
            <div ng-model="model_temp2" data-drop="true" jqyoui-droppable="{multiple:true, onDrop: 'dropCallback(1)', onOver: 'overCallback()', onOut: 'outCallback()'}" class="content_box_img" layout-align="center center" layout="column">
                <img ng-click="delete_exercise_drop(1);" ng-show="model_temp2 != null ? true : false" class="icon_delete_stretching" src="/img/images/delete_copy.png">
                <video ng-mouseover="hoverIn($event)" ng-mouseleave="hoverOut($event)" class="img-responsive" preload="none" src="{{model_temp2.Exercise.video}}" poster="{{model_temp2 != null ? model_temp2.Exercise.photo : '/img/images/drag_exercise.png'}}" <="" video=""></video>
            </div>
            <div ng-model="model_temp3" data-drop="true" jqyoui-droppable="{multiple:true, onDrop: 'dropCallback(2)', onOver: 'overCallback()', onOut: 'outCallback()'}" class="content_box_img" layout-align="center center" layout="column">
                <img ng-click="delete_exercise_drop(2);" ng-show="model_temp3 != null ? true : false" class="icon_delete_stretching" src="/img/images/delete_copy.png">
                <video ng-mouseover="hoverIn($event)" ng-mouseleave="hoverOut($event)" class="img-responsive" preload="none" src="{{model_temp3.Exercise.video}}" poster="{{model_temp3 != null ? model_temp3.Exercise.photo : '/img/images/drag_exercise.png'}}" <="" video=""></video>
            </div>
            <div ng-model="model_temp4" data-drop="true" jqyoui-droppable="{multiple:true, onDrop: 'dropCallback(3)', onOver: 'overCallback()', onOut: 'outCallback()'}" class="content_box_img" layout-align="center center" layout="column">
                <img ng-click="delete_exercise_drop(3);" ng-show="model_temp4 != null ? true : false" class="icon_delete_stretching" src="/img/images/delete_copy.png">
                <video ng-mouseover="hoverIn($event)" ng-mouseleave="hoverOut($event)" class="img-responsive" preload="none" src="{{model_temp4.Exercise.video}}" poster="{{model_temp4 != null ? model_temp4.Exercise.photo : '/img/images/drag_exercise.png'}}" <="" video=""></video>
            </div>
        </div>
        <div class="fotter_box" layout-align="center center" layout="row">
            Serie
            <input ng-model="serie" class="serie1" type="text">
            Repeation
            <input ng-model="repeat" class="repeat1" type="text">
        </div>
    </div>
</div>