<div ng-model="content" class="exercise_box" ng-if="item.mode == 5" 
    >
    <div class="box_program_vew"
        dnd-draggable="item"    
        dnd-horizontal-list="true"        
        dnd-dragstart="dragStartCallback1(event, $index, item)"     
        dnd-effect-allowed="move"        
        dnd-disable-if="!isEdit">
        <div class="header_box">
           <p>{{$index+1}}</p>
            <img ng-click="click_icon_option($event);" src="/img/images/icon_option.png" ng-show="isEdit">
            <ul class="option_program_editor">
                <li ng-click="change_type_exercise('1', $index)"><?php echo __('Regular');?></li>
                <li ng-click="change_type_exercise('2', $index)"><?php echo __('Stretching');?></li>
                <li ng-click="change_type_exercise('3', $index)"><?php echo __('Super-set');?></li>
                <li ng-click="change_type_exercise('4', $index)"><?php echo __('With notes');?></li>
                <li ng-if="tab.exercise_list.length > 1" ng-click="delete_exercise($index)"><?php echo __('Delete');?></li>
            </ul>
        </div>        
        <textarea class="content_only_text" ng-class="isEdit ? '' : 'tranparent_input'" style="text-align:center;resize:none;font-weight:normal; border:1px solid black;" type="text" ng-model="item.text" ng-disabled="!isEdit"></textarea>
    </div>
</div>