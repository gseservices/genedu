
angular.module('app')
.controller('receiptCtrl',['ReceiptService','HelperService','toaster','$scope','$http','$location', function( ReceiptService,HelperService,toaster,$scope,$http,$location) {

  $scope.toaster = {
    type :'info', // success , warning, info, error, wait
    title : 'Receipt New',
    text : ''
  };
  
  $scope.makeToast = function(toast_type, message) {
    $scope.toaster.type = toast_type;
    $scope.toaster.text = message;
    toaster.pop($scope.toaster.type, $scope.toaster.title, $scope.toaster.text);
  };

	$scope.applyDate = false;
	var _fromDate  = new Date();
	_fromDate  = new Date(_fromDate.getDate(),_fromDate.getMonth() - 1,_fromDate.getYear());
	
	var _toDate = new Date();

	$scope.fromDate = _fromDate;
	$scope.toDate = _toDate;
    
    $scope.itemByPage = 15;

	$scope.receiptList = [];

  $scope.clearData = function() {
    $scope.receiptList = [];
  };
  
  $scope.setSelectedPRN= function(prnNo){
    $scope.selectedPRN = prnNo;  
  };
 
  $scope.getData = function() {
    // Call the async method and then do stuff with what is returned inside our own then function
    ReceiptService.async_get_data().then(function(d) {
      $scope.receiptList = d.data;
      debugLog("getData --> async_get_data --> success --> "+$scope.receiptList);
      
    });
  };
  
  $scope.selectedPRNInfo = {
    studentInfo : "",
    feesInfo : "",
    installmentInfo : ""
  };
  
  $scope.getPRNInfo = function(){
      ReceiptService.reset_promises();
      
      ReceiptService.async_get_prn_info($scope.selectedPRN, $scope.academicYear).then(function(d){
         $scope.selectedPRNInfo = d.data;
         
         if($scope.selectedPRNInfo !== undefined || $scope.selectedPRNInfo !== null){
             var obj = $scope.selectedPRNInfo.studentInfo[0];
             
             $scope.resetStudentDetails();
             $scope.setPRNInfo(obj);
             
             $scope.feesInfo = ($scope.selectedPRNInfo.feesInfo !== undefined ? $scope.selectedPRNInfo.feesInfo : []);
             $scope.installmentInfo = ($scope.selectedPRNInfo.installmentInfo !== undefined ? $scope.selectedPRNInfo.installmentInfo : []);
             
             debugLog("fees Info set -->"+ $scope.feesInfo);
             debugLog("installment Info set -->"+ $scope.installmentInfo);
         }
         
         debugLog('getPRNInfo called for '+$scope.selectedPRN); 
      });
      
      
  };
  
  $scope.getAcademicYears = function(){
    var temp = HelperService.async_get_academic_years();
    
    if(temp !== null || temp !== undefined){
      $scope.academicYears = temp;
      debugLog( "retrieved academic years --> " + $scope.academicYears);
    }
    
  };
  
  $scope.setPRNInfo = function(obj){
    //$scope.PRN = obj.PRN;
    if(!obj)
    { 
      debugLog("setPRNInfo --> object is not set"); 
      $scope.resetStudentDetails();
      $scope.makeToast('warning','No info found for given criteria!'); 
      return;
    }
    
    $scope.admissionId = obj["pk_admission_id"];
    $scope.receiptDate = getTodaysDateFormatted();
    $scope.studentName = obj["student_name"];
    
    $scope.totalFees = obj["total_fees"];
    $scope.paidAmt = obj["paid_fees"];
    $scope.totalPaid = $scope.paidAmt;
    
    $scope.totalBalance = $scope.totalFees - $scope.paidAmt;
    $scope.currentBalance = $scope.totalBalance;
    $scope.previousBalance = $scope.currentBalance;
    
    $scope.makeToast('info','Record info retrieved!');
    debugLog("setPRNInfo done");  
  };
  
  $scope.validate = function(){
    var blnValidate = true;
    if($scope.paymentMode !== "Cash"){
        if(
            ($scope.bankName == undefined || $scope.bankName == null || $scope.bankName.toString().length < 1) 
            || ($scope.chqDDDate == undefined || $scope.chqDDDate == null || $scope.chqDDDate < new Date())
            || ($scope.bankBranch == undefined || $scope.bankBranch == null || $scope.bankBranch.toString().length < 1) 
            || ($scope.chqDDNo == undefined || $scope.chqDDNo == null || $scope.chqDDNo.toString().length < 1)
            || ($scope.accountNo == undefined || $scope.accountNo == null || $scope.accountNo.toString().length < 1)
          ){
              blnValidate = false;
          }
    }  
    return blnValidate;
  };
  
  $scope.saveReceipt = function(){
    ReceiptService.reset_promises();
    
    if(!$scope.validate())   
      return;
      
    var formData = {
          a:'a',
          varreceip_code:'',
          varrcpt_no:$scope.receiptNo,
          varfk_admission_id:$scope.admissionId,
          'varreciept_date':getMySqlDate($scope.receiptDate),
          'varpay_mode':$scope.paymentMode,
          'varch_dd_ac_no':$scope.accountNo,
          'varch_dd_no':$scope.chqDDNo,
          'varch_dd_date':($scope.chqDDDate?getMySqlDate($scope.chqDDDate):''),
          'varch_dd_bbranch':$scope.bankBranch,
          'varch_dd_bank':$scope.bankName,
          'varch_dd_status':'', // default status
          'varprevious_balance':$scope.previousBalance,
          'varpaid_amt':$scope.receivedAmount,
          'varcurrent_balance':$scope.currentBalance,
          'varremark':$scope.remarks,
          'varcreated_by':$scope.createdBy,
          'varmodified_by':$scope.createdBy,
          'varpk_reciept_id':$scope.receiptId,
          'varrcpt_type':$scope.receiptType,
          'varis_admission':$scope.isAdmission,
          'varcollegetype':$scope.collegeType,
          'p_xml':'',
          'var_is_rcpt_no_manual':'N' // default value
          
        };
        
        debugLog("New Receipt Data before save : "+ formData); 
        
    ReceiptService.async_save_new_receipt(formData).then(function(d){
         $scope.newReceiptData = d.data;
         
         if($scope.newReceiptData !== undefined || $scope.newReceiptData !== null){
             var obj = $scope.newReceiptData;
             if(obj !== undefined){
              $scope.makeToast('success','New receipt created! Rcpt Code is : ');
              debugLog("New Receipt Saved Data : "+ obj);   
             }else{
               $scope.makeToast('error','Unable to create new receipt!');
              debugLog("Receipt Not Saved Data : "+ obj);
             }
             
             
             // extract new receipt code 
             // and display to user for future reference
         }
         
         
      });        
      
  };

  $scope.receiptTypeChanged = function(){
      $scope.collegeType = ($scope.receiptType == "Transport" ? "PST" : "PSBA");
      debugLog("receipt type changed --> " + $scope.receiptType);
  };
  
  $scope.receivedAmountChanged = function(){
      $scope.receivedAmount = parseFloat($scope.receivedAmount);
      $scope.currentBalance = parseFloat($scope.currentBalance);
        
      if($scope.receivedAmount >= 0){
          if($scope.receivedAmount <= $scope.previousBalance){
            $scope.currentBalance = $scope.previousBalance - $scope.receivedAmount;      
          }else{
              $scope.receivedAmount = $scope.previousBalance;
              $scope.currentBalance = $scope.previousBalance - $scope.receivedAmount;
          }
              
      }
      debugLog("received amount changed --> " + $scope.receivedAmount); 
  };

  $scope.paymentModeChanged = function(){
      switch($scope.paymentMode){
          case "Cash":
            $scope.disableBankDetails = true;
            break;
          case "Cheque":
          case "DD":
            $scope.disableBankDetails = false;
            break;
      }
     debugLog("payment mode changed --> "+ $scope.paymentMode);
  };

  $scope.selectedPRN = 0;
  

    var searchObject = $location.search();
    var query;
    if(searchObject.q !== null || searchObject.q !== undefined){
        query = searchObject.q;
    }
    
    if(query !== undefined){
        // get prn info
        $scope.selectedPRN = query;
        
    }

    //alert($scope.selectedPRN);
    
    
    
    // object definition
    $scope.academicYears = [];
    $scope.feesInfo = [];
    $scope.installmentInfo = [];
    
    $scope.PRN = $scope.selectedPRN;
    $scope.isAdmission = "N";
    $scope.admissionId = 0;
    $scope.receiptId = 0;
    $scope.receiptDate = getTodaysDateFormatted();
    $scope.studentName = "student name";
    $scope.academicYear = "";
    $scope.previousBalance = 0.00;
    $scope.totalBalance = 0.00;
    $scope.currentBalance = 0.00;
    
    $scope.receiptType = "Regular"; // regular / bus / other
    $scope.receiptNo = 0;
    $scope.paymentMode = "Cash"; // cash / cheque / dd
    $scope.receiptCode = "";
    $scope.receivedAmount = 0.00;
    
    $scope.bankName = "";
    $scope.chqDDDate = getTodaysDateFormatted();
    $scope.bankBranch = "";
    $scope.chqDDNo = "";
    $scope.accountNo = "";
    $scope.remarks = "";
    $scope.collegeType = "";
    $scope.createdBy = 1; // sample value for testing purpose
    $scope.modifiedBy = $scope.createdBy; // sample value for testing purpose
    
    $scope.disableBankDetails = true;
    
    
    
    $scope.resetStudentDetails = function(){
      $scope.feesInfo = [];
      $scope.installmentInfo = [];
    
      $scope.admissionId = 0;
      $scope.receiptNo = 0;
      $scope.admissionDate = getTodaysDateFormatted();
      $scope.studentName = "student name";
      //$scope.academicYear = ($scope.academicYears.length > 0 ? $scope.academicYears[0].Key : "");
      
      $scope.totalBalance = 0.00;
      $scope.currentBalance = 0.00;
      $scope.paymentMode = "Cash";
      $scope.paymentModeChanged();
      $scope.chqDDDate = getTodaysDateFormatted();
      $scope.feesType = 1;
      
      $scope.receiptType = "Regular"; // regular / bus / other
      $scope.receiptTypeChanged();
      
      $scope.receiptCode = "";
      $scope.receivedAmount = 0.00;
      
      $scope.bankName = "";
      $scope.chqDDDate = getTodaysDateFormatted();
      $scope.bankBranch = "";
      $scope.chqDDNo = "";
      $scope.accountNo = "";
      $scope.remarks = "";
      
      
      $scope.isNew = true;
      
      debugLog("resetStudentDetails called")
    };
    
    
    $scope.initializeForm = function(){
      // fill combo boxes
      $scope.getAcademicYears();
      $scope.feesInfo = [];
      $scope.installmentInfo = [];
    
      
      $scope.PRN = 0;
      $scope.admissionId = 0;
      $scope.admissionDate = getTodaysDateFormatted();
      $scope.studentName = "student name";
      $scope.academicYear = ($scope.academicYears.length > 0 ? $scope.academicYears[0].Key : "");
      
      $scope.totalBalance = 0.00;
      $scope.totalPaid = 0.00;
      $scope.totalFees = 0.00;
      $scope.currentBalance = 0.00;
      $scope.paymentMode = "Cash";
      $scope.paymentModeChanged();
      $scope.chqDDDate = getTodaysDateFormatted();
      $scope.feesType = 1;
      
      $scope.receiptType = "Regular"; // regular / bus / other
      $scope.receiptNo = 0;
      $scope.receiptCode = "";
      $scope.receivedAmount = 0.00;
      
      $scope.bankName = "";
      $scope.chqDDDate = getTodaysDateFormatted();
      $scope.bankBranch = "";
      $scope.chqDDNo = "";
      $scope.accountNo = "";
      $scope.remarks = "";
      $scope.collegeType = "";
      
      $scope.isNew = true;
      
      debugLog("initializeForm called");
      //$scope.getPRNInfo();
    };
    
    if($location.path().indexOf("receiptNew") > 0 && $scope.PRN !== undefined){
        $scope.initializeForm();
        //$scope.getPRNInfo();
    }
    
    $scope.getInfo = function(){
      $scope.selectedPRN = $scope.PRN;
      
      
      // getPRNInfo require PRN & academicYear 
      $scope.getPRNInfo();
      
      
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

