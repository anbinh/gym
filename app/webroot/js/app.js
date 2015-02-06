(function(){

'use strict';
angular.module('App', ['ngMaterial','ngDropdowns'])
.controller('bodyController', function($scope,$timeout, $mdSidenav, $log){
    $scope.toggleRight = function() {
        $mdSidenav('right').toggle();
    };
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
})
.controller('LeftMenu', function($scope, $timeout, $mdSidenav, $log) {
    $scope.lists = [{
        title: 'Search programs',
        link: '1'
    }, {
        title: 'Search exercises',
        link: '2'
    },{
        title: 'Create a program',
        link: '3'
    },{
        title: 'Get the App',
        link: '4'
    },{
        title: 'Profile',
        link: '5'
    },{
        title: 'Lexic',
        link: '6'
    },{
        title: 'About',
        link: '7'
    },{
        title: 'Privacy Terms',
        link: '8'
    }
    ];

    $scope.itemMenuClick = function($link)
    {
        console.log($link);
    };   
})
.controller('ListController', ['$scope', '$http', function($scope, $http){
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
}]);



})();