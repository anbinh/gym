<script>    
    $(function(){
        $("#upload_link").on('click', function(e){
            e.preventDefault();
            $("#upload").trigger('click');
        });              
        $(".toggle_bar").click(function(){
          if($(".detail_footer_program_editor").hasClass('actived')){
              $(".detail_footer_program_editor").animate({height: '50px'}, 300, function(){
                $(".bar").attr("style","overflow:hidden;");            
              }).removeClass('actived');                    
              $(".toggle_bar").html("<img src='/img/images/bar_sprite.png'/>");
          }else{
              $(".bar").removeAttr("style");
              $(".detail_footer_program_editor").animate({height: '200px'}).addClass('actived');
              $(".toggle_bar").html("<img src='/img/images/bar_sprite_down.png'/>");
          }
            
        });
        if(!$(".detail_footer_program_editor").hasClass('actived')){
              $(".detail_footer_program_editor").animate({height: '50px'}, 300, function(){
                $(".bar").attr("style","overflow:hidden;");  
              });          
          }
    });

    function fileSelected() {
        // get selected file element
        var oFile = document.getElementById('upload').files[0];
        var oImage = $('#box-img');
        // prepare HTML5 FileReader
        var oReader = new FileReader();
        oReader.onload = function(e) {
            // e.target.result contains the DataURL which we will use as a source of the image
            /*oImage.attr("src",e.target.result);*/
            oImage.css('background-image', 'url(' + e.target.result + ')');
            //$('#btn_add_picture').css('padding-top', '210px');
            //$('#btn_add_picture a').html("<?php echo __("Edit Picture")?>");
        };

        // read selected file as DataURL
        oReader.readAsDataURL(oFile);
    }
</script>
<div ng-controller="ExerciseProgramEditorController">
  <div layout="row" layout-align="center start">
      <div flex>
          <div layout="row" layout-sm="column" class="header_program_editor" layout-align="start center">
            <div flex='45' style="padding-top:10px;">
              <img src="/img/images/object_dynamique.png">
              <span style="margin-left:25px;"><?php echo __("CREAT A PROGRAM");?></span>
            </div>         
            <div flex='100' layout="column" class="list_button">    
              <div>          
                <input type="button" class="btn btn_program_editor btn_draft_program" value="<?php echo __("Preview");?>">
                <input ng-disabled="isSaving" ng-click="save_program()" type="button" class="btn btn_program_editor btn_public_program" value="<?php echo __("Save");?>" style="margin-left: 2px;margin-right: 10px;">
                <input type="button" ng-click="cancel_click()" class="btn btn_program_editor btn_cancel_program" value="<?php echo __("Cancel");?>">
              </div>
              <div ng-show="isObjectiveChose || isImgChose || isSaving">
                <span ng-show="isObjectiveChose || isImgChose" style="color:red;padding-left: 8px;"><?php echo __("Complete all fields");?> *</span>
                <span ng-show="isSaving" style="color:grey;padding-left: 8px;"><img src="/img/loader.gif"/> <?php echo __("Saving");?></span>
              </div>
            </div>            
          </div>             
      </div>  
         
  </div>

  <div layout="row" class="main_content_program_editor">
      <div class="program_tab" flex>               
        <p ng-show='isLoading'><img src="/img/loader.gif"/>Loading...</p>
        <md-tabs ng-show="isShowTabs" md-selected="selectedIndex" flex>            
            <md-tab ng-repeat="tab in tabs track by $index">  
              <md-tab-label style="padding:13px 0 13px 0;" ng-click="(tab.day_number == '' && isOk == true)? addTab() : set_index_current_tab($index);">                
                <img src="/img/images/delete_copy.png" ng-click="removeTab(tab)" ng-show="tab.day_number != '' && tabs.length > 2" class="delete_tab">
                <img src="/img/images/add.png" ng-show="tab.day_number == ''">
                {{ tab.day_number != "" ? 'Day '+ tab.day_number : ''}}
              </md-tab-label>   
                <?php echo $this->Element('program_editor');?>                
            </md-tab>                                           
        </md-tabs>
      </div>
    
    <div layout="row" layout-align="center start" class="right_content_program_editor">
      <div>
        <div class="type_of_program">    
          <span style="color:red;font-weight:bold;font-size: x-large;margin-left: -18px;" ng-show="isObjectiveChose">*</span>  
          <span style="margin-right:10px;"><?php echo __("OBJECTIVE");?></span>
          <select ng-model="selectObjectiveChange" ng-change="selectObjective(selectObjectiveChange)" class="input_select input_location">
              <option value=""><?php echo __('Choose')?></option>  
              <option value="{{item.id}}" ng-repeat="item in objective_items">{{item.name}}</option>
          </select>            
        </div>
        <div class="main_content_type_of_program">          
          <div layout="row" layout-align="center center" class="program_upload_img none_border topic_box_program_editor" id="box-img">   
            <span style="color:red;font-weight:bold;font-size: x-large;" ng-show="isImgChose">*</span>          
            <div style="text-align:center;">              
              <a href="javascript:void(0);" class="btn_add_picture" id="upload_link">
                <img src="/img/images/add_picture_program.png">
                <p style="color:white;margin-top:10px;"><?php echo __("ADD PICTURE");?></p>
              </a>                    
              <input id="upload" type="file" file-model="myFile" onchange='fileSelected()'/>                            
            </div>                    
          </div>   
          <div style="padding:10px 0 10px 0">
              <input ng-model="descriptive" class="description_title_program_editor" placeholder=" <?php echo __("Descriptive title");?>"> 
          </div>     
          <div>
              <textarea ng-model="short_text" class="short_text_program_editor" placeholder=" <?php echo __("Short text about program");?>" rows="5"></textarea>
          </div>      
        </div>              
      </div>
    </div>
  </div> 
  <div class="bar" >  
    <div class="detail_footer_program_editor">
      <header layout="row" layout-align="center center">
        <div flex class="type_of_exercise_program_editor">        
          <ul class="list-inline">
              <li><img src="/img/images/icon_search_white.png"></li>
              <li ng-click="muscleClick()" ng-class="{bottomline_filter_program_editor: isMuscleSelected}"><?php echo __("Bodybuilding");?></li>
              <li ng-click="stretchingClick()" ng-class="{bottomline_filter_program_editor: isStretchingSelected}"><?php echo __("Stretching");?></li>
              <li ng-click="cardioClick()" ng-class="{bottomline_filter_program_editor: isCardioSelected}"><?php echo __("Cardio");?></li>
              <li>
                  <select class="input_select input_location" ng-model="selectedBodyPartItem" ng-change="changedValue(selectedBodyPartItem)">
                      <option value=""><?php echo __("Part");?></option>
                      <option ng-repeat="item in body_part_items" value="{{item.id}}">{{item.name}}</option>
                  </select>
              </li>
          </ul>
        </div>
        <div flex class="type_of_exercise_program_editor_hidden">
          <select class="input_select input_location" ng-model="selectedExercise" ng-change="changeValueExercise(selectedExercise)">
            <option value=""><?php echo __("Choosing");?></option>
            <option value="1"><?php echo __("Bodybuilding");?></option>
            <option value="2"><?php echo __("Stretching");?></option>
            <option value="3"><?php echo __("Cardio");?></option>
          </select>
          <select class="input_select input_location" ng-model="selectedBodyPartItem" ng-change="changedValue(selectedBodyPartItem)">
              <option value=""><?php echo __("Part");?></option>            
              <option ng-repeat="item in body_part_items" value="{{item.id}}">{{item.name}}</option>
          </select>
        </div>      
        <div flex class="show_only_program_editor">
          <div class="toggle_bar"><img src="/img/images/bar_sprite.png"></div>
          <ul ng-click="chooseFavouriteExerciseClick();" class="list-inline show_favourite_exercise" style="float:right;">           
              <li class="text_show_only_program_editor"><?php echo __('Show only');?></li>
              <li><img ng-src="{{getImageShowOnly();}}"></li>
          </ul>
        </div>      
      </header>
      <div style="height:140px; overflow-y:scroll; padding: 5px 10px 0 10px">
          <div  ng-repeat="exercise in exercises_list" ng-controller="ItemExerciseProgramEditorController">
            <div data-drag="true" data-jqyoui-options="{revert: 'invalid', helper: 'clone'}" ng-model="exercises_list" jqyoui-draggable="{index: {{$index}}, animate: true, placeholder: 'keep'}" class="dropbox_program_editor">
              <div class="zone_hand_drag">
                  <img style="position:absolute; left:7px; top:5px;" ng-src="{{getImage()}}">
                  <img style="position:absolute; right:5px; top:5px;" src="/img/images/drag_exercise.png">                  
              </div>
              <div style="text-align:center; padding-top:10px;">
                <img src="{{exercise.Exercise.photo}}" class="img-responsive" style="height:82px; margin:auto;">
              </div> 
              <div class="text_exercise">
                <p>{{exercise.Exercise.name}}</p>
              </div>                       
            </div> 
          </div>  
      </div>
    </div>
  </div>
</div>
