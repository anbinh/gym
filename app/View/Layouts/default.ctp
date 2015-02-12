<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->css(array(
            'style',
            'bower_components/angular-material/angular-material.min',
            'bower_components/angular-dropdown/angular-dropdowns',
            'bootstrap.min',
            'bootstrap-theme.min'
        ));

		echo $this->Html->script(array('bower_components/hammerjs/hammer.min',
            'bower_components/angular/angular.min',
            'bower_components/angular-animate/angular-animate.min',
            'bower_components/angular-aria/angular-aria.min',
            'bower_components/angular-material/angular-material.min',
            'app',
            'bower_components/angular-dropdown/angular-dropdowns',
            'jquery-1.11.2.min',
            'bootstrap.min'
        ));

		echo $this->Html->meta('icon');

		//echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body ng-app="App">
	<div id="container">
		 <div id="header" ng-controller="headerController">
            <md-toolbar class="" layout="row" layout-sm="row" layout-align="center center" layout-align-sm="center center">
                <div flex="33" layout="row" layout-align="start center" style="padding-left:10px;" class="header_menu">
                    <md-button class="header_button_menu"
                       dropdown-menu="ddMenuOptions"
                       dropdown-model="ddMenuSelected"
                       dropdown-item-label="text">
                        <img src="/img/images/menu.png">
                    </md-button>
                    <md-button class="header_button" hide-sm ng-click="programClick()" style="font-size:16px;">{{programs}}</md-button>
                    <md-button class="header_button" hide-sm ng-click="exerciseClick()" style="font-size:16px;">{{exercises}}</md-button>                    
                </div>
                <div flex="33" layout="row" layout-align="center center">
                    <md-button class="logo" ng-click="logoClick()"> <img class="logo_img" src="/img/images/logo.png"></md-button>
                </div>
                <div flex="33" layout="row" layout-align="end center" class="login_logout">
                    <?php if(isset($auth_user)):?>
                        <md-button class="right_header_button"  ng-click="signInClick()" style="font-size:14px;">
                            <a href="/Users"><?php echo $auth_user['firstname'].' '.$auth_user['lastname'];?></a>
                        </md-button>    
                    <?php endif;?>                        
                    <md-button class="right_header_button"  ng-click="signInClick()" style="font-size:14px;">
                        <div>
                        <?php if(isset($auth_user)):?>
                            <a href="/Users/logout"><img src="/img/images/picto.png"/> <p1>Sign out</p1></a>
                        <?php else:?>                                                        
                            <a href="/Users/signup"><img src="/img/images/picto.png"/> <p1>Sign in</p1></a>
                        <?php endif;?>                        
                        </div>
                    </md-button>
                    <md-button class="right_header_button"  ng-click="engClick()" style="font-size:14px;"
                               dropdown-menu="ddSelectOptions"
                               dropdown-model="ddSelectSelected"
                               dropdown-item-label="text">
                        <img src="/img/images/earth.png"/> <?php echo $language;?>
                    </md-button>
                </div>
            </md-toolbar>
		</div>
		<div id="content">
			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>

            <div ng-view></div>
		</div>
		<div id="footer">
			 <?php //echo $this->Html->link(
			// 		$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
			// 		'http://www.cakephp.org/',
			// 		array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
			// 	);
			?>
			<p>
				
			</p>
		</div>
	</div>
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>
