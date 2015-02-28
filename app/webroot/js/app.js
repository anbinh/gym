(function(){

'use strict';
var app = angular.module('App', ['ngMaterial','ngDropdowns'])
app.controller('headerController', function($scope,$timeout, $mdSidenav, $log){
    $scope.main_logo = "";
    $scope.programs = 'PROGRAMS';
    $scope.exercises = 'EXERCIES';
    $scope.isProgramSelect = true;
    $scope.ddLoginSelectOptions = [
        {
            text: 'Profile page',
            href: '/Users'
        },
        {
            text: 'Sign-out',
            href: '/Users/logout'
        }
    ];
    $scope.ddSelectOptions = [
        {
            text: 'ENG',
            href: '/App/changeLang/eng'
        },
        {
            text: 'FRA',
            href: '/App/changeLang/fra'
        }
    ];
    $scope.ddSelectSelected = {}; // Must be an object
    $scope.ddMenuOptions = [{
        text: 'Search programs',
        href: '#'
    }, {
        text: 'Search exercises',
        href: '#'
    },{
        text: 'Create a program',
        href: '#'
    },{
        text: 'Get the App',
        href: '#'
    },{
        text: 'Profile',
        href: '#'
    },{
        text: 'Lexic',
        href: '#'
    },{
        text: 'About',
        href: '#'
    },{
        text: 'Privacy Terms',
        href: '#'
    }
    ];
    $scope.ddMenuSelected = {};

    $scope.itemMenuClick = function($link)
    {
        console.log($link);
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
    /*$scope.click = function(param){
        console.log('param is', param);
        window.location = "/" + param;
    };*/
});

/*app.directive('header', function(){
    var curr = curr_page;
    return {
        restrict: 'E',
        replace: true,
        transclude: true,
        scope: {
            active: '=',
            click: '&'
        },
        template: '<a hide-sm ng-click="active = $id; click({param: param});" ng-class="{bottomline: $id === active}" ng-transclude class="header_text"></a>'
    }
});*/

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
    $http.get('/apis/getUserProfileAndExerciseById/' + id +'.json')
        .then(function(res){
            console.log(res);
            $scope.user = res.data.user;
            $scope.exercises_list = angular.copy(res.data.exercises_like);
            $scope.exercises_like = angular.copy(res.data.exercises_like);
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
            return "/img/images/star_blank.png";
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
                $scope.formData.password = res.data.user.password;
            });
    }

    $scope.getClassBtnAddPicture= function(isHasPicture){
        if(isHasPicture)
            return "hasProfilePicture";
        else
            return "hasNoPicture";
    }
    
    $scope.cancel = function() {
        window.location='index';
    };

    $scope.editProgram = function() {
        $scope.isEdit = true;
    };
    $scope.getImage = function() {
        if ( $scope.isSelected ) {
            return "/img/images/star.png";
        } else {
            return "/img/images/star_blank.png";
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

app.controller('signupController', function($scope,$http,$location){
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
                    window.location='edit_profile';
                else
                    $scope.message = data.message;
            })
    };
    $scope.signIn = function() {
        window.location='login';
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
                    window.location='index';
                else
                    $scope.message = data.message;
            })
    };
    $scope.signUp = function() {
        window.location='signup';
    }
});

app.controller('ExerciseController', function($scope,$http,$filter){
    $scope.exercises_list_backup = [];
    $scope.exercises_beforefilter_backup = [];
    $scope.exercises_list = [];
    // get list exercise
    $http.get('/Exercises/getListExercise.json')
        .then(function(res){
            console.log(res);
            $scope.exercises_like = res.data.exercises_like;
            $scope.exercises_list = angular.copy(res.data.exercises_list);
            $scope.exercises_list_backup = angular.copy(res.data.exercises_list);
        });
    // get list part body for select
    $http.get('/Exercises/getListBodyPart.json')
        .then(function(res){
            console.log(res);
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

    // filter action click
    $scope.muscleClick = function() {
        if($scope.isMuscleSelected)
        {
            $scope.isMuscleSelected = false;
            $scope.isStretchingSelected = false;
            $scope.isCardioSelected = false;
            $scope.exercises_list = angular.copy($scope.exercises_list_backup);
        }
        else
        {
            var temp = angular.copy($scope.exercises_list_backup);
            $scope.exercises_list = angular.copy($filter('exerciseOptionFilter')(temp,1));
            $scope.isMuscleSelected = true;
            $scope.isStretchingSelected = false;
            $scope.isCardioSelected = false;
        }
        $scope.exercises_beforefilter_backup = angular.copy($scope.exercises_list);
        $scope.selectedBodyPartItem = "";
    }
    $scope.stretchingClick = function() {
        if($scope.isStretchingSelected)
        {
            $scope.isMuscleSelected = false;
            $scope.isStretchingSelected = false;
            $scope.isCardioSelected = false;
            $scope.exercises_list = angular.copy($scope.exercises_list_backup);
        }
        else
        {
            var temp = angular.copy($scope.exercises_list_backup);
            $scope.exercises_list = angular.copy($filter('exerciseOptionFilter')(temp,2));
            $scope.isMuscleSelected = false;
            $scope.isStretchingSelected = true;
            $scope.isCardioSelected = false;
        }
        $scope.exercises_beforefilter_backup = angular.copy($scope.exercises_list);
        $scope.selectedBodyPartItem = "";
    }
    $scope.cardioClick = function() {
        if($scope.isCardioSelected)
        {
            $scope.isMuscleSelected = false;
            $scope.isStretchingSelected = false;
            $scope.isCardioSelected = false;
            $scope.exercises_list = angular.copy($scope.exercises_list_backup);
        }
        else
        {
            var temp = angular.copy($scope.exercises_list_backup);
            $scope.exercises_list = angular.copy($filter('exerciseOptionFilter')(temp,3));
            $scope.isMuscleSelected = false;
            $scope.isStretchingSelected = false;
            $scope.isCardioSelected = true;
        }
        $scope.exercises_beforefilter_backup = angular.copy($scope.exercises_list);
        $scope.selectedBodyPartItem = "";
    }
    $scope.isMuscleSelected = false;
    $scope.isStretchingSelected = false;
    $scope.isCardioSelected = false;

    // select body part change
    $scope.changedValue=function(item){
        if(item.length > 0)
        {
            var temp = angular.copy($scope.exercises_beforefilter_backup);
            if($scope.isMuscleSelected)
            {
                $scope.exercises_list = angular.copy($filter('exerciseOptionBodyPartFilter')(temp,1,item));
                return;
            }
            if($scope.isStretchingSelected)
            {
                $scope.exercises_list = angular.copy($filter('exerciseOptionBodyPartFilter')(temp,2,item));
                return;
            }
            if($scope.isCardioSelected)
            {
                $scope.exercises_list = angular.copy($filter('exerciseOptionBodyPartFilter')(temp,3,item));
                return;
            }
            temp = angular.copy($scope.exercises_list_backup);
            $scope.exercises_list = angular.copy($filter('exerciseOptionBodyPartFilter')(temp,4,item));
            return;
        }
        else
        {
            var mode = 0;
            if($scope.isMuscleSelected)
                mode = 1;
            if($scope.isStretchingSelected)
                mode = 2;
            if($scope.isCardioSelected)
                mode = 3;
            if(mode != 0)
            {
                var temp = angular.copy($scope.exercises_list_backup);
                $scope.exercises_list = angular.copy($filter('exerciseOptionFilter')(temp,mode));
            }
            else
            {
                $scope.exercises_list = angular.copy($scope.exercises_list_backup);
            }
            return;
        }
    }


});

app.controller('ItemExerciseController', function($scope,$http,$filter){
    $scope.toggleSelection = function() {
        $scope.isSelected = ! $scope.isSelected;
        if ( $scope.isSelected ) {
            $http.get('/Exercises/likeExerciseByUser/' + $scope.exercise.Exercise.id +'.json')
                .then(function(res){
                    console.log(res);
                });
            $scope.selectFriend( $scope.exercise );
        } else {
            $http.get('/Exercises/unlikeExerciseByUser/' + $scope.exercise.Exercise.id +'.json')
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
            return "/img/images/star_blank.png";
        }
    };

    if ( $filter('checkExerciseIsLike')($scope.exercises_like, $scope.exercise.Exercise.id))
        $scope.isSelected = true;
    else
        $scope.isSelected = false;
});

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

app.filter('exerciseOptionFilter', function() {
    return function(input , mode) {
        var i=0, len=input.length;
        var option = "";
        var offset = 0;
        switch (mode)
        {
            case 1:
                option = "body_building";
                break;
            case 2:
                option = "stretching";
                break;
            case 3:
                option = "cardio";
                break;
            default :
                return input;
        }
        for (i; i<len; i++) {
            if (input[i - offset].Exercise[option].length == 0 || input[i - offset].Exercise[option] == null) {
                input.splice( i - offset, 1 );
                offset++ ;
            }
        }
        return input;
    }
});

app.filter('exerciseOptionBodyPartFilter', function() {
    return function(input , mode , body_part_id) {
        var i=0, len=input.length;
        var option = "";
        var offset = 0;
        switch (mode)
        {
            case 1:
                option = "body_building";
                break;
            case 2:
                option = "stretching";
                break;
            case 3:
                option = "cardio";
                break;
            default :
                break;
        }

        if(option == "")
        {
            for (i; i<len; i++) {
                console.log(i);
                if (input[i - offset].Exercise["body_building"].length > 0)
                {
                    if(input[i - offset].Exercise["body_building"][0]['bodypart'] == body_part_id)
                    {
                        continue;
                    }
                }
                if (input[i - offset].Exercise["stretching"].length > 0)
                {
                    if(input[i - offset].Exercise["stretching"][0]['bodypart'] == body_part_id)
                    {
                        continue;
                    }
                }
                if (input[i - offset].Exercise["cardio"].length > 0)
                {
                    if(input[i - offset].Exercise["cardio"][0]['bodypart'] == body_part_id)
                    {
                        continue;
                    }
                }
                input.splice( i - offset, 1 );
                offset++ ;
            }
        }
        else
        {
            for (i; i<len; i++) {
                console.log(i);
                if (input[i - offset].Exercise[option].length > 0) {
                    if (input[i - offset].Exercise[option][0]['bodypart'] != body_part_id) {
                        input.splice(i - offset, 1);
                        offset++;
                    }
                }
            }
        }
        return input;
    }
});


}());