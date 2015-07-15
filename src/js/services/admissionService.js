

angular.module('app')
.factory('AdmissionService', function($http,$q) {
  var promise;
  var AdmissionService = {
    async_get_data: function() {
      if ( !promise ) {
        // $http returns a promise, which has a then function, which also returns a promise
        promise = $http.get('../src/api/php/epnt/trans/ctrl_cls_Admission.php?a=r').
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
    }, // -- async_get_data --
    
    async_get_prn_info: function(query) {
      if ( !promise ) {
        // $http returns a promise, which has a then function, which also returns a promise
        promise = $http.get('../src/api/php/epnt/trans/ctrl_cls_Receipt.php?a=rp&p='+query).
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
    }, // -- async_get_prn_info --
    
    async_save_new_admission: function(dataObj){
      if ( !promise ) {
        // $http returns a promise, which has a then function, which also returns a promise
        
        promise = $http.post('../src/api/php/epnt/trans/ctrl_cls_Admission.php',dataObj).
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
      
    } // -- async_save_new_admission --
    
    // add new function here...

  };
  return AdmissionService;
});

