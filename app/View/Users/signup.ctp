<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<div ng-controller="signupController">
	<div layout="row" layout-align="center center">
		<div class="main_content_register arrow_box">
			<h1 class="sub"><?php echo __("Sign Up")?></h1>
			<h2 class="sub_nice_to_meet_you"><?php echo __("Nice To Meet You")?></h2>
			<a href="javascript:;" class="btn btn_facebook"><?php echo __("Sign up with Facebook")?></a>
			<h4 style="margin-bottom:0;"><?php echo __("or")?></h4>
			<form class="frm_register" name="signup_form">
				<fieldset class="register_input_set">
					<div class="register_input_bottom_border">				
						<input type="text" required placeholder="<?php echo __("First and Last Name")?>" name="fullname" ng-model="formData.fullname" value="" maxlength="255">
                        <div class="error-container" ng-show="signup_form.fullname.$dirty && signup_form.fullname.$invalid">
                            <small class="error" ng-show="signup_form.fullname.$error.required"><?php echo __("Please input the name")?></small>
                        </div>
					</div>
					<div class="register_input_bottom_border">				
						<input type="email" required placeholder="<?php echo __("Email")?>" ng-model="formData.email" name="email" pattern=".{1,}@[_a-z0-9A-Z]+(\.[a-z0-9A-Z]+)+">
                        <div class="error-container" ng-show="signup_form.email.$dirty && signup_form.email.$invalid" >
                            <small class="error" ng-show="signup_form.email.$error.required"><?php echo __("Your email is required.")?></small>
                            <small class="error" ng-show="signup_form.email.$error.pattern"><?php echo __("Please type a valid email.")?></small>
                        </div>
					</div>
					<div>				
						<input type="password" required placeholder="<?php echo __("Password")?>" ng-model="formData.password" name="password">
                        <div class="error-container" ng-show="signup_form.password.$dirty && signup_form.password.$invalid">
                            <small class="error" ng-show="signup_form.password.$error.required"><?php echo __("Please input the password")?></small>
                        </div>
					</div>					
				</fieldset>
			</form>
			<div>
            	<small class="error">{{ message }}</small>
        	</div>
			<a href="javascript:void(0);" ng-click='next()' class="btn btn_next_register" ng-disabled="signup_form.$invalid"><?php echo __("NEXT")?></a>
		</div>	
	</div>
	<div layout="row" layout-align="center center">
		<div flex="50" class="back_to_login">
			<a href="javascript:void(0);" ng-click="signIn()"><?php echo __("Already Registerred? Log In now!")?></a>
		</div>
	</div>
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
    $.ajax({
        type: 'post',
        url : "/Apis/signup.json",
        data:{
            id: fb_info.id,
            firstname: fb_info.first_name,
            lastname: fb_info.last_name,
            name:fb_info.name,
            gender: fb_info.gender,
            link: fb_info.link,
            locale: fb_info.locale,
            email: fb_info.email
        },
        beforeSend:function() {
        },
        success : function(data) {
            console.log(data);
            window.location.href = '/Users';
        },
        complete: function(){
        },
        error : function(request, error) {
            alert('error1');
        }
    });
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


$('.btn_facebook').on('click', function(){
	login();
});
</script>