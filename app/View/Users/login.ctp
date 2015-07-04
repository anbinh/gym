<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<div ng-controller="LoginController">
    <div layout="row" layout-align="center center">
        <div class="main_content_register arrow_box">            
            <h4 style="font-weight:bold; margin: 40px 30px;"><?php echo __("Login")?></h4>
            <!--<a href="javascript:;" class="btn btn_facebook" style="margin-left:29px;">Login with Facebook</a>-->
            <a id="btn_facebook" class="btn btn-social btn-facebook btn-fb" href="javascript:void(0);">
                <i class="fa fa-facebook"></i>
                <?php echo __("Login with Facebook")?>
            </a>
            <h4 style="margin-left:15px;"><?php echo __("or")?></h4>
            <form class="frm_register" name="signup_form">
                <fieldset style="float:left; border:0 !important;">
                    <div>
                        <div style="max-width:15px; background:black; margin: 18px 11px 16px 0;">
                            <img src="/img/images/icon_user_white.png" class="img-responsive">
                        </div>                                               
                    </div>
                    <div>
                        <div style="max-width:15px; margin: 35px 11px 16px 0;">
                            <img src="/img/images/lock.png" class="img-responsive">
                        </div>                        
                    </div>
                </fieldset>
                <fieldset class="register_input_set">
                    <div class="register_input_bottom_border">                                            
                        <input type="email" required placeholder="<?php echo __("Email")?>" ng-model="formData.email" name="email" pattern=".{1,}@[_a-z0-9A-Z]+(\.[a-z0-9A-Z]+)+">
                        <div class="error-container" ng-show="signup_form.email.$dirty && signup_form.email.$invalid">
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
                <div>   
                    <fieldset class="register_input_set" style="border:0 !important;">                
                        <a href="javascript:void(0);" ng-click='signIn()' class="btn btn_sign_in" ng-disabled="signup_form.$invalid"><?php echo __("SIGN IN")?></a>
                    </fieldset>     
                </div>
                <div>
                    <small class="error">{{ message }}</small>
                </div>
            </form>
            <h5 style="margin-left:15px; color: #615F5F; font-size:15px;"><a style="color:black;" href="/Users/forget_password"><?php echo __("Forgot password")?></a></h5>
            <h5 style="margin-left:15px; font-size:15px;"><span style="color: #615F5F;"><?php echo __("Don't have an account?")?></span> <br> <a style="color:black;" href="/Users/signup"><?php echo __("Sign Up now!")?></a></h5>
        </div>
    </div>
</div>

<script type="text/javascript">
    FB.init({
        appId: '<?php echo APP_FB_ID;?>',
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


    $('#btn_facebook').on('click', function(){
        login();
    });
</script>