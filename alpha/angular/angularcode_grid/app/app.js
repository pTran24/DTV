var app = angular.module('myApp', ['ui.bootstrap','uiTable']);

app.filter('startFrom', function() {
    return function(input, start) {
        if(input) {
            start = +start; //parse to int
            return input.slice(start);
        }
        return [];
    };
});
app.controller('customersCrtl', function ($scope, $http, $timeout) {
    $http.get('ajax/getCustomers.php').success(function(data){
        console.log(data);
        $scope.list = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 20; //max no of items to display in a page
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

app.controller('MyCtrl', function($scope) {
    $scope.tableOptions = {
        // Use this on IE8 or very slow hardware.
        // Your cells will not be data bound
        // but use simple string replacement.
        //noCellBinding: true,
        // Use this to disable the dynamic row height feature
        // (improves rendering performance).
        //rowsHeight:24,
        // use this to set the available with for all columns
        // (useful for star-based layouts).
        //columnsWidth:1600,
        // Use headTemplate to define the column header cell template.
        // Use dataTemplate to define the data cell template for this column.
        columns:[
            {
                title:'First Name', field:'firstName',
                sort:'', sortOrder:0,
                width:'1*', fixed:'',
                headTemplate:'', dataTemplate:''
            },
            {
                title:'Last Name', field:'lastName',
                sort:'', sortOrder:0,
                width:'2*', fixed:'',
                headTemplate:'', dataTemplate:''
            },
            {
                title:'First Name', field:'firstName',
                sort:'', sortOrder:0,
                width:'50px', fixed:'',
                headTemplate:'', dataTemplate:''
            }
        ],
        // can be an array of row data or a function
        // that receives the row index and
        // returns the data for the requested row.
        data:[
            {firstName:"Walter", lastName:"Wurst", age:20},
            {firstName:"Peter", lastName:"Pan", age:21},
            {firstName:"Erwin", lastName:"Erster", age:22},
            {firstName:"Paula", lastName:"Pummel", age:23}
        ],
        // in case data is a function,
        // total has to indicate the total number of rows available.
        //total:100,
        // the selected rows data.
        selection: [],
        // allow the selection of multiple rows with the
        // SHIFT and CTRL keys.
        allowMultiSelection: true
    };
});
