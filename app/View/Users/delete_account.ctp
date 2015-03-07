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
    md-dialog{
      width: 400px;
    }
    md-dialog md-content h2{
      font-size: 20px;
    }
</style>
<div layout="row" layout-align="center start">
    <div ng-controller="DeleteaccountController as deleteaccount" layout="column" flex style="border-bottom:1px solid #ccc; padding:10px 0 45px 0;">           
            <div style="margin:auto;">
              <form class="deleteaccountForm" name="deleteaccountForm" novalidate ng-submit="deleteaccount.submit(deleteaccountForm.$valid)">
                <h3><?php echo __('Delete your account');?></h3>
                <div class="row_delete_account">
                    <p><?php echo __('To confirm your account deletion please type &lt&ltDELETE&gt&gt below.');?></p>                                      
                    <input type="email" placeholder="<?php echo __("Email")?>" ng-model="deleteaccount.email" name="email" pattern=".{1,}@[_a-z0-9A-Z]+(\.[a-z0-9A-Z]+)+">
                    <div ng-messages="deleteaccountForm.email.$error" ng-messages-include="/files/message_changepass.html"></div>
                    <div style="color:green;">
                      {{deleteaccount.message}}
                       <img ng-show="showLoader" src="/img/loader.gif"/>
                    </div>
                </div>               
                <div style="padding-top:40px;">
                    <input type="submit" value="<?php echo __('SAVE');?>" class="btn btn_change_save">
                    <a href="javascript:void(0);" class="btn btn_change_cancel" ng-click="cancel()" tabindex="0"><?php echo __('CANCEL');?></a>
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