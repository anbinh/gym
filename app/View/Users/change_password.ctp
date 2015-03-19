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
              <form class="changepassForm" name="changepassForm" novalidate ng-submit="changepass.submit(changepassForm.$valid)">
                <h3><?php echo __('Change your password');?></h3>
                <div class="row_change_pass">
                    <label><?php echo __('New password');?></label>
                    <input type="password" name="password" ng-model="changepass.user.password" placeholder="<?php echo __('New password');?>" required>
                </div>
                <div class="row_change_pass">
                    <label><?php echo __('Confirm password');?></label>
                    <input type="password" required name="confirmPassword" ng-model="changepass.user.confirmPassword" compare-to="changepass.user.password" placeholder="<?php echo __('Confirm password');?>">
                    <div ng-show="changepassForm.$invalid && !changepassForm.password.$error.required && !changepassForm.confirmPassword.$error.required" class="messages"><?php echo __('Password does not match!');?></div>
                </div>
                <div style="color:green;">
                  {{changepass.message}}
                   <img ng-show="showLoader" src="/img/loader.gif"/>
                </div>
                <div style="padding-top:40px;">
                    <a href="javascript:void(0);" ng-click='save()' class="btn btn_change_save" ng-disabled="changepassForm.$invalid"><?php echo __('SAVE');?></a>
                    <a href="javascript:void(0);" class="btn btn_change_cancel" ng-click="cancel()" tabindex="0"><?php echo __('CANCEL');?></a>
                </div>
              </form>                      
            </div>        
    </div>
    <?php echo $this->element('right_advs');?>    
</div>