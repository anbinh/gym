<div class="UserIndexLeftContent">                
    <div layout="row">            
        <div class="list_program_view">                                                                    
            <div class="exercise_box exercise_box_editor ng-scope" ng-controller="VideoController">
                <div data-drop="true" jqyoui-droppable="{multiple:true, onDrop:'dropCallback'}" ng-model="test" class="box_program_vew">                           
                    <div class="sequence_number_box">
                        <p>1</p>
                    </div>
                    <div class="row no_margin" style="padding: 0 40px 0 40px;"> 
                        <video ng-mouseover="hoverIn($event)" 
                                ng-mouseleave="hoverOut($event)" 
                                class="img-responsive" preload="none" 
                                src="{{test.Exercise.video}}" 
                                poster="{{test.Exercise.photo}}" 
                                width="208px" height="152px" <="" video=""></video>
                    </div>
                    <div class="description">
                        <p>{{test.Exercise.name}}</p>
                    </div>
                    <div class="serie">
                        <p class="serie_text">Serie</p> 
                        <p class="serie_number"> 10</p>
                        <p class="repeat_text">Repetition</p> 
                        <p class="repeat_number"> 15 à 20</p>
                    </div>
                </div>                            
            </div> 

            <div class="exercise_box exercise_box_editor">
                <div class="box_program_vew">   
                    <div class="sequence_number_box">
                        <p>2</p>
                    </div>                    
                    <div class="row no_margin" style="padding: 0 10px 0 10px;"> 
                        <div data-drop="true" jqyoui-droppable="{multiple:true}" ng-model="test1" class="col-xs-6 no_padding">
                            <div class="small_box">
                                <img class="img-responsive" src="{{test1.Exercise.photo}}">
                            </div>
                        </div>
                        <div data-drop="true" jqyoui-droppable="{multiple:true}" ng-model="test2" class="col-xs-6 no_padding">
                            <div class="small_box">
                                <img class="img-responsive" src="{{test2.Exercise.photo}}">
                            </div>
                        </div>
                        <div data-drop="true" jqyoui-droppable="{multiple:true}" ng-model="test3" class="col-xs-6 no_padding">
                            <div class="small_box">
                                <img class="img-responsive" src="{{test3.Exercise.photo}}">
                            </div>
                        </div>
                        <div data-drop="true" jqyoui-droppable="{multiple:true}" ng-model="test4" class="col-xs-6 no_padding">
                            <div class="small_box">
                                <img class="img-responsive" src="{{test4.Exercise.photo}}">
                            </div>
                        </div>
                    </div>
                    <div class="serie">
                        <p style="color:#c7c8c9; margin-right:10px; font-size:11pt;">Serie</p> 
                        <p> exercise text</p>
                    </div>                    
                </div>                            
            </div>   

        </div>
    </div>
</div>