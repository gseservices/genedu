angular.module('app')
.controller('ReceiptCtrl', function( ReceiptService,$scope) {
  $scope.clearData = function() {
    $scope.data = {};
  };
  $scope.getData = function() {
    // Call the async method and then do stuff with what is returned inside our own then function
    myService.async_get_data().then(function(d) {
      $scope.data = d;
    });
  };
});