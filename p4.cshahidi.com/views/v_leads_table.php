/* ====================  v_leads_table ======================== */
			
<table class="tablesorter">
  <caption>
	Leads To Be Worked
  </caption>
  <thead>
	<tr>
	  <th>#</th>
	  <th>Date Entered</th>
	  <th>Street Address</th>
	  <th>City</th>
	  <th>State</th>
	  <th>Status</th>
	</tr>
  </thead>
  
  <tbody id="table_results">      
	 <!-- Table Results placeholder -->
  
	<? foreach($leads as $lead): ?>    <!-- (i.e. $key=>lead) -->
		
		<!-- Print this row of table -->
		<!-- Give each row an id so we can fade it out after deleting the lead (Susan) -->
		<tr id="lead_row_<?=$lead['lead_id']?>">				
			<td><?=$lead['lead_id']?></td>
			<td><?=Time::display($lead['created'])?>  </td> 		 <!-- Time & Date entered -->
			<td><?=$lead['street_address']?></td>  
			<td><?=$lead['city']?></td>
			<td><?=$lead['state']?></td>
			<td id="lead_row_<?=$lead['lead_id']?>_status>">     
			
				<!-- Make this modifiable (Pending, Accepted, Rejected) -->	
				<!-- Use HTML 5 data attributes to associate lead_id and status with record -->
				<select name="status" class="status" data-lead-id="<?=$lead['lead_id']?>"
													 data-status-value="<?=$lead['status']?>">
													 
					<option value="<?=$lead['status']?>" selected="selected"><?=$lead['status']?></option>
					<option value="accepted">accepted</option>
					<option value="rejected">rejected</option>
				</select>
			</td>
				
			<!-- Susan: Here's our Delete button. -->
			<!-- Note we're using the HTML 5 "data attribute" to associate the lead_id with it -->
			<!-- More about the data attribute here: http://ejohn.org/blog/html-5-data-attributes/ -->
			<td><input type='button' class='delete' data-lead-id="<?=$lead['lead_id']?>" 
				 value='Delete Lead'>
			</td>

	<? endforeach; ?>
  </tbody>		  
		  
		
		
<!-- Use Ajax to do the row deletion and then have JS visually remove that row from the table (Susan) -->
<!-- This avoids re-rendering the whole table after deleting a record -->
<script type='text/javascript'>

	$('.delete').click(function() {
		
		// Figure out the lead_id based on the data attribute
		var lead_id = $(this).attr('data-lead-id');
	
		// Call delete method in our leads controller to do the ajax work of deleting this lead from DB
		$.ajax({
			type: 'POST',
			url: '/leads/delete/',
			success: function(response) { 
				
				// Fade out this lead row since it has now been deleted
				$('#lead_row_' + lead_id).hide('slow');				
			},
			data: {
				// Make sure we tell our method what the lead_id is
				lead_id: lead_id;
			},
		});
		
	});


		
		
<!-- Use Ajax to change "status" field drop-down and then have JS visually change it -->

  	<select name="status" class="status" data-lead-id="<?=$lead['lead_id']?>" 
										 data-status-value="<?=$lead['status']?>">
  
	$('.status').change(function() {
		
		// Figure out the lead_id based on the data attribute
		var lead_id = $(this).attr('data-lead-id');		
		
		// Figure out the status (pending, accepted, rejected) based on the data attribute
		var status = $(this).attr('data-status-value');  
	
		// Call update_status method in leads controller to do the ajax work of updating status in DB
		$.ajax({
			type: 'POST',
			url: '/leads/update_status/',
			success: function(response) { 
				
				// Fade out this toy row since it has now been deleted
				// $('#lead_row_' + lead_id).hide('slow');					
				$('#lead_row_' + lead_id + '_status').hide('slow');		

				// Update the status field in this row
				$('#lead_row_' + lead_id + '_status').hide('slow');					
			},
			data: {
				// Make sure we tell our method the lead_id and status 
				lead_id: lead_id;				
				status: status;
			},
		});
		
	});
</script>		