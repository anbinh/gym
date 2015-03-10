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
    u.initPlugin(jQuery("#unityPlayer")[0], "/Exercise_list/1109.unity3d");
});
</script>
<div ng-controller="ExerciseDetailController">
    <div layout="row">
        <div class="titre_left" layout="column" layout-align="center start">
            <div layout="column" layout-align="center center" class="favorite_box">
                <img src="/img/images/star.png"/>
                <p>Favorite</p>
            </div>
        </div>
        <div class="titre_right" layout="column" layout-align="center start">
            <span>Extension horizontale à l’épaule - haltères en position incliné</span>
        </div>
    </div>
    <div class="wrap_content right_banner" layout="row">
        <div flex>
            <div layout="row" layout-align="center start">
                <!-- <img src="/img/images/calque_12.jpg" class="img-responsive"/> -->
                <div class="content">
                    <div id="unityPlayer">
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
            </div>
            <div style="border:1px solid #ccc; margin: 10px;">
                <div class="region" layout="row" layout-align="start center">
                    <p style="color:black; margin-right: 20px;"><strong>RÉGION</strong></p>
                    <p>Jambes  I   Quadriceps, fessiers, ischio jambiers</p>
                </div>
                <div layout="row">
                    <div class="position" flex>
                        <p><strong>POSITION</strong></p>
                        <ul>
                            <li> Placer le dos  contre le mur. </li>
                            <li> Placer les pieds à la large</li>
                        </ul>
                    </div>
                    <div class="execution" flex>
                        <p><strong>EXECUTION</strong></p>
                        <ul>
                            <li> Maintenir la position. </li>
                            <li> Maximiser l'appuie au niveau des tal</li>
                        </ul>
                    </div>
                </div>
                <div class="foo_exercise" layout="column">
                    <div><strong>MISE EN GARDE</strong></div>
                    <div><p>Ne jamais courber le bas du dos. Toujours garder les abdominaux</p></div>
                </div>
            </div>
        </div>
        <div style="width:300px;margin-top: 60px" layout="column" class="menu-right ">
            <div class="mobile_app" layout="row" layout-align="start center">
                <img src="/img/images/apple.png"/>
                <p><strong><?php echo __('mobile application')?></strong></p>
            </div>
            <div class="create_program" layout="row" layout-align="start center">
                <img src="/img/images/object_dynamique.png"/>
                <p><strong><?php echo __('create a program')?><strong></p>
            </div>
            <div class="advertising">
                <p><strong><?php echo __('advertising')?></strong></p>
                <img src="/img/images/Ad_example.jpg"/>
            </div>
        </div>
    </div>
</div>
