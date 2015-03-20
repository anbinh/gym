<div layout="row" layout-align="center start">
    <div flex>
        <div layout="row" layout-sm="column" class="header_program_editor" layout-align="start center">
          <div flex style="padding-top:10px;">
            <img src="/img/images/object_dynamique.png">
            <span style="margin-left:25px;"><?php echo __("CREAT A PROGRAM");?></span>
          </div>         
          <div flex class="list_button">
            <input type="button" class="btn btn_program_editor btn_public_program" value="Publish">
            <input type="button" class="btn btn_program_editor btn_draft_program" value="Save draft">
            <input type="button" class="btn btn_program_editor btn_cancel_program" value="Cancel">
          </div>
        </div>             
    </div>  
       
</div>

<div layout="row" class="main_content_program_editor">
  <div flex class="program_tab_editor">
    asd
  </div>
  <div layout="row" layout-align="center start" class="right_content_program_editor">
    <div>
      <div class="type_of_program">      
        <span style="margin-right:10px;"><?php echo __("OBJECTIVE");?></span>
        <select  class="input_select input_location">
            <option value=""><?php echo __('Choose')?></option>              
        </select>
      </div>
      <div class="main_content_type_of_program">
        <div layout="row" layout-align="center center" class="user_favorite_exercise_img none_border topic_box_program_editor"> 
          <div style="text-align:center;">
            <img src="/img/images/add_picture_program.png">            
            <p style="color:white;margin-top:10px;"><?php echo __("ADD PICTURE");?></p>
          </div>                    
        </div>   
        <div style="padding:10px 0 10px 0">
            <input class="description_title_program_editor" placeholder="Descriptive title"> 
        </div>     
        <div>
            <textarea class="short_text_program_editor" placeholder="Short text about program" rows="5"></textarea>
        </div>      
      </div>              
    </div>
  </div>
</div> 
<div class="bar" >  
  <div ng-controller="ExerciseProgramEditorController" class="detail_footer_program_editor">
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
        <div ng-repeat="exercise in exercises_list" ng-controller="ItemExerciseProgramEditorController">
          <div class="dropbox_program_editor" >
            <div class="zone_hand_drag">
                <img style="position:absolute; left:7px; top:5px;" ng-src="{{getImage()}}">
                <img style="position:absolute; right:7px; top:5px;" src="/img/images/square.png">
                <img style="position:absolute; right:3px; top:11px;" src="/img/images/hand_drag.png">        
            </div>
            <div style="text-align:center; padding-top:10px;">
              <img src="/img/images/favourite_exercise.png">
            </div> 
            <div class="text_exercise">
              <p>Cum autem commodis intervallata temporibus...</p>
            </div>                       
          </div> 
        </div>  
    </div>
  </div>
</div>

<script> 
$(document).ready(function(){
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
</script>