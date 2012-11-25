
$(document).ready(function() {	//start doc ready
				
	// Declare Global variables
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

	/******************************************************************************/
	// Show calculator div and hide help div on page load
	$("#help").hide();
	
	// If "Help" link on top is clicked, hide calculator div and show help div
	$("#help_link").click(function() {
		$("#calculator").hide();
		$("#finalize-buttons").hide();		
		$("#help").show();
	});
	
	// If "Calculator" link on top is clicked, show calculator div and hide help div
	$("#calculator_link").click(function() {
		$("#calculator").show();
		$("#finalize-buttons").show();		
		$("#help").hide();
	});	
	
	
	
	/******************************************************************************/	
	// "Calculate" Offer Button in Calculator form. Depressed after all the inputs have been entered.
	$("#calculate-button").click(function() {
		calculate_offer();
	});
	
	
	/******************************************************************************/
	function calculate_offer() {
	
		// Clear the error message on each Calculate click
		$("#input_error").html(""); 

		// Validate each input field entry
		if( validateInputFields()) {
		
			/* Calculate Subtotal, used to figure monthly mortgage payments if offer is not All Cash.
			 * This is After Rehab Value minus all expenses except Principal & Interest, which we we
			 * trying to figure.
			 * This is the "Property Price" to plug into the Trulia Mortgage Calculator.
			 * Please find the Mortgage Calculator at http://www.trulia.com/mortgage-calculators/.
			 * Multiply the "Total monthly payments" figure by 6 (6 months) and plug it into 
			 * "Principal & Interest" field.
			 */
			calculate_subtotal_for_mortgage();	
		
			// All the inputs are validated, Calculate maximimum Offer Price							  
			max_offer_price = after_repair_value - profit_goal - estimated_repairs - commission - 
							closing_costs_in - closing_costs_out - taxes - 
							insurance - principal_and_interest;

			// Round final value down to lowest integer value.
			$("#maximum-offer").val(Math.floor(max_offer_price));		
		
		}							
	}
	
	/******************************************************************************/
	// Validate all input fields
	function validateInputFields() {	  
		
		// Process After Repair Value.  Verify that text field inputs have numeric content.
		after_repair_value = $("#after-repair-value").val();		
		if (validateNumericInput( after_repair_value, "After Repair Value")== false) {
			return (false);
		}
		
		// Process Profit Goal
		profit_goal = $("#profit-goal").val();
		if (validateNumericInput( profit_goal, "Profit Goal")== false) {
			return (false);
		}
		
		
		// Process Estimated Repairs
		estimated_repairs = $("#estimated-repairs").val();
		if (validateNumericInput( estimated_repairs, "Estimated Repairs")== false) {
			return (false);
		}			
		
		// Process Commission				
		commission = $("#commission").val();
		if (validateNumericInput( commission, "Commission")== false) {
			return (false);
		}	
		
		// Process Closing Costs In				
		closing_costs_in = $("#closing-costs-in").val();
		if (validateNumericInput( closing_costs_in, "Closing Costs In")== false) {
			return (false);
		}		
		
		// Process Closing Costs Out				
		closing_costs_out = $("#closing-costs-out").val();
		if (validateNumericInput( closing_costs_out, "Closing Costs Out")== false) {
			return (false);
		}		
		
		// Process Taxes				
		taxes = $("#taxes").val();
		if (validateNumericInput( taxes, "Taxes")== false) {
			return (false);
		}

		// Process Insurance			
		insurance = $("#insurance").val();
		if (validateNumericInput( insurance, "Insurance")== false) {
			return (false);
		}
		
		// Process Principal & Interest (P&I: Mortgage Payments)			
		principal_and_interest = $("#principal-and-interest").val();
		if (validateNumericInput( principal_and_interest, "Principal & Interest")== false) {
			return (false);
		}		
						
		// All inputs valid
		return (true);
			
	} // end validateInputFields()
	

	
	/*************Function called from validateInputFields()****************************/
	// Verify that text field inputs have positive numeric content (and are not an empty string)
	
	function validateNumericInput(str_value, str_label) {
		
		var int_value = parseInt(str_value);
		
		// check that number is integer and not an empty string
		if( isNaN(int_value) || str_value == "") {
			$("#input_error").html("Please enter a valid number for " + str_label +"!");  
			return(false);
		}	
		
		// check that number is positive
		else if (int_value < 0) {
			$("#input_error").html("Please enter a positive number or 0 for " + str_label +"!");  
			return(false);
		}
		
		// check that number is not larger than after_repair_value
		else if (str_label != "After Repair Value") {
		
			if (int_value >= after_repair_value) {
				$("#input_error").html("Please ensure " + str_label + " is less than After Repair Value!");  
				return(false);
			}
		}
		
		// Input is Valid		
		else {
			return(true);		
		}		
	}
		
	
	/*************Function called from first ****************************/
	//  Calculate Subtotal, used to figure monthly mortgage payments (P&I) if offer is not All Cash.
	function calculate_subtotal_for_mortgage() {
	
		subtotal =  after_repair_value - profit_goal - estimated_repairs - commission - 
						closing_costs_in - closing_costs_out - taxes - insurance; 

		$("#trulia_info").html("Your Subtotal is " + subtotal + ". " +
						"You can use this as your Property Price to get your mortgage payment using " +
						"<a href='http://www.trulia.com/mortgage-calculators/'>Trulia Mortgage Calculator</a> " +
						"for Principal & Interest.");	

		// Clear the div for Trulia mortgage caculator link if user inputs any entries in P&I
		if (principal_and_interest != "0") {
			$("#trulia_info").html("");  
		}		
	}
	
	
	
	
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
		
		$("#trulia_info").html("");  
		
		$("#maximum-offer").val("");
		$("#input_error").html(""); 
		
	});	
	
	
});  //end doc ready; do not delete this!
