<style type="text/css">
  .ng-invalid {
      border-color: red;
      outline-color: red;
    }

    .ng-valid {
      border-color: green !important;
      outline-color: green !important;
    }

    .messages {
      font-size: smaller;
      padding-top: 5px;
      padding-bottom: 10px;
      color: red;
      font-size: 15px;
    }
</style>
<div layout="row" layout-align="center start">
    <div ng-controller="ChangepassController as changepass" layout="column" flex style="border-bottom:1px solid #ccc; padding:10px 0 45px 0;">           
            <div style="margin:auto;">
              <form name="changepassForm" novalidate ng-submit="changepass.submit(changepassForm.$valid)">
                <h3>Change your password</h3>
                <div class="row_change_pass">
                    <label>New password</label>
                    <input type="password" name="password" ng-model="changepass.user.password" placeholder="new password">                    
                </div>
                <div class="row_change_pass">
                    <label>Confirm password</label>
                    <input type="password" name="confirmPassword" ng-model="changepass.user.confirmPassword" compare-to="changepass.user.password" placeholder="confirm password">
                    <div ng-messages="changepassForm.confirmPassword.$error" ng-messages-include="/files/message_changepass.html"></div>
                </div>
                <div style="padding-top:40px;">
                    <input type="submit" value="SAVE" class="btn btn_change_save">
                    <a href="javascript:void(0);" class="btn btn_change_cancel" ng-click="cancel()" tabindex="0">CANCEL</a>
                </div>
              </form>
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