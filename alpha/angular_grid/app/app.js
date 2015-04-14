var app = angular.module('myApp', ['ui.bootstrap', 'ngRoute']);
// configure our routes
app.config(function($routeProvider) {
    $routeProvider
    // route for the home page
    .when('/catalog', {
        templateUrl : 'views/catalog.html',
        controller  : 'catalogCtrl'
    })
});

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

app.controller('navCtrl', function ($scope) {
    $scope.tabs = [
        { link : '#/catalog', label : 'Catalog' },
        { link : '#/invoices', label : 'Invoices' },
        { link : '#/payments', label : 'Payments' }
    ];
    $scope.selectedTab = $scope.tabs[0];
    $scope.setSelectedTab = function(tab) {
        $scope.selectedTab = tab;
    }
    $scope.tabClass = function(tab) {
        if ($scope.selectedTab == tab) {
            return "active";
        } else {
            return "";
        }
    };
});

app.controller('catalogCtrl', function ($scope, $http, $timeout) {
    $http.get('ajax/getCatalog.php').success(function(data){
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
        'ServiceName',
        'Status',
        'Txn',
        'Errors',
        'Port',
        'BasePath',
        'Project',
        'Author',
        'Capacity',
        'Build',
        'StartTime',
        'ModifyDate'
    ];
    $scope.test = "Status";
});
