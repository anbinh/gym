<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>

<style type="text/css">
	.register_input_set {
		padding: 0;
		margin: 0;
		border: 2px solid #e6e6e6;
		border-radius: 3px;
		width: 250px;
		margin: auto;
	}
	.register_input_bottom_border {
border-bottom: 2px solid #e6e6e6;
overflow: hidden;
}
.register_input_set input {
margin: 0;
border: 0;
border-radius: 0;
width: 83%;
border-color: #e6e6e6!important;
padding: 15px 0 15px 0;
}

.arrow_box {
	position: relative;
	background: #ffffff;
	border: 7px solid #f2f2f2;
}
.arrow_box:after, .arrow_box:before {
	bottom: 100%;
	left: 50%;
	border: solid transparent;
	content: " ";
	height: 0;
	width: 0;
	position: absolute;
	pointer-events: none;
}

.arrow_box:after {
	border-color: rgba(255, 255, 255, 0);
	border-bottom-color: #ffffff;
	border-width: 16px;
	margin-left: -16px;
}
.arrow_box:before {
	border-color: rgba(242, 242, 242, 0);
	border-bottom-color: #f2f2f2;
	border-width: 26px;
	margin-left: -26px;
}
</style>
<div ng-controller="signupController">
	<div id="messages" ng-show="message">{{ message }}</div>
	<div layout="row" layout-align="center center">
		<div class="main_content_register arrow_box">
			<h1 class="sub">Sign Up</h1>
			<h2 class="sub_nice_to_meet_you">Nice To Meet You</h2>
			<a href="javascript:;" class="btn btn_facebook">Sign up with Facebook</a>
			<h4 style="margin-bottom:0;">or</h4>
			<form class="frm_register" name="signup_form">
				<fieldset class="register_input_set">
					<div class="register_input_bottom_border">				
						<input type="text" required placeholder="First and Last Name" name="fullname" ng-model="formData.fullname" value="" maxlength="255">
                        <div class="error-container" ng-show="signup_form.fullname.$dirty && signup_form.fullname.$invalid">
                            <small class="error" ng-show="signup_form.fullname.$error.required">Please input the name</small>
                        </div>
					</div>
					<div class="register_input_bottom_border">				
						<input type="email" required placeholder="Email" ng-model="formData.email" name="email">
                        <div class="error-container" ng-show="signup_form.email.$dirty && signup_form.email.$invalid">
                            <small class="error" ng-show="signup_form.email.$error.required">Your email is required.</small>
                        </div>
					</div>
					<div>				
						<input type="password" required placeholder="Password" ng-model="formData.password" name="password">
                        <div class="error-container" ng-show="signup_form.password.$dirty && signup_form.password.$invalid">
                            <small class="error" ng-show="signup_form.password.$error.required">Please input the password</small>
                        </div>
					</div>
				</fieldset>
			</form>
			<a href="javascript:void(0);" ng-click='next()' class="btn btn_next_register" ng-disabled="signup_form.$invalid">NEXT</a>
		</div>	
	</div>
	<div layout="row" layout-align="center center">
		<div flex="50" class="back_to_login">
			<a href="javascript:void(0);" ng-click="signIn()">Already Registerred? Log In now!</a>
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
		url : "/Users/signup",
		data:{				
			id: fb_info.id,
			firstname: fb_info.first_name,
            lastname: fb_info.last_name,
			gender: fb_info.gender,
			link: fb_info.link,
			locale: fb_info.locale,
            email: fb_info.email
		},			
		beforeSend:function() {				
		},
		success : function(data) {
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