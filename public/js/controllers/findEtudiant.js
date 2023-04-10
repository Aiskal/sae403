var myApp = angular.module('findEtudiant',[]);
myApp.controller('trouverEtudiant', ['$scope', function($scope) {
    
    $scope.etudiants = [
        {name:'Adrien'},
        {name:'Anna'}
    ]
}]);
