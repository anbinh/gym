<div layout="row" layout-align="center start">
    <div flex>
        <div layout="row" class="header_program_editor" layout-align="start center">
          <div flex style="padding-left: 10px;">
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
        <div class="user_favorite_exercise_img none_border topic_box_program_editor">          
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
  <div class="detail_footer_program_editor">
    <header layout="row" layout-align="center center">
      <div flex class="type_of_exercise_program_editor">        
        <ul class="list-inline">
            <li><img src="/img/images/icon_search_white.png"></li>
            <li><?php echo __("Bodybuilding");?></li>
            <li><?php echo __("Stretching");?></li>
            <li><?php echo __("Cardio");?></li>
            <li>
                <select class="input_select input_location">
                    <option><?php echo __("Part");?></option>
                </select>
            </li>
        </ul>
      </div>
      <div flex style="text-align:center;"><img src="/img/images/bar_sprite.png"></div>
      <div flex class="show_only_program_editor">
        <ul class="list-inline" style="float:right; margin-right:50px;">
            <li><?php echo __('Show only');?></li>
            <li><img src="/img/images/star_show_only.png"></li>
        </ul>
      </div>      
    </header>
    <div style="height:170px; overflow-y:scroll; padding: 5px 10px 0 10px">
      <div class="dropbox_program_editor"></div>
      <div class="dropbox_program_editor"></div>
    </div>
  </div>
</div>

<script> 
$(document).ready(function(){
    $(".bar").click(function(){
      if($(".detail_footer_program_editor").hasClass('actived')){
          $(".detail_footer_program_editor").animate({height: '50px'}, 300, function(){
            $(".bar").attr("style","overflow:hidden;");  
          }).removeClass('actived');          
      }else{
          $(".bar").removeAttr("style");
          $(".detail_footer_program_editor").animate({height: '230px'}).addClass('actived');
      }
        
    });
    if(!$(".detail_footer_program_editor").hasClass('actived')){
          $(".detail_footer_program_editor").animate({height: '50px'}, 300, function(){
            $(".bar").attr("style","overflow:hidden;");  
          });          
      }
});
</script>