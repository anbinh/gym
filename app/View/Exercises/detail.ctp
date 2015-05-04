<script src="http://connect.facebook.net/en_US/all.js"></script>
<?php if(!isset($is_mobile) && $exercise['Exercise']['category_id'] != 2) {?>
    <script type="text/javascript">
    var config = {
                    width: 480,
                    height: 350,
                    params: { enableDebugging:"0" }

                };
    var u = new UnityObject2(config);
    jQuery(function() {

        var $missingScreen = jQuery("#unityPlayer").find(".missing");
        var $brokenScreen = jQuery("#unityPlayer").find(".broken");
        $missingScreen.hide();
        $brokenScreen.hide();

        u.observeProgress(function (progress) {
            switch(progress.pluginStatus) {
                case "broken":
                    $brokenScreen.find("a").click(function (e) {
                        e.stopPropagation();
                        e.preventDefault();
                        u.installPlugin();
                        return false;
                    });
                    $brokenScreen.show();
                break;
                case "missing":
                    $missingScreen.find("a").click(function (e) {
                        e.stopPropagation();
                        e.preventDefault();
                        u.installPlugin();
                        return false;
                    });
                    $missingScreen.show();
                break;
                case "installed":
                    $missingScreen.remove();
                break;
                case "first":
                break;
            }
        });
        u.initPlugin(jQuery("#unityPlayer")[0], "<?php echo $exercise['Exercise']['web_player']; ?>");
    });
    </script>
<?php } ?>
<div ng-controller="ExerciseDetailController">
    <div layout="row" style="border-bottom: 1px solid #ccc;">
        <div class="titre_left" layout="column" layout-align="center start">
            <div layout="column" layout-align="center center" class="favorite_box">
                <img class="img_star"
                     ng-src="{{getImage()}}"
                     ng-click="toggleSelection()"
                    >
                <p>Favorite</p>
            </div>
        </div>
        <div class="titre_right" layout="column" layout-align="center start">
            <span><?php echo $exercise['Exercise']['name'];?></span>
        </div>
    </div>
    <div class="wrap_content right_banner" layout="row">
        <div flex>
            <div layout="row" layout-align="center start">
                <?php if($exercise['Exercise']['category_id'] == 2) {?>
                    <img src="<?php echo $exercise['Exercise']['photo'];?>" class="img-responsive"/>
                <?php }else{
                if(!isset($is_mobile)) { ?>
                    <div class="content">
                        <div id="unityPlayer" style="z-index: 0;">
                            <div class="missing">
                                <a href="http://unity3d.com/webplayer/" title="Unity Web Player. Install now!">
                                    <img alt="Unity Web Player. Install now!" src="http://webplayer.unity3d.com/installation/getunity.png" width="193" height="63" />
                                </a>
                            </div>
                            <div class="broken">
                                <a href="http://unity3d.com/webplayer/" title="Unity Web Player. Install now! Restart your browser after install.">
                                    <img alt="Unity Web Player. Install now! Restart your browser after install." src="http://webplayer.unity3d.com/installation/getunityrestart.png" width="193" height="63" />
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <video class="img-responsive" controls="true" autoplay="autoplay" src="<?php echo $exercise['Exercise']['video']; ?>" poster="<?php echo $exercise['Exercise']['photo']; ?>"></video>
                <?php }}?>
            </div>
            <div style="border:1px solid #ccc; margin: 10px;">
                <div class="region" layout="row" layout-align="start center">
                    <p style="color:black; margin-right: 20px; margin-top:15px;"><?php echo __('Body Part');?></p>
                    <p style="margin-top:15px;">
                        <?php 
                        $muscle_text = '';
                        $bodypart_text = '';      
                        $body_field = 'body_path_text'; 
                        if($language == 'fr')     
                             $body_field = 'body_path_text_fr';            
                        foreach($exercise['Exercise']['muscle'] as $key=>$muscle):
                            $pos = strrpos($bodypart_text, $muscle[$body_field]);
                            if($pos === false)
                            {
                                $bodypart_text = $bodypart_text . $muscle[$body_field];
                                $bodypart_text .= ", ";
                            }
                                
                            $muscle_text = $muscle_text .$muscle['name'];
                            if($key != count($exercise['Exercise']['muscle'])-1){
                                $muscle_text .= ", ";
                            }                           
                        endforeach;     
                        $bodypart_text = substr($bodypart_text,0,-2);              
                        echo $bodypart_text." | ".$muscle_text;
                        ?>
                    </p>
                </div>
                <div layout="row">
                    <div class="position" flex>
                        <p><?php echo __('Position');?></p>
                        <ul>
                            <?php                                 
                                $postures = split("\.", $exercise['Exercise']['posture']);                             
                                foreach($postures as $posture){
                                    if($posture != ''){
                                        echo "<li>".$posture.".</li>";    
                                    }                                    
                                }
                            ?>                          
                        </ul>
                    </div>
                    <div class="execution" flex>
                        <p><?php echo __('Execution');?></p>
                        <ul>
                            <?php                                 
                                $executions = split("\.", $exercise['Exercise']['execution']);                             
                                foreach($executions as $execution){
                                    if($execution != ''){
                                        echo "<li>".$execution.".</li>";    
                                    }                                    
                                }
                            ?>  
                        </ul>
                    </div>
                </div>
                <div class="foo_exercise" layout="column">
                    <div><?php echo __('Care');?></div>
                    <div><p><?php echo $exercise['Exercise']['care'];?></p></div>
                </div>
            </div>
        </div>
       <?php echo $this->element('right_advs');?>
    </div>
</div>
