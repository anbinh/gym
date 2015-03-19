<div class="right_banner" layout="row" ng-controller="ForgetPasswordController">
    <div flex>
        <div layout="row" layout-align="center center">
            <div class="main_content_register arrow_box" style="height: 400px;">
                <div ng-show="isReset">
                    <h4 style="font-weight:bold; margin: 40px 30px;"><?php echo __("Forgot Password")?></h4>
                    <form class="frm_register" name="signup_form">
                        <div style="margin-bottom: 15px;">
                            <div class="error" ng-bind-html="message"></div>
                        </div>
                        <fieldset style="float:left; border:0 !important;">
                            <div>
                                <div style="max-width:15px; background:black; margin: 18px 11px 16px 0;">
                                    <img src="/img/images/email_icon.png" style="background-color: white;height: 36px;margin-top: -8px;display: block;max-width: 150%;">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="register_input_set">
                            <div class="register_input_bottom_border">
                                <input type="email" required placeholder="<?php echo __("Email")?>" ng-model="email" name="email" pattern=".{1,}@[_a-z0-9A-Z]+(\.[a-z0-9A-Z]+)+">
                                <div class="error-container" ng-show="signup_form.email.$dirty && signup_form.email.$invalid">
                                    <small class="error" ng-show="signup_form.email.$error.required"><?php echo __("Your email is required.")?></small>
                                    <small class="error" ng-show="signup_form.email.$error.pattern"><?php echo __("Please type a valid email.")?></small>
                                </div>
                            </div>
                        </fieldset>
                        <div>
                            <fieldset class="register_input_set" style="border:0 !important;">
                                <a href="javascript:void(0);" ng-click='reset()' class="btn btn_sign_in" ng-disabled="signup_form.$invalid"><?php echo __("Reset")?></a>
                            </fieldset>
                        </div>
                    </form>
                </div>
                <div ng-show="!isReset" class="resetBox">
                    <h4 style="font-weight:bold; margin: 40px 30px;"><?php echo __("Sent!")?></h4>
                    <p><?php echo __("We've sent password reset")?></p>
                    <p><?php echo __("instruction to your email address.")?></p>
                    </br>
                    <p><?php echo __("If you don't receive instructions")?></p>
                    <p><?php echo __("within a minute or two, check your")?></p>
                    <p><?php echo __("email's spam and junk filters, or try")?></p>
                    <p><a style="text-decoration: underline;cursor: pointer;color:#000000;" href="javascript:void(0);" ng-click='reset()'><?php echo __("resending your request.")?></a></p>
                </div>
                <img ng-show="showLoader" src="/img/loader.gif"/>
            </div>
        </div>
    </div>
   <?php echo $this->element('right_advs');?>    
</div>
