<div ng-model="model_temp" ng-init="model_temp.Exercise = item.exercise_item[0].Exercise" data-drop="true" jqyoui-droppable="{multiple:true, onDrop: 'dropCallback(model_temp, $index, 1, 0)', onOver: 'overCallback()', onOut: 'outCallback()'}" class="exercise_box" ng-if="item.mode == 1">
    <div class="box_program_vew">
        <div class="header_box">
            <p>{{$index+1}}</p>
            <img class="icon_change_type_exercise" src="/img/images/icon_option.png">
            <ul class="option_program_editor">
                <li ng-click="change_type_exercise('2', $index)">Stretching</li>
                <li ng-click="change_type_exercise('3', $index)">Super-set</li>
                <li ng-click="change_type_exercise('4', $index)">With notes</li>
                <li ng-click="change_type_exercise('5', $index)">Only text</li>
                <li ng-click="delete_exercise($index)">Delete</li>
            </ul>
        </div>        
        <div class="content_box_regular">
            <div class="content_image" layout-align="center center" layout="column">
                <img ng-click="delete_exercise_drop(0, $index);" ng-show="model_temp.Exercise != null ? true : false" class="icon_delete_regular" src="/img/images/delete_copy.png">
                <video ng-mouseover="hoverIn($event)" ng-mouseleave="hoverOut($event)" class="img-responsive" preload="none" src="{{model_temp.Exercise.video}}" poster="{{model_temp.Exercise != null ? model_temp.Exercise.photo : '/img/images/drag_exercise.png'}}" <="" video=""></video>
                <div>{{model_temp.Exercise == null ? 'DRAG EXERCISE' : ''}}</div>
            </div>
            <p class="name_exercise">{{model_temp.Exercise.name}}</p>
        </div>
        <div class="fotter_box" layout-align="center center" layout="row">
            Serie
            <input ng-model="item.exercise_item[0].serie" class="serie1" type="text" value="">
            Repeation
            <input ng-model="item.exercise_item[0].repeat" class="repeat1" type="text" value="">
        </div>
    </div>
</div>