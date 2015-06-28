(function(){

'use strict';
var app = angular.module('App', ['ngMaterial','ngDropdowns','ui.bootstrap','ngMessages','ngDragDrop','dndLists']);

app.controller('ExerciseDetailController', function($scope,$http) {
    var exercise_id = window.location.search;
    exercise_id = exercise_id.substr(exercise_id.indexOf("=") + 1);
    $scope.isSelected = false;
    $http.get('/Apis/getExerciseDetail/' + exercise_id +'.json')
        .then(function(res){
            console.log(res);
            if(res.data.isVote == 1)
                $scope.isSelected = true;
            if(res.data.message == "NofUserLogin")
            {
                $scope.id = 0;
            }
        });
    $scope.getImage = function() {
        if ( $scope.isSelected ) {
            return "/img/images/star.png";
        } else {
            return "/img/images/Star_none.png";
        }
    };

    $scope.toggleSelection = function() {
        if($scope.id == 0)
        {
            window.location='/Users/login';
        }
        else
        {
            $scope.toggleStar();
        }
    };

    $scope.toggleStar = function(){
        $scope.isSelected = ! $scope.isSelected;
        if ( $scope.isSelected ) {
            $http.get('/Apis/likeExerciseByUser/' + exercise_id +'.json')
                .then(function(res){
                    console.log(res);
                });
        } else {
            $http.get('/Apis/unlikeExerciseByUser/' + exercise_id +'.json')
                .then(function(res){
                    console.log(res);
                });
        }
    };
});

app.controller('headerController', function($scope,$http){
    $scope.ddSelectSelected = {}; // Must be an object
    $scope.ddMenuSelected = {};
    $http.get('/Apis/getMenuHeaderFile.json')
        .then(function(res){
            // console.log(res);
            $scope.ddLoginSelectOptions = res.data.data.user;
            $scope.ddSelectOptions = res.data.data.language;
            $scope.ddMenuOptions = res.data.data.menu;
        });

    $scope.toggleLanguageClick = function($value)
    {
        console.log($value.value);
        $http.get('/Apis/toggleLanguage/' +  $value.value +'.json')
            .then(function(res){
                console.log(res);
                window.location.reload();
            });
    };
    $scope.toggleLoginClick = function($value)
    {
        window.location = $value.value;
    };
    $scope.programClick = function(){
        window.location='/Programs/index';
    };
    $scope.exerciseClick = function(){
        window.location='/Exercises/index';
    };
    $scope.loginClick = function(){
        window.location='/Users/login';
    };
});

app.controller('ListController', ['$scope', '$http', function($scope, $http){
    $scope.results=[];
    $scope.search = function(){

        $http({
            method: 'GET',
            url:'https://api.flickr.com/services/rest',
            params:{
                method: 'flickr.photos.search',
                api_key:'b31499089ba318a6d834eb86f1a5d49e',
                text: $scope.searchTerm,
                format:'json',
                nojsoncallback:1
            }
        }).success(function(data){
            $scope.results=data;
        }).error(function(error){
            console.log(error);
        });
    };
}
]);

app.controller('UserController', function($scope,$http,$modal) {
    $scope.user = [];
    $scope.exercises_list = [];
    $scope.exercises_like = [];
    $scope.list_program_saved = [];

    $http.get('/apis/getUserProfileAndExerciseById/' + id +'.json')
        .then(function(res){        
            $scope.user = res.data.user;
            if(res.data.user.picture.trim().length == 0)
                $scope.user.picture = '/img/images/avarta.png';
            if(res.data.user.language == "?")
                $scope.user.language = "No Language Selected";
            $scope.exercises_list = angular.copy(res.data.exercises_like);
            $scope.exercises_like = angular.copy(res.data.exercises_like); 
            console.log(res.data);            
        });

    // get list of programs had saved before by this User
    $http.get('/Apis/getListProgramOfUser.json')
        .then(function(res){  
             console.log(res.data.message);
            $scope.list_program_saved = angular.copy(res.data.message);
        });
    $scope.edit = function() {
        window.location='/Users/edit_profile';
    };
    $scope.editProgram = function() {
        $scope.isEdit = true;
        $scope.isSelected = true;
    };
    $scope.getImage = function() {
        if ( $scope.isSelected ) {
            return "/img/images/star.png";
        } else {
            return "/img/images/Star_none.png";
        }
    };
    // like star handler
    $scope.deselectFriend = function( exercise ) {
        var index = $scope.exercises_like.indexOf( exercise );
        if ( index >= 0 ) {
            $scope.exercises_like.splice( index, 1 );
        }
    };
    $scope.selectFriend = function( exercise ) {
        $scope.exercises_like.push( exercise );
    };

    $scope.toggleMyProgram = function(){
        $scope.isProgramShow = !$scope.isProgramShow;
    };
    $scope.toggleExercise = function(){
        $scope.isExerciseShow = !$scope.isExerciseShow;
    };
    $scope.delete_program = function(program_id, index){        
        if($scope.list_program_saved[index].Program.creator_id != "")
        {
            var modalInstance = $modal.open({
              templateUrl:'/Users/confirm_delete.ctp',
              controller: 'confirmDeleteController',
              backdropClass: 'backdropClass_custom',
              size:'sm'                    
            });            
            modalInstance.result.then(function (isDelete) {
                console.log(isDelete);
                if(isDelete == 1)
                {
                    $scope.list_program_saved.splice(index, 1);
                    $http.get('/Apis/deleteAssignedProgram/'+program_id+'.json')
                    .then(function(res){
                        console.log(res);                        
                    });
                }                
            }, function () {
            });
        }
        else
        {
            $scope.list_program_saved.splice(index, 1);
            $http.get('/Apis/deleteAssignedProgram/'+program_id+'.json')
            .then(function(res){               
                
            });
        }        
    };
    $scope.isExerciseShow = true;
    $scope.isProgramShow = true;

    $scope.isEdit = false;
    $scope.isSelected = false;

    $scope.dragIndex = 0;    
    $scope.dropIndex = 0;        
    $scope.dropCallback = function(event, index, item) {        
        console.log('drop : ' + index);
        $scope.dropIndex = index;   
        return item;
    };

    $scope.movedCallback = function(event, index, item) {      
        $scope.list_program_saved.splice(index, 1);              
        if($scope.dragIndex == $scope.dropIndex || $scope.dragIndex == $scope.dropIndex-1)      
        {

        }   
        else
        {
            var array_order = [];
            angular.forEach($scope.list_program_saved, function(value, key) {
              this.push(value.Program.id);
            }, array_order);
            $http({
                method  : 'POST',
                url     : '/Apis/reorderProgram.json',            
                data    : array_order,  // pass in data as strings
                headers : { 'Content-Type': 'application/json' }  // set the headers so angular passing info as form data (not request payload)
            }).success(function(data) {
                    console.log(data);
                    if(data.message != "success")
                    {
                        window.location='/Users/edit_profile';
                    }                  
            });
        }                           
    };

    $scope.dragStartCallback = function(event, index, item) {      
        console.log('drag : ' + index);     
        $scope.dragIndex = index;     
    };
});

app.controller('confirmDeleteController',function($scope,$modalInstance){
    $scope.cancel = function()
    {
        $modalInstance.close(0);
    }

    $scope.delete_program = function()
    {
        $modalInstance.close(1);
    }
});

app.controller('UserProfileController', function($scope,$http){
    $scope.formData = [];
    $http.get('/language.json').success(function(response) {
        $scope.options = response;
    });
    $http.get('/datetime.json').success(function(response) {
        $scope.optionDays = response.day;
        $scope.optionMonths = response.month;
        $scope.optionYears = response.year;
        $scope.day = $scope.optionDays[0];
        $scope.month = $scope.optionMonths[0];
        $scope.year = $scope.optionYears[0];
    });

    
    $scope.formData.language = {name: "English", value:"English"};
    $scope.message = '';
    $scope.isHasPicture = false;
    $scope.imgURL = "/img/images/add_picture_icon.png";
    if(id != 0)
    {
        $http.get('/apis/getUserProfileAndExerciseById/' + id +'.json')
            .then(function(res){
                console.log(res);
                
                $scope.formData = res.data.user;
                //$scope.formData.birthday = new Date(res.data.user.birthday);
                if($scope.formData.picture.length > 0)
                {
                    $scope.isHasPicture = true;
                    $scope.imgURL = $scope.formData.picture;
                }
                $scope.formData.language = {name: res.data.user.language, value:res.data.user.language};                
                var splitBirthday = res.data.user.birthday.split("-");
                if(splitBirthday.length > 0)
                {
                    $scope.day = {name: splitBirthday[0], value:splitBirthday[0]};
                    $scope.month = {name: splitBirthday[1], value:splitBirthday[1]};
                    $scope.year = {name: splitBirthday[2], value:splitBirthday[2]};                    
                }
                $scope.exercises_list = angular.copy(res.data.exercises_like);
                $scope.exercises_like = angular.copy(res.data.exercises_like);
                $scope.fb_id = res.data.user.fb_id;
                $scope.id = res.data.user.id;
                $scope.picture = res.data.user.picture;
                $scope.password = res.data.user.password;
            });
        // get list of programs had saved before by this User
        $http.get('/Apis/getListProgramOfUser.json')
            .then(function(res){  
                 console.log(res.data);
                $scope.list_program_saved = angular.copy(res.data.message);
            });
    }
    else
    {
        $http.get('/apis/getRegisterUser.json')
            .then(function(res){
                console.log(res);
                $scope.formData = res.data.user;
                var split_fullname = res.data.user.fullname.split(" ");
                var lastname = "";
                if (split_fullname.length > 1) {
                    $scope.formData.firstname = split_fullname[0];
                    var i = 0;
                    for(i;i<split_fullname.length;i++)
                    {
                        if(i == 0)
                            continue;
                        lastname = lastname + split_fullname[i] + " ";
                    }
                } else
                    $scope.formData.firstname = res.data.user.fullname;
                $scope.formData.lastname = lastname;
                $scope.password = res.data.user.password;
            });
    }

    $scope.getClassBtnAddPicture= function(isHasPicture){
        if(isHasPicture)
            return "hasProfilePicture";
        else
            return "hasNoPicture";
    }
    
    $scope.cancel = function() {
        window.location='/Users/index';
    };

    $scope.changePassword = function(){
        window.location='/Users/change_password';
    };

    $scope.editProgram = function() {
        $scope.isEdit = true;
        $scope.isSelected = true;
    };
    $scope.getImage = function() {
        if ( $scope.isSelected ) {
            return "/img/images/star.png";
        } else {
            return "/img/images/Star_none.png";
        }
    };
    // like star handler
    $scope.deselectFriend = function( exercise ) {
        var index = $scope.exercises_like.indexOf( exercise );
        if ( index >= 0 ) {
            $scope.exercises_like.splice( index, 1 );
        }
    };
    $scope.selectFriend = function( exercise ) {
        $scope.exercises_like.push( exercise );
    };

    $scope.toggleMyProgram = function(){
        $scope.isProgramShow = !$scope.isProgramShow;
    };
    $scope.toggleExercise = function(){
        $scope.isExerciseShow = !$scope.isExerciseShow;
    };

    $scope.delete_program = function(program_id, index){
        $scope.list_program_saved.splice(index, 1);
        $http.get('/Apis/deleteAssignedProgram/'+program_id+'.json')
        .then(function(res){               
            
        });
    };
    $scope.isExerciseShow = true;
    $scope.isProgramShow = true;
    $scope.isEdit = false;
    $scope.isSelected = false;

    $scope.dragIndex = 0;    
    $scope.dropIndex = 0;        
    $scope.dropCallback = function(event, index, item) {        
        console.log('drop : ' + index);
        $scope.dropIndex = index;   
        return item;
    };

    $scope.movedCallback = function(event, index, item) {      
        $scope.list_program_saved.splice(index, 1);              
        if($scope.dragIndex == $scope.dropIndex || $scope.dragIndex == $scope.dropIndex-1)      
        {

        }   
        else
        {
            var array_order = [];
            angular.forEach($scope.list_program_saved, function(value, key) {
              this.push(value.Program.id);
            }, array_order);
            $http({
                method  : 'POST',
                url     : '/Apis/reorderProgram.json',            
                data    : array_order,  // pass in data as strings
                headers : { 'Content-Type': 'application/json' }  // set the headers so angular passing info as form data (not request payload)
            }).success(function(data) {
                    console.log(data);
                    if(data.message != "success")
                    {
                        window.location='/Users/edit_profile';
                    }                  
            });
        }                           
    };

    $scope.dragStartCallback = function(event, index, item) {      
        console.log('drag : ' + index);     
        $scope.dragIndex = index;     
    };    
});

app.controller('signupController', function($scope,$http){
    $scope.formData = {};
    $scope.message = '';
    $scope.next = function() {
        var data = $scope.formData;
        console.log(data);
        $http({
            method  : 'POST',
            url     : '/Apis/registerByUsername.json',            
            data    : $scope.formData,  // pass in data as strings
            headers : { 'Content-Type': 'application/json' }  // set the headers so angular passing info as form data (not request payload)
        })
            .success(function(data) {
                console.log(data);  
                if(data.message == "success")
                    window.location='/Users/edit_profile';
                else
                    $scope.message = data.message;
            })
    };
    $scope.signIn = function() {
        window.location='/Users/login';
    }
});

app.controller('LoginController', function($scope,$http,$location){
    $scope.formData = {};
    $scope.message = '';
    $scope.signIn = function() {
        var data = $scope.formData;
        console.log(data);
        $http({
            method  : 'POST',
            url     : '/Apis/loginByEmailAndPassword.json',
            data    : $scope.formData,  // pass in data as strings
            headers : { 'Content-Type': 'application/json' }  // set the headers so angular passing info as form data (not request payload)
        })
            .success(function(data) {
                console.log(data);
                if(data.message == 'success')
                    window.location= '/Users/index';
                else
                    $scope.message = data.message;
            })
    };
    $scope.signUp = function() {
        window.location='/Users/signup';
    }
});
app.directive( 'test', function ( $compile ) {
  return {
    restrict: 'E',
    scope: { text: '@' },
    template: '<p ng-click="add()">{{text}}</p>',
    controller: function ( $scope, $element ) {
      $scope.add = function () {
        var el = $compile( "<test text='n'></test>" )( $scope );
        $element.parent().append( el );
      };
    }
  };
});
app.directive( 'creator', function ( $compile ) {
  return {
    restrict: 'E',
    template : "<div ng-model=\"model_temp_plus\" data-drop=\"true\" jqyoui-droppable=\"{multiple:true, onDrop: 'dropCallbackPlus(model_temp_plus)'}\" class=\"exercise_box\">\
                    <div class=\"box_program_vew box_creator\" layout-align=\"center center\" layout=\"row\">\
                        <div ng-click=\"create_exercise(1);\" class=\"box_creator_plus\" layout-align=\"center center\" layout=\"row\">+</div>\
                    </div>\
                </div>",
    controller: function ( $scope, $element ) {
        $scope.showOptionChooseTypeExercise = false;        
        $scope.create_exercise = function(event, model_temp_plus){           
            var day_number = $scope.$parent.index_current_tab;
            var program_item = {            
                'mode':'1',
                'order':'1',
                'exercise_item':[
                    {
                        'exercise_id':'',
                        'series':'',
                        'repeatation_from':'',
                        'repeatation_to':'',
                        'hold':'',
                        'Exercise':null
                    }
                ],
                'text':''                   
            };   
            if(model_temp_plus != undefined){
                var data = angular.copy(model_temp_plus);
                program_item.exercise_item[0].exercise_id = data.Exercise.id;
                program_item.exercise_item[0].Exercise = data.Exercise;
                //$element.remove();
            }
                    
            $scope.$parent.tabs[day_number-1].exercise_list.push(program_item);
            

        }
        $scope.dropCallbackPlus = function(event, ui, model_temp_plus){
            $scope.create_exercise(event, model_temp_plus);            
        };
    }
  };
});

app.controller('ExerciseProgramEditorController', function($scope,$http,$filter,$compile,$timeout,fileUpload){
    $scope.exercises_list_backup = [];
    $scope.exercises_beforefilter_backup = [];
    $scope.exercises_list = [];
    $scope.body_part_id = "";
    $scope.exercise_type = ""; // select type of exercise when using on Iphone portrait device   
    $scope.showOptionChooseTypeExercise = false;
    $scope.testdrop = '';
    $scope.selectedObjective = '';
    $scope.index_current_tab = 1;
    $scope.descriptive = '';
    $scope.short_text = '';
    $scope.isLoading = false;
    $scope.isShowTabs = true;
    $scope.isLoadingExercises = true;    
    $scope.imgURL = "";
    // tabs 
    $scope.tabs = [];    
    $scope.index = 1;   
    $scope.tabs.push(
        {
            'day_number':'',
            'exercise_list': []
        }
    );    
    var program_item = {
        'day_number': $scope.index,
        'exercise_list': [            
            {
                'mode':'1',
                'order':'1',
                'exercise_item':[
                    {
                        'exercise_id':'',
                        'series':'',
                        'repeatation_from':'',
                        'repeatation_to':'',
                        'hold':'',
                        'Exercise':null
                    }
                ],
                'text':''   
            }              
        ]        
    };   
    $scope.tabs.unshift(program_item);
    $scope.selectedIndex = 0;    
    // end tabs
    var program_id = window.location.search;
    program_id = program_id.substr(program_id.indexOf("=") + 1);
     
    if(program_id!=""){
        $scope.isLoading = true;
        $scope.isShowTabs = false;
    }

    $http.get('/Apis/getListObjective.json')
        .then(function(res){         
            $scope.objective_items = res.data.objective_list;            
        });
    // get list body part
    $http.get('/Apis/getListBodyPart.json')
        .then(function(res){   
            $scope.body_part_items = res.data.body_list;
        });
    // get list exercise
    $http.get('/Apis/getListExerciseProgramEditor.json')
        .then(function(res){
            $scope.exercises_like = res.data.exercises_like;
            $scope.exercises_list = angular.copy(res.data.exercises_list);
            $scope.exercises_list_backup = angular.copy(res.data.exercises_list);    
            $scope.isLoadingExercises = false;
        }).then(function(){// get list programs

            if(program_id){
                $http.get('/Apis/getListProgramEditor/'+program_id+'.json')
                .then(function(res){                        
                    $scope.tabs = res.data.message.Program.content;
                    $scope.selectObjectiveChange = res.data.message.Program.objective;
                    $scope.short_text = res.data.message.Program.short_text;
                    $scope.descriptive = res.data.message.Program.descriptive;
                    $scope.imgURL = "/upload/image/" + res.data.message.Program.photo;
                    for(var i = 0; i < $scope.tabs.length; i++){
                        for(var j = 0; j < $scope.tabs[i].exercise_list.length; j++){
                            switch($scope.tabs[i].exercise_list[j].mode)
                            {
                                case '1':  // regular                                   
                                case '2': // stretching                                                  
                                case '3':  // super set                                  
                                case '4': // with note
                                    for(var k = 0; k < $scope.tabs[i].exercise_list[j].exercise_item.length; k++)
                                    {
                                        var exercise_id = $scope.tabs[i].exercise_list[j].exercise_item[k].exercise_id;
                                        if(exercise_id!=''){
                                            var Exercise = $scope.getExerciseById(exercise_id);
                                            if(Exercise.length != 0){
                                                 $scope.tabs[i].exercise_list[j].exercise_item[k].Exercise = Exercise[0].Exercise;
                                            }
                                        }
                                    }
                                    break;                                
                            }
                        }
                    }     
                    
                    $scope.tabs.push(
                        {
                            'day_number':'',
                            'exercise_list': []
                        }
                    );  
                    $scope.isLoading = false;
                    $scope.isShowTabs = true;
                });
                
            }            

        });

    $scope.showAllExercise = true; 
    $scope.isStretchingSelected = false;
    $scope.isCardioSelected = false;   
    $scope.isMuscleSelected = false;
    
    $scope.getExerciseDetail = function(){

    }
    $scope.getExerciseById = function(exercise_id){
       var result  = $scope.exercises_list_backup.filter(function(item){
                        return item.Exercise.id == exercise_id;
                    } );
        return result;
    }   
    $scope.chooseFavouriteExerciseClick = function(){
        if($scope.showAllExercise){                        
            $scope.showAllExercise = false;
        }
        else{            
            $scope.showAllExercise = true;
        }            
        $scope.exercises_list = angular.copy($filter('filterExerciseProgramEditor')($scope.exercises_like, $scope.exercises_list_backup, $scope.showAllExercise, $scope.isStretchingSelected, $scope.isCardioSelected, $scope.isMuscleSelected, $scope.body_part_id));       
    }
    $scope.stretchingClick = function(){
        if($scope.isStretchingSelected)
        {               
            $scope.isStretchingSelected = false;
            $scope.isCardioSelected = false;  
            $scope.isMuscleSelected = false;          
        }
        else
        {
            $scope.isStretchingSelected = true;
            $scope.isCardioSelected = false;
            $scope.isMuscleSelected = false;  
        }    
        $scope.exercises_list = angular.copy($filter('filterExerciseProgramEditor')($scope.exercises_like, $scope.exercises_list_backup, $scope.showAllExercise, $scope.isStretchingSelected, $scope.isCardioSelected, $scope.isMuscleSelected, $scope.body_part_id));    
        console.log($scope.exercises_list.length);
    };
    $scope.cardioClick = function() {
        if($scope.isCardioSelected)
        {                        
            $scope.isStretchingSelected = false;
            $scope.isCardioSelected = false;
            $scope.isMuscleSelected = false;  
        }
        else
        {                            
            $scope.isStretchingSelected = false;
            $scope.isCardioSelected = true;
            $scope.isMuscleSelected = false;  
        }    
        $scope.exercises_list = angular.copy($filter('filterExerciseProgramEditor')($scope.exercises_like, $scope.exercises_list_backup, $scope.showAllExercise, $scope.isStretchingSelected, $scope.isCardioSelected, $scope.isMuscleSelected, $scope.body_part_id));    
        console.log($scope.exercises_list.length);
    };

    $scope.muscleClick = function() {
        if($scope.isMuscleSelected)
        {                        
            $scope.isStretchingSelected = false;
            $scope.isCardioSelected = false;
            $scope.isMuscleSelected = false;          
        }
        else
        {            
            $scope.isStretchingSelected = false;
            $scope.isCardioSelected = false;
            $scope.isMuscleSelected = true;
        }    
        $scope.exercises_list = angular.copy($filter('filterExerciseProgramEditor')($scope.exercises_like, $scope.exercises_list_backup, $scope.showAllExercise, $scope.isStretchingSelected, $scope.isCardioSelected, $scope.isMuscleSelected, $scope.body_part_id));    
        console.log($scope.exercises_list.length);
    };

      // select body part change
    $scope.changedValue=function(item){
        if(item.length > 0)
        {                   
            $scope.body_part_id = item;
        }
        else
        {           
           $scope.body_part_id = "";
        }
        $scope.exercises_list = angular.copy($filter('filterExerciseProgramEditor')($scope.exercises_like, $scope.exercises_list_backup, $scope.showAllExercise, $scope.isStretchingSelected, $scope.isCardioSelected, $scope.isMuscleSelected, $scope.body_part_id));       
    }
    $scope.changeValueExercise = function(item){
        switch(item){
            case "1":
                $scope.muscleClick();                
                break;
            case "2":
                $scope.stretchingClick();                
                break;
            case "3":
                $scope.cardioClick();
                break;
            default:
                $scope.isStretchingSelected = false;
                $scope.isCardioSelected = false;
                $scope.isMuscleSelected = false;
                $scope.exercises_list = angular.copy($filter('filterExerciseProgramEditor')($scope.exercises_like, $scope.exercises_list_backup, $scope.showAllExercise, $scope.isStretchingSelected, $scope.isCardioSelected, $scope.isMuscleSelected, $scope.body_part_id));
                break;
        }

    }
    $scope.set_index_current_tab = function(index_tab){
        $scope.index_current_tab = index_tab+1;        
    }
    $scope.click_icon_option = function(event){
        event.stopPropagation();
        var elem = angular.element(event.currentTarget);

        if(elem.parent().find('.option_program_editor').is(":visible")){
            elem.parent().find('.option_program_editor').hide();
        }
        else{
            elem.parent().find('.option_program_editor').show();
        }
    };
    // change type of exercise in program editor
    $scope.change_type_exercise = function(type_of_exercise, index_of_exercise){                 
        $scope.tabs[$scope.index_current_tab - 1].exercise_list[index_of_exercise].mode = type_of_exercise;
        $scope.tabs[$scope.index_current_tab - 1].exercise_list[index_of_exercise].order = type_of_exercise;
        
        var items =  [];
        // filter null item
        var exercise_item = $scope.tabs[$scope.index_current_tab - 1].exercise_list[index_of_exercise].exercise_item;
        var model1 = null;
        var model2 = null;
        var count = 0;
        for(var i = 0; i < exercise_item.length; i++){
            if(exercise_item[i].Exercise != null){
               if(count==0){
                    model1 = exercise_item[i];
                    count++;
                    continue; 
               }
               if(count==1){
                    model2 = exercise_item[i];
               }
            }
        }
        for(var i = 0; i < 4; i++){
            items[i] = {
                            'exercise_id':'',
                            'series':'',
                            'repeatation_from':'',
                            'repeatation_to':'',
                            'hold':'',
                            'Exercise':null
                        }; 
        }
    
        switch(type_of_exercise){
            case '1': // regular
            case '4': // with note
                if(model1!=null){                    
                    items[0] = model1;
                }                
                items.splice(1, 3);                              
            case '2': // stretching
                if(model2!=null){
                    items[0] = model1;
                    items[1] = model2;
                }
                else{
                    if(model1!=null){
                        items[0] = model1;
                    }
                }
            break;
            case '3': // superset
                if(model2!=null){
                    items[0] = model1;
                    items[1] = model2;
                }
                else{
                    if(model1!=null){
                        items[0] = model1;
                    }
                }
                items.splice(2, 2);  
                //$scope.tabs[$scope.index_current_tab - 1].exercise_list[index_of_exercise].exercise_item.push(item);
            break;
        }
        $scope.tabs[$scope.index_current_tab - 1].exercise_list[index_of_exercise].exercise_item = items;
    }
    // delete exerise in program editor
    $scope.delete_exercise = function(index_of_exercise,event){  
        console.log(index_of_exercise); 
        console.log($(event.target).scope().model_temp);
        $(event.target).scope().model_temp = null;
        $scope.tabs[$scope.index_current_tab - 1].exercise_list.splice(index_of_exercise, 1);
        console.log($scope.tabs[$scope.index_current_tab - 1].exercise_list);
    }    

    $scope.getImageShowOnly = function(){
        if($scope.showAllExercise){
            return "/img/images/star_show_only.png";
        }
        else{
            return "/img/images/star.png";
        }
    }
          

    // $scope.selectedIndex = 0;
    $scope.isOk = true;
    $scope.removeTab = function(tab)
    {        
        $scope.index = $scope.index - 1;        
        var index_remove = $scope.tabs.indexOf(tab);
        if(index_remove == 0){
            $scope.index_current_tab = 1;
        }
        else{
            $scope.index_current_tab = $scope.index_current_tab - 1;
        }       
        $scope.tabs.splice(index_remove, 1);
        // update the index
        var j = index_remove;
        for(j = index_remove; j < $scope.tabs.length - 1; j++){       
            var daynumber = $scope.tabs[j].day_number;             
            $scope.tabs[j].day_number = daynumber - 1;    
        }   

        if(index_remove == $scope.tabs.length - 1)
        {
            $scope.isOk = false;
            $timeout(function () {
                $scope.isOk = true;
                $scope.selectedIndex = $scope.tabs.length - 2;
                $scope.index_current_tab = $scope.index_current_tab - 1;
            }, 50);
        }       
    };

    $scope.addTab = function()
    {
        if(program_id!=undefined){
            $scope.index = $scope.tabs.length;    
        }
        else{
            $scope.index = $scope.index + 1;    
        }
        
        $scope.index_current_tab = $scope.index;
        var program_item = {
            'day_number': $scope.index,
            'exercise_list': [            
                {
                    'mode':'1',
                    'order':'1',
                    'exercise_item':[
                        {
                            'exercise_id':'',
                            'series':'',
                            'repeatation_from':'',
                            'repeatation_to':'',
                            'hold':'',
                            'Exercise':null
                        }
                    ],
                    'text':''  
                }              
            ]            
        };   
        $scope.tabs.splice($scope.tabs.length - 1,0,program_item);                                           
    } 
   
    $scope.isObjectiveChose = false;
    $scope.isImgChose = false;
    $scope.isSaving = false;
    $scope.isEdit = true;
    $scope.save_program = function(){  
        //console.log($scope.tabs);
        if($scope.selectObjectiveChange == "" || $scope.selectObjectiveChange == undefined || ($scope.myFile == undefined && $scope.imgURL == ""))
        {
            if($scope.selectObjectiveChange == "" || $scope.selectObjectiveChange == undefined)
                $scope.isObjectiveChose = true;
            if($scope.myFile == undefined && $scope.imgURL == "")
                $scope.isImgChose = true;
        }
        else
        {
            $scope.isSaving = true;
            //console.log($scope.tabs);
            var tabs = $scope.tabs;
            var tabs_save = angular.copy($scope.tabs);
            for(var i = 0; i < tabs_save.length; i++){
                delete tabs_save[i]['count_exercise'];

                for(var j = 0; j < tabs_save[i]['exercise_list'].length; j++){
                    for(var k = 0; k < tabs_save[i]['exercise_list'][j]['exercise_item'].length; k++){
                        delete tabs_save[i]['exercise_list'][j]['exercise_item'][k]['Exercise'];
                    }
                }
                
            } 
            if($scope.isEdit)
                tabs_save.splice(tabs_save.length-1, 1);
            var isNewImg = false;
            if($scope.myFile != undefined)
                isNewImg = true;
            var data = {
                        'tabs':tabs_save,
                        'objective':$scope.selectObjectiveChange,
                        'descriptive': $scope.descriptive,
                        'text': $scope.short_text,
                        'program_id' : program_id,
                        'isNewImg' : isNewImg
                    };
            
            $http({
                method  : 'POST',
                url     : '/Apis/saveProgramEditor.json',            
                data    : data, 
                headers : { 'Content-Type': 'application/json' }  // set the headers so angular passing info as form data (not request payload)
            })
                .success(function(data) {
                    if(data.message == 'success')
                    {
                        console.log(data);   
                        if(isNewImg == true)
                        {
                            var file = $scope.myFile;        
                            var uploadUrl = "/Apis/ProgramUploadFile.json";
                            fileUpload.uploadFileToUrl(file, uploadUrl);                    
                        }
                        else
                        {
                            window.location = "/Programs/program_view/" + data.id;
                        }                               
                    }
                    else
                    {

                    }                
                });
        }              
    }    

    $scope.preview_program = function()
    {
        if($scope.selectObjectiveChange == "" || $scope.selectObjectiveChange == undefined || ($scope.myFile == undefined && $scope.imgURL == ""))
        {
            if($scope.selectObjectiveChange == "" || $scope.selectObjectiveChange == undefined)
                $scope.isObjectiveChose = true;
            if($scope.myFile == undefined && $scope.imgURL == "")
                $scope.isImgChose = true;
        }
        else
        {
            $scope.isEdit = false;
            $scope.tabs.splice($scope.tabs.length-1, 1);
        }
    }
    $scope.backToEditor = function()
    {
        $scope.isEdit = true;
        $scope.tabs.push(
            {
                'day_number':'',
                'exercise_list': []
            }
        );
    }

    $scope.selectObjective = function(selected){
        $scope.selectedObjective = selected;  
        if(selected != 0)
            $scope.isObjectiveChose = false;
    }

    $scope.overCallback = function(event, ui){
        if($(event.target).find('.content_image').length!=0){
            $(event.target).find('.content_image').addClass('hightlight_dropzone');    
        }
        else if($(event.target).find('.content_box_img').length!=0){
            $(event.target).find('.content_box_img').addClass('hightlight_dropzone');    
        }
        else{
            $(event.target).addClass('hightlight_dropzone');
        }                
    };
    $scope.outCallback = function(event, ui){ 
        if($(event.target).find('.content_image').length!=0){
            $(event.target).find('.content_image').removeClass('hightlight_dropzone');
        }        
        else if($(event.target).find('.content_box_img').length!=0){
            $(event.target).find('.content_box_img').removeClass('hightlight_dropzone');
        }
        else{
            $(event.target).removeClass('hightlight_dropzone');    
        }
    };   

    $scope.dropCallback = function(event, ui, model_temp, index_of_exercise, type_of_exercise, index){
        if($(event.target).find('.content_image').length!=0){
            $(event.target).find('.content_image').removeClass('hightlight_dropzone');
        }
        else if($(event.target).find('.content_box_img').length!=0){
            $(event.target).find('.content_box_img').removeClass('hightlight_dropzone');
        }
        else{
            $(event.target).removeClass('hightlight_dropzone');    
        }
                
        var data = angular.copy(model_temp);        

        $scope.tabs[$scope.index_current_tab - 1].exercise_list[index_of_exercise].exercise_item[index].exercise_id = data.Exercise.id;
        $scope.tabs[$scope.index_current_tab - 1].exercise_list[index_of_exercise].exercise_item[index].Exercise = data.Exercise;

    }

    $scope.delete_exercise_drop = function(index, index_of_exercise, type_of_exercise, event){
        switch(type_of_exercise){
            case 1://regular  
            case 4://withnote
                $(event.target).scope().model_temp = null; 
                break;
            case 2:// stretching
                switch(index){
                    case 0:
                        $(event.target).scope().model_temp1 = null; 
                        break;
                    case 1:
                        $(event.target).scope().model_temp2 = null; 
                        break;
                    case 2:
                        $(event.target).scope().model_temp3 = null; 
                        break;
                    case 3:
                        $(event.target).scope().model_temp4 = null; 
                        break;
                }
                break;
            case 3://superset
                switch(index){
                    case 0:
                        $(event.target).scope().model_temp1 = null; 
                        break;
                    case 1:
                        $(event.target).scope().model_temp2 = null; 
                        break;                    
                }
                break;
        }
       
        $scope.tabs[$scope.index_current_tab - 1].exercise_list[index_of_exercise].exercise_item[index].Exercise = null;
        $scope.tabs[$scope.index_current_tab - 1].exercise_list[index_of_exercise].exercise_item[index].exercise_id = '';
    }    

    $scope.cancel_click = function()
    {
        window.location = "/Programs/index";
    }

    $scope.hoverIn = function(item){
         var videoElements = angular.element(item.target);
         videoElements[0].play();       
    };
    $scope.hoverOut = function(e){
        var videoElements = angular.element(e.target);
        videoElements[0].pause();        
        videoElements[0].currentTime = 0;
        videoElements[0].load();
    };

    $scope.dragIndex = 0;    
    $scope.dropIndex = 0; 
    $scope.dropCallback1 = function(event, index, item) {        
        console.log('drop : ' + index);   
        $scope.dropIndex = index;     
        if($scope.dragIndex == $scope.dropIndex)      
        {
             
        }   
        else
        {
            var copier = $scope.tabs[$scope.index_current_tab - 1].exercise_list[$scope.dragIndex];
            if($scope.dragIndex > $scope.dropIndex)
            {
                $scope.tabs[$scope.index_current_tab - 1].exercise_list.splice($scope.dragIndex, 1);
                $scope.tabs[$scope.index_current_tab - 1].exercise_list.splice($scope.dropIndex,0,copier);   
            }
            else
            {                
                $scope.tabs[$scope.index_current_tab - 1].exercise_list.splice($scope.dragIndex, 1);
                $scope.tabs[$scope.index_current_tab - 1].exercise_list.splice($scope.dropIndex-1,0,copier);   
            }              
        }   
        return false;
    };    

    $scope.dragStartCallback1 = function(event, index, item) {      
        console.log('drag : ' + index);       
        $scope.dragIndex = index;           
    };


});

app.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;
            
            element.bind('change', function(){
                scope.$apply(function(){
                    modelSetter(scope, element[0].files[0]);

                });
            });
        }
    };
}]);

app.service('fileUpload', ['$http', function ($http) {
    this.uploadFileToUrl = function(file, uploadUrl){
        var fd = new FormData();
        fd.append('file', file);
        $http.post(uploadUrl, fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined}
        })
        .success(function(data){            
            console.log('ok');
            window.location = "/Programs/program_view/" + data.message;
        })
        .error(function(){
            console.log('fail');
        });
    }
}]);

app.filter('filterExerciseProgramEditor', function(){
    return function(exercises_like, exercises_list_backup, showAllExercise, isStretchingSelected, isCardioSelected, isMuscleSelected, body_part_id) {
       var results = [];            
        if(showAllExercise){            
            results = exercises_list_backup.slice();  
           // console.log('1');
        }
        else{
            results = exercises_like.slice();            
           // console.log('2');
        }
        if(isMuscleSelected){
            results = exerciseOptionFilter(results, 1).slice();             
        }
        if(isStretchingSelected){
            results = exerciseOptionFilter(results, 2).slice();            
        }
        if(isCardioSelected){
            results = exerciseOptionFilter(results, 3).slice();            
        }  
        if(body_part_id != ""){
            results = exercisePartFilter(results, body_part_id);
        }       
        return results;
    }
});
app.filter('filterExercise', function(){
    return function(isStretchingSelected, isCardioSelected, isMuscleSelected, body_part_id) {
       var results = [];           
    var mode = 0;
    if(isStretchingSelected){
        mode = 1;
    }
    else if(isCardioSelected){
        mode = 2;
    }
    else if(isMuscleSelected){
        mode = 3;
    }
    $http.get('/Apis/getListExercise/'+mode+'/'+'.json')
        .then(function(res){    
            console.log(res);        
            $scope.exercises_like = res.data.exercises_like;
            $scope.exercises_list = angular.copy(res.data.exercises_list);
            $scope.exercises_list_backup = angular.copy(res.data.exercises_list);
            //$scope.print_out_view(angular.copy(res.data.exercises_list));
        });   
    return results;
    }
});
function exercisePartFilter(input, body_part_id){        
    // filter by bodypart_id
    input = input.filter(function(element){

        var j, flag = false;                
        var arr_temp = element.Exercise.bodypart_id.split('.');
        if(arr_temp.indexOf(body_part_id) != -1){
            //console.log(arr_temp.indexOf(body_part_id));    
            flag = true;
        }
        
        // for(j = 0; j < element.Exercise.muscle.length; j++){                    
        //     if(element.Exercise.muscle[j].bodypart_id == body_part_id){
        //         flag = true;                        
        //         break;
        //     }                    
        // }

        return flag;           
    });
    
    for(var i = 0; i < input.length; i++){
        input.sort(function(a, b){
            if(a.Exercise.bodypart_id.split('.').length > b.Exercise.bodypart_id.split('.').length)
                return true;
            return false;
        });
    }
    
    return input;
}
function exerciseOptionFilter(input , mode){    
    var option = "";    
    switch (mode)
    {
        case 1:
            option = "1";
            break;
        case 2:
            option = "2";
            break;
        case 3:
            option = "3";
            break;
        default :
            return input;
    }
       
    input = input.filter(function(element){
        return element.Exercise.category_id == option;
    });
    
    return input;
}
app.controller('ItemExerciseProgramEditorController', function($scope,$http,$filter,$modal,$window){    
    
    $scope.getImage = function() {
        if ( $scope.isSelected ) {
            return "/img/images/star.png";
        } else {
            return "/img/images/Star_none.png";
        }
    };
    $scope.position = 'relative';  
    
    if ( $filter('checkExerciseIsLike')($scope.exercises_like, $scope.exercise.Exercise.id))
        $scope.isSelected = true;
    else
        $scope.isSelected = false;
});

app.controller('ExerciseController', function($scope,$http,$filter){
    $scope.exercises_list_backup = [];
    $scope.exercises_beforefilter_backup = [];
    $scope.exercises_list = [];
    $scope.exercises_list_for_loadmore = [];
    $scope.isMoblie = false;
    $scope.isOver = true;
    $scope.showLoader = false;
    // detect is mobile device
    $http.get('/Apis/GetIsOnMobile.json')
        .then(function(res){            
            $scope.isMoblie = res.data.message;            
        });
    // get list exercise    
    $http.get('/Apis/getListExercise.json')
        .then(function(res){    
            console.log(res);        
            $scope.exercises_like = res.data.exercises_like;
            $scope.exercises_list = angular.copy(res.data.exercises_list);
            $scope.exercises_list_backup = angular.copy(res.data.exercises_list);
            //$scope.print_out_view(angular.copy(res.data.exercises_list));
        });
    // get list part body for select
    $http.get('/Apis/getListBodyPart.json')
        .then(function(res){
            $scope.body_part_items = res.data.body_list;
        });

    // like star handler
    $scope.deselectFriend = function( exercise ) {
        var index = $scope.exercises_like.indexOf( exercise );
        if ( index >= 0 ) {
            $scope.exercises_like.splice( index, 1 );
        }
    };
    $scope.selectFriend = function( exercise ) {
        $scope.exercises_like.push( exercise );
    };

    $scope.isStretchingSelected = false;
    $scope.isCardioSelected = false;   
    $scope.isMuscleSelected = false;
    $scope.showAllExercise = true;
    $scope.body_part_id = "";

    // filter action click
    $scope.stretchingClick = function(){
        if($scope.isStretchingSelected)
        {               
            $scope.isStretchingSelected = false;
            $scope.isCardioSelected = false;  
            $scope.isMuscleSelected = false;          
        }
        else
        {
            $scope.isStretchingSelected = true;
            $scope.isCardioSelected = false;
            $scope.isMuscleSelected = false;  
        }    
        //$scope.exercises_list = angular.copy($filter('filterExerciseProgramEditor')($scope.exercises_like, $scope.exercises_list_backup, $scope.showAllExercise, $scope.isStretchingSelected, $scope.isCardioSelected, $scope.isMuscleSelected, $scope.body_part_id));            
        $scope.print_out_view();
    };
    $scope.cardioClick = function() {
        if($scope.isCardioSelected)
        {                        
            $scope.isStretchingSelected = false;
            $scope.isCardioSelected = false;
            $scope.isMuscleSelected = false;  
        }
        else
        {                            
            $scope.isStretchingSelected = false;
            $scope.isCardioSelected = true;
            $scope.isMuscleSelected = false;  
        }    
        //$scope.exercises_list = angular.copy($filter('filterExerciseProgramEditor')($scope.exercises_like, $scope.exercises_list_backup, $scope.showAllExercise, $scope.isStretchingSelected, $scope.isCardioSelected, $scope.isMuscleSelected, $scope.body_part_id));    
         $scope.print_out_view();
    };

    $scope.muscleClick = function() {
        if($scope.isMuscleSelected)
        {                        
            $scope.isStretchingSelected = false;
            $scope.isCardioSelected = false;
            $scope.isMuscleSelected = false;          
        }
        else
        {            
            $scope.isStretchingSelected = false;
            $scope.isCardioSelected = false;
            $scope.isMuscleSelected = true;
        }    
       // $scope.exercises_list = angular.copy($filter('filterExerciseProgramEditor')($scope.exercises_like, $scope.exercises_list_backup, $scope.showAllExercise, $scope.isStretchingSelected, $scope.isCardioSelected, $scope.isMuscleSelected, $scope.body_part_id));    
         $scope.print_out_view();
    };   

    // select body part change
    $scope.changedValue=function(item){        
        if(item.length > 0)
        {                  
            $scope.body_part_id = item;
        }
        else
        {      
           $scope.body_part_id = "";
        }       
        $scope.print_out_view();
    }   

    // print out on the view
    $scope.print_out_view = function(){                
       $scope.exercises_list = angular.copy($filter('filterExerciseProgramEditor')($scope.exercises_like, $scope.exercises_list_backup, $scope.showAllExercise, $scope.isStretchingSelected, $scope.isCardioSelected, $scope.isMuscleSelected, $scope.body_part_id));    
    }
    // load more exercises
    $scope.current_ofset = 1;    
    $scope.loadmore_exercises = function(){       
        $scope.showLoader = true; 
        $scope.current_ofset = $scope.current_ofset + 1;
        $http.get('/Apis/getListExerciseLoadMore/' + $scope.current_ofset +'.json')
            .then(function(res){     
                console.log(res);                       
                var i = 0;
                for(i = 0;i<res.data.exercises_list_more.length;i++)
                {                    
                    $scope.exercises_list_backup.push( angular.copy(res.data.exercises_list_more[i]) );    
                }
                if(res.data.isOver == true)
                    $scope.isOver = false;
                $scope.print_out_view();    
                $scope.showLoader = false;        
        });          
    }  
    $scope.$on('ngRepeatFinished', function(ngRepeatFinishedEvent) {
        // append list_exercises
        var list_exercises = angular.element(document.querySelector( '#list_exercises' ));
        var temp = angular.element(document.querySelector( '#loadmore' ));           
        list_exercises.append(temp.html()); 
    });   
});
app.directive('onFinishRender', function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {
            if (scope.$last === true) {
                $timeout(function () {
                    scope.$emit('ngRepeatFinished');
                });
            }
        }
    }
});

/*' poster="{{video.Exercise.photo}}"',*/
app.directive('uiVideo', function () {
    return {
        template: [
            '<div class="video">',
            '<video class="img-responsive" preload="none"',
            ' src="{{video.Exercise.video}}"',   
            ' poster="{{video.Exercise.photo}}"',         
            ' width="208px" height="152px"',
            '</video>',
            '</div>'
        ].join(''),
        scope: {
            video: '=video'
        },
        link: function (scope, element, attrs) {
            $(element).find("video").on("ended", function () {
             var v = this.src;
             this.src='';
             this.src=v;
             });
        }
    };
});

app.controller('ItemExerciseController', function($scope,$http,$filter,$modal,$window,state){
    $scope.toggleSelection = function() {
        if(id == 0)
        {
            var modalInstance = $modal.open({
              templateUrl:'login_modal.ctp',
              controller: 'LoginModalInstanceCtrl',
              backdropClass: 'backdropClass_custom'                    
            });            
            modalInstance.result.then(function (Id) {
                console.log(Id);
                $http.get('/Apis/likeExerciseByUser/' + $scope.exercise.Exercise.id +'.json')
                    .then(function(res){
                        console.log(res);
                        $window.location.reload();
                    });
            }, function () {
            });
        }
        else
        {
            $scope.toggleStar();
        }        
    };

    $scope.hoverIn = function(item){
         var videoElements = angular.element(item.target);
         videoElements[0].play();       
    };
    $scope.hoverOut = function(e){
        var videoElements = angular.element(e.target);
        videoElements[0].pause();        
        videoElements[0].currentTime = 0;
        videoElements[0].load();
    };

    $scope.OnMobileImgClick = function(e){
        if($scope.isAnimate)
        {
            var url = "/Exercises/detail?id=" + $scope.exercise.Exercise.id;
            window.location = url;
        }
        else
        {
            state.update($scope.exercise.Exercise.id);
            $scope.isAnimate = true;
        }        
    };

    $scope.getExerciseImage = function()
    {
        if ( $scope.isAnimate ) {
            return $scope.exercise.Exercise.photo_animate;
        } else {
            return $scope.exercise.Exercise.photo;
        }
    }

    $scope.$on('state.update', function (newState) {
        if($scope.exercise.Exercise.id != newState)
             $scope.isAnimate = false;
    });

    $scope.toggleStar = function(){
        $scope.isSelected = ! $scope.isSelected;
        if ( $scope.isSelected ) {
            $http.get('/Apis/likeExerciseByUser/' + $scope.exercise.Exercise.id +'.json')
                .then(function(res){
                    console.log(res);
                });
            $scope.selectFriend( $scope.exercise );
        } else {
            $http.get('/Apis/unlikeExerciseByUser/' + $scope.exercise.Exercise.id +'.json')
                .then(function(res){
                    console.log(res);
                });
            $scope.deselectFriend( $scope.exercise );
        }
    };
    $scope.getImage = function() {
        if ( $scope.isSelected ) {
            return "/img/images/star.png";
        } else {
            return "/img/images/Star_none.png";
        }
    };

    $scope.isAnimate = false;

    if ( $filter('checkExerciseIsLike')($scope.exercises_like, $scope.exercise.Exercise.id))
        $scope.isSelected = true;
    else
        $scope.isSelected = false;
});

app.factory('state', function($rootScope) {
    var state;

    var broadcast = function (state) {
      $rootScope.$broadcast('state.update', state);
    };

    var update = function (newState) {
      state = newState;
      broadcast(state);
    };
    
    return {
      update: update,
      state: state,
    };
});


app.controller('ProgramListController', function($scope,$http,$filter,$modal,$window){
    $scope.programs_list_backup = [];
    $scope.programs_list = [];
    // get list exercise
    $http.get('/Apis/getListProgram.json')
        .then(function(res){
          //  console.log(res);
            $scope.programs_list = res.data.programs_list;
            $scope.programs_list_backup = angular.copy(res.data.programs_list);
        });
    // get list part body for select
    $http.get('/Apis/getListObjective.json')
        .then(function(res){
         //   console.log(res);
            $scope.objective_items = res.data.objective_list;
        });

    $scope.changedValue=function(item){        
        if(item.length > 0)
        {
            var temp = angular.copy($scope.programs_list_backup);
            $scope.programs_list = angular.copy($filter('programOptionFilter')(temp,item));
        }
        else
        {
            $scope.programs_list = angular.copy($scope.programs_list_backup);
        }
    }    
    
    $scope.close_legal_bar = function(option){
        // set session close legal bar
        $http.get('/Apis/setLegalBar.json')
            .then(function(){                
                switch(option){
                    case '0':
                        break;
                    case '1':
                        window.location='/Aptitudes';
                        break;
                    case '2':
                        window.location='/Privacies';        
                        break;                        
                }
            });        
    }
}
);

app.controller('ItemProgramController', function($scope,$http,$filter,$modal,$window){
    // console.log($scope.user);
    // get list of programs had saved by this User

});

app.controller('ProgramController', function($scope, $http, $modal,$window,state){
    $scope.selectedIndex = 0;   
    $scope.isAuthenticate = false;
    $http.get('/Apis/GetIsAuthenticate.json')
        .then(function(res){
            console.log(res);
            $scope.isAuthenticate = res.data.message;
        });

    $scope.modify_program = function(program_id)
    {
        var url = "/Programs/program_editor?id=" + program_id;
        window.location = url;
    }

    $scope.save_program = function(program_id){
        
        if($scope.isAuthenticate == false)
        {
            var modalInstance = $modal.open({
              templateUrl:'/Programs/login_modal.ctp',
              controller: 'LoginModalInstanceCtrl',
              backdropClass: 'backdropClass_custom'                    
            });            
            modalInstance.result.then(function (Id) {
                console.log(Id);
                $http.get('/Apis/saveProgramUserProfile/' + program_id +'.json')
                    .then(function(res){
                        console.log(res);
                        $window.location.reload();
                    });
            }, function () {
            });      
        }
        else
        {
            $scope.saveProgramHandler(program_id);
        }
    }       

    $scope.saveProgramHandler = function(program_id)
    {
        // var content = "remove_program('"+program_id+"')";
         $('.btn_save_program').hide();
         $('.btn_remove_from_profile').show();
        // $('.btn_save_program').attr('ng-click', content);
        // $('.btn_save_program').addClass('btn_remove_from_profile');        

        $http.get('/Apis/saveProgramUserProfile/' + program_id +'.json')
        .success(function(res){
            //$window.location.reload();
        }).finally(function() {           
           // $('.btn_save_program').attr('disabled', 'disabled');
        });     
    }

    $scope.remove_program = function(program_id){            
        if($scope.isAuthenticate == false)
        {        
            var modalInstance = $modal.open({
              templateUrl:'/Programs/login_modal.ctp',
              controller: 'LoginModalInstanceCtrl',
              backdropClass: 'backdropClass_custom'                    
            });            
            modalInstance.result.then(function (Id) {
                console.log(Id);
                $http.get('/Apis/deleteAssignedProgram/' + program_id +'.json')
                    .then(function(res){
                        console.log(res);
                        $window.location.reload();
                    });
            }, function () {
            });      
        }
        else{
             $scope.removeProgramHandler(program_id);
        }
    }

    $scope.removeProgramHandler = function(program_id)
    {
        $('.btn_save_program').show();
        $('.btn_remove_from_profile').hide();       

        $http.get('/Apis/deleteAssignedProgram/' + program_id +'.json')
        .success(function(res){
           // $window.location.reload();
        }).finally(function() {           
           // $('.btn_save_program').attr('disabled', 'disabled');
        });     
    }    
});

app.controller('ForgetPasswordController', ['$scope', '$http' , '$sce' , function($scope,$http,$sce){
    $scope.message = "";
    $scope.isReset = true;
    $scope.showLoader = false;
    $scope.reset = function(){
        $scope.showLoader = true;
        $http({
            method  : 'POST',
            url     : '/Apis/resetPassword.json',
            data    : {'email' : $scope.email},  // pass in data as strings
            headers : { 'Content-Type': 'application/json' }  // set the headers so angular passing info as form data (not request payload)
        })
            .success(function(data) {
                $scope.showLoader = false;
                console.log(data);
                if(data.message == "success")
                    $scope.isReset = false;
                else
                    $scope.message = $sce.trustAsHtml(data.message);
            })
    }
}
]);

app.controller('LoginModalInstanceCtrl', function($scope,$modalInstance, $http){
    $scope.formData = {};
    $scope.message = '';
    $scope.signIn = function() {
        var data = $scope.formData;
        console.log(data);
        $http({
            method  : 'POST',
            url     : '/Apis/loginByEmailAndPassword.json',
            data    : $scope.formData,  // pass in data as strings
            headers : { 'Content-Type': 'application/json' }  // set the headers so angular passing info as form data (not request payload)
        })
            .success(function(data) {                
                if(data.message == 'success')                
                    $modalInstance.close(data.id);                        
                else
                    $scope.message = data.message;
            })
    };
    $scope.signUp = function() {
        window.location='/Users/signup';
    };

    FB.init({
        appId: '577637839045306',
        //appId: '609280322537059', // gym.miratik.com account test
        status: true,
        cookie: true,
        oauth: true
    });

    $scope.login = function ()
    {
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                FB.api('/me', function(response1) {
                    console.log(response1);
                    $http({
                        method  : 'GET',
                        url     : '/Apis/loginByFbId/' + response1.id +'.json'
                    })
                        .success(function(data) {
                            if(data.message == 'success')
                                $modalInstance.close("123");
                        })
                });
            } else {
                FB.login(function(response) {
                 if (response.authResponse)
                 {
                     FB.api('/me', function(response1) {
                     console.log(response1);
                     $http({
                         method  : 'GET',
                         url     : '/Apis/loginByFbId/' + response1.id +'.json'
                         })
                         .success(function(data) {
                         if(data.message == 'success')
                              $modalInstance.close();
                         else
                             window.location='/Users/signup';
                         })
                     });
                 } else
                 {
                     console.log('User cancelled login or did not fully authorize.');
                 }
                 },{scope: 'email,publish_actions,user_friends'});
                 //window.location='/Users/signup';
            }
        })
    }
}
);
app.controller('ChangepassController', function($http, $scope, $timeout){
    var model = this;
    $scope.showLoader = false;

    model.message = "";    
    model.user = {    
      password: "",
      confirmPassword: ""
    };

    $scope.cancel = function(){
        window.location = '/Users/edit_profile';
    }

    $scope.save = function() {
        $scope.showLoader = true;
        $http({
                method  : 'POST',
                url     : '/Apis/changePassword.json',
                data    : {'password' : model.user.password},  // pass in data as strings
                headers : { 'Content-Type': 'application/json' }  // set the headers so angular passing info as form data (not request payload)
            })
            .success(function(data) {
                $scope.showLoader = false;
                if(data.message == "success")
                {
                    model.message = "Change password successful!";            
                }                    
                else
                    model.message = "Change password failed!";

                $timeout(function(){
                    window.location = '/Users/edit_profile';
                }, 1000);
            })

        };
});
app.directive('compareTo', function(){
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
});

app.directive('draggable', function() {
  return function(scope, element) {
    // this gives us the native JS object
    var el = element[0];
    
    el.draggable = true;
    
    el.addEventListener(
      'dragstart',
      function(e) {
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('Text', this.id);
        this.classList.add('drag');
        return false;
      },
      false
    );
    
    el.addEventListener(
      'dragend',
      function(e) {
        this.classList.remove('drag');
        return false;
      },
      false
    );
  }
});
app.directive('droppable', function() {
  return {
    scope: {
      drop: '&',
      bin: '='
    },
    link: function(scope, element) {
      // again we need the native object
      var el = element[0];
      
      el.addEventListener(
        'dragover',
        function(e) {
          e.dataTransfer.dropEffect = 'move';
          // allows us to drop
          if (e.preventDefault) e.preventDefault();
          this.classList.add('over');
          return false;
        },
        false
      );
      
      el.addEventListener(
        'dragenter',
        function(e) {
          this.classList.add('over');
          return false;
        },
        false
      );
      
      el.addEventListener(
        'dragleave',
        function(e) {
          this.classList.remove('over');
          return false;
        },
        false
      );
      
      el.addEventListener(
        'drop',
        function(e) {
          // Stops some browsers from redirecting.
          if (e.stopPropagation) e.stopPropagation();
          
          this.classList.remove('over');
          
          var binId = this.id;
          var item = document.getElementById(e.dataTransfer.getData('Text'));
          this.appendChild(item);
          // call the passed drop function
          scope.$apply(function(scope) {
            var fn = scope.drop();
            if ('undefined' !== typeof fn) {            
              fn(item.id, binId);
            }
          });
          
          return false;
        },
        false
      );
    }
  }
});

app.controller('DeleteaccountController', function($http, $scope, $mdDialog, $timeout){
    var model = this;
    model.email = "";
    model.message = "";
    $scope.showLoader = false;
    model.submit = function(isValid){
         if(isValid && model.email!=""){
             var confirm = $mdDialog.confirm()
              .title('Would you like to delete your account?')
              .content('')
              .ariaLabel('Lucky day')
              .ok('OK')
              .cancel('Cancel')
              .targetEvent();
            $mdDialog.show(confirm).then(function() {  
                $scope.showLoader = true;        
                $http({
                    method  : 'POST',
                    url     : '/Apis/deleteAccount.json',
                    data    : {'email' : model.email},  
                    headers : { 'Content-Type': 'application/json' }  // set the headers so angular passing info as form data (not request payload)
                })
                .success(function(data) {         
                    $scope.showLoader = false;
                    if(data.message == "email_does_not_match"){
                        model.message = "Your email does not match!";   
                        $timeout(function(){
                            model.message = "";
                        }, 3000);
                    }
                    else{
                        model.message = "Delete account successful!";
                        window.location='/Users/login';
                    }
                     
                }) 
            }, function() {          
                // do code here when click on cancel button
            });
        }else{

        }        
    };
});
// Filter part
app.filter('checkExerciseIsLike', function() {
    return function(input, id) {
        var i=0, len=input.length;
        for (i; i<len; i++) {
            if (input[i].Exercise.id == id) {
                return true;
            }
        }
        return false;
    }
});

app.filter('programOptionFilter', function() {
    return function(input , item) {
        var i=0, len=input.length;
        var option = "";
        var offset = 0;        
        for (i; i<len; i++) {
            if (input[i - offset].Program["objective"] != item ) {
                input.splice( i - offset, 1 );
                offset++ ;
            }
        }
        return input;
    }
});

app.controller('VideoController', function($scope,$http,$filter,state){     
        $scope.isAnimate = false;
        $scope.exercise_id = '';   
        $scope.hoverIn = function(item){
            var videoElements = angular.element(item.target);
            videoElements[0].play();       
        };
        $scope.hoverOut = function(e){
            var videoElements = angular.element(e.target);
            videoElements[0].pause();        
            videoElements[0].currentTime = 0;
            videoElements[0].load();
        };

        $scope.OnMobileImgClick = function(e,id){
            $scope.exercise_id = id;
            if($scope.isAnimate)
            {
                var url = "/Exercises/detail?id=" + id;
                window.location = url;
            }
            else
            {
                state.update(id);
                $scope.isAnimate = true;
            }        
        };

        $scope.getExerciseImage = function(static_img,animate)
        {
            if ( $scope.isAnimate ) {
                return animate;
            } else {
                return static_img;
            }
        }

        $scope.$on('state.update', function (newState) {
            if($scope.exercise_id != newState)
                 $scope.isAnimate = false;
        });
    }
);

app.controller('TestRepeatController', function($scope){
        $scope.dragoverCallback = function(event, index, external, type) {
            $scope.logListEvent('dragged over', event, index, external, type);
            return index > 0;
        };

        $scope.dropCallback = function(event, index, item, external, type, allowedType) {
            $scope.logListEvent('dropped at', event, index, external, type);
            if (external) {
                if (allowedType === 'itemType' && !item.label) return false;
                if (allowedType === 'containerType' && !angular.isArray(item)) return false;
            }
            return item;
        };

        $scope.logEvent = function(message, event) {
            console.log(message, '(triggered by the following', event.type, 'event)');
            console.log(event);
        };

        $scope.logListEvent = function(action, event, index, external, type) {
            var message = external ? 'External ' : '';
            message += type + ' element is ' + action + ' position ' + index;
            $scope.logEvent(message, event);
        };

        $scope.items = [];
        var id = 0;
        // Initialize model
        for (var k = 0; k < 7; ++k) {
            $scope.items.push({label: 'Item ' + id++});
        }
        
        

        $scope.$watch('model', function(model) {
            $scope.modelAsJson = angular.toJson(model, true);
        }, true);
    }
);




}());