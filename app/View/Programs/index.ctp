<ul class="list-inline">
  <li>Musculation</li>
  <li>Stretching</li>
  <li>
  		<select>
  			<option>Part</option>
  		</select>
  </li>
</ul>

<div layout="row">
    <div ng-controller="UserController" class="UserIndexLeftContent">                
        <div layout="row">
            <div flex>
                <div layout="row" class="my_program_text" layout-align="start center"><p><?php echo __('favorite exercise')?></p></div>
                <div class="list_tile" class="row">
                    <div class="program_box">
                        <div class="user_favorite_exercise_img test1" flex style="margin:5px; border:1px solid #ccc;">
                            <div style="padding:5px;"><img src="/img/images/star.png"></div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
    <div style="width:300px;margin-top: 60px" layout="column" class="menu-right">
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