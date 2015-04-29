var app = angular.module('myApp', ['ui.bootstrap', 'ngRoute']);
// configure our routes
app.config(function($routeProvider) {
    $routeProvider
    // route for the home page
    .when('/catalog', {
        templateUrl : 'views/catalog.html',
        controller  : 'catalogCtrl'
    })
    .when('/metrics', {
        templateUrl : 'views/metrics.html',
        controller  : 'metricsCtrl'
    })
    .when('/test', {
        templateUrl : 'views/test.html'
    })
    .otherwise({redirectTo: '/catalog'})
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
        { link : '#/metrics', label : 'Metrics' },
        { link : '#/test', label : 'Test' }
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
    $http.get('ajax/getCatalog.php', {cache: true}).success(function(data){
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
        'Port',
        'BasePath',
        'Status',
        'Txn',
        'Errors',
        'Project',
        'Build',
        'App',
        'Env',
        'Config',
        'Author',
        'StartTime',
        'ModifyDate'
    ];
    $scope.test = "Status";
});

app.controller('metricsCtrl', function ($scope, $http, $timeout) {
    $http.get('ajax/getMetrics-totalStatus.php').success(function(data){
        $scope.metrics = data; // query result
    });
    $http.get('ajax/getMetrics-TotalStatus.php').success(function(data){
        $scope.metrics = data; // query result
    });
    $scope.metricsHeader = [
        'Server',
        'Running',
        'Loaded',
        'Down',
        'Total'
    ];
});
