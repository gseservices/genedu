

angular.module('app')
.factory('ReceiptService', function($http,$q,$templateCache) {
  var promise,
  promiseGetPRNInfo,
  promiseSaveNewReceipt;
  var ReceiptService = {
    
    reset_promises: function(){
      promise = promiseGetPRNInfo = promiseSaveNewReceipt = undefined;
      debugLog("promises reset");
    },
    
    async_get_data: function() {
      if ( !promise ) {
        // $http returns a promise, which has a then function, which also returns a promise
        promise = $http.get('../src/api/php/epnt/trans/ctrl_cls_Receipt.php?a=r').
        success(function(data, status, headers, config) {
          // this callback will be called asynchronously
          // when the response is available
          // The then function here is an opportunity to modify the response
          //console.log(data);
          // The return value gets picked up by the then in the controller.
          debugLog("Receipt Service --> async_get_data --> success --> "+data);
          return data;
        }).
        error(function(data, status, headers, config) {
          // called asynchronously if an error occurs
          // or server returns response with an error status.
          debugLog("Receipt Service --> async_get_data --> failure --> "+data);
        });
        
      }
      
            
      // Return the promise to the controller
      return promise;
    }, // -- async_get_data --
    
    async_get_prn_info: function(selected_prn, academic_year) {
      if ( !promiseGetPRNInfo ) {
        // $http returns a promise, which has a then function, which also returns a promise
        
        promiseGetPRNInfo = $http.get('../src/api/php/epnt/trans/ctrl_cls_Receipt.php?a=rp&p='+selected_prn+'&ay='+academic_year+'').
        success(function(data, status, headers, config) {
          // this callback will be called asynchronously
          // when the response is available
          // The then function here is an opportunity to modify the response
          //console.log(data);
          // The return value gets picked up by the then in the controller.
          debugLog("Receipt Service --> async_get_prn_info --> success --> "+data);
          return data;
        }).
        error(function(data, status, headers, config) {
          // called asynchronously if an error occurs
          // or server returns response with an error status.
          debugLog("Receipt Service --> async_get_prn_info --> failure --> "+data);
        });
        
      }
      
       // Return the promise to the controller
      return promiseGetPRNInfo;
    }, // -- async_get_prn_info --
    
    async_save_new_receipt: function(formData){
      if ( !promiseSaveNewReceipt ) {
        // $http returns a promise, which has a then function, which also returns a promise
        var method = 'POST';
        var url = '../src/api/php/epnt/trans/ctrl_cls_Receipt.php';
        
        //promiseSaveNewReceipt = $http.post('../src/api/php/epnt/trans/ctrl_cls_Receipt.php',dataObj).
        
        promiseSaveNewReceipt = $http({
          method: method,
          url: url,
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          transformRequest: function(obj) {
              var str = [];
              for(var p in obj)
              str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
              return str.join("&");
          },
          data: formData
        }).
        success(function(data, status, headers, config) {
          // this callback will be called asynchronously
          // when the response is available
          // The then function here is an opportunity to modify the response
          //console.log(data);
          // The return value gets picked up by the then in the controller.
          debugLog("Receipt Service --> async_save_new_receipt --> success --> "+data);
          return data;
        }).
        error(function(data, status, headers, config) {
          // called asynchronously if an error occurs
          // or server returns response with an error status.
          debugLog("Receipt Service --> async_save_new_receipt --> failure --> "+data);
        });
        
      }
      
       // Return the promise to the controller
      return promiseSaveNewReceipt;
      
    } // -- async_save_new_receipt --

    //add new function here...
    
  };
  return ReceiptService;
});

