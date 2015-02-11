(function(){

'use strict';
var app = angular.module('App', ['ngMaterial','ngDropdowns'])
app.controller('headerController', function($scope,$timeout, $mdSidenav, $log){
    $scope.programs = 'PROGRAMS';
    $scope.exercises = 'EXERCIES';
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

app.controller('LoginController', function($scope,$http,$location){    
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
});





}());