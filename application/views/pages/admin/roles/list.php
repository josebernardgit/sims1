<?php
	if($myData){
?>
		<script type="text/javascript">
			$('#messageContent').html('No Roles found in the database.');
			$('#message').addClass('alert-error');
			$('#message').fadeIn('slow');
		</script>
<?php
	}
?>

<div class="container widgets">

	<div class="subnav subnav-fixed">
	  <ul class="nav nav-pills">
	    <li><a href="<?php echo site_url('admin/roles/create'); ?>">Create Role</a></li>
	    <li class="active"><a href="<?php echo current_url(); ?>">List of Roles</a></li>
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
		    <h3>Delete Role</h3>
		</div>
		<div class="modal-body">
		    <p>Proceed in deleting the Role Information from the database?</p>
		    </div>
		    <div class="modal-footer">
		    <a href="#" class="btn btn-success" id="cmdYes"><i class="icon-ok icon-white"></i> Yes</a>
		    <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-remove icon-white"></i> No</a>
	    </div>
    </div>
	
	<div class="modal fade" id="myUsers" style="display: none;">
	    <div class="modal-header">
		    <button class="close" data-dismiss="modal">×</button>
		    <h3>Add Role to Users</h3>
		</div>
		<form name="frmAddUserRoles" id="frmAddUserRoles" action="<?php echo site_url('admin/roles/save_users'); ?>" method="post" class="form-horizontal">
			<div class="modal-body">
			    <p id="displayUsers">&nbsp;</p>
			</div>
			<div class="modal-footer">
			    <button class="btn btn-success"><i class="icon-plus-sign icon-white"></i> Add Users</button>
			    <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-remove-sign icon-white"></i> Close</a>
		    </div>
		</form>
    </div>
	
	<div class="modal fade" id="removeUsers" style="display: none;">
	    <div class="modal-header">
		    <button class="close" data-dismiss="modal">×</button>
		    <h3>Remove Role to Users</h3>
		</div>
		<form name="frmDeleteUserRoles" id="frmDeleteUserRoles" action="<?php echo site_url('admin/roles/delete_users'); ?>" method="post" class="form-horizontal">
			<div class="modal-body">
			    <p id="displayRemoveUsers">&nbsp;</p>
			</div>
			<div class="modal-footer">
			    <button class="btn btn-success"><i class="icon-plus-sign icon-white"></i> Remove Users</button>
			    <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-remove-sign icon-white"></i> Close</a>
		    </div>
		</form>
    </div>
  	
  	<div class="row">	
         <div class="span12">
		 	<input type="hidden" name="roleId" id="roleId" value=""/>
			<input type="hidden" name="currentUrl" id="currentUrl" value="<?php echo current_url(); ?>"/>
			<legend>List of Roles</legend>
			<?php
				if($myData){
			?>
					<table class="table table-bordered">
						<tr>
							<th>Module Name</th>
							<th>Role Name</th>
							<th>Role Description</th>
							<th>&nbsp;</th>
						</tr>
						<?php
							foreach($myData as $indexmyData){
						?>
								<tr>
									<td><?php echo $indexmyData['module_name']; ?></td>
									<td><?php echo $indexmyData['role_name']; ?></td>
									<td><?php echo $indexmyData['role_description']; ?></td>
									<td>
										<a href="<?php echo site_url('admin/roles/edit/' . $indexmyData['id']); ?>" class="btn btn-warning"><i class="icon-pencil icon-white"></i> Edit</a>
										<a href="#" class="btn btn-warning" data-toggle="modal" onclick="addRoleUser('<?php echo $indexmyData['id']; ?>')"><i class="icon-plus-sign icon-white"></i> Add Role to User</a>
										<a href="#" class="btn btn-warning" data-toggle="modal" onclick="removeRoleUser('<?php echo $indexmyData['id']; ?>')"><i class="icon-remove-sign icon-white"></i> Remove Role to User</a>
										<a href="#" class="btn btn-warning" data-toggle="modal" onclick="deleteRole('<?php echo $indexmyData['id']; ?>')"><i class="icon-trash icon-white"></i> Delete</a>
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
	function deleteRole(roleId)
	{
		$('#roleId').val(roleId);
		$('#myModal').modal('show');
	}
	
	$('#cmdYes').click
	(
		function()
		{
			$('#myModal').modal('hide');
			$.post
			(
				'<?php echo site_url('admin/roles/delete'); ?>',
				{
					roleId: $('#roleId').val()
				},
				function(data)
				{
					if(data == 'DELETE'){
						$('#messageContent').html('Role Information successfully deleted from the database.');
						$('#message').addClass('alert-success');
						$('#message').fadeIn('slow');	
						setTimeout('hideMessage()', 3000);	
					} else if(data == 'ERROR'){
						$('#messageContent').html('There was an error found in deleting the Role Information.');
						$('#message').addClass('alert-error');
						$('#message').fadeIn('slow');		
					}
				}
			);
		}
	)
	
	function addRoleUser(roleId)
	{
		$('#roleId').val(roleId);
		$('#myUsers').modal('show');
		
		// Get the Users that does have the role
		$.post
		(
			'<?php echo site_url('admin/roles/add_users'); ?>',
			{
				roleId: roleId,
				currentUrl: $('#currentUrl').val()
			},
			function(data)
			{
				$('#displayUsers').html(data);
			}
		);	
	}
	
	function removeRoleUser(roleId)
	{
		$('#roleId').val(roleId);
		$('#removeUsers').modal('show');
		
		// Get the Users that does have the role
		$.post
		(
			'<?php echo site_url('admin/roles/remove_users'); ?>',
			{
				roleId: roleId,
				currentUrl: $('#currentUrl').val()
			},
			function(data)
			{
				$('#displayRemoveUsers').html(data);
			}
		);			
	}
</script>