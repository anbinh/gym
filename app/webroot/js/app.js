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

app.controller('UserController', function($scope,$http) {
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
                    window.location='/Programs/index';
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
    template : "<div class=\"exercise_box\">\
                    <div class=\"box_program_vew box_creator\" layout-align=\"center center\" layout=\"row\">\
                        <div ng-click=\"create_exercise(1);\" class=\"box_creator_plus\" layout-align=\"center center\" layout=\"row\">+</div>\
                    </div>\
                </div>",
    controller: function ( $scope, $element ) {
        $scope.showOptionChooseTypeExercise = false;        
        $scope.create_exercise = function(){
            // hide option dropdown list
            $scope.showOptionChooseTypeExercise = !$scope.showOptionChooseTypeExercise;    
            var type_of_exercise = 1;
            var day_number = $scope.$parent.index_current_tab;
            // tracking index of exercise when create new
            var index_of_exercise = $scope.$parent.tabs[day_number-1]["exercise_list"].length;
            var exercise_template = "";                                

            exercise_template = "<regular isnew='1' index='"+index_of_exercise+"' type='"+type_of_exercise+"' day='"+day_number+"'></regular>";        
           // exercise_template = "<superset type='"+type_of_exercise+"' day='"+day_number+"'></superset>";
            var el = $compile( exercise_template )( $scope );           
            el.insertBefore($element);
        }
        $scope.click_icon_option = function(){
            $scope.showOptionChooseTypeExercise = !$scope.showOptionChooseTypeExercise;
        };
    }
  };
});
app.directive( 'regular', function ( $compile ) {
  return {
    // model = tabs.day_1.exercise 
    restrict: 'E',
    scope: { 
        type: '@',
        day: '@',
        index: '@',
        isnew: '@',     
    },
    template : "<div ng-model=\"model_temp\" data-drop=\"true\" jqyoui-droppable=\"{multiple:true, onDrop: 'dropCallback()', onOver: 'overCallback()', onOut: 'outCallback()'}\" class=\"exercise_box\">\
                    <div class=\"box_program_vew\">\
                        <div class=\"header_box\">\
                            <p>1</p>\
                            <img ng-click=\"click_icon_option()\" src=\"/img/images/icon_option.png\">\
                        </div>\
                        <ul ng-show=\"showOptionChooseTypeExercise\" class=\"option_program_editor\">\
                            <li ng-click=\"change_type_exercise('2')\">Stretching</li>\
                            <li ng-click=\"change_type_exercise('3')\">Super-set</li>\
                            <li ng-click=\"change_type_exercise('4')\">With notes</li>\
                            <li ng-click=\"change_type_exercise('5')\">Only text</li>\
                            <li ng-click=\"delete_exercise()\">Delete</li>\
                        </ul>\
                        <div class=\"content_box_regular\">\
                            <div class=\"content_image\" layout-align=\"center center\" layout=\"column\">\
                                <img ng-click=\"delete_exercise_drop();\" ng-show=\"model_temp != null ? true : false\" class=\"icon_delete_regular\" src=\"/img/images/delete_copy.png\">\
                                <video ng-mouseover=\"hoverIn($event)\" ng-mouseleave=\"hoverOut($event)\" class=\"img-responsive\" preload=\"none\" src=\"{{model_temp.Exercise.video}}\" poster=\"{{model_temp != null ? model_temp.Exercise.photo : '/img/images/drag_exercise.png'}}\" <=\"\" video=\"\"></video>\
                                <div>{{model_temp == null ? 'DRAG EXERCISE' : ''}}</div>\
                            </div>\
                            <p class=\"name_exercise\">{{model_temp.Exercise.name}}</p>\
                        </div>\
                        <div class=\"fotter_box\" layout-align=\"center center\" layout=\"row\">\
                            Serie\
                            <input class=\"serie1\" type=\"text\" value=\"{{model_temp.serie}}\">\
                            Repeation\
                            <input class=\"repeat1\" type=\"text\" value=\"{{model_temp.repeat}}\">\
                        </div>\
                    </div>\
                </div>",
    link: function ( $scope, $element ) {         
        var day = $scope.day;          
        var exercise_list_item = {
            'mode':$scope.type,
            'order':$scope.type,
            'exercise_item':[],
            'text':''            
        };
        
        
        if($scope.isnew == 1){ // create new an exercise

            $scope.$parent.tabs[day-1]["exercise_list"].push(exercise_list_item); 
            $scope.$parent.tabs[day-1]["count_exercise"]++;

        }
        else{ // update exercise
            
            $scope.$parent.tabs[day-1]["exercise_list"][$scope.index] = exercise_list_item;

        } 
        

        $scope.dropCallback = function(event, ui){            
            var exercise = $(event.target).scope().model_temp;
            $scope.$parent.tabs[day-1]["exercise_list"][$scope.index]['exercise_item'][0] = {'exercise_id':exercise.Exercise.id};
            $(event.target).find('.content_image').removeClass('hightlight_dropzone');          
        };             
        $scope.overCallback = function(event, ui){
            $(event.target).find('.content_image').addClass('hightlight_dropzone');
        };
        $scope.outCallback = function(event, ui){
            $(event.target).find('.content_image').removeClass('hightlight_dropzone');
        };        
        
        $scope.showOptionChooseTypeExercise = false;
        $scope.click_icon_option = function(){            
            $scope.showOptionChooseTypeExercise = !$scope.showOptionChooseTypeExercise;
        };

        //change type of exercise
        $scope.change_type_exercise = function(type_of_exercise){           
            $scope.showOptionChooseTypeExercise = !$scope.showOptionChooseTypeExercise;         
            $scope.$parent.change_type_exercise($element, type_of_exercise);
        }
        // delete exercise
        $scope.delete_exercise = function(type_of_exercise){           
            $scope.showOptionChooseTypeExercise = !$scope.showOptionChooseTypeExercise;         
            $scope.$parent.delete_exercise($element);
        }
        // delete exercise drop
        $scope.delete_exercise_drop = function(){            
            $scope.$parent.tabs[day-1]["exercise_list"][0]["exercise_item"].splice(0, 1);
            $(event.target).scope().model_temp = null;           
        }
    }
  };
});
app.directive( 'stretching', function ( $compile ) {
  return {
    restrict: 'E',
    scope: { 
        type: '@',
        day: '@',
        index: '@',
        isnew: '@'            
    },
    template: "<div class=\"exercise_box\">\
                    <div class=\"box_program_vew\">\
                        <div class=\"header_box\">\
                            <p>1</p>\
                            <img ng-click=\"click_icon_option()\" src=\"/img/images/icon_option.png\">\
                        </div>\
                        <ul ng-show=\"showOptionChooseTypeExercise\" class=\"option_program_editor\">\
                            <li ng-click=\"change_type_exercise('1')\">Regular</li>\
                            <li ng-click=\"change_type_exercise('3')\">Super-set</li>\
                            <li ng-click=\"change_type_exercise('4')\">With notes</li>\
                            <li ng-click=\"change_type_exercise('5')\">Only text</li>\
                            <li ng-click=\"delete_exercise()\">Delete</li>\
                        </ul>\
                        <div class=\"content_box_stretching\">\
                            <div ng-model=\"model_temp1\" data-drop=\"true\" jqyoui-droppable=\"{multiple:true, onDrop: 'dropCallback(0)', onOver: 'overCallback()', onOut: 'outCallback()'}\" class=\"content_box_img\" layout-align=\"center center\" layout=\"column\">\
                                <img ng-click=\"delete_exercise_drop(0);\" ng-show=\"model_temp1 != null ? true : false\" class=\"icon_delete_stretching\" src=\"/img/images/delete_copy.png\">\
                                <video ng-mouseover=\"hoverIn($event)\" ng-mouseleave=\"hoverOut($event)\" class=\"img-responsive\" preload=\"none\" src=\"{{model_temp1.Exercise.video}}\" poster=\"{{model_temp1 != null ? model_temp1.Exercise.photo : '/img/images/drag_exercise.png'}}\" <=\"\" video=\"\"></video>\
                            </div>\
                            <div ng-model=\"model_temp2\" data-drop=\"true\" jqyoui-droppable=\"{multiple:true, onDrop: 'dropCallback(1)', onOver: 'overCallback()', onOut: 'outCallback()'}\" class=\"content_box_img\" layout-align=\"center center\" layout=\"column\">\
                                <img ng-click=\"delete_exercise_drop(1);\" ng-show=\"model_temp2 != null ? true : false\" class=\"icon_delete_stretching\" src=\"/img/images/delete_copy.png\">\
                                <video ng-mouseover=\"hoverIn($event)\" ng-mouseleave=\"hoverOut($event)\" class=\"img-responsive\" preload=\"none\" src=\"{{model_temp2.Exercise.video}}\" poster=\"{{model_temp2 != null ? model_temp2.Exercise.photo : '/img/images/drag_exercise.png'}}\" <=\"\" video=\"\"></video>\
                            </div>\
                            <div ng-model=\"model_temp3\" data-drop=\"true\" jqyoui-droppable=\"{multiple:true, onDrop: 'dropCallback(2)', onOver: 'overCallback()', onOut: 'outCallback()'}\" class=\"content_box_img\" layout-align=\"center center\" layout=\"column\">\
                                <img ng-click=\"delete_exercise_drop(2);\" ng-show=\"model_temp3 != null ? true : false\" class=\"icon_delete_stretching\" src=\"/img/images/delete_copy.png\">\
                                <video ng-mouseover=\"hoverIn($event)\" ng-mouseleave=\"hoverOut($event)\" class=\"img-responsive\" preload=\"none\" src=\"{{model_temp3.Exercise.video}}\" poster=\"{{model_temp3 != null ? model_temp3.Exercise.photo : '/img/images/drag_exercise.png'}}\" <=\"\" video=\"\"></video>\
                            </div>\
                            <div ng-model=\"model_temp4\" data-drop=\"true\" jqyoui-droppable=\"{multiple:true, onDrop: 'dropCallback(3)', onOver: 'overCallback()', onOut: 'outCallback()'}\" class=\"content_box_img\" layout-align=\"center center\" layout=\"column\">\
                                <img ng-click=\"delete_exercise_drop(3);\" ng-show=\"model_temp4 != null ? true : false\" class=\"icon_delete_stretching\" src=\"/img/images/delete_copy.png\">\
                                <video ng-mouseover=\"hoverIn($event)\" ng-mouseleave=\"hoverOut($event)\" class=\"img-responsive\" preload=\"none\" src=\"{{model_temp4.Exercise.video}}\" poster=\"{{model_temp4 != null ? model_temp4.Exercise.photo : '/img/images/drag_exercise.png'}}\" <=\"\" video=\"\"></video>\
                            </div>\
                        </div>\
                        <div class=\"fotter_box\" layout-align=\"center center\" layout=\"row\">\
                            Serie\
                            <input class=\"serie1\" type=\"text\">\
                            Repeation\
                            <input class=\"repeat1\" type=\"text\">\
                        </div>\
                    </div>\
                </div>",
    controller: function ( $scope, $element ) {       
        var day = $scope.day;
        var exercise_list_item = {
            'mode':$scope.type,
            'order':$scope.type,
            'exercise_item':[],
            'text':''
        };        
        if($scope.isnew == 1){ // create new an exercise

            $scope.$parent.tabs[day-1]["exercise_list"].push(exercise_list_item);        

        }
        else{ // update exercise
            
            $scope.$parent.tabs[day-1]["exercise_list"][$scope.index] = exercise_list_item;

        }  
        $scope.dropCallback = function(event, ui, index){  
            var data = $(event.target).scope();
            var exercise = null;            
            switch(index){
                case 0:
                    exercise = data.model_temp1;                    
                    break;
                case 1:
                    exercise = data.model_temp2;                    
                    break;
                case 2:
                    exercise = data.model_temp3;                    
                    break;
                case 3:
                    exercise = data.model_temp4;                    
                    break;
            }
            // var exercise = $(event.target).scope().model_temp1;
            //exercise_list_item.exercise_item[index] = {'exercise_id':exercise.Exercise.id};
            $scope.$parent.tabs[day-1]["exercise_list"][$scope.index]['exercise_item'][index] = {'exercise_id':exercise.Exercise.id};
            $(event.target).removeClass('hightlight_dropzone');
        };                
        

        // hightligh cell when drag over
        $scope.overCallback = function(event, ui){
            $(event.target).addClass('hightlight_dropzone');
        };
        $scope.outCallback = function(event, ui){
            $(event.target).removeClass('hightlight_dropzone');
        };
        // delete exercise drop
        $scope.delete_exercise_drop = function(index_cell){                
            switch(index_cell){
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
            $scope.$parent.tabs[day-1]["exercise_list"][$scope.index]["exercise_item"][index_cell] = "";            
        }   

        $scope.showOptionChooseTypeExercise = false;
        $scope.click_icon_option = function(){
            $scope.showOptionChooseTypeExercise = !$scope.showOptionChooseTypeExercise;
        };

        //change type of exercise
        $scope.change_type_exercise = function(type_of_exercise){           
            $scope.showOptionChooseTypeExercise = !$scope.showOptionChooseTypeExercise;         
            $scope.$parent.change_type_exercise($element, type_of_exercise);
        }
        // delete exercise
        $scope.delete_exercise = function(type_of_exercise){           
            $scope.showOptionChooseTypeExercise = !$scope.showOptionChooseTypeExercise;         
            $scope.$parent.delete_exercise($element);
        }
    }
  };
});
app.directive( 'superset', function ( $compile ) {
  return {
    restrict: 'E',
    scope: { 
        type: '@',
        day: '@',
        index: '@',
        isnew: '@'            
    },
    template : "<div class=\"exercise_box\">\
                    <div class=\"box_program_vew\">\
                        <div class=\"header_box\">\
                            <p>1</p>\
                            <img ng-click=\"click_icon_option()\" src=\"/img/images/icon_option.png\">\
                        </div>\
                        <ul ng-show=\"showOptionChooseTypeExercise\" class=\"option_program_editor\">\
                            <li ng-click=\"change_type_exercise('1')\">Regular</li>\
                            <li ng-click=\"change_type_exercise('2')\">Stretching</li>\
                            <li ng-click=\"change_type_exercise('4')\">With notes</li>\
                            <li ng-click=\"change_type_exercise('5')\">Only text</li>\
                            <li ng-click=\"delete_exercise()\">Delete</li>\
                        </ul>\
                        <div ng-model=\"model_temp1\" data-drop=\"true\" jqyoui-droppable=\"{multiple:true, onDrop: 'dropCallback(0)', onOver: 'overCallback()', onOut: 'outCallback()'}\" class=\"content_box_super_set\">\
                            <div class=\"content_box_img\" layout-align=\"center center\" layout=\"column\">\
                                <img ng-click=\"delete_exercise_drop(0);\" ng-show=\"model_temp1 != null ? true : false\" class=\"icon_delete_superset_1\" src=\"/img/images/delete_copy.png\">\
                                <video ng-mouseover=\"hoverIn($event)\" ng-mouseleave=\"hoverOut($event)\" class=\"img-responsive\" preload=\"none\" src=\"{{model_temp1.Exercise.video}}\" poster=\"{{model_temp1 != null ? model_temp1.Exercise.photo : '/img/images/drag_exercise.png'}}\" <=\"\" video=\"\"></video>\
                            </div>\
                            <div class=\"content_box_main\" layout=\"column\">\
                                Serie\
                                <input class=\"serie2\" type=\"text\">\
                                Repetition\
                                <input class=\"repeat2\" type=\"text\">\
                            </div>\
                            <p class=\"name_exercise\">{{model_temp1.Exercise.name}}</p>\
                        </div>\
                        <div ng-model=\"model_temp2\" data-drop=\"true\" jqyoui-droppable=\"{multiple:true, onDrop: 'dropCallback(1)', onOver: 'overCallback()', onOut: 'outCallback()'}\" class=\"content_box_super_set\">\
                            <div class=\"content_box_img\" layout-align=\"center center\" layout=\"column\">\
                                <img ng-click=\"delete_exercise_drop(1);\" ng-show=\"model_temp2 != null ? true : false\" class=\"icon_delete_superset_2\" src=\"/img/images/delete_copy.png\">\
                                <video ng-mouseover=\"hoverIn($event)\" ng-mouseleave=\"hoverOut($event)\" class=\"img-responsive\" preload=\"none\" src=\"{{model_temp2.Exercise.video}}\" poster=\"{{model_temp2 != null ? model_temp2.Exercise.photo : '/img/images/drag_exercise.png'}}\" <=\"\" video=\"\"></video>\
                            </div>\
                            <div class=\"content_box_main\" layout=\"column\">\
                                Serie\
                                <input class=\"serie2\" type=\"text\">\
                                Repetition\
                                <input class=\"repeat2\" type=\"text\">\
                            </div>\
                            <p class=\"name_exercise\">{{model_temp2.Exercise.name}}</p>\
                        </div>\
                    </div>\
                </div>",
    controller: function ( $scope, $element ) {
        var day = $scope.day;
        var exercise_list_item = {
            'mode':$scope.type,
            'order':$scope.type,
            'exercise_item':[],
            'text':''
        };     
        if($scope.isnew == 1){ // create new an exercise

            $scope.$parent.tabs[day-1]["exercise_list"].push(exercise_list_item);        

        }
        else{ // update exercise
            
            $scope.$parent.tabs[day-1]["exercise_list"][$scope.index] = exercise_list_item;

        }  
         $scope.dropCallback = function(event, ui, index){  
            var data = $(event.target).scope();
            var exercise = null;            
            switch(index){
                case 0:
                    exercise = data.model_temp1;                    
                    break;
                case 1:
                    exercise = data.model_temp2;                    
                    break;               
            }            
            $scope.$parent.tabs[day-1]["exercise_list"][$scope.index]['exercise_item'][index] = {'exercise_id':exercise.Exercise.id};
            $(event.target).find('.content_box_img').removeClass('hightlight_dropzone');
        };            

        // hightlight drop zone
        $scope.overCallback = function(event, ui){
            $(event.target).find('.content_box_img').addClass('hightlight_dropzone');
        };
        $scope.outCallback = function(event, ui){
            $(event.target).find('.content_box_img').removeClass('hightlight_dropzone');
        };   

        // delete exercise drop
        $scope.delete_exercise_drop = function(index_cell){                
            switch(index_cell){
                case 0:                    
                    $(event.target).scope().model_temp1 = null; 
                    break;
                case 1:                    
                    $(event.target).scope().model_temp2 = null; 
                    break;               
            }
            $scope.$parent.tabs[day-1]["exercise_list"][$scope.index]["exercise_item"][index_cell] = "";            
        } 
        $scope.showOptionChooseTypeExercise = false;
        $scope.click_icon_option = function(){
            $scope.showOptionChooseTypeExercise = !$scope.showOptionChooseTypeExercise;
        };

        //change type of exercise
        $scope.change_type_exercise = function(type_of_exercise){           
            $scope.showOptionChooseTypeExercise = !$scope.showOptionChooseTypeExercise;         
            $scope.$parent.change_type_exercise($element, type_of_exercise);
        }
        // delete exercise
        $scope.delete_exercise = function(type_of_exercise){           
            $scope.showOptionChooseTypeExercise = !$scope.showOptionChooseTypeExercise;         
            $scope.$parent.delete_exercise($element);
        }
    }
  };
});
app.directive( 'withnote', function ( $compile ) {
  return {
    restrict: 'E',
    scope: { 
        type: '@',
        day: '@',
        index: '@',
        isnew: '@'            
    },
    template : "<div ng-model=\"model_temp\" data-drop=\"true\" jqyoui-droppable=\"{multiple:true, onDrop: 'dropCallback()', onOver: 'overCallback()', onOut: 'outCallback()'}\" class=\"exercise_box\">\
                    <div class=\"box_program_vew\">\
                        <div class=\"header_box\">\
                            <p>1</p>\
                            <img ng-click=\"click_icon_option()\" src=\"/img/images/icon_option.png\">\
                        </div>\
                        <ul ng-show=\"showOptionChooseTypeExercise\" class=\"option_program_editor\">\
                            <li ng-click=\"change_type_exercise('1')\">Regular</li>\
                            <li ng-click=\"change_type_exercise('2')\">Stretching</li>\
                            <li ng-click=\"change_type_exercise('3')\">Super-set</li>\
                            <li ng-click=\"change_type_exercise('5')\">Only text</li>\
                            <li ng-click=\"delete_exercise()\">Delete</li>\
                        </ul>\
                        <div class=\"content_box_regular\">\
                            <div class=\"content_image\" layout-align=\"center center\" layout=\"column\">\
                                <img ng-click=\"delete_exercise_drop();\" ng-show=\"model_temp != null ? true : false\" class=\"icon_delete_regular\" src=\"/img/images/delete_copy.png\">\
                                <video ng-mouseover=\"hoverIn($event)\" ng-mouseleave=\"hoverOut($event)\" class=\"img-responsive\" preload=\"none\" src=\"{{model_temp.Exercise.video}}\" poster=\"{{model_temp != null ? model_temp.Exercise.photo : '/img/images/drag_exercise.png'}}\" <=\"\" video=\"\"></video>\
                                <div>{{model_temp == null ? 'DRAG EXERCISE' : ''}}</div>\
                            </div>\
                            <p class=\"name_exercise\">{{model_temp.Exercise.name}}</p>\
                        </div>\
                        <div class=\"fotter_box\" layout-align=\"center center\" layout=\"row\">\
                            <input style=\"width:185px\" type=\"text\">\
                        </div>\
                    </div>\
                </div>",
    controller: function ( $scope, $element ) {
        var day = $scope.day;
        var exercise_list_item = {
            'mode':$scope.type,
            'order':$scope.type,
            'exercise_item':[],
            'text':''
        };     
        if($scope.isnew == 1){ // create new an exercise

            $scope.$parent.tabs[day-1]["exercise_list"].push(exercise_list_item);        

        }
        else{ // update exercise
            
           $scope.$parent.tabs[day-1]["exercise_list"][$scope.index] = exercise_list_item;

        }  

        $scope.dropCallback = function(event, ui){            
            var exercise = $(event.target).scope().model_temp;
            $scope.$parent.tabs[day-1]["exercise_list"][$scope.index]['exercise_item'][0] = {'exercise_id':exercise.Exercise.id};
            $(event.target).find('.content_image').removeClass('hightlight_dropzone');          
        };             
        $scope.overCallback = function(event, ui){
            $(event.target).find('.content_image').addClass('hightlight_dropzone');
        };
        $scope.outCallback = function(event, ui){
            $(event.target).find('.content_image').removeClass('hightlight_dropzone');
        };    

        $scope.showOptionChooseTypeExercise = false;
        $scope.click_icon_option = function(){
            $scope.showOptionChooseTypeExercise = !$scope.showOptionChooseTypeExercise;
        };

        //change type of exercise
        $scope.change_type_exercise = function(type_of_exercise){           
            $scope.showOptionChooseTypeExercise = !$scope.showOptionChooseTypeExercise;         
            $scope.$parent.change_type_exercise($element, type_of_exercise);
        }
        // delete exercise
        $scope.delete_exercise = function(type_of_exercise){           
            $scope.showOptionChooseTypeExercise = !$scope.showOptionChooseTypeExercise;         
            $scope.$parent.delete_exercise($element);
        }
        // delete exercise drop
        $scope.delete_exercise_drop = function(){            
            $scope.$parent.tabs[day-1]["exercise_list"][0]["exercise_item"].splice(0, 1);
            $(event.target).scope().model_temp = null;               
        }
    }
  };
});
app.directive( 'textonly', function ( $compile ) {
  return {
    restrict: 'E',
    scope: { 
        type: '@',
        day: '@',
        index: '@',
        isnew: '@'              
    },
    template : "<div class=\"exercise_box\">\
                    <div class=\"box_program_vew\">\
                        <div class=\"header_box\">\
                            <p>1</p>\
                            <img ng-click=\"click_icon_option()\" src=\"/img/images/icon_option.png\">\
                        </div>\
                        <ul ng-show=\"showOptionChooseTypeExercise\" class=\"option_program_editor\">\
                            <li ng-click=\"change_type_exercise('1')\">Regular</li>\
                            <li ng-click=\"change_type_exercise('2')\">Stretching</li>\
                            <li ng-click=\"change_type_exercise('3')\">Super-set</li>\
                            <li ng-click=\"change_type_exercise('4')\">With notes</li>\
                            <li ng-click=\"delete_exercise()\">Delete</li>\
                        </ul>\
                        <textarea class=\"content_only_text\" type=\"text\"></textarea>\
                    </div>\
                </div>",
    controller: function ( $scope, $element ) {
        var day = $scope.day;
        var exercise_list_item = {
            'mode':$scope.type,
            'order':$scope.type,
            'exercise_item':[],
            'text':''
        };  
        if($scope.isnew == 1){ // create new an exercise

            $scope.$parent.tabs[day-1]["exercise_list"].push(exercise_list_item);        

        }
        else{ // update exercise
            
           $scope.$parent.tabs[day-1]["exercise_list"][$scope.index] = exercise_list_item;

        }

        $scope.showOptionChooseTypeExercise = false;
        $scope.click_icon_option = function(){
            $scope.showOptionChooseTypeExercise = !$scope.showOptionChooseTypeExercise;
        };

        //change type of exercise
        $scope.change_type_exercise = function(type_of_exercise){           
            $scope.showOptionChooseTypeExercise = !$scope.showOptionChooseTypeExercise;         
            $scope.$parent.change_type_exercise($element, type_of_exercise);
        }
        // delete exercise
        $scope.delete_exercise = function(type_of_exercise){           
            $scope.showOptionChooseTypeExercise = !$scope.showOptionChooseTypeExercise;         
            $scope.$parent.delete_exercise($element);
        }
    }
  };
});
app.controller('ExerciseProgramEditorController', function($scope,$http,$filter,$compile,$timeout){
    $scope.exercises_list_backup = [];
    $scope.exercises_beforefilter_backup = [];
    $scope.exercises_list = [];
    $scope.body_part_id = "";
    $scope.exercise_type = ""; // select type of exercise when using on Iphone portrait device   
    $scope.showOptionChooseTypeExercise = false;
    $scope.testdrop = '';
    $scope.index_current_tab = 1;
    
    // get list body part
    $http.get('/Apis/getListBodyPart.json')
        .then(function(res){   
            $scope.body_part_items = res.data.body_list;
        });
    // get list exercise
    $http.get('/Apis/getListExercise.json')
        .then(function(res){
            $scope.exercises_like = res.data.exercises_like;
            $scope.exercises_list = angular.copy(res.data.exercises_list);
            $scope.exercises_list_backup = angular.copy(res.data.exercises_list);            
        });

    $scope.showAllExercise = true; 
    $scope.isStretchingSelected = false;
    $scope.isCardioSelected = false;   
    $scope.isMuscleSelected = false;
       
    $scope.chooseFavouriteExerciseClick = function(){
        if($scope.showAllExercise){                        
            $scope.showAllExercise = false;
        }
        else{            
            $scope.showAllExercise = true;
        }            
        $scope.exercises_list = angular.copy($filter('filterExerciseProgramEditor')($scope.exercises_like, $scope.exercises_list_backup, $scope.showAllExercise, $scope.isStretchingSelected, $scope.isCardioSelected, $scope.isMuscleSelected, $scope.body_part_id));    
        console.log($scope.exercises_list.length);
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
           // var temp = angular.copy($filter('filterExerciseProgramEditor')($scope.exercises_like, $scope.exercises_list_backup, $scope.showAllExercise, $scope.isStretchingSelected, $scope.isCardioSelected, $scope.isMuscleSelected));    
            //$scope.exercises_list = angular.copy($filter('exerciseOptionBodyPartFilter')(temp,4,item));
            //return;
            $scope.body_part_id = item;
        }
        else
        {
           // $scope.exercises_list = angular.copy($filter('filterExerciseProgramEditor')($scope.exercises_like, $scope.exercises_list_backup, $scope.showAllExercise, $scope.isStretchingSelected, $scope.isCardioSelected, $scope.isMuscleSelected));    
           // return;
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
    // change type of exercise in program editor
    $scope.change_type_exercise = function(element, type_of_exercise){   
        var index_of_exercise = element.attr('index');
        var day_number = $scope.index_current_tab;
        var exercise_template = '';
        switch(type_of_exercise){
            case '1':
                exercise_template = "<regular isnew='0' index='"+ index_of_exercise +"' type='"+type_of_exercise+"' day='"+day_number+"'></regular>";        
                break;
            case '2':
                exercise_template = "<stretching isnew='0' index='"+ index_of_exercise +"' type='"+type_of_exercise+"' day='"+day_number+"'></stretching>";
                break;
            case '3':
                exercise_template = "<superset isnew='0' index='"+ index_of_exercise +"' type='"+type_of_exercise+"' day='"+day_number+"'></superset>";
                break;
            case '4':                
                exercise_template = "<withnote isnew='0' index='"+ index_of_exercise +"' type='"+type_of_exercise+"' day='"+day_number+"'></withnote>";
                break;    
            case '5':
                exercise_template = "<textonly isnew='0' index='"+ index_of_exercise +"' type='"+type_of_exercise+"' day='"+day_number+"'></textonly>";
                break;
        }
        var el = $compile( exercise_template )( $scope );        
        element.replaceWith(el);
    }
    // delete exerise in program editor
    $scope.delete_exercise = function(element){
        var index_of_exercise = element.attr('index'); 
        var day_number = $scope.index_current_tab;

        // only can remove exercise in a tab, if number of exercise > 1
        if($scope.tabs[day_number-1]['count_exercise'] > 1){
            $scope.tabs[day_number-1]['exercise_list'][index_of_exercise] = '';
            element.replaceWith('');    
            $scope.tabs[day_number-1]['count_exercise'] = $scope.tabs[day_number-1]['count_exercise'] - 1;
        }        
    }
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
        'exercise_list': [],
        'count_exercise':0
    };   
    $scope.tabs.unshift(program_item);
    $scope.selectedIndex = 0;    
    $scope.create_day_program = function(){
      
    }
    
    $scope.getImageShowOnly = function(){
        if($scope.showAllExercise){
            return "/img/images/star_show_only.png";
        }
        else{
            return "/img/images/star.png";
        }
    }
   
   
    // drag 
    $scope.startCallback = function(event, ui){
        var $draggable = $(event.target);
        ui.helper.width($draggable.width());
        ui.helper.height($draggable.height());
        $draggable.css('opacity', '0');
    };
    $scope.revertCard = function(valid){
        if(!valid){
            var that = this;
            setTimeout(function(){
                $(that).css('opacity', 'inherit');
            }, 500);
        }

        return !valid;
    };
   
    $scope.dropCallback = function (event, ui) {
        var $lane = $(event.target);
        var $exercise = ui.draggable;                                  
    };

    $scope.selectedIndex = 0;
    $scope.isOk = true;
    $scope.removeTab = function(tab)
    {
        $scope.index = $scope.index - 1;        
        var index = $scope.tabs.indexOf(tab);
        if(index == 0){
            $scope.index_current_tab = 1;
        }
        else{
            $scope.index_current_tab = $scope.index_current_tab - 1;
        }     
        
        

        $scope.tabs.splice(index, 1);
        // update the index
        var j = index;
        for(j = index; j < $scope.tabs.length - 1; j++){                    
            $scope.tabs[j].day_number = $scope.tabs[j].day_number - 1;    
        }
        $scope.selectedIndex = 0;
        if(index == $scope.tabs.length - 1)
        {
            $scope.isOk = false;
            $timeout(function () {
                $scope.isOk = true;
                $scope.selectedIndex = $scope.tabs.length - 2;
            }, 50);
        }        
    };

    $scope.addTab = function()
    {
        $scope.index = $scope.index + 1;
        $scope.index_current_tab = $scope.index;
        var program_item = {
            'day_number': $scope.index,
            'exercise_list': [],
            'count_exercise': 0
        };
        $scope.tabs.splice($scope.tabs.length - 1,0,program_item);
        console.log($scope.tabs);
        $scope.selectedIndex = 0; 
    } 
});
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
       //console.log(results);
        return results;
    }
});
function exercisePartFilter(input, body_part_id){        
    // filter by bodypart_id
    input = input.filter(function(element){

        var j, flag = false;                
        for(j = 0; j < element.Exercise.muscle.length; j++){                    
            if(element.Exercise.muscle[j].bodypart_id == body_part_id){
                flag = true;                        
                break;
            }                    
        }

        if(flag){
            return true;
        }
        return false;            
    });

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
            ' src="{{video.Exercise.video_small}}"',   
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

app.controller('ProgramController', function($scope, $http, $modal,$window){
    $scope.selectedIndex = 0;   
    $scope.isAuthenticate = false;
    $http.get('/Apis/GetIsAuthenticate.json')
        .then(function(res){
            console.log(res);
            $scope.isAuthenticate = res.data.message;
        });


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
        // $scope.showLoader = true;
        // if(isValid){
        //     $http({
        //         method  : 'POST',
        //         url     : '/Apis/deleteAccount.json',
        //         data    : {'email' : model.email},  
        //         headers : { 'Content-Type': 'application/json' }  // set the headers so angular passing info as form data (not request payload)
        //     })
        //     .success(function(data) {         
        //         $scope.showLoader = false;
        //         if(data.message == "email_does_not_match"){
        //             model.message = "Your email does not match!";   
        //         }
        //         else{
        //             model.message = "Delete account successful!";
        //         }
                 
        //     }) 
        // }else{

        // }
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
// app.filter('exerciseOptionFilter', function() {
//     return function(input , mode) {
//         var i=0, len=input.length;
//         var option = "";
//         var offset = 0;
//         switch (mode)
//         {
//             case 1:
//                 option = "1";
//                 break;
//             case 2:
//                 option = "2";
//                 break;
//             case 3:
//                 option = "3";
//                 break;
//             default :
//                 return input;
//         }
           
//         input = input.filter(function(element){
//             return element.Exercise.category_id == option;
//         });
        
//         return input;
//     }
// });


// app.filter('exerciseOptionBodyPartFilter', function() {



//     return function(input , option , body_part_id) {        
        
//         // filter by category_id
//         if(option != 4)
//         {            
//             input = input.filter(function(element){
//                 return element.Exercise.category_id == option;
//             });                      
//         }
        
//         // filter by bodypart_id
//         input = input.filter(function(element){

//             var j, flag = false;                
//             for(j = 0; j < element.Exercise.muscle.length; j++){                    
//                 if(element.Exercise.muscle[j].bodypart_id == body_part_id){
//                     flag = true;                        
//                     break;
//                 }                    
//             }

//             if(flag){
//                 return true;
//             }
//             return false;            
//         });

//         return input;
//     }
// });

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