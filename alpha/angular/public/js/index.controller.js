var app = angular.module('catalog', ['ui.bootstrap']);

app.filter('startFrom', function() {
    return function(input, start) {
        if(input) {
            start = +start; //parse to int
            return input.slice(start);
        }
        return [];
    }
});
app.controller('dataCtrl', function ($scope, $http, $timeout) {
    $scope.meals =  [
        {
            "meal"  : "breakfast",
            "item"  : "Orange Juice"
        },
        {
            "meal"  : "lunch",
            "item"  : "sandwich"
        }
    ]
    // $http.get('ajax/getCustomers.php').success(function(data){
    $http.get('ajax/getCustomers.php').success(function(data){
        $scope.list = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 5; //max no of items to display in a page
        $scope.filteredItems = $scope.list.length; //Initially for no filter
        $scope.totalItems = $scope.list.length;
    });
    $scope.setPage = function(pageNo) {
        $scope.currentPage = pageNo;
    };
    $scope.filter = function() {
        $timeout(function() {
            $scope.filteredItems = $scope.filtered.length;
        }, 10);
    };
    $scope.sort_by = function(predicate) {
        $scope.predicate = predicate;
        $scope.reverse = !$scope.reverse;
    };
});
