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
            $scope.exercises_unlike = res.data.exercises_unlike;
        });
    $scope.ImgStartLike= "/img/images/star.png";
    $scope.ImgStartUnLike= "/img/images/star_unlike.png";
    $scope.switchPoint = true;
    $scope.toggle= function(id) {
        console.log(id);
        $scope.switchPoint= id;
    };
    /*$scope.followBtnImgUrl = '/img/images/star.png'
    $scope.merchants = [{imgUrl: "/img/images/star.png", name:"star"},
        {imgUrl: "/img/images/star_unlike.png", name: "star_unlike"}];
    $scope.toggleImage = function(merchant) {
        if(merchant.imgUrl === $scope.followBtnImgUrl) {
            merchant.imgUrl = merchant.$backupUrl;
        } else {
            merchant.$backupUrl = merchant.imgUrl;
            merchant.imgUrl = $scope.followBtnImgUrl;
        }
    };*/
});





}());