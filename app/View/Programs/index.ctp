<div ng-controller="ProgramListController">

<?php if(!$this->Session->check('is_SHOW_LEGAL_BAR')):?>
<div class="legal_bar" layout="row" layout-sm="column" layout-align="start center">
    <div class="close_legal_bar" ng-click="close_legal_bar('0')">
        <img src="/img/images/close_legal_bar.png">
    </div>
    <div style="float:left; padding: 10px 0 10px 0;" ng-click="close_legal_bar('1')">
        <a class="btn btn_aptitude" href="javascript:void(0);"><?php echo __('Aptitude test')?></a>
    </div>
    <div class="col-xs-10 col-lg-6">
        <p style="margin:0; line-height:1.2; padding: 10px 0 10px 0;"><?php echo __('If you have any doubt as to your capacity to participate in a physical training program 
        or if you feel any discomfort, stop exercising and consult a physician immediately.')?> </p>
    </div>    
    <div style="float:left; border-bottom:1px solid;" ng-click="close_legal_bar('2')">
        <a style="color:black; text-decoration: none;" href="javascript:void(0);"><?php echo __('Term of use');?></a>
    </div>
</div>
<?php endif;?>
<ul class="list-inline filter_objective_program">
    <li><img src="/img/images/icon_search.png"/></li>
    <li><?php echo __('OBJECTIVE')?></li>
    <li>
        <select class="input_select input_location select_custom" ng-model="selectedObjectiveItem" ng-change="changedValue(selectedObjectiveItem)">
            <option value=""><?php echo __('Choose')?></option>
            <option ng-repeat="item in objective_items" value="{{item.id}}">{{item.name}}</option>
        </select>
    </li>
</ul>

<div layout="row" layout-align="center start">
    <div flex>                
        <div layout="row">
            <div flex>                
                <div class="list_tile" class="row">
                    <div ng-repeat="program in programs_list" ng-controller="ItemProgramController">
                        <div class="exercise_box">
                            <div class="user_favorite_exercise_img none_border" ng-style="{'background-color': program.Program.color_code}">
                                <a href="/Programs/program_view/{{program.Program.id}}" style=" border: 0; outline: 0; outline-offset: -1px;">
                                <div style="text-align:center;"><img class="img_program" ng-src="/img/images/{{program.Program.photo}}"></div>
                                <div class="program_text_name"> <?php echo ($language=='fra')?'{{program.Program.name_fr}}':'{{program.Program.name}}';?></div>
                                </a>                                               
                            </div>
                        </div>
                    </div>                   
                </div>                
            </div>
        </div>
    </div>
    <?php echo $this->element('right_advs');?>
</div>
</div>