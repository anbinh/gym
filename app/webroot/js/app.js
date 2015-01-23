(function(){
	var material_design = angular.module('material', ['ngMaterial']);
	material_design.controller('MaterialCtrl', function($scope){

	});

	var content_home = angular.module('content_home', ['ngMaterial'])
	.controller('AppCtrl', function($scope) {
	  $scope.data = {};
	  $scope.data.cb1 = true;
	  $scope.data.cb2 = false;
	  $scope.data.cb3 = false;
	  $scope.data.cb4 = false;
	  $scope.data.cb5 = false;
	});	
})();

// (function(){
// 'use strict';
// angular.module('flickrApp', ['ngMaterial'])
// .controller('ListController', ['$scope', '$http', function($scope, $http){
// 	$scope.results=[];
// 	$scope.search = function(){
	
// 		$http({
// 			method: 'GET',
// 			url:'https://api.flickr.com/services/rest',
// 			params:{
// 				method: 'flickr.photos.search',
// 				api_key:'b31499089ba318a6d834eb86f1a5d49e',
// 				text: $scope.searchTerm,
// 				format:'json',
// 				nojsoncallback:1
// 			}
// 		}).success(function(data){
// 			$scope.results=data;
// 		}).error(function(error){
// 			console.log(error);
// 		});
		
// 	};
// }]);

// })();