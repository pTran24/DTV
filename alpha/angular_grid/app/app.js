var app = angular.module('myApp', ['ui.bootstrap']);

app.filter('startFrom', function() {
    return function(input, start) {
        if(input) {
            start = +start; //parse to int
            return input.slice(start);
        }
        return [];
    }
});
app.filter('regex', function() {
  return function(input, field, regex) {
      var patt = new RegExp(regex);
      var out = [];
      for (var i = 0; i < input.length; i++){
          if(patt.test(input[i][field]))
              out.push(input[i]);
      }
    return out;
  };
});
app.controller('customersCtrl', function ($scope, $http, $timeout) {
    $http.get('ajax/getCustomers.php').success(function(data){
        $scope.list = data; // query result
        $scope.currentPage = 1; // current page
        $scope.entryLimit = 5; // max no of items to display in a page
        $scope.filteredItems = $scope.list.length; // Initially for no filter
        $scope.totalItems = $scope.list.length;
        $scope.search = [];
        $scope.setRange();
    });
    $scope.setPage = function(pageNo) {
        $scope.currentPage = pageNo;
        $scope.setRange();
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
    $scope.setRange = function() {
        $scope.showBegin = $scope.currentPage * $scope.entryLimit - $scope.entryLimit + 1;
        $scope.showEnd   = $scope.currentPage * $scope.entryLimit;
        if ($scope.showEnd > $scope.filteredItems) {
            $scope.showEnd = $scope.filteredItems;
        }
    };
    $scope.tableHeader = [
        'Environment',
        'HostIP',
        'Status',
        'ServiceName',
        'StartTime',
        'Capacity',
        'Txn',
        'Errors',
        'Build',
        'Project',
        'Author',
        'ModifyDate',
        'Port',
        'BasePath'
    ];
    $scope.test = "Status";
});
