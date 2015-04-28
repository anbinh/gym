<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places" type="text/javascript"></script>
<script>
    var  id = '<?php echo isset($profile['id']) ? $profile['id'] : 0  ?>';    
    $(function(){
        $("#upload_link").on('click', function(e){
            e.preventDefault();
            $("#upload").trigger('click');
        });
        $("#id").val(id);
        initAutoCompleteAddress();
    });
    function initAutoCompleteAddress () {
        var input = document.getElementById('address');
        var autocomplete = new google.maps.places.Autocomplete(input);
    }
    function fileSelected() {
        // get selected file element
        var oFile = document.getElementById('upload').files[0];
        var oImage = $('#AccountImage');
        // prepare HTML5 FileReader
        var oReader = new FileReader();
        oReader.onload = function(e) {
            // e.target.result contains the DataURL which we will use as a source of the image
            /*oImage.attr("src",e.target.result);*/
            oImage.css('background-image', 'url(' + e.target.result + ')');
            $('#btn_add_picture').css('padding-top', '210px');
            $('#btn_add_picture a').html("<?php echo __("Edit Picture")?>");
        };

        // read selected file as DataURL
        oReader.readAsDataURL(oFile);
    }
</script>

<div class="right_banner" layout="row" ng-controller="UserProfileController">
	<div flex>
		<div layout-align="center start" style="border-bottom: 1px solid #ccc;">
            <?php
            echo $this -> Form -> create('User',
                array('enctype' => 'multipart/form-data',
                    'class' => 'form-horizontal user_profile',
                    'url' => '/Users/save_profile',
                    'id' => 'userProfileForm')); ?>
			<!--<form action="/Users/save_profile" class="user_profile" enctype="multipart/form-data">-->
                <input type="hidden" name="data[User][id]" id="id" ng-value="id">
                <input type="hidden" name="data[User][picture]" id="picture_fb" ng-value="picture">
                <input type="hidden" name="data[User][fb_id]" id="fb_id" ng-value="fb_id">
                <input type="hidden" name="data[User][password]" id="password" ng-value="password">
                <div layout-gt-md="row" layout-md="column" layout-gt-sm="column" layout-sm="column">
                    <div class="picture_box">
                        <div id="AccountImage" class="add_picture_box" ng-style="{'background-image':'url('+imgURL+')'}">
                            <input id="upload" type="file" name="picture" ng-model="formData.picture" onchange='fileSelected()'/>
                            <div id="btn_add_picture" ng-class='getClassBtnAddPicture(isHasPicture)' style="padding-top: 110px;">
                                <a href="javascript:void(0);" class="btn_add_picture" id="upload_link"><?php echo __("Edit Picture")?></a>
                            </div>
                        </div>
                    </div>
                    <div class="form_register">
                        <div class="input_row_register">
                            <label><?php echo __("User Name")?></label>
                            <div>
                                <input class="input_textbox" type="text" name="data[User][login]" ng-model="formData.login">
                            </div>
                        </div>
                        <div class="input_row_register">
                            <label><?php echo __("Email Address")?></label>
                            <input id="email" class="input_textbox" type="text" name="data[User][email]" ng-model="formData.email">
                        </div>
                        <div class="input_row_register">
                            <label><?php echo __("First Name")?></label>
                            <input id="firstname" class="input_textbox" type="text" name="data[User][firstname]" ng-model="formData.firstname">
                        </div>
                        <div class="input_row_register">
                            <label><?php echo __("Last Name")?></label>
                            <input id="lastname" class="input_textbox" type="text" name="data[User][lastname]" ng-model="formData.lastname">
                        </div>
                        <div class="input_row_register">
                            <label><?php echo __("Gender")?></label>
                            <input id="sexMen" type="radio" name="data[User][sex]" value="1" ng-model="formData.sex"> <?php echo __("Men")?>
                            <input id="sexWomen" type="radio" name="data[User][sex]" value="0" ng-model="formData.sex"> <?php echo __("Women")?>
                        </div>
                        <div class="input_row_register">
                            <label><?php echo __("Language")?></label>
                            <select class="input_select input_location"
                                    name="data[User][language]"
                                    id="language"
                                    ng-model="formData.language" 
                                    ng-init="formData.language || options[0]"
                                    ng-options="option.name for option in options track by option.value">
                            </select>                        
                        </div>
                        <div class="input_row_register">
                            <label><?php echo __("Location")?></label>
                            <input id="address" class="input_textbox input_location" type="text" name="data[User][address][street]" ng-model="formData.address.street">
                        </div>
                        <div class="input_row_register">
                            <label><?php echo __("Birthday")?></label>
                            <!-- <input class="input_textbox" type="date" name="data[User][birthday]" ng-model="formData.birthday"> -->
                            <select class="input_select input_location"
                                    name="data[User][day]"
                                    ng-model="day" 
                                    ng-init="day || optionDays[0]"
                                    ng-options="option.name for option in optionDays track by option.value">
                            </select>
                            <select class="input_select input_location"
                                    name="data[User][month]"
                                    ng-model="month" 
                                    ng-init="month || optionMonths[0]"
                                    ng-options="option.name for option in optionMonths track by option.value">
                            </select>
                            <select class="input_select input_location"
                                    name="data[User][year]"
                                    ng-model="year" 
                                    ng-init="year || optionYears[0]"
                                    ng-options="option.name for option in optionYears track by option.value">
                            </select>
                        </div>
                        <div class="input_row_register_fb">
                            <label><?php echo __("Your Password")?></label>
                            <a href="javascript:void(0);" class="btn btn_change_pass" ng-click="changePassword()">
                                <?php if(isset($profile['id']))
                                        echo __("Change Password");
                                     else
                                        echo __("Set Password");
                                ?></a>
                        </div>
                        <div class="input_row_register_fb">
                            <label><?php echo __("Facebook")?></label>
                            <!--<a href="#"><p class="logo">Facebook</p></a>-->
                            <a id="btn_facebook" class="btn btn-social btn-facebook btn-fb-profile" href="javascript:void(0);">
                                <i class="fa fa-facebook"></i>
                                <?php echo __("Connect Facebook")?>
                            </a>
                        </div>
                        <div class="input_row_register">
                            <label><?php echo __("Promotion Email")?></label>
                            <div class="right_input_edit_profile">
                                <input id="cb" type="checkbox" name="data[User][receive_promote]" ng-model="formData.receive_promote"><?php echo __("Receive promotion emails")?>
                            </div>
                        </div>
                        <hr>
                        <div class="input_row_save_cancel" layout="row">
                            <div flex="40"><input type="submit" value="<?php echo __("SAVE")?>" class="btn btn_change_save"></div>
                            <div flex="40"><a href="javascript:void(0);" class="btn btn_change_cancel" ng-click='cancel()'><?php echo __("CANCEL")?></a></div>
                        </div>
                        <p style="font-weight:bold;"><?php echo __("To remove your Keep account please")?> <a href="javascript:void(0);" style="color:#ccc; text-decoration:none;"><?php echo __("click here")?>.</a></p>
                    </div>
                </div>
			<!--</form>-->
            <?php echo $this -> Form -> end();?>
		</div>
        <div layout="row">
            <div flex style="padding-bottom: 10px; border-bottom: 1px solid #ccc;">
                <div class="my_program">
                    <div class="my_program_text" layout="row" layout-align="start center"><div class="arrow_click" ng-class="isProgramShow ? 'arrow_down' : 'arrow_right'" ng-click="toggleMyProgram()"></div><p><?php echo __('my program')?></p>
                        <a class="edit_text" ng-click="editProgram()" style="padding-left:10px;" href="javascript:void(0);"> <?php echo __('edit')?></a></div>
                    <div ng-show="isProgramShow" class="list_tile" class="row" 
                        dnd-list="list_program_saved"   
                        >                        
                            <?php echo $this->element('program_box_template');?>
                    </div>
                </div>
            </div>
        </div>
        <div layout="row">
            <div flex>
                <div layout="row" class="my_program_text" layout-align="start center"><div class="arrow_click" ng-class="isExerciseShow ? 'arrow_down' : 'arrow_right'" ng-click="toggleExercise()"></div><p><?php echo __('favorite exercise')?></p></div>
                <div ng-show="isExerciseShow" class="list_tile" class="row">
                    <div ng-repeat="exercise in exercises_list" ng-controller="ItemExerciseController">
                        <div class="exercise_box">
                            <?php echo $this->element('exercise_box_template');?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>	
	<?php echo $this->element('right_advs');?>    
</div>
<script type="text/javascript">
    FB.init({
        appId: '607706552694436',
        //appId: '609280322537059', // gym.miratik.com account test
        status: true,
        cookie: true,
        oauth: true
    });
    var userData = null;

    function add_User(fb_info){
        $('#firstname').val(fb_info.first_name);
        $('#lastname').val(fb_info.last_name);
        $('#email').val(fb_info.email);
        if(fb_info.gender == "male")
            $('#sexMen').prop('checked', true);
        else
            $('#sexWomen').prop('checked', true);
        var imageUrl = "//graph.facebook.com/" + fb_info.id + "/picture?type=large";
        $('#AccountImage').css('background-image', 'url(' + imageUrl + ')');
        $('#picture_fb').val(imageUrl);
        $('#fb_id').val(fb_info.id);
    }
    function login()
    {
        FB.login(function(response) {
            if (response.authResponse)
            {
                FB.api('/me', function(response1) {
                    console.log(response1);
                    add_User(response1);
                });
            } else
            {
                console.log('User cancelled login or did not fully authorize.');
            }
        },{scope: 'email,publish_actions,user_friends'});
    }


    $('#btn_facebook').on('click', function(){
        login();
    });
</script>
