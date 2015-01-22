(function(){
'use strict';
angular.module('flickrApp', ['ngMaterial'])
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