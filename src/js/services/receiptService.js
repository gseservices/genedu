'use strict';

angular.module('app')
.factory('ReceiptService', function($http,$q) {
  var promise;
  var ReceiptService = {
    async_get_data: function() {
      if ( !promise ) {
        // $http returns a promise, which has a then function, which also returns a promise
        promise = $http.get('../api/php/epnt/mst/ctrl_cls_Receipt.php?a=r').then(
            success:function (response) {
          // The then function here is an opportunity to modify the response
          console.log(response);
          // The return value gets picked up by the then in the controller.
          return response.data;
        },
        error:function(ex){
            console.log(ex.message);
        });
      }
      // Return the promise to the controller
      return promise;
    }
  };
  return myService;
});

