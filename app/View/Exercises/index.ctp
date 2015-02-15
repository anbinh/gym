<div layout="row">
    <span class="musculation">Musculation</span>
    <span class="stretching">Stretching</span>
    <select>
        <option>Part</option>
    </select>
</div>
<div layout="row">
    <div ng-controller="ExercisesController" flex>       
        <div layout="row">
            <div flex>
                <div class="list_tile" class="row">
                    <?php foreach($exercises as $item):?>
                        <!-- <div class="program_box">
                            <div class="user_favorite_exercise_img test1" flex style="margin:5px; border:1px solid #ccc;background-image: url('/img/images/6035.jpeg')">
                                <div style="padding:5px;"><img src="/img/images/star.png"></div>
                            </div>
                        </div> -->
                        <div class="col-sm-6 col-md-4 col-lg-3 exercise_box">
                            <div class="user_favorite_exercise_img" flex style="background-image: url('/img/images/6035.jpeg')">
                                <div style="padding:5px;"><img src="/img/images/star.png"></div>
                            </div>
                        </div>                   
                    <?php endforeach;?>
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