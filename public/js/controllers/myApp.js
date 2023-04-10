angular.module('MyApp', [])
  .controller('monController', function($scope) {
    $scope.show = false;
    $scope.showDiv = function() {
        $scope.show = !$scope.show;
    }
  });