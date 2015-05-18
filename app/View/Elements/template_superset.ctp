<div class="exercise_box" ng-if="item.mode == 3">
    <div class="box_program_vew">
        <div class="header_box">
            <p>1</p>
            <img ng-click="click_icon_option()" src="/img/images/icon_option.png">
        </div>
        <ul ng-show="showOptionChooseTypeExercise" class="option_program_editor">
            <li ng-click="change_type_exercise('1')">Regular</li>
            <li ng-click="change_type_exercise('2')">Stretching</li>
            <li ng-click="change_type_exercise('4')">With notes</li>
            <li ng-click="change_type_exercise('5')">Only text</li>
            <li ng-click="delete_exercise()">Delete</li>
        </ul>
        <div ng-model="model_temp1" data-drop="true" jqyoui-droppable="{multiple:true, onDrop: 'dropCallback(0)', onOver: 'overCallback()', onOut: 'outCallback()'}" class="content_box_super_set">
            <div class="content_box_img" layout-align="center center" layout="column">
                <img ng-click="delete_exercise_drop(0);" ng-show="model_temp1 != null ? true : false" class="icon_delete_superset_1" src="/img/images/delete_copy.png">
                <video ng-mouseover="hoverIn($event)" ng-mouseleave="hoverOut($event)" class="img-responsive" preload="none" src="{{model_temp1.Exercise.video}}" poster="{{model_temp1 != null ? model_temp1.Exercise.photo : '/img/images/drag_exercise.png'}}" <="" video=""></video>
            </div>
            <div class="content_box_main" layout="column">
                Serie
                <input ng-model="serie1" class="serie2" type="text">
                Repetition
                <input ng-model="repeat1" class="repeat2" type="text">
            </div>
            <p class="name_exercise">{{model_temp1.Exercise.name}}</p>
        </div>
        <div ng-model="model_temp2" data-drop="true" jqyoui-droppable="{multiple:true, onDrop: 'dropCallback(1)', onOver: 'overCallback()', onOut: 'outCallback()'}" class="content_box_super_set">
            <div class="content_box_img" layout-align="center center" layout="column">
                <img ng-click="delete_exercise_drop(1);" ng-show="model_temp2 != null ? true : false" class="icon_delete_superset_2" src="/img/images/delete_copy.png">
                <video ng-mouseover="hoverIn($event)" ng-mouseleave="hoverOut($event)" class="img-responsive" preload="none" src="{{model_temp2.Exercise.video}}" poster="{{model_temp2 != null ? model_temp2.Exercise.photo : '/img/images/drag_exercise.png'}}" <="" video=""></video>
            </div>
            <div class="content_box_main" layout="column">
                Serie
                <input ng-model="serie2" class="serie2" type="text">
                Repetition
                <input ng-model="repeat2" class="repeat2" type="text">
            </div>
            <p class="name_exercise">{{model_temp2.Exercise.name}}</p>
        </div>
    </div>
</div>