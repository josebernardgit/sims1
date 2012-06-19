<?php
	if($myData){
?>
		<script type="text/javascript">
			$('#messageContent').html('No Modules found in the database.');
			$('#message').addClass('alert-error');
			$('#message').fadeIn('slow');
		</script>
<?php
	}
?>

<div class="container widgets">

	<div class="subnav subnav-fixed">
	  <ul class="nav nav-pills">
	    <li><a href="<?php echo site_url('user/user_group/create'); ?>">Create User Group</a></li>
	    <li class="active"><a href="<?php echo current_url(); ?>">List of User Group</a></li>
	  </ul>
	</div>
  
  
  	<div style="height: 20px;"></div>
  
  	<div class="alert alert-block" style="display: none;" id="message">
		<button class="close" data-dismiss="alert">×</button>
		<h4 class="alert-heading">System Message</h4>
		<p id="messageContent">&nbsp;</p>
	</div>
	
	<div class="modal fade" id="myModal" style="display: none;">
	    <div class="modal-header">
		    <button class="close" data-dismiss="modal">×</button>
		    <h3>Delete User Group</h3>
		</div>
		<div class="modal-body">
		    <p>Proceed in deleting the User Group Information from the database?</p>
		    </div>
		    <div class="modal-footer">
		    <a href="#" class="btn btn-success" id="cmdYes"><i class="icon-ok icon-white"></i> Yes</a>
		    <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-remove icon-white"></i> No</a>
	    </div>
    </div>
  
  	<div class="row">	
         <div class="span12">
		 	<input type="hidden" name="userGroupId" id="userGroupId" value=""/>
		 	<input type="hidden" name="userGroupName" id="userGroupName" value=""/>
			<legend>List of User Group</legend>
			<?php
				if($myData){
			?>
					<table class="table table-bordered">
						<tr>
							<th>User Group Name</th>
							<th>User Group Description</th>
							<th>&nbsp;</th>
						</tr>
						<?php
							foreach($myData as $indexmyData){
						?>
								<tr>
									<td><?php echo $indexmyData['group_name']; ?></td>
									<td><?php echo $indexmyData['group_description']; ?></td>
									<td>
										<a href="<?php echo site_url('user/user_group/edit/' . $indexmyData['id']); ?>" class="btn btn-warning"><i class="icon-pencil icon-white"></i> Edit</a>
										<a href="#" class="btn btn-warning" data-toggle="modal" onclick="addRoleUserGroup('<?php echo $indexmyData['id']; ?>')"><i class="icon-plus-sign icon-white"></i> Add Role to User Group</a>
										<a href="#" class="btn btn-warning" data-toggle="modal" onclick="removeRoleUserGroup('<?php echo $indexmyData['id']; ?>')"><i class="icon-remove-sign icon-white"></i> Remove Role to User Group</a>
										<a href="#" class="btn btn-warning" data-toggle="modal" onclick="deleteUserGroup('<?php echo $indexmyData['id']; ?>','<?php echo $indexmyData['group_name']; ?>')"><i class="icon-trash icon-white"></i> Delete</a>
									</td>
								</tr>
						<?php
							}
						?>
					</table>			
			<?php
				}
			?>
        </div>
   	</div>
</div>

<script type="text/javascript">
	function deleteUserGroup(userGroupId, userGroupName)
	{
		$('#userGroupId').val(userGroupId);
		$('#userGroupName').val(userGroupName);
		$('#myModal').modal('show');
	}
	
	$('#cmdYes').click
	(
		function()
		{
			$('#myModal').modal('hide');
			$.post
			(
				'<?php echo site_url('user/user_group/delete'); ?>',
				{
					userGroupId: $('#userGroupId').val(),
					userGroupName: $('#userGroupName').val()
				},
				function(data)
				{
					if(data == 'DELETE'){
						$('#messageContent').html('User Group Information successfully deleted from the database.');
						$('#message').addClass('alert-success');
						$('#message').fadeIn('slow');	
						setTimeout('hideMessage()', 3000);	
					} else if(data == 'ERROR'){
						$('#messageContent').html('There was an error found in deleting the User Group Information.');
						$('#message').addClass('alert-error');
						$('#message').fadeIn('slow');		
					}
				}
			);
		}
	)
</script>