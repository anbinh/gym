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
		echo $this->Html->css(array('style', 'bower_components/angular-material/angular-material.min'));

		echo $this->Html->script(array('bower_components/hammerjs/hammer.min', 'bower_components/angular/angular.min', 'bower_components/angular-animate/angular-animate.min', 'bower_components/angular-aria/angular-aria.min', 'bower_components/angular-material/angular-material.min', 'app'));

		echo $this->Html->meta('icon');

		//echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body ng-app="App" ng-controller="bodyController">
	<div id="container">
		 <div id="header">
            <md-toolbar class="toolbar-title" layout="row" layout-sm="row" layout-align="center center" layout-align-sm="center center">
                <div flex="33" layout="row" layout-align="start center">
                    <md-button class="md-raised header_button_menu"  ng-click="toggleRight()"></md-button>
                    <md-button class="header_button " hide-sm ng-click="programClick()">PROGRAMS</md-button>
                    <md-button class="header_button " hide-sm ng-click="exerciseClick()">EXERCIES</md-button>
                </div>
                <div flex="33" layout="row" layout-align="center center">
                    <md-button class="logo" ng-click="logoClick()"></md-button>
                </div>
                <div flex="33" layout="row" layout-align="end center">
                    <md-button class="right_header_button"  ng-click="signInClick()"><img src="/img/images/picto.png"/> Sign in</md-button>
                    <md-button class="right_header_button"  ng-click="engClick()"><img src="/img/images/earth.png"/> ENG</md-button>
                </div>
            </md-toolbar>
            <md-sidenav class="md-sidenav-left md-whiteframe-z2 left-menu" md-component-id="right">
                <md-content ng-controller="LeftMenu" class="md-padding">
                    <md-list>
                        <md-item ng-repeat="item in lists">
                            <md-item-content>
                                <div class="md-tile-content">
                                    <md-button md-no-ink class="md-primary" ng-click="itemMenuClick(item.link)">{{item.title}}</md-button>
                                </div>
                            </md-item-content>
                            <md-divider ng-if="!$last"></md-divider>
                        </md-item>
                    </md-list>
                </md-content>
            </md-sidenav>
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
				<?php// echo $cakeVersion; ?>
			</p>
		</div>
	</div>
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>
