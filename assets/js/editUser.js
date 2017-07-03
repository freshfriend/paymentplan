/**
 * File : editUser.js 
 * 
 * This file contain the validation of edit user form
 * 
 * @author Kishor Mali
 */
$(document).ready(function(){
	
	var editUserForm = $("#editUser");
	
	var validator = editUserForm.validate({
		
		rules:{
			fname :{ required : true },
			email : { required : true, email : true, remote : { url : baseURL + "checkEmailExists", type :"post", data : { userId : function(){ return $("#userId").val(); } } } },
			cpassword : {equalTo: "#password"},
			mobile : { required : true, digits : true },
			role : { required : true, selected : true}
		},
		messages:{
			fname :{ required : "This field is required" },
			email : { required : "This field is required", email : "Please enter valid email address", remote : "Email already taken" },
			cpassword : {equalTo: "Please enter same password" },
			mobile : { required : "This field is required", digits : "Please enter numbers only" },
			role : { required : "This field is required", selected : "Please select atleast one option" }			
		}
	});

	var editPlanForm = $("#editPlan");
	
	var validator = editPlanForm.validate({
		
		rules:{
			title :{ required : true },
			amount : { required : true, number : true, min : 0.1 },
			payDate : { required : true, date : true }
		},
		messages:{
			title :{ required : "This field is required" },
			amount : { required : "This field is required", number : "Please enter numbers only", min : "Amount is too low" },
			payDate : { required : "This field is required", date : "Pay Date can't be past" }	
		}
	});
});