
angular.module('app')
.controller('receiptCtrl',['ReceiptService','$scope','$http', function( ReceiptService,$scope,$http) {

	$scope.applyDate = false;
	var _fromDate  = new Date();
	_fromDate  = new Date(_fromDate.getDate(),_fromDate.getMonth() - 1,_fromDate.getYear());
	
	var _toDate = new Date();

	$scope.fromDate = _fromDate;
	$scope.toDate = _toDate;

	$scope.receiptList = {};

  $scope.clearData = function() {
    $scope.receiptList = {};
  };
  
  
 
  $scope.getData = function() {
    // Call the async method and then do stuff with what is returned inside our own then function
    ReceiptService.async_get_data().then(function(d) {
      $scope.receiptList = d.data;
      console.log($scope.receiptList);
      
    });
  };

  /* Grid Options */

	$scope.filterOptions = {
        filterText: "",
        useExternalFilter: true
    }; 
    $scope.totalServerItems = 0;
    $scope.pagingOptions = {
        pageSizes: [250, 500, 1000],
        pageSize: 250,
        currentPage: 1
    };  
    $scope.setPagingData = function(data, page, pageSize){  
        var pagedData = data.slice((page - 1) * pageSize, page * pageSize);
        $scope.myData = pagedData;
        $scope.totalServerItems = data.length;
        if (!$scope.$$phase) {
            $scope.$apply();
        }
    };
    $scope.getPagedDataAsync = function (pageSize, page, searchText) {
        setTimeout(function () {
            var data;
            if (searchText) {
                var ft = searchText.toLowerCase();
                $http.get('../src/api/php/epnt/mst/ctrl_cls_Receipt.php?a=r').success(function (largeLoad) {    
                    data = largeLoad.filter(function(item) {
                        return JSON.stringify(item).toLowerCase().indexOf(ft) != -1;
                    });
                    $scope.setPagingData(data,page,pageSize);
                });            
            } else {
                $http.get('../src/api/php/epnt/mst/ctrl_cls_Receipt.php?a=r').success(function (largeLoad) {
                    $scope.setPagingData(largeLoad,page,pageSize);
                });
            }
        }, 100);
    };

    $scope.getDataAsync = function(){
    	$scope.getPagedDataAsync($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage);

	    $scope.$watch('pagingOptions', function (newVal, oldVal) {
	        if (newVal !== oldVal && newVal.currentPage !== oldVal.currentPage) {
	          $scope.getPagedDataAsync($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage, $scope.filterOptions.filterText);
	        }
	    }, true);
	    $scope.$watch('filterOptions', function (newVal, oldVal) {
	        if (newVal !== oldVal) {
	          $scope.getPagedDataAsync($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage, $scope.filterOptions.filterText);
	        }
	    }, true);

	    $scope.gridOptions = {
	        data: 'myData',
	        enablePaging: true,
	        showFooter: true,
	        rowHeight: 36,
	        headerRowHeight: 36,
	        totalServerItems: 'totalServerItems',
	        pagingOptions: $scope.pagingOptions,
	        filterOptions: $scope.filterOptions
	    };
    }

    


  /* End Grid Options */


}]);

