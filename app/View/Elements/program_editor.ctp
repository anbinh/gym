<div ng-if="tab.day_number != ''" class="UserIndexLeftContent">                
    <div layout="row">            
        <div class="list_program_view" ng-repeat="item in tab.exercise_list">         	
				<?php echo $this->Element('template_regular');?>                					
				<?php echo $this->Element('template_stretching');?>                					
				<?php echo $this->Element('template_superset');?>                
				<?php echo $this->Element('template_withnote');?>                
				<?php echo $this->Element('template_onlytext');?>                			
        </div>
        <creator></creator>
        <!-- <input type="button" value="add" ng-click="test()">
        <input type="button" value="remove" ng-click="testremove()"> -->
    </div>
</div>

<!-- <div class="exercise_box">
	<div class="box_program_vew">
		<div class="header_box">
			<p>1</p>
			<img src="/img/images/icon_option.png">
		</div>
		<div class="content_box_stretching">
			<div class="content_box_img" layout-align="center center" layout="column">
				<img src="/img/images/drag_exercise.png">												
			</div>
			<div class="content_box_img" layout-align="center center" layout="column">
				<img src="/img/images/drag_exercise.png">												
			</div>
			<div class="content_box_img" layout-align="center center" layout="column">
				<img src="/img/images/drag_exercise.png">												
			</div>
			<div class="content_box_img" layout-align="center center" layout="column">
				<img src="/img/images/drag_exercise.png">												
			</div>
		</div>	
		<div class="fotter_box" layout-align="center center" layout="row">
			Serie
			<input class="serie1" type="text">
			Repeation
			<input class="repeat1" type="text">
		</div>
	</div>
</div>

<div class="exercise_box">
	<div class="box_program_vew">
		<div class="header_box">
			<p>1</p>
			<img src="/img/images/icon_option.png">
		</div>
		<div class="content_box_super_set">
			<div class="content_box_img" layout-align="center center" layout="column">
				<img src="/img/images/drag_exercise.png">
			</div>
			<div class="content_box_main" layout="column">
				Serie
				<input class="serie2" type="text">
				Repetition
				<input class="repeat2" type="text">
			</div>
			<p class="name_exercise">name of exercise</p>
		</div>
		<div class="content_box_super_set">
			<div class="content_box_img" layout-align="center center" layout="column">
				<img src="/img/images/drag_exercise.png">
			</div>
			<div class="content_box_main" layout="column">
				Serie
				<input class="serie2" type="text">
				Repetition
				<input class="repeat2" type="text">
			</div>
			<p class="name_exercise">name of exercise</p>
		</div>
	</div>
</div>
<div class="exercise_box">
	<div class="box_program_vew">
		<div class="header_box">
			<p>1</p>
			<img src="/img/images/icon_option.png">
		</div>
		<div class="content_box_regular">
			<div class="content_image" layout-align="center center" layout="column">
				<img src="/img/images/drag_exercise.png">									
				<div><?php echo "DRAG EXERCISE";?></div>
			</div>
			<p class="name_exercise">name of exercise</p>
		</div>
		<div class="fotter_box" layout-align="center center" layout="row">		
			<input style="width:185px" type="text">		
		</div>
	</div>
</div>

<div class="exercise_box">
	<div class="box_program_vew">
		<div class="header_box">
			<p>1</p>
			<img src="/img/images/icon_option.png">
		</div>
		<div class="content_box_regular">
			<div class="content_image" layout-align="center center" layout="column">
				<img src="/img/images/drag_exercise.png">									
				<div><?php echo "DRAG EXERCISE";?></div>
			</div>
			<p class="name_exercise">name of exercise</p>
		</div>
		<div class="fotter_box" layout-align="center center" layout="row">
			Serie
			<input class="serie1" type="text">
			Repeation
			<input class="repeat1" type="text">
		</div>
	</div>
</div>

<div class="exercise_box">
	<div class="box_program_vew">
		<div class="header_box">
			<p>2</p>
			<img src="/img/images/icon_option.png">
		</div>
		<textarea class="content_only_text" type="text"></textarea>
	</div>
</div>

<div class="exercise_box">
	<div class="box_program_vew box_creator" layout-align="center center" layout="row">
		<div ng-click="add_exercise();" class="box_creator_plus" layout-align="center center" layout="row">+</div>
	</div>
</div> -->