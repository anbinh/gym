<div class="UserIndexLeftContent">                
    <div layout="row">            
        <div class="list_program_view" class="row">
            <?php $i = 0;?>
            <?php foreach($content['exercise_list'] as $key=>$item):?>
                <?php $i++;?>                
                <?php if($item['mode']==1):?>   <!-- regular-->             
                    <?php echo $this->Element('template_regular_view', array('index'=>$key, 'item'=>$item, 'exercise_list'=>$exercises_list));?>                    
                <?php endif;?>
                <?php if($item['mode']==2):?>  <!-- stretching-->             
                    <?php echo $this->Element('template_stretching_view', array('index'=>$key, 'item'=>$item, 'exercise_list'=>$exercises_list));?>                    
                <?php endif;?>
                <?php if($item['mode']==3):?>  <!-- super-set-->             
                    <?php echo $this->Element('template_superset_view', array('index'=>$key, 'item'=>$item, 'exercise_list'=>$exercises_list));?>                    
                <?php endif;?>
                 <?php if($item['mode']==4):?> <!-- with-note-->             
                    <?php echo $this->Element('template_withnote_view', array('index'=>$key, 'item'=>$item, 'exercise_list'=>$exercises_list));?>                    
                <?php endif;?>                
                <?php if($item['mode']==5):?>
                    <?php echo $this->Element('template_onlytext_view', array('index'=>$key, 'item'=>$item, 'exercise_list'=>$exercises_list));?>                    
                <?php endif;?>
            <?php endforeach;?>            
                      
        </div>                        
    </div>
</div>