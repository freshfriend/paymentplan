/**
 * File : addUser.js
 * 
 * This file contain the validation of add user form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */

$(document).ready(function(){
	
	var addUserForm = $("#addUser");
	var validator = addUserForm.validate({
		rules:{
			fname :{ required : true },
			email : { required : true, email : true, remote : { url : baseURL + "checkEmailExists", type :"post"} },
			password : { required : true },
			cpassword : {required : true, equalTo: "#password"},
			mobile : { required : true, digits : true },
			role : { required : true, selected : true}
		},
		messages:{
			fname :{ required : "This field is required" },
			email : { required : "This field is required", email : "Please enter valid email address", remote : "Email already taken" },
			password : { required : "This field is required" },
			cpassword : {required : "This field is required", equalTo: "Please enter same password" },
			mobile : { required : "This field is required", digits : "Please enter numbers only" },
			role : { required : "This field is required", selected : "Please select atleast one option" }			
		}
	});

	var addPlanForm = $("#addPlan");
	var validatorPlan = addPlanForm.validate({
		rules:{
			userId : { required : true },
			title : { required : true },
			amount : { required : true, number : true, min : 0.1 },
			payDate : { required : true, date : true }
		},
		messages:{
			userId :{ required : "This field is required" },
			title :{ required : "This field is required" },
			amount : { required : "This field is required", number : "Please enter numbers only", min : "Amount is too low" },
			payDate : { required : "This field is required", date : "Pay Date can't be past" }	
		}
	});
});
