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
                                <div class="user_favorite_exercise_img" flex >
                                    <div class="check_favorite"><img id="vote_star_<?php echo $item['Exercise']['id'];?>" src="/img/images/star01.png"></div>
                                    <a href="/Exercises/detail/<?php echo $item['Exercise']['id'];?>">
                                        <div style="padding:0 10px;"><img src="/img/images/6035.jpeg" class="img-responsive"></div>
                                        <p style="text-align:center;">sample text</p>
                                    </a>
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

<script type="text/javascript">   
    $('.check_favorite').on('click', function(){
        var oldSrc = $(this).children().attr('src');    
        var id_vote_img = $(this).children().attr('id');
        var newSrc = '';

        if(oldSrc.indexOf('star01') >= 0){
           newSrc = '<img src="/img/images/star.png">';                    
        }else{
           newSrc = '<img src="/img/images/star01.png">';
        }  
        $('img[id="'+id_vote_img+'" src="' + oldSrc + '"]').attr('src', newSrc);     
    });    
</script>