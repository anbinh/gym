<div class="UserIndexLeftContent">                
    <div layout="row">            
        <div class="list_program_view" class="row">
            <?php foreach($content['exercise_list'] as $item):?>
                <?php if($item['mode']==1):?>
                    <div class="exercise_box">
                        <div class="box_program_vew">                           
                            <div class="sequence_number_box">
                                <p>1</p>
                            </div>
                            <div class="row no_margin" style="padding: 0 40px 0 40px;"> 
                                <img src="/img/images/6035.jpeg" class="img-responsive">
                            </div>
                            <div class="description">
                                <p>Cum autem commodis intervallata  temporibus convivia longa et n copie</p>
                            </div>
                            <div class="serie">
                                <p style="color:#c7c8c9; margin-right:10px;">Serie</p> 
                                <p style="font-size:18px; font-weight:bold; line-height: 1.45; border-right:1px solid; padding-right:5px; margin-right:5px;"> <?php echo $item['exercise_item'][0]['series'];?></p>
                                <p style="color:#bcbdbe; margin-right:10px;">Répétition</p> 
                                <p style="font-size:18px; font-weight:bold; line-height: 1.45;"> <?php echo $item['exercise_item'][0]['repeatation_from'];?> à <?php echo $item['exercise_item'][0]['repeatation_to'];?></p>
                            </div>
                        </div>                            
                    </div>
                <?php endif;?>
                <?php if($item['mode']==2):?>
                     <div class="exercise_box">
                        <div class="box_program_vew">   
                            <div class="sequence_number_box">
                                <p>1 Etrement</p>
                            </div>                    
                            <div class="row no_margin" style="padding: 0 10px 0 10px;"> 
                                <div class="col-xs-6 no_padding">
                                    <div class="small_box"></div>
                                </div>
                                <div class="col-xs-6 no_padding">
                                    <div class="small_box"></div>
                                </div>
                                <div class="col-xs-6 no_padding">
                                    <div class="small_box"></div>
                                </div>
                                <div class="col-xs-6 no_padding">
                                    <div class="small_box"></div>
                                </div>
                            </div>
                            <div class="serie">
                                <p style="color:#c7c8c9; margin-right:10px;">Serie</p> 
                                <p> <?php echo $item['text'];?></p>
                            </div>                    
                        </div>                            
                    </div> 
                <?php endif;?>
                <?php if($item['mode']==4):?>
                    <div class="exercise_box">
                        <div class="box_program_vew">                           
                            <div class="sequence_number_box" style="float:left;">
                                <p>4</p>
                            </div>
                            <div>
                                <div style="position:relative; padding-top:3px;">
                                    <div class="small_box" style="width:90px; float:left;"></div>                            
                                    <div>
                                        <p style="color:#c7c8c9; margin:0px; line-height:1;">Serie</p> 
                                        <p style="font-size:18px; font-weight:bold; line-height: 1.2; margin:0;"> 10</p>
                                    </div>
                                    <div style="padding-top:5px;">
                                        <p style="color:#bcbdbe; margin:0px; line-height:1;">Répétition</p> 
                                        <p style="font-size:18px; font-weight:bold; line-height: 1.2; margin:0;"> 15 à 20</p>
                                    </div>
                                </div>      
                                <div class="description">
                                    <p>Cum autem commodis intervallata  temporibus convivia longa et n copie</p>
                                </div>
                                <div style="position:relative;padding-left:14px; padding-top:3px;">
                                    <div class="small_box" style="width:90px; float:left;"></div>                            
                                    <div>
                                        <p style="color:#c7c8c9; margin:0px; line-height:1;">Serie</p> 
                                        <p style="font-size:18px; font-weight:bold; line-height: 1.2; margin:0;"> 10</p>
                                    </div>
                                    <div style="padding-top:5px;">
                                        <p style="color:#bcbdbe; margin:0px; line-height:1;">Répétition</p> 
                                        <p style="font-size:18px; font-weight:bold; line-height: 1.2; margin:0;"> 15 à 20</p>
                                    </div>
                                </div>   
                                <div class="description">
                                    <p>Cum autem commodis intervallata  temporibus convivia longa et n copie</p>
                                </div>                    
                            </div>                    
                        </div>                            
                    </div>
                <?php endif;?>
                <?php if($item['mode']==5):?>
                    <div class="exercise_box">
                        <div class="box_program_vew">                           
                            <div class="sequence_number_box">
                                <p>3</p>
                            </div>
                            <div class="row no_margin" style="padding: 0 40px 0 40px;"> 
                                <img src="/img/images/6035.jpeg" class="img-responsive">
                            </div>
                            <div class="description">
                                <p>Cum autem commodis intervallata  temporibus convivia longa et n copie</p>
                            </div>
                            <div class="serie">
                                <p style="color:#c7c8c9; margin-right:10px;">Serie</p> 
                                <p> Tenir 8 secondes</p>
                            </div>
                        </div>                            
                    </div>
                <?php endif;?>
            <?php endforeach;?>            
                      
        </div>                        
    </div>
</div>