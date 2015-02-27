<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>

<style type="text/css">
    .register_input_set {
        padding: 0;
        margin: 0;
        border: 2px solid #e6e6e6;
        border-radius: 3px;
        width: 220px;
        /*margin: auto;*/
        margin-left: 30px;
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
<div ng-controller="LoginController">
    <div layout="row" layout-align="center center">
        <div class="main_content_register arrow_box">            
            <h4 style="font-weight:bold; margin-left:26px;">Login</h4>
            <a href="javascript:;" class="btn btn_facebook" style="margin-left:29px;">Login with Facebook</a>
            <h4 style="margin-left:15px;">or</h4>
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
                        <input type="email" required placeholder="Email" ng-model="formData.email" name="email" pattern=".{1,}@[_a-z0-9A-Z]+(\.[a-z0-9A-Z]+)+">
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
                <div>
                    <a href="javascript:void(0);" ng-click='signIn()' class="btn btn_sign_in" ng-disabled="signup_form.$invalid">SIGN IN</a>
                </div>
                <div>
                    <small class="error">{{ message }}</small>
                </div>
            </form>
            <h5 style="margin-left:15px; color: #615F5F; font-size:15px;">Forgot password</h5>
            <h5 style="margin-left:15px; font-size:15px;"><span style="color: #615F5F;">Don't have an account?</span> <a style="color:black;" href="/Users/signup">Sign Up now!</a></h5>
        </div>
    </div>
   <!--  <div layout="row" layout-align="center center">
        <div flex="50" class="back_to_login">
            <a href="javascript:void(0);" ng-click='signUp()'>Sign Up Here!</a>
        </div>
    </div> -->
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