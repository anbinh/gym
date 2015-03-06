<script type="text/javascript">
    (function() {

          var app = angular.module("validation", ["ngMessages"]);

          var RegistrationController = function() {
            var model = this;

            model.message = "";

            model.user = {
              username: "",
              password: "",
              confirmPassword: ""
            };

            model.submit = function(isValid) {
              console.log("h");
              if (isValid) {
                model.message = "Submitted " + model.user.username;
              } else {
                model.message = "There are still invalid fields below";
              }
            };

          };

          var compareTo = function() {
            return {
              require: "ngModel",
              scope: {
                otherModelValue: "=compareTo"
              },
              link: function(scope, element, attributes, ngModel) {

                ngModel.$validators.compareTo = function(modelValue) {
                  return modelValue == scope.otherModelValue;
                };

                scope.$watch("otherModelValue", function() {
                  ngModel.$validate();
                });
              }
            };
          };

          app.directive("compareTo", compareTo);
          app.controller("RegistrationController", RegistrationController);

        }());
</script>

<div layout="row" layout-align="center start">
    <div ng-controller="RegistrationController as registration" layout="column" flex style="border-bottom:1px solid #ccc; padding:10px 0 45px 0;">
        <h3>{{registration.message}}</h3>
        <form name="registrationForm" novalidate ng-submit="registration.submit(registrationForm.$valid)">
            <div style="margin:auto;">
                <h3>Change your password</h3>
                <div class="row_change_pass">
                    <label>New password</label>
                    <input type="password" name="password" ng-model="registration.user.password" placeholder="new password">
                </div>
                <div class="row_change_pass">
                    <label>Confirm password</label>
                    <input type="password" name="confirmPassword" ng-model="registration.user.confirmPassword" compare-to="registration.user.password" placeholder="confirm password">
                </div>
                <div style="padding-top:40px;">
                    <input type="submit" value="SAVE" class="btn btn_change_save">
                    <a href="javascript:void(0);" class="btn btn_change_cancel" ng-click="cancel()" tabindex="0">CANCEL</a>
                </div>
            </div>
        </form>
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