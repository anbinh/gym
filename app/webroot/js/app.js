(function(){

'use strict';
var app = angular.module('App', ['ngMaterial','ngDropdowns','ui.bootstrap','ngMessages','ngDragDrop']);

app.controller('ExerciseDetailController', function($scope,$http) {
    var exercise_id = window.location.search;
    exercise_id = exercise_id.substr(exercise_id.indexOf("=") + 1);
    $scope.isSelected = false;
    $http.get('/Apis/getExerciseDetail/' + exercise_id +'.json')
        .then(function(res){
            console.log(res);
            if(res.data.isVote == 1)
                $scope.isSelected = true;
            if(res.data.message == "NoUserLogin")
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
    $scope.isSelected = true;
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
    $scope.isExerciseShow = true;
    $scope.isProgramShow = true;
    $scope.isEdit = false;
    $scope.isSelected = true;
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
app.controller('ExerciseProgramEditorController', function($scope,$http,$filter){
    $scope.exercises_list_backup = [];
    $scope.exercises_beforefilter_backup = [];
    $scope.exercises_list = [];
    $scope.body_part_id = "";
    $scope.exercise_type = ""; // select type of exercise when using on Iphone portrait device   

    //$scope.list4 = null;
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
        console.log($scope.exercises_list.length);
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

    $scope.lanes = [
      {id:'lane1'},
      {id:'lane2'},
      {id:'lane3'}
    ];
    // drop
    $scope.dropCallback = function (event, ui) {
        var $lane = $(event.target);
        var $exercise = ui.draggable;                                  
    };
});
app.filter('filterExerciseProgramEditor', function(){
    return function(exercises_like, exercises_list_backup, showAllExercise, isStretchingSelected, isCardioSelected, isMuscleSelected, body_part_id) {
        console.log(showAllExercise);
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
    $scope.current_ofset = 0;    
    $scope.loadmore_exercises = function(){       
        $scope.showLoader = true; 
        $scope.current_ofset = $scope.current_ofset + 1;
        $http.get('/Apis/getListExerciseLoadMore/' + $scope.current_ofset +'.json')
            .then(function(res){                            
                var i = 0;
                for(i = 0;i<24;i++)
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
        $('.btn_save_program').attr('disabled', 'disabled');  
        $http.get('/Apis/saveProgramUserProfile/' + program_id +'.json')
        .success(function(res){

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
                    model.message = "Change password successful!"
                else
                    model.message = "Change password failed!"

                $timeout(function(){
                    model.message = "";
                }, 3000);
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
        $scope.hoverIn = function(e){
            var videoElements = angular.element(e.srcElement);
            videoElements[0].play();
            console.log('in');
        };
        $scope.hoverOut = function(){
            console.log('out');
        };
    }
);




}());