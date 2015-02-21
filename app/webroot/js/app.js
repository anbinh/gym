(function(){

'use strict';
var app = angular.module('App', ['ngMaterial','ngDropdowns'])
app.controller('headerController', function($scope,$timeout, $mdSidenav, $log){
    $scope.programs = 'PROGRAMS';
    $scope.exercises = 'EXERCIES';
    $scope.isProgramSelect = true;
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

app.controller('UserController', function($scope) {

    $scope.user = {'name': name ,'city' : city , 'street' : street};
    $scope.edit = function() {
        window.location='/Users/edit_profile';
    };

});

app.controller('UserProfileController', function($scope,$http){
    $scope.message = '';
    $scope.formData = {
        'gender' : gender,
        'username' : login,
        'firstname' : firstname,
        'lastname' : lastname,
        'email' : email,
        'language' : language,
        'address' : address,
        'birthday' : new Date(birthday),
        'receive_promote' : receive_promote,
        'id' : id
    };
    $scope.save = function() {
        var data = $scope.formData;
        console.log(data);
        $http({
            method  : 'POST',
            url     : '/Users/save_profile.json',            
            data    : $scope.formData,  // pass in data as strings
            headers : { 'Content-Type': 'application/json' }  // set the headers so angular passing info as form data (not request payload)
        })
            .success(function(data) {
                console.log(data);
                window.location='index';
            });
    };
    $scope.cancel = function() {
        window.location='index';
    };
});

app.controller('signupController', function($scope,$http,$location){
    $scope.formData = {};
    $scope.message = '';
    $scope.next = function() {
        var data = $scope.formData;
        console.log(data);
        $http({
            method  : 'POST',
            url     : '/Users/registerByUsername.json',            
            data    : $scope.formData,  // pass in data as strings
            headers : { 'Content-Type': 'application/json' }  // set the headers so angular passing info as form data (not request payload)
        })
            .success(function(data) {
                console.log(data);  
                 window.location='edit_profile';
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
            url     : '/Users/loginByEmailAndPassword.json',
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

app.controller('ExerciseController', function($scope,$http){
    $http.get('/Exercises/getListExercise.json')
        .then(function(res){
            console.log(res);
            $scope.exercises_like = res.data.exercises_like;
            $scope.exercises_list = res.data.exercises_list;
        });
    $scope.deselectFriend = function( exercise ) {
        var index = $scope.exercises_like.indexOf( exercise );
        if ( index >= 0 ) {
            $scope.exercises_like.splice( index, 1 );
        }
    };
    $scope.selectFriend = function( exercise ) {
        $scope.exercises_like.push( exercise );
    };
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


}());