var app = angular.module("UserTelo", ["ngTable", "chart.js"]);

app.service('TableService', function ($http, $filter) {

    function filterData(data, filter){
        return $filter('filter')(data, filter)
    }

    function orderData(data, params){
        return params.sorting() ? $filter('orderBy')(data, params.orderBy()) : filteredData;
    }

    function sliceData(data, params){
        return data.slice((params.page() - 1) * params.count(), params.page() * params.count())
    }

    function transformData(data,filter,params){
        return sliceData( orderData( filterData(data,filter), params ), params);
    }
    var service = {
        cachedData:[],
        getTable:function($defer, params, filter, data){

            if(service.cachedData.length>0){
                service.cachedData = data;
                var filteredData = filterData(service.cachedData,filter);
                var transformedData = sliceData(orderData(filteredData,params),params);
                params.total(filteredData.length)
                $defer.resolve(transformedData);
            }
            else
            {
                angular.copy(data,service.cachedData)
                params.total(data.length)
                var filteredData = $filter('filter')(data, filter);
                var transformedData = transformData(data,filter,params)
                $defer.resolve(transformedData);
            }
        }
    };
    return service;

});

app.config(["$routeProvider", function($router)
{
    $router.when("/home", {
        templateUrl: "/templates/user/home.html"
    })
    .when("/about", {
        templateUrl: "/templates/about.html"
    })
    .when("/coupon/list", {
        templateUrl: "/templates/user/coupon/list.html"
    })
    .when("/establishments/list", {
        templateUrl: "/templates/user/establishments/list.html"
    })
    .otherwise({
        redirectTo: '/home'
    });
}]);

app.controller("HomeUserController", ['$scope', '$http', '$filter', 'ngTableParams', 'TableService', '$timeout', function($scope, $http, $filter, ngTableParams, TableService, $timeout)
{

}]);

app.controller("CouponListController", ['$scope', '$http', '$filter', 'ngTableParams', 'TableService', '$timeout', function($scope, $http, $filter, ngTableParams, TableService, $timeout)
{

}]);

app.controller("EstablishmentListController", ['$scope', '$http', '$filter', 'ngTableParams', 'TableService', '$timeout', function($scope, $http, $filter, ngTableParams, TableService, $timeout)
{

    $scope.newEstablishment={}; $scope.listCountries=[]; $scope.listProvinces = []; $scope.listCities = [];
    $scope.listEstablishments = function()
    {
        $http.get('/customer/establishments').success(function(data, status, headers, config)
        {
            $scope.establishments = data;
            $scope.total = $scope.establishments.length;
            $scope.tableParams = new ngTableParams({page:1, count:10, sorting: { id: 'asc'}}, {
                total: $scope.establishments.length,
                getData: function($defer, params)
                {
                    TableService.getTable($defer,params,$scope.filter, $scope.establishments);
                }
            });
            $scope.tableParams.reload();
            $scope.$watch("filter.$", function () {
                $scope.tableParams.reload();
            });
        });
    };

    $scope.getListCountries = function ()
    {
        $http.get('/countries').success(function(data, status, headers, config)
        {
            $scope.listCountries = data;
        });
    };

    $scope.getListProvinces = function (country_id)
    {
        $http.get('/countries/'+country_id+"/provinces").success(function(data, status, headers, config)
        {
            $scope.listProvinces = data;
        });
    };

    $scope.getListCities = function (province_id)
    {
        $http.get('/provinces/'+province_id+"/cities").success(function(data, status, headers, config)
        {
            $scope.listCities = data;
        });
    };

    $scope.getListCountries();

    $scope.listEstablishments();

    $scope.createEstablishment= function()
    {
        $http({
            method: 'POST',
            url: '/customer/establishments',
            data: $scope.newEstablishment
        }).success(function(data, status, headers, config) {
            createOrUpdateEntity('Se ha registrado un nuevo establecimiento');
        })
        .error(function(error, status, headers, config) {
            parseError(error, status);
        });
    };

    $scope.establishmentForUpdate = {};

    $scope.setEstablishmentUpdate = function(establishment)
    {
        $scope.establishmentForUpdate = establishment;
    };
}]);


/**
 *
 * @param error
 * @param status
 */
function parseError(error, status) {
    if(status == 400 || status == 406) {
        new_error = error[Object.keys(error)[0]];
        alert(JSON.stringify(new_error[0]));
        return;
    }
    alert("Ha ocurrido un error");
}

/**
 *
 * @param object
 * @param message
 */
function createOrUpdateEntity(message) {
    alert(message);
    window.location.reload()
}