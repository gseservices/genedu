

angular.module('app')
.factory('ReceiptService', function($http,$q) {
  var promise;
  var ReceiptService = {
    async_get_data: function() {
      if ( !promise ) {
        // $http returns a promise, which has a then function, which also returns a promise
        promise = $http.get('../src/api/php/epnt/mst/ctrl_cls_Receipt.php?a=r').
        success(function(data, status, headers, config) {
          // this callback will be called asynchronously
          // when the response is available
          // The then function here is an opportunity to modify the response
          //console.log(data);
          // The return value gets picked up by the then in the controller.
          return data;
        }).
        error(function(data, status, headers, config) {
          // called asynchronously if an error occurs
          // or server returns response with an error status.
          console.log("Error : " + status + " - " + data.message);
        });
        
      }
      // Return the promise to the controller
      return promise;
    }
  };
  return ReceiptService;
});

