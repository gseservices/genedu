

angular.module('app')
.factory('HelperService', function($http,$q) {
  var promiseStudentList,
      promiseCollegeTypes, 
      promiseCourses,
      promiseCasteCategories,
      promiseDivisions;
  var HelperService = {
    
    reset_promises: function(){
      promiseStudentList =  undefined;
      debugLog("promises reset");
    },
    // retrieve data for college type or section combo box 
    async_get_student_list: function(snameCriteria, ay) {
      if ( !promiseStudentList ) {
        // $http returns a promise, which has a then function, which also returns a promise
        promiseStudentList = $http.get('../src/api/php/epnt/mst/ctrl_cls_mst_admission.php?a=sl&snc='+snameCriteria+'&ay='+ay).
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
      return promiseStudentList;
    }, // -- async_get_college_types --
    
    // retrieve data for college type or section combo box 
    async_get_college_types: function() {
      if ( !promiseCollegeTypes ) {
        // $http returns a promise, which has a then function, which also returns a promise
        promiseCollegeTypes = $http.get('../src/api/php/epnt/mst/ctrl_cls_mst_college_type.php?a=r').
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
      return promiseCollegeTypes;
    }, // -- async_get_college_types --
    
     
    async_get_courses: function() {
      if ( !promiseCourses ) {
        // $http returns a promise, which has a then function, which also returns a promise
        promiseCourses = $http.get('../src/api/php/epnt/mst/ctrl_cls_mst_course.php?a=r').
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
      return promiseCourses;
    }, // -- async_get_courses --

    async_get_caste_categories: function() {
      if ( !promiseCasteCategories ) {
        // $http returns a promise, which has a then function, which also returns a promise
        promiseCasteCategories = $http.get('../src/api/php/epnt/mst/ctrl_cls_mst_caste_category.php?a=r').
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
      return promiseCasteCategories;
    }, // -- async_get_caste_categories --
    
    async_get_divisions: function() {
      if ( !promiseDivisions ) {
        // $http returns a promise, which has a then function, which also returns a promise
        promiseDivisions = $http.get('../src/api/php/epnt/mst/ctrl_cls_mst_division.php?a=r').
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
      return promiseDivisions;
    }, // -- async_get_caste_categories --

    
    async_get_academic_years: function(query) {
        
        var academic_years = [
          {"Key":"2012 - 2013","Value":"2012 - 2013"},
          {"Key":"2013 - 2014","Value":"2013 - 2014"},
          {"Key":"2014 - 2015","Value":"2014 - 2015"},
          {"Key":"2015 - 2016","Value":"2015 - 2016"},
          {"Key":"2016 - 2017","Value":"2016 - 2017"},
          {"Key":"2017 - 2018","Value":"2017 - 2018"},
          {"Key":"2018 - 2019","Value":"2018 - 2019"},
          {"Key":"2019 - 2020","Value":"2019 - 2020"}
          ];
        
        
      return academic_years;
    } // -- async_get_academic_years --
    
    // add new function here...
  };
  return HelperService;
});

