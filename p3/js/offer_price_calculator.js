
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
	var utilities;
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
	// March 4, 2015 - Enhancement to original code 
	// Add commas to the figures to represent 1000's. 
	
	/* Source: http://stackoverflow.com/questions/3883342/add-commas-to-a-number-in-jquery/18676419#18676419 */
	/* Timothy Pirez answer was very correct but if you need to replace the numbers with commas 
	 * Immediately as user types in textfield, u might want to use the Keyup function. 
	 */	

	
	/************************************************************************/
	/* Source: http://javidrashid.blogspot.com/2012/12
	 *    "We will write a regex that will add a comma after every third character is entered. This 
	 *     function will be called on blur and keyup events.  Since we are using jQuery fn function, we
	 * 	   need to import jQuery library to get it working. Below is the code snippet."
	 */
	(function($){
      String.prototype.addComma = function() {
      /* Original Code:
	   * return this.replace(/(.)(?=(.{3})+$)/g,"$1,");
	   */
	   
	  /*CS: Modified original regex so commas not inserted before decimal points */
	    return this.replace(/\B(?=(\d{3})+(?!\d))/g,","); 

      }
       $.fn.digits = function () {
        return this.each(function () {
            /* Original Code:
			 * $(this).val($(this).val().replace(/(,| )/g,'').addComma()); //Comma works; allows dots & 3 decimals
			 */
			/* CS: Modified original regex so non decimal values other than comma are immediately removed
			 *   along with commas. 
			 */  
			//$(this).val($(this).val().replace(/[^\d.]/g,'').addcomma()); // Allows multiple dots
			
			$(this).val($(this).val().replace(/[^\d]/g,'').addComma());  // Allows more than one dot 
	       })
		}
	})(jQuery)
    
	jQuery(function(){
    $('input[type=text]').bind('blur keyup',function(){ $(this).digits(); }).digits();
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
							insurance - utilities- principal_and_interest;
					
			// Round final value down to lowest integer value 
			// $("#maximum-offer").val(Math.floor(max_offer_price));			
			max_offer_price = Math.floor(max_offer_price);
			
			// Convert int to string, inserting commas for 1,000s	
			var max_offer_price_comma = max_offer_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");	
				
			// Insert in "Maximum Offer" text field.
			$("#maximum-offer").val(max_offer_price_comma);	
			
		
		}		
	}
	
	/******************************************************************************/
	// Validate all input fields
	function validateInputFields() {	  
		
		// Process After Repair Value.  
		// Retrieve text field: after_repair_value = $("#after-repair-value").val();
		// Remove commas (otherwise, there will be int processing problems): replace(/\,/g,"");
		// Verify that text field inputs have numeric content.
		
		after_repair_value = $("#after-repair-value").val().replace(/\,/g,"");	
		if (validateNumericInput( after_repair_value, "After Repair Value")== false) {
			return (false);
		}
		// alert (after_repair_value);
		
		// Process Profit Goal
		profit_goal = $("#profit-goal").val().replace(/\,/g,"");
		if (validateNumericInput( profit_goal, "Profit Goal")== false) {
			return (false);
		}
		
		
		// Process Estimated Repairs
		estimated_repairs = $("#estimated-repairs").val().replace(/\,/g,"");
		if (validateNumericInput( estimated_repairs, "Estimated Repairs")== false) {
			return (false);
		}			
		
		// Process Commission				
		commission = $("#commission").val().replace(/\,/g,"");
		if (validateNumericInput( commission, "Commission")== false) {
			return (false);
		}	
		
		// Process Closing Costs In				
		closing_costs_in = $("#closing-costs-in").val().replace(/\,/g,"");
		if (validateNumericInput( closing_costs_in, "Closing Costs In")== false) {
			return (false);
		}		
		
		// Process Closing Costs Out				
		closing_costs_out = $("#closing-costs-out").val().replace(/\,/g,"");
		if (validateNumericInput( closing_costs_out, "Closing Costs Out")== false) {
			return (false);
		}		
		
		// Process Taxes				
		taxes = $("#taxes").val().replace(/\,/g,"");
		if (validateNumericInput( taxes, "Taxes")== false) {
			return (false);
		}

		// Process Insurance			
		insurance = $("#insurance").val().replace(/\,/g,"");
		if (validateNumericInput( insurance, "Insurance")== false) {
			return (false);
		}
		
		// Process Utilities			
		utilities = $("#utilities").val().replace(/\,/g,"");
		if (validateNumericInput( utilities, "Utilities")== false) {
			return (false);
		}			
		
		// Process Principal & Interest (P&I: Mortgage Payments)			
		principal_and_interest = $("#principal-and-interest").val().replace(/\,/g,"");
		if (validateNumericInput( principal_and_interest, "Principal & Interest")== false) {
			return (false);
		}		
						
		// All inputs valid
		return (true);
			
	} // end validateInputFields()
	

	
	/*************Function called from validateInputFields()****************************/
	// Verify that text field inputs have positive numeric content (and are not an empty string)
	
	function validateNumericInput(str_value, str_label) {
		 		
		// Parse integer froms string
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
	
		var subtotal =  after_repair_value - profit_goal - estimated_repairs - commission - 
						closing_costs_in - closing_costs_out - taxes - insurance - utilities; 
		
		console.log(subtotal);

						
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
	
		// Suggested edit by SB: Give all elements that can be refreshed a class "refreshable".
		// That way you can clear them all with one line of code, and easily add new elements
		// the road.
	
		$("#after-repair-value").val("");	
		$("#profit-goal").val("");	
		$("#estimated-repairs").val("");	
		$("#commission").val("");	
		$("#closing-costs-in").val("");	
		$("#closing-costs-out").val("");	
		$("#taxes").val("");	
		$("#insurance").val("");	
		$("#principal-and-interest").val("");	
		$("#utilities").val("");	
		
		$("#trulia_info").html("");  
		
		$("#maximum-offer").val("");
		$("#input_error").html(""); 
		
	});	
	
	
});  //end doc ready; do not delete this!
