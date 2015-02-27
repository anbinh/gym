<div layout="row">
    <div ng-controller="UserController" class="UserIndexLeftContent">
        <div layout="column" class="info_user">
            <div layout="row" class="avatar">
                <div style="padding-left:10px;"><img class="img_avatar" ng-src="{{user.picture}}"/></div>
                <div layout="row" layout-align="start center" class="username">{{user.login}}</div>
            </div>
            <div layout="row" style="height:120px;">
                <div style="padding:8px 0 0 190px;" flex>
                    <!-- <div><img src="/img/images/facebook_icon.png"/> &nbsp&nbsp <img src="/img/images/twitter_icon.png"/></div> -->
                    <div class="fullname">{{user.firstname}} {{user.lastname}}</div>
                    <div class="city">{{user.language}}</div>
                    <div class="language">{{user.address.street}}</div>
                    <div class="edit_profile"><a class="edit_text" href="javascript:void(0);" ng-click='edit()'><?php echo __('edit')?></a></div>
                </div>
            </div>
        </div>
    </div>
</div>