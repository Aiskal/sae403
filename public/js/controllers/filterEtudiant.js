var myApp = angular.module('MyApp',[]);

myApp.controller('myCtrl',['$scope', function($scope){
    $scope.customers = [
        {nom:'andi',email:'andi@email.com',country:'UK'},
        {nom:'brown',email:'brown@email.com',country:'NL'},
        {nom:'jake',email:'jake@email.com',country:'DE'},
        {nom:'jane',email:'jane@email.com',country:'UK'},
        {nom:'mike',email:'mike@email.com',country:'US'},
        {nom:'xemmy',email:'xemmy@email.com',country:'US'},
        {nom:'zahra',email:'zahra@email.com',country:'CA'},
        {nom:'안나',email:'안나@이매일.컴',country:'KO'}
        ]
}])


