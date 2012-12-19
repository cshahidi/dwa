<!-- Add Lead(Lead Generator) -->	

<h2>Lead Generator Input Form</h2>
<h3>Welcome back <?=$user->first_name?>! Please Add New Lead:</h3>

<? if($add_another_lead): ?>
	<div class="msg">
		Your lead has been added. Add another?
	</div>
	<br>
<? endif; ?>
	
<p>Please input "Hot Deal" property information below, as accurately as possible. Referral fees
   shall be paid at closing!
</p>

<form id="leadsForm" method="POST" action="/leads/p_add">

	  <fieldset>
		<legend>Property Information</legend>

		<p id="fineprint">
			<span class="star">*</span><span class="fineprint">= Required field.</span>
		</p>			
		
		
		<fieldset>  
		   <legend>Address</legend> 
			<p>
			  <label for="address">Street Address <span class="star" >*</span></label> <br>
			  <input type="text" id="address" name="address" size="25"/> </p>   
			<p>
			  <label for="city">City/Town <span class="star" >*</span></label> <br>
			  <input type="text" id="city" name="city" size="25"/> </p>
			
			<p>State<br>
			  <select name="state">
				  <optgroup label="US">
					<!-- value is an optional attribute. If not provided, Content will be sent to server -->
					<option value="CA">California</option>
					<option value="CO">Colorado</option>
					<option value="FL">Florida</option>
					<option value="MA" selected="selected">Massachusetts</option>
					<option value="NH">New Hampshire</option>
					<option value="RI">Rhode Island</option>
					<option value="VT">Vermont</option>
				  </optgroup>
			  </select> <br>
			</p>
			
			<p>
			  <label for="zipcode">Zip Code <span class="star" >*</span></label> <br>
			  <input id="zipcode" name="zipcode" size="25"/> </p>
		</fieldset>
							
	   <fieldset>  
		   <legend>Basic Info</legend>
	 
			<p id="vacant">Vacant? <span class="star" >*</span></p>
			<p class="questionchoices"> 
			  <input type="radio" name="vacant" id="vacant_y" value="yes"/>
			  <label for="vacant_y">Yes</label><br>
	
			  <input type="radio" name="vacant" id="vacant_n" value="no"/>
			  <label for="vacant_n">No</label> 
			</p>

			<p id="mls">MLS Listing? <span class="star" >*</span></p>
			<p class="questionchoices">  <!-- this class is used to indent the radio buttons -->
			  <input type="radio" name="mls_listing" id="mls_y" value="yes"/>
			  <label for="mls_y">Yes</label><br>
	
			  <input type="radio" name="mls_listing" id="mls_n" value="no"/>
			  <label for="mls_n">No</label> 
			</p>
			
			<p>
			  <label for="bedrooms">Bedrooms <span class="star" >*</span></label> <br>
			  <input id="bedrooms" name="bedrooms" size="6"/> </p>	
			
			<p>
			  <label for="baths">Baths  <span class="star" >*</span></label> <br>
			  <input id="baths" name="baths" size="6"/> </p>	

			<p>
			  <label for="sqft">Living Area (sqft) <span class="star" >*</span></label> <br>
			  <input id="sqft" name="liv_area_sqft" size="25"/> </p>	

			<p>
			  <label for="lotsize">Lot Size (sqft) <span class="star" >*</span></label> <br>
			  <input id="lotsize" name="lot_size_sqft" size="25"/> </p>	
			  
			<p>Type <span class="star" >*</span><br>
			  <select name="type">
					<option value="">--Please Select--</option>
					<option value="single">Single Family</option>
					<option value="condo">Condo</option>
					<option value="2family">Two Family</option>
					<option value="3family">Three Family</option>
					<option value="4familyplus">Four+ Family (Specify in Comments Section)</option>
			  </select> <br>
			</p>
			  
			<p>
			  <label for="year_built">Year Built <span class="star" >*</span></label> <br>
			  <input type="text" id="year_built" name="year_built" size="25"/> 
			</p>					  
			
			<!-- Future: Store link (not image) in DB
			<p id="picture">Picture <span class="fineprint">(optional) </span><br>
			  <input type="file" name="picture" />
			</p>
			-->
			
	   </fieldset>

		  
	   <fieldset>  
		   <legend>Financial Info</legend>
			<p>
			  <label for="asking_price">Asking Price ($) <span class="star" >*</span></label><br>
			  <input type="text" id="asking_price" name="asking_price" size="25"/> </p>		
			<p>
			  <label for="estd_repairs">Estimated Repairs ($) <span class="star" >*</span></label><br>
			  <input type="text" id="estd_repairs" name="estimated_repairs" size="25"/> </p>						  
			<p>
			  <label for="arv">After Repair Value ($)  <span class="star" >*</span></label><br>
			  <input type="text" id="arv" name="arv" size="25"/> </p>
		</fieldset>
		
		<p>
		  <label for="ccomment">Your Comments</label><br>
		  <textarea id="ccomment" name="comment" cols="50" rows="5"></textarea> <br>			  
		</p>	
	 
   </fieldset>
  
   <p>
	 <input type="submit" class="button" value="Add Lead" />
   </p>
</form>


<!-- JQuery form validation plugin -->
<script type="text/javascript">

	// Set up rules 
	var validation = $("#leadsForm").validate(
		{
		 rules: { 
		   address: { required: true, minlength: 4 },
		   city: { required: true, minlength: 3 },
		   zipcode: { required: true, number: true, minlength: 5, max: 99999 },
		   vacant: {required: true},
		   mls: {required: true},
		   bedrooms: { required: true, digits: true, min: 1, max: 100},
		   baths: { required: true, number: true, min: 1, max: 50},
		   sqft: {required: true, number: true, max: 20000, minlength: 3},
		   lotsize: {required: true, number: true, max: 90000, minlength: 3},
		   type: { required: true},
		   yearbuilt: {required: true, digits: true, min: 1780, max: 2012, minlength: 4},
		   asking_price: {required: true, digits: true, max: 4000000, minlength: 4},
		   estd_repairs: {required: true, digits: true, max: 1000000, minlength: 3},
		   arv:	{required: true, digits: true, max: 60000000, minlength: 4 }
		},
		
		/* Place error for radio input selections right after question name (vs after answer labels) */
		errorPlacement: function(error,element) {
		   if ( element.is("[name=vacant]") ) 
			  error.appendTo( $('p#vacant') );
		   else if ( element.is("[name=mls]") ) 
			  error.appendTo( $('p#mls') );
		   else 
			  error.insertAfter(element);
		}
	});
	$("#zipcode").mask("99999");  /* apply 5 digit mask to zip code */

</script>	
