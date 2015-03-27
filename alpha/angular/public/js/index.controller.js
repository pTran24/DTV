var app = angular.module("catalog", []);

app.controller('dataCtrl', function ($scope){
    var sqlSelect = "select d.environment as Environment, d.hostip as HostIP, l.serviceName as ServiceName, l.status as Status, l.starttime as StartTime, l.capacity as Capacity, l.txncnt as Txn, l.errors as Errors, m.build as Build, m.lisaproject as Project, IFNULL(m.author, 'NULL') as Author, IFNULL(m.modifydate, 'NULL') as ModifyDate, l.port as Port, l.basepath as BasePath FROM domain d INNER JOIN lisalog l ON l.hostip = d.hostip LEFT JOIN lisamar m ON l.servicename = m.modelname AND l.hostip = m.hostip;";
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
});
