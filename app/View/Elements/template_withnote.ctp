<div ng-model="model_temp" data-drop="true" jqyoui-droppable="{multiple:true, onDrop: 'dropCallback()', onOver: 'overCallback()', onOut: 'outCallback()'}" class="exercise_box" ng-if="item.mode == 4">
    <div class="box_program_vew">
        <div class="header_box">
            <p>1</p>
            <img ng-click="click_icon_option()" src="/img/images/icon_option.png">
        </div>
        <ul ng-show="showOptionChooseTypeExercise" class="option_program_editor">
            <li ng-click="change_type_exercise('1')">Regular</li>
            <li ng-click="change_type_exercise('2')">Stretching</li>
            <li ng-click="change_type_exercise('3')">Super-set</li>
            <li ng-click="change_type_exercise('5')">Only text</li>
            <li ng-click="delete_exercise()">Delete</li>
        </ul>
        <div class="content_box_regular">
            <div class="content_image" layout-align="center center" layout="column">
                <img ng-click="delete_exercise_drop();" ng-show="model_temp != null ? true : false" class="icon_delete_regular" src="/img/images/delete_copy.png">
                <video ng-mouseover="hoverIn($event)" ng-mouseleave="hoverOut($event)" class="img-responsive" preload="none" src="{{model_temp.Exercise.video}}" poster="{{model_temp != null ? model_temp.Exercise.photo : '/img/images/drag_exercise.png'}}" <="" video=""></video>
                <div>{{model_temp == null ? 'DRAG EXERCISE' : ''}}</div>
            </div>
            <p class="name_exercise">{{model_temp.Exercise.name}}</p>
        </div>
        <div class="fotter_box" layout-align="center center" layout="row">
            <input ng-model="content" style="width:185px" type="text">
        </div>
    </div>
</div>