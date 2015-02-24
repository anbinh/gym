<script>
    var  id = '<?php echo isset($profile['id']) ? $profile['id'] : 0  ?>';
    $(function(){
        $("#upload_link").on('click', function(e){
            e.preventDefault();
            $("#upload").trigger('click');
        });
        $("#id").val(id);
    });
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
        };

        // read selected file as DataURL
        oReader.readAsDataURL(oFile);
    }
</script>

<div class="wrap_content right_banner" layout="row" ng-controller="UserProfileController">
	<div flex>
		<div layout-align="center start">
            <?php
            echo $this -> Form -> create('User',
                array('enctype' => 'multipart/form-data',
                    'class' => 'form-horizontal user_profile',
                    'url' => '/Users/save_profile',
                    'id' => 'userProfileForm')); ?>
			<!--<form action="/Users/save_profile" class="user_profile" enctype="multipart/form-data">-->
                <input type="hidden" name="data[User][id]" id="id" ng-model="formData.id">
                <div layout="row">
                <div flex="33">
                    <div id="AccountImage" class="add_picture_box" ng-style="{'background-image':'url('+imgURL+')'}">
                        <!--<img id="AccountImage" src="" class="add_picture_img">-->
                        <input id="upload" type="file" name="picture" ng-model="formData.picture" onchange='fileSelected()'/>
                        <div id="btn_add_picture" ng-class='getClassBtnAddPicture(isHasPicture)' style="padding-top: 110px;">
                            <a href="javascript:void(0);" class="btn_add_picture" id="upload_link">Add picture</a>
                        </div>
                    </div>
                </div>
                <div flex="67">
                    <div class="input_row_register">
                        <label>User Name</label>
                        <input class="input_textbox" type="text" name="data[User][login]" ng-model="formData.login">
                    </div>
                    <div class="input_row_register">
                        <label>Email Address</label>
                        <input class="input_textbox" type="text" name="data[User][email]" ng-model="formData.email">
                    </div>
                    <div class="input_row_register">
                        <label>First Name</label>
                        <input class="input_textbox" type="text" name="data[User][firstname]" ng-model="formData.firstname">
                    </div>
                    <div class="input_row_register">
                        <label>Last Name</label>
                        <input class="input_textbox" type="text" name="data[User][lastname]" ng-model="formData.lastname">
                    </div>
                    <div class="input_row_register">
                        <label>Gender</label>
                        <input type="radio" name="data[User][sex]" value="1" ng-model="formData.sex"> Men
                        <input type="radio" name="data[User][sex]" value="0" ng-model="formData.sex"> Women
                    </div>
                    <div class="input_row_register">
                        <label>Language</label>
                        <input class="input_textbox" type="test" name="data[User][language]" ng-model="formData.language">
                    </div>
                    <div class="input_row_register">
                        <label>Location</label>
                        <input class="input_textbox" type="text" name="data[User][address][street]" ng-model="formData.address.street">
                    </div>
                    <div class="input_row_register">
                        <label>Birthday</label>
                        <input class="input_textbox" type="date" name="data[User][birthday]" ng-model="formData.birthday">
                    </div>
                    <div class="input_row_register_fb">
                        <label>Your Password</label>
                        <a href="#" class="btn btn_change_pass">Change Password</a>
                    </div>
                    <div class="input_row_register_fb">
                        <label>Facebook</label>
                        <a href="#" class="btn btn_facebook_user_profile">Connect Facebook</a>
                    </div>
                    <div class="input_row_register">
                        <label>Promotion Email</label>
                        <input id="cb" type="checkbox" name="data[User][receive_promote]" ng-model="formData.receive_promote"> Receive promotion emails
                    </div>
                    <hr>
                    <div class="input_row_save_cancel" layout="row">
                        <div flex><input type="submit" value="SAVE" class="btn btn_change_save"></div>
                        <div flex><a href="javascript:void(0);" class="btn btn_change_cancel" ng-click='cancel()'>CANCEL</a></div>
                    </div>
                    <p style="font-weight:bold;">To remove your Keep account please <a href="javascript:void(0);" style="color:#ccc; text-decoration:none;">click here.</a></p>
                </div>
                </div>
			<!--</form>-->
            <?php echo $this -> Form -> end();?>
		</div>		
	</div>	
	<div style="width:300px;" class="advertisement" layout="column">		
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
