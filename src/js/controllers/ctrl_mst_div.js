/**
 * REGION: APP DECLARATION
 */
/*------------------------------------------------------------------------------------------------------------------------*/
//var appGsaudit = angular.module('gsaudit',['ngRoute','ngGrid']);
/*------------------------------------------------------------------------------------------------------------------------*/
/**
 * REGIONEND: APP DECLARATION
 */
/*------------------------------------------------------------------------------------------------------------------------*/
/**
 * REGION: DOCUMENT CATEGORY
 */ 
//Controller: Document Category
app.controller('Division',function ($scope, $rootScope){	

	$rootScope.base_url = "http://localhost/p/gsaudit/";
	//Initialise data holder
	$scope.doc_cat = [];//[{"pk_doc_category_id":"1","uk_doc_category_code":"KYC","doc_category_name":"Know Your Customer","description":"Documents like address proof, photo identity, etc.","created_on":"2014-04-02 12:16:36","created_by":"1","modified_on":"2014-04-02 12:01:07","modified_by":null,"deleted":"N","deleted_on":null,"deleted_by":null},{"pk_doc_category_id":"2","uk_doc_category_code":"TAXREG","doc_category_name":"Tax Registration","description":"All kinds of tax registrations like Service Tax, Excise, etc.","created_on":"2014-04-02 12:16:36","created_by":"1","modified_on":"2014-04-02 12:02:23","modified_by":null,"deleted":"N","deleted_on":null,"deleted_by":null}];

	$scope.crud_url = $rootScope.base_url +"phpctrl/mst/ctrl_cls_document_category.php";
	
	$scope.$on('$viewContentLoaded', init());

	$scope.newDocCat =[];

	//Initialise view componenets

	function init ()
	{		
		ApplyJQueryUI();
		InitControlStates();
		ValidateControls();
		//Hiding menu
		toggleMenuOnLogin(false);
	};
	toggleProgIndicator(true);
	
	//Get data for Doc Category
	$.ajax({
		type:"POST",
		url:$scope.crud_url + "?a=r",
		success: (function(response){
			if(response != "" ){				
				$scope.doc_cat = eval("(" + response +")");	
				$scope.$apply();
				toggleProgIndicator(false);											
			}else{
				redirectCheckToLogin(response,$rootScope.base_url);
				$scope.doc_cat = [];
				toggleProgIndicator(false);
			}			
		}),
		error:(function(response){
			// alert("Data not retrived: "+ response);			
		})
	});

	//Rendering grid
	$scope.grid_doc_cat = { 
			data: 'doc_cat',
			showGroupPanel: false,
			showFilter: true,
			jqueryUITheme:true,
			filterOptions:{
				filterText:'',
				useExternalFilter:false
			},			
			multiSelect: false,
			columnDefs: [{field: 'pk_doc_category_id', displayName: 'Document Category Id', visible:false},
			             {field: 'uk_doc_category_code', displayName: 'Document Category Code'},
			             {field: 'doc_category_name', displayName: 'Category Name'},
			             {field: 'description', displayName: 'Description'},
			             {displayName: 'Options', cellTemplate: '<img class="editItem" data-ng-click="editDocCat()"></img>&nbsp;<img class="delItem" data-ng-click="deleteDocCat()"></img>'}			             
			             ]	
	};

	//Factory methods Add
	$scope.add_updateDocCat = function(){
		//Validation Function		
		$scope.validateControls=[];		
		if($scope.formDocCat.$valid!= true){
			// alert($scope.formDocCat.$valid);
			angular.forEach($scope.formDocCat.$error, function(value, key){
				$scope.validateControls.push(key + ': ' + value[0].$name);
			}); 
			return;
		};
		var PK_ID=$scope.newDocCat.pk_doc_category_id;
		// alert(PK_ID);
		if(PK_ID>0)				
			var data = {"a":"a","pk_doc_category_id":PK_ID ,"uk_doc_category_code":$scope.newDocCat.uk_doc_category_code,"doc_category_name":$scope.newDocCat.doc_category_name,"description":$scope.newDocCat.description,"created_on":"2014-04-02 12:16:36","created_by":"1","modified_on":"2014-04-02 12:01:07","modified_by":null,"deleted":"N","deleted_on":null,"deleted_by":null};
		else			
			var data = {"a":"a","pk_doc_category_id":"0" ,"uk_doc_category_code":$scope.newDocCat.uk_doc_category_code,"doc_category_name":$scope.newDocCat.doc_category_name,"description":$scope.newDocCat.description,"created_on":"2014-04-02 12:16:36","created_by":"1","modified_on":"2014-04-02 12:01:07","modified_by":null,"deleted":"N","deleted_on":null,"deleted_by":null};	

		$.ajax({
			type:"POST",
			data: $.param(data),
			url:$scope.crud_url,
			success: (function(response){				
				if((response != "FAIL")){					
					//show_msg_to_user("RECORD ADDED: New Id " + response);
					$scope.newDocCat.pk_doc_category_id=response;										
					$scope.doc_cat.push({"pk_doc_category_id":""+$scope.newDocCat.pk_doc_category_id,"uk_doc_category_code":$scope.newDocCat.uk_doc_category_code,"doc_category_name":$scope.newDocCat.doc_category_name,"description":$scope.newDocCat.description,"created_on":"2014-04-02 12:16:36","created_by":"1","modified_on":"2014-04-02 12:01:07","modified_by":null,"deleted":"N","deleted_on":null,"deleted_by":null});					
					show_msg_to_user("RECORD ADDED: New Id - " + $scope.newDocCat.pk_doc_category_id);					
					toggleProgIndicator(false);						
					ClearFormContent('#formDocCat');							
					$scope.$apply();
					$scope.newDocCat =[];

				}else{
					show_msg_to_user("PLEASE TRY AGAIN");
					toggleProgIndicator(false);
				}			
			}),
			error:(function(response){
				show_msg_to_user("Server error: "+ response);
				toggleProgIndicator(false);
			})
		});
	};	

	$scope.Cancel=function(){
		// alert("cancel");
		ClearFormContent('#formDocCat');
		$scope.newDocCat =[];
	}
	//Factory methods Edit
	$scope.editDocCat = function(){
		var index = this.row.rowIndex;
		var indexID = this.row.entity.pk_doc_category_id;
		//// alert("Row Index " + indexID);		
		$(".form-container").fadeIn(2500);
		$scope.newDocCat.pk_doc_category_id = this.row.entity.pk_doc_category_id;
		$scope.newDocCat.uk_doc_category_code = this.row.entity.uk_doc_category_code;
		$scope.newDocCat.doc_category_name = this.row.entity.doc_category_name;
		$scope.newDocCat.description = this.row.entity.description;		
		$("#btnAddDetails").html('Update Category');
		toggleProgIndicator(false);
	};

	//Factory methods Delete
	$scope.deleteDocCat = function(){		
		var index = this.row.rowIndex;
		var indexID = this.row.entity.pk_doc_category_id;
		// alert("Row Index " + indexID);
		if (confirm('Are you want to Delete Record?')) {
			var data = {"a":"d","pk_doc_category_id":""+indexID ,"deleted_by":"1","deletedtype":"s"};		
			// alert(data);
			$.ajax({
				type:"POST",
				data: $.param(data),
				url:$scope.crud_url,
				success: (function(response){
					// alert(response);
					if((response != "FAIL")){	
						$scope.grid_doc_cat.selectItem(index, false);
						$scope.doc_cat.splice(index, 1);						
						show_msg_to_user("RECORD DELETED: Id - " + indexID);
						toggleProgIndicator(false);
						$scope.$apply();							
					}else{
						show_msg_to_user("PLEASE TRY AGAIN");
					}			
				}),
				error:(function(response){
					show_msg_to_user("Server error: "+ response);			
				})
			});
		} else {
			//// alert('Why did you press cancel? You should have confirmed');
		}
	};
});


/**
 * REGIONEND: DOCUMENT CATEGORY
 */
