<div ng-controller="ProgramListController">
<ul class="list-inline filter_objective_program">
    <li><img src="/img/images/icon_search.png"/></li>
    <li>OBJECTIVE</li>
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
                                <a href="/Programs/program_view/{{program.Program.id}}">
                                <div style="text-align:center;"><img class="img_program" ng-src="/img/images/{{program.Program.photo}}"></div>
                                <div class="program_text_name"> {{program.Program.name}}</div>
                                </a>                                               
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-sm-6 col-md-4 col-lg-3 exercise_box">
                        <div class="user_favorite_exercise_img tile_butcher none_border">                           
                            <div style="text-align:center;"><img class="img_program" src="/img/images/butcher.png"></div>
                            <div class="program_text_name"> SHAPE MODELING</div>
                        </div>                            
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3 exercise_box">
                        <div class="user_favorite_exercise_img tile_packabs none_border"  >                                
                            <div style="text-align:center;"><img class="img_program" src="/img/images/packabs.png"></div>
                            <div class="program_text_name"> LOOSING WEIGHT </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3 exercise_box ">
                        <div class="user_favorite_exercise_img tile_packabs none_border"  >                                 
                            <div style="text-align:center;"><img class="img_program" src="/img/images/eugenie.png"></div>
                            <div class="program_text_name"> LOOSING WEIGHT </div>
                        </div>
                    </div>                    
                    <div class="col-sm-6 col-md-4 col-lg-3 exercise_box ">
                        <div class="user_favorite_exercise_img tile_1 none_border">                           
                            <div style="text-align:center;"><img class="img_program" src="/img/images/bunnybacon.png"></div>
                            <div class="program_text_name"> SHAPE MODELING</div>
                        </div>                            
                    </div>
                     <div class="col-sm-6 col-md-4 col-lg-3 exercise_box">
                        <div class="user_favorite_exercise_img tile_2 none_border"  >                                
                            <div style="text-align:center;"><img class="img_program" src="/img/images/bellyJelly.png"></div>
                            <div class="program_text_name"> LOOSING WEIGHT </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3 exercise_box">
                        <div class="user_favorite_exercise_img tile_3 none_border"  >                                 
                            <div style="text-align:center;"><img class="img_program" src="/img/images/burn.png"></div>
                            <div class="program_text_name"> LOOSING WEIGHT </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3 exercise_box ">
                        <div class="user_favorite_exercise_img tile_packabs none_border">                           
                            <div style="text-align:center;"><img class="img_program" src="/img/images/bunnybacon.png"></div>
                            <div class="program_text_name"> SHAPE MODELING</div>
                        </div>                            
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3 exercise_box ">
                        <div class="user_favorite_exercise_img tile_butcher none_border">                           
                            <div style="text-align:center;"><img class="img_program" src="/img/images/bunnybacon.png"></div>
                            <div class="program_text_name"> SHAPE MODELING</div>
                        </div>                            
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3 exercise_box">
                        <div class="user_favorite_exercise_img tile_2 none_border"  >                                 
                            <div style="text-align:center;"><img class="img_program" src="/img/images/burn.png"></div>
                            <div class="program_text_name"> LOOSING WEIGHT </div>
                        </div>
                    </div> -->
                </div>                
            </div>
        </div>
    </div>
    <?php echo $this->element('right_advs');?>
</div>
</div>