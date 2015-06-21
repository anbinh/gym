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
    <meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo "Studio Gym" ?>
	</title>        
	<?php
		echo $this->Html->css(array(
            'style?665464',
            'bower_components/angular-material/angular-material.min',
            'bower_components/angular-dropdown/angular-dropdowns',
            'bootstrap.min',
            'bootstrap-theme.min',
            'bootstrap-social'
        ));

		echo $this->Html->script(array(
            'jquery.min',
            'bower_components/hammerjs/hammer.min',
            'bower_components/angular/angular.min',
            'bower_components/angular-route/angular-route.min',
            'bower_components/angular-animate/angular-animate.min',
            'bower_components/angular-aria/angular-aria.min',
            'bower_components/angular-material/angular-material.min',
            'app?432432',            
            'bower_components/angular-dropdown/angular-dropdowns',
            'jquery-ui.min',
            'bower_components/angular/angular-dragdrop.min',            
            'jquery.ui.touch-punch.min',
            'bower_components/angular/angular-drag-and-drop-lists',
            'bootstrap.min',
            'custom?654765',
            'bower_components/angular-ui/ui-bootstrap-tpls-0.12.1',
            'bower_components/angular/angular-messages',
            'UnityObject2.js',            
                        
            /*'bower_components/angular-ui/ui-bootstrap-0.12.1'*/
        ));

		echo $this->Html->meta('icon');

		//echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!--<base href="/" />-->
</head>
<body ng-app="App">
	<div id="container">
		 <div id="header" ng-controller="headerController">
            <md-toolbar class="" layout="row" layout-sm="row" layout-align="center center" layout-align-sm="center center">
                <div flex layout="row" layout-align="start center" style="padding-left:10px;" class="header_menu">
                    <div class="hover_dropdown"></div>
                    <button class="header_button_menu"
                       dropdown-menu="ddMenuOptions"
                       dropdown-model="ddMenuSelected"
                       dropdown-item-label="text">
                        <img src="/img/images/menu.png">
                    </button>
                    <button class="header_button" hide-sm ng-click="programClick()" style="font-size:16px;"><span class="header_text program_menu <?php echo isset($curr_page)? ($curr_page == 'Programs')? 'bottomline' : '' : ''?>"><?php echo __('program header')?></span></button>
                    <button class="header_button" hide-sm ng-click="exerciseClick()" style="font-size:16px;"><span class="header_text exercise_menu <?php echo isset($curr_page)? ($curr_page == 'Exercises')? 'bottomline' : '' : ''?>"><?php echo __('exercise header')?></span></button>
                </div>
                <div flex layout="row" layout-align="center center">
                    <?php if($language=="eng") :?>
                     <img class="logo_img" src="/img/images/logo_eng.png">
                 <?php else :?>
                     <img class="logo_img" src="/img/images/logo_fr.png">
                 <?php endif;?>
                </div>
                <div flex layout="row" layout-align="end center" class="login_logout">                        
                    <div class="logout_menu">
                        <button class="header_button right_header_button"
                            style="font-size:14px;"
                            <?php if(!isset($auth_user)):?> 
                            ng-click="loginClick()" 
                            <?php else:?>
                            dropdown-menu="ddLoginSelectOptions"
                            dropdown-model="ddLoginSelectSelected"
                            dropdown-item-label="text"
                            dropdown-onchange="toggleLoginClick(selected)"
                            <?php endif;?>                        
                            >
                            <div id="loginBtn">
                                <img src="/img/images/picto.png"/>
                            <?php if(!isset($auth_user)):?>
                                <span class="header_text hidden_username"><?php echo __('Login')?></span></a>
                            <?php else:?>                                                  
                                <span class="header_text hidden_username <?php echo isset($curr_page)? ($curr_page == 'Users')? 'bottomline' : '' : ''?>"><?php echo $auth_user['login'];?></span></a>
                            <?php endif;?>                        
                            </div>
                        </button>
                    </div>
                    <div class="language_menu">
                        <button class="header_button right_header_button" style="font-size:14px;"
                                   dropdown-menu="ddSelectOptions"
                                   dropdown-model="ddSelectSelected"
                                   dropdown-item-label="text"
                                   dropdown-onchange="toggleLanguageClick(selected)"
                            >
                            <img src="/img/images/earth.png" class="icon_language"/> <span class="hidden_language"><?php echo $language;?></span>
                        </button>
                    </div>                    
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
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
