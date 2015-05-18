<div ng-model="content" class="exercise_box" ng-if="item.mode == 5">
    <div class="box_program_vew">
        <div class="header_box">
            <p>1</p>
            <img ng-click="click_icon_option()" src="/img/images/icon_option.png">
        </div>
        <ul ng-show="showOptionChooseTypeExercise" class="option_program_editor">
            <li ng-click="change_type_exercise('1')">Regular</li>
            <li ng-click="change_type_exercise('2')">Stretching</li>
            <li ng-click="change_type_exercise('3')">Super-set</li>
            <li ng-click="change_type_exercise('4')">With notes</li>
            <li ng-click="delete_exercise()">Delete</li>
        </ul>
        <textarea class="content_only_text" type="text" ng-model="content"></textarea>
    </div>
</div>