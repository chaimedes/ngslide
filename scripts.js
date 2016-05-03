/* 
ng-slide, an AngularJS slideshow
Main script file
Martin Berlove
4/28/2016
*/
(function() {
	
	var app = angular.module('ngslide', [])
	
	// As a service, in case we want to reuse it later.
	.factory('retrieveService', ['$http', function($http) {
		
		/* Grab the data and store it locally. */
		return function retrieve() {
			
			var images = []; // We will store the image objects here.
			
			var errors = []; // If any errors come through, store them here.
			
			$http.post('retrieve.php', {}) // Send a POST request to the PHP script.
		 
			.then(
			
				// If successful
				function(response) {
					alert(response.data[0]);
					// Loop through the data and push the data from each image to our array
					for (var i = 0; i < response.data.length; i++) {
						images.push(
						{
							src: response.data[i].url,
							title: response.data[i].title,
							caption: response.data[i].caption
						});
					} // End of looping through data
					
				}, // End of success
				
				// If unsuccessful, push an error
				function(response) {
					errors.push(response.statusText);
				}
				
			); // End of reaction
			
			return [images,errors];
		};
	}])
	
	.controller('SlideshowController', ['$scope', '$http', '$interval', 'retrieveService', function($scope, $http, $interval, retrieveService) {
		
		// Init some blankish data we'll be using later.
		$scope.data = [];
		$scope.images = [];
		$scope.errors = [];
		$scope.numImages = -1;
		$scope.imageIndex = 0; // Initially the index is at the first image

		// Move forward or restart (based on index)
		$scope.next = function() {
		  $scope.imageIndex < $scope.images.length - 1 ? $scope.imageIndex++ : $scope.imageIndex = 0;
		};

		// Move backward or restart (based on index)
		$scope.prev = function() {
		  $scope.imageIndex > 0 ? $scope.imageIndex-- : $scope.imageIndex = $scope.images.length - 1;
		};
		
		// Select an individual item based on index
		$scope.select = function(which) {
			$scope.imageIndex = which;
		};
	
		$scope.$watch(function(scope) {
			scope.images.forEach(function(image) {
				image.currentImage = false; // make every image invisible
			});
			scope.images[scope.imageIndex].currentImage = true; // make the current image visible
		});
		
		$scope.data = retrieveService();
		$scope.images = $scope.data[0];
		$scope.errors = $scope.data[1];
		
		$scope.cycleSpeed = 4000; // TODO get this as an option
		// Now start cycling
		$scope.cycle = $interval(function() {
			$scope.next();
		}, $scope.cycleSpeed);
		
	}])
	.directive("ngslide", function() {
		return {
			restrict: 'AE',
			replace: true,
			templateUrl: 'ngslide.html'
		};
	});
	
}());