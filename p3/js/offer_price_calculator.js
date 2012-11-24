
$(document).ready(function() {	//start doc ready
				
	// Declare local variables
	var after_repair_value;
	var profit_goal;
	var estimated_repairs;
	var commission;
	var closing_costs_in;
	var closing_costs_out;
	var taxes;
	var insurance;
	var principal_and_interest;
	var max_offer_price;

	/*********************************************************************/				
	// Recipient (from text input). Find the value of the input box
	$("input").keyup(function () {
	
		// Get content entered in the form element			
		var recipient = $(this).val();  
		
		// JS string.length property
		var length = recipient.length;  
		
		// Error checking
		var maxlength = 14;
		
		// Show a countdown message of how many characters user has left
		var characters_left = maxlength - length;
		$("#recipient-error").html("There are " + characters_left + " characters left");				
		
		// Toggle color of the message depending on how many characters they have left
		if(characters_left <=3 && characters_left > 0) {
			$("#recipient-error").css("color", "orange");
		}	
		else if (characters_left == 0) {
			$("#recipient-error").html("The maximum number of characters is " +  maxlength);
			$("#recipient-error").css("color", "red");	
			$("#recipient-error").css("font-weight", "bold");	
			// color default red (.error), but changed with the if{} statement 	
		}		
		else {
			$("#recipient-error").css("color", "grey");				
		}

		
	});

	
	
	/******************************************************************************/	
	// "Calculate" Button - Clear all text fields
	$("#calculate-button").click(function() {

		validateInputFields();
		
		// If all the input are validated, Calculate maximimum Offer Price
		max_offer_price = 	after_repair_value - (profit_goal + estimated_repairs + commission +
							closing_costs_in + closing_costs_out + taxes + insurance + 
							principal_and_interest);
							
		console.log(max_offer_price);
		$("#maximum_offer").val(max_offer_price);
					
	});	
	
	/******************************************************************************/
	// Validate all input fields
	function validateInputFields() {	
		
		// Process After Repair Value
		after_repair_value = $("#after-repair-value").val();
		
		// Verify that input is not an empty string and is a number
		if (isNaN(after_repair_value)) {
			$("#input_error").html("Please enter a number for After Repair Value");
			return (false);
		}	
		
		// Process Profit Goal
		profit_goal = $("#profit-goal").val();
		if (isNaN(profit_goal)) {
			$("#input_error").html("Please enter a number for Profit Goal");
			return (false);
		}	
		
		// Process Estimated Repairs
		estimated_repairs = $("#estimated-repairs").val();
		if (isNaN(estimated_repairs)) {
			$("#input_error").html("Please enter a number for Estimated Repairs");
			return (false);
		}			
		
		// Process Commission				
		commission = $("#commission").val("");
		if (isNaN(commission)) {
			$("#input_error").html("Please enter a number for Commission");
			return (false);
		}	
		
		// Process Closing Costs In				
		closing_costs_in = $("#closing-costs-in").val();
		if (isNaN(closing_costs_in)) {
			$("#input_error").html("Please enter a number for Closing Costs In");
			return (false);
		}		
		
		// Process Closing Costs Out				
		closing_costs_out = $("#closing-costs-out").val();
		if (isNaN(closing_costs_out)) {
			$("#input_error").html("Please enter a number for Closing Costs Out");
			return (false);
		}			
		
		// Process Taxes				
		taxes = $("#taxes").val();
		if (isNaN(taxes)) {
			$("#input_error").html("Please enter a number for Taxes");
			return (false);
		}	

		// Process Insurance			
		insurance = $("#insurance").val();
		if (isNaN(insurance)) {
			$("#input_error").html("Please enter a number for Insurance");
			return (false);
		}
		
		// Process Principal & Interest (Mortgage Payments)			
		principal_and_interest = $("#principal-and-interest").val();
		if (isNaN(principal_and_interest)) {
			$("#input_error").html("Please enter a number for Principal & Interest");
			return (false);
		}		
			
	} // end validateInputFields()
	



	
	
	/******************************************************************************/	
	// "Clear All" Button - Clear all text fields & Error message
	$("#refresh-button").click(function() {
	
		$("#after-repair-value").val("");	
		$("#profit-goal").val("");	
		$("#estimated-repairs").val("");	
		$("#commission").val("");	
		$("#closing-costs-in").val("");	
		$("#closing-costs-out").val("");	
		$("#taxes").val("");	
		$("#insurance").val("");	
		$("#principal-and-interest").val("");	
		
		$("#input_error").html("");  
			
	});	
	
	
});  //end doc ready; do not delete this!
