
angular.module('app')
.controller('admissionCtrl',['AdmissionService','HelperService','$scope','$http','$location', function( AdmissionService,HelperService,$scope,$http,$location) {

	$scope.applyDate = false;
	var _fromDate  = new Date();
	_fromDate  = new Date(_fromDate.getDate(),_fromDate.getMonth() - 1,_fromDate.getYear());
	
	var _toDate = new Date();

	$scope.fromDate = _fromDate;
	$scope.toDate = _toDate;
    
    $scope.itemByPage = 15;

	$scope.admissionList = [];

  $scope.clearData = function() {
    $scope.admissionList = [];
  };
  
  $scope.setSelectedPRN= function(prnNo){
    $scope.selectedPRN = prnNo;  
  };
 
  $scope.getData = function() {
    // Call the async method and then do stuff with what is returned inside our own then function
    AdmissionService.async_get_data().then(function(d) {
      $scope.admissionList = d.data;
      console.log($scope.admissionList);
      
    });
  };
  
  $scope.getPRNInfo = function(){
      AdmissionService.async_get_prn_info($scope.selectedPRN).then(function(d){
         $scope.selectedPRNInfo = d.data;
         
         if($scope.selectedPRNInfo !== undefined || $scope.selectedPRNInfo !== null){
             var obj = $scope.selectedPRNInfo[0];
             
             $scope.setPRNInfo(obj);
         }
         
         console.log($scope.selectedReceiptInfo); 
      });
      
  };
  
  $scope.getCollegeTypes = function(){
      HelperService.async_get_college_types().then(function(d){
         $scope.collegeTypes = d.data;
         
         console.log($scope.collegeTypes); 
         // initialize section variable 
         $scope.section = ($scope.collegeTypes.length > 0 ? $scope.collegeTypes[0].pk_college_type_id : "");
         $scope.collegeTypeChanged();
      });
      
  };
  
  $scope.getCourses = function(){
      HelperService.async_get_courses().then(function(d){
         $scope.courses = d.data;
         
         console.log($scope.courses); 
         // initialize section variable 
         $scope.courseCode = ($scope.courses.length > 0 ? $scope.courses[0].courseId : "");
         $scope.courseCodeChanged();
      });
      
  };
  
  $scope.getCasteCategories = function(){
      HelperService.async_get_caste_categories().then(function(d){
         $scope.casteCategories = d.data;
         
         console.log($scope.casteCategories); 
         // initialize section variable 
         $scope.casteCategory = ($scope.casteCategories.length > 0 ? $scope.casteCategories[0].pk_castecategory_id : "");
         
      });
      
  };
  
  $scope.getDivisions = function(){
      HelperService.async_get_divisions().then(function(d){
         $scope.divisions = d.data;
         
         console.log($scope.divisions); 
         // initialize section variable 
         $scope.division = ($scope.divisions.length > 0 ? $scope.divisions[0].courseId : "");
      });
      
  };
  
  $scope.getAcademicYears = function(){
    var temp = HelperService.async_get_academic_years();
    if(temp !== null || temp !== undefined){
      $scope.academicYears = temp;
      console.log($scope.academicYears);
    }
    
  };
  
  
  $scope.setPRNInfo = function(obj){
    $scope.PRN = obj.PRN;
    $scope.admissionId = obj["fk_admission_id"];
    $scope.receiptDate = getTodaysDateFormatted();
    $scope.studentName = obj["Student Name"];
    $scope.academicYear = obj["Academic Year"].toString();
    $scope.totalBalance = obj["addTotalFees"];
    $scope.currentBalance = obj["current_balance"];
    $scope.previousBalance = $scope.currentBalance;
    
      
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
   if(!$scope.validate())   
      return;
      
    var dataObj = {
          'varreceip_code':'',
          'varrcpt_no':'',
          'varfk_admission_id':$scope.admissionId,
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
        
    AdmissionService.async_save_new_admission(dataObj).then(function(d){
         $scope.newAdmissionData = d.data;
         
         if($scope.newAdmissionData !== undefined || $scope.newAdmissionData !== null){
             var obj = $scope.newAdmissionData[0];
             
             // extract new receipt code 
             // and display to user for future reference
         }
         
         console.log($scope.selectedAdmissionInfo); 
         
         // clear scope variables after save
         
      });        
      
  };

  $scope.receiptTypeChanged = function(){
      $scope.collegeType = ($scope.receiptType == "Transport" ? "PST" : "PSBA");
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
     
  };

  $scope.collegeTypeChanged = function(){
    $scope.filteredCourses = [];
    
    if($scope.courses == null || $scope.courses == undefined){
      return;
    }
      
    angular.forEach($scope.courses, function(element) {
      if(element.courseType == $scope.section){
        $scope.filteredCourses.push(element);
      }
    }, this);
    
    if($scope.filteredCourses.length > 0){
      $scope.courseCode = $scope.filteredCourses[0].courseId;
      $scope.courseCodeChanged();
    }
  };
  
  
  $scope.courseCodeChanged = function(){
    $scope.filteredDivisions = [];
    
    if($scope.divisions == null || $scope.divisions == undefined){
      return;
    }
    
    angular.forEach($scope.divisions, function(element){
      if(element.fk_course_id == $scope.courseCode ){
        $scope.filteredDivisions.push(element);
      }
    }, this);
    
    if($scope.filteredDivisions.length > 0){
      $scope.division = $scope.filteredDivisions[0].pk_div_id;
      
    }
  };

  $scope.selectedPRN = 1182;

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
    $scope.collegeTypes =[];
    $scope.academicYears = [];
    $scope.courses = [];
    $scope.filteredCourses = [];
    $scope.feeTypes = [];
    $scope.casteCategories = [];
    $scope.divisions = [];
    $scope.filteredDivisions = [];
    $scope.courseSubjects = [];
    $scope.filteredCourseSubjects = [];
    
    
    $scope.PRN = $scope.selectedPRN;
    $scope.admissionId = 0;
    $scope.section = 0;
    $scope.courseCode = 0;
    $scope.casteCategory = 0;
    $scope.studentName = "";
    $scope.academicYear = "";
    $scope.previousBalance = 0.00;
    $scope.totalBalance = 0.00;
    $scope.currentBalance = 0.00;
    
    $scope.receiptType = "Regular"; // Regular / Transport / Other
    $scope.receiptNo = "";
    $scope.paymentMode = "Cash"; // Cash / Cheque / DD
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
    
    /*if($location.path().indexOf("receiptNew") > 0 && $scope.PRN !== undefined){
        $scope.getPRNInfo();
    }*/
    
    
    $scope.initializeForm = function(){
      
      
      // fill combo boxes
      $scope.getAcademicYears();
      $scope.getDivisions();
      $scope.getCasteCategories();
      $scope.getCourses();
      $scope.getCollegeTypes();
      
      
      
      $scope.PRN = 0;
      $scope.admissionId = 0;
      $scope.admissionDate = getTodaysDateFormatted();
      $scope.studentName = "";
      $scope.academicYear = ($scope.academicYears.length > 0 ? $scope.academicYears[0].Key : "");
      
      $scope.totalBalance = 0.00;
      $scope.currentBalance = 0.00;
      $scope.paymentMode = "Cash";
      $scope.chqDDDate = getTodaysDateFormatted();
      $scope.feesType = 1;
      
      
      $scope.isNew = true;
      
      
    };
    
    
    $scope.initializeForm();
    
}]);

