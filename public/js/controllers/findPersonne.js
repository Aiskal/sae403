var myApp = angular.module('findPersonne',[]);
myApp.controller('trouverPersonne', ['$scope', function($scope) {
    
    $scope.personnes = [
        {name:'Flo', role:'etudiant'},
        {name:'Adrien', role:'professeur'},
        {name:'Anna', role:'sansrole'},
        {name:'Boris', role:'admin'}
    ]
}]);
