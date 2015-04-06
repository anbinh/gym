<script src="http://connect.facebook.net/en_US/all.js"></script>
<style type="text/css">
 .tabsdemoDynamicTabs .sample {
  height: 500px; }
.tabsdemoDynamicTabs .remove-tab {
  margin-bottom: 40px; }
.tabsdemoDynamicTabs .demo-tab {
  height: 300px;
  text-align: center; }
.tabsdemoDynamicTabs .demo-tab button {
  margin-bottom: 40px; }
.tabsdemoDynamicTabs md-tabs, .tabsdemoDynamicTabs md-tabs .md-header {
  border-bottom: 1px solid #D8D8D8; }
.tabsdemoDynamicTabs md-tab[disabled] {
  opacity: 0.5; }
.tabsdemoDynamicTabs .md-tab-content {
  background: white; }
.tabsdemoDynamicTabs .title {
  padding-top: 8px;
  padding-right: 8px;
  text-align: left;
  text-transform: uppercase;
  color: #888;
  margin-top: 24px; }
.tabsdemoDynamicTabs [layout-align] > * {
  margin-left: 8px; }
.tabsdemoDynamicTabs form > [layout] > * {
  margin-left: 8px; }
.tabsdemoDynamicTabs form > [layout] > span {
  padding-top: 2px; }
.tabsdemoDynamicTabs .long > input {
  width: 264px; }
.tabsdemoDynamicTabs .md-button.add-tab {
  margin-top: 20px;
  max-height: 30px !important; }

md-tabs-ink-bar{
    height: 7px;
    top: 0px !important;
}
md-tabs.md-default-theme md-tabs-ink-bar {
    color: black;
    background: black;
}
.program_tab{
    background: #d8e6dc;
    border: 1px solid #d8e6dc;
    margin-top: 20px;
}
.program_tab md-tabs.md-default-theme md-tab{
  color: grey;
}
.program_tab md-tabs.md-default-theme md-tab.active{
    background: #d8e6dc;  
    border: 0; 
    color: black;
    font-weight: bold;
}
.program_tab md-tab{
    border: 1px solid #d8e6dc;    
}
.program_tab md-tabs.md-default-theme .md-header{
    background: white;
}
.program_tab .md-header{
  width: 80%;
  margin-left: 10px;
}
</style>

<div layout="row" layout-align="center start">
    <div ng-controller="ProgramController" flex class="ProgramIndexLeftContent">
        <div layout="column" class="summary_program">
            <div layout="row" class="header_program" layout-wrap>
                <div flex="20"  style="padding-left:10px;">
                    <div class="program_logo_topic" style="background-color: <?php echo $programs['Program']['color_code']?>">
                        <div style="text-align:center;"><img class="img_program_view" src="/img/images/<?php echo $programs['Program']['photo']?>"></div>
                        <div class="program_view_text_name"> <?php echo $programs['Program']['name']?></div>
                    </div>
                </div>
                <div flex layout-align="end end" style="text-align: end; margin-right:15px;">                    
                    <?php if($isSaved):?>
                      <input disabled type="button" class="btn btn_save_program" value="<?php echo __('Save');?>">
                    <?php else:?>
                      <input ng-click="save_program('<?php echo $programs['Program']['id']?>');" type="button" class="btn btn_save_program" value="<?php echo __('Save');?>">
                    <?php endif;?>
                </div>
            </div>
            <div layout="row">
                <div flex id="program_header_content">
                    <div class="title_program">
                        Intentse work on the buttocks and thighs
                    </div>
                    <div class="content_program">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed no Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed no Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed no</div>
                    <div class="sharing_program_social_fb"><img src="/img/images/facebook_icon.png"/> </div>
                    <div class="sharing_program_social_twitter"><img src="/img/images/twitter_icon.png"/></div>
                    <div class="sharing_program_link"><span><a href="#">Share</a></span></div>
                </div>
            </div>
        </div>

        <div class="program_tab" layout="column">
          <md-tabs md-selected="selectedIndex" flex>
            <?php foreach($programs['Program']['content'] as $content):?>
                <md-tab label="<?php echo __("Day").' '.$content['day_number'];?>">
                  <?php echo $this->Element('exercise_stretching', array('content'=>$content));?>
                </md-tab>              
            <?php endforeach;?>
          </md-tabs>              
        </div>
    </div>   
    <div style="margin-top:52px;"> 
      <?php echo $this->element('right_advs');?>    
    </div>
</div>
