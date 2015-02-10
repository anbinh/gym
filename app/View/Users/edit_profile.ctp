<div class="wrap_content right_banner" layout="row" hide-sm ng-controller="UserProfileController">
	<div flex>
        <div id="messages" ng-show="message">{{ message }}</div>
		<div layout="row" layout-align="center start">
			<form action="#" class="user_profile">
				<div class="input_row_register">
					<label>User Name</label>
					<input type="text" name="username" ng-model="formData.username">
				</div>
				<div class="input_row_register">
					<label>Email Address</label>
					<input type="text" name="email" ng-model="formData.email">
				</div>
				<div class="input_row_register">
					<label>First Name</label>
					<input type="text" name="firstname" ng-model="formData.firstname">
				</div>
				<div class="input_row_register">
					<label>Last Name</label>
					<input type="text" name="lastname" ng-model="formData.lastname">
				</div>
				<div class="input_row_register">
					<label>Gender</label>
					<input type="radio" name="gender" value="1" ng-model="formData.gender"> Men
					<input type="radio" name="gender" value="0" ng-model="formData.gender"> Women
				</div>
				<div class="input_row_register">
					<label>Language</label>
					<input type="text" name="language" ng-model="formData.language">
				</div>
				<div class="input_row_register">
					<label>Location</label>
					<input type="text" name="address" ng-model="formData.address">
				</div>
				<div class="input_row_register">
					<label>Birthday</label>
					<input type="date" name="birthday" ng-model="formData.birthday">
				</div>
				<div class="input_row_register_fb">
					<label>Your Password</label>
					<a href="#" class="btn btn_change_pass">Change Password</a>
				</div>
				<div class="input_row_register_fb">
					<label>Facebook</label>
					<a href="#" class="btn btn_facebook">Connect Facebook</a>
				</div>
				<div class="input_row_register">
					<label>Promotion Email</label>					
					<input type="checkbox" name="receive_promote" ng-model="formData.receive_promote"> Receive promotion emails
				</div>
				<hr>
				<div class="input_row_save_cancel" layout="row">
					<div flex><a href="javascript:void(0);" class="btn btn_change_save" ng-click='save()'>SAVE</a></div>
					<div flex><a href="javascript:void(0);" class="btn btn_change_cancel">CANCEL</a></div>
				</div>
				<p style="font-weight:bold;">To remove your Keep account please <a href="javascript:void(0);" style="color:#ccc; text-decoration:none;">click here.</a></p>		
			</form>	

		</div>		
	</div>	
	<div style="width:300px;" layout="column">		
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
