<div class="container widgets">

	<div class="subnav subnav-fixed">
	  <ul class="nav nav-pills">
	    <li><a href="<?php echo site_url('user/user_group/create'); ?>">Create User Group</a></li>
	    <li><a href="<?php echo site_url('user/user_group/list_user_group'); ?>">List of User Group</a></li>
	  </ul>
	</div>
  
  
  	<div style="height: 20px;"></div>
  
  	<div class="alert alert-block" style="display: none;" id="message">
		<button class="close" data-dismiss="alert">×</button>
		<h4 class="alert-heading">System Message</h4>
		<p id="messageContent">&nbsp;</p>
	</div>
  
  	<div class="row">	
		<div class="span12">
			<form name="frmUserGroup" id="frmUserGroup" action="" method="post" class="form-horizontal">
				<input type="hidden" name="userGroupId" id="userGroupId" value="<?php echo $this->uri->segment(4); ?>"/>
				<fieldset>
					<legend>Edit User Group</legend>
					<div class="control-group" id="groupUserGroup">
						<label class="control-label" for="userGroup"><span class="required">*</span> User Group</label>
						<div class="controls">
							<input name="userGroup" id="userGroup" class="input-xlarge" type="text" value="<?php echo $myData[0]['group_name']; ?>">
							<span class="help-inline" id="userGroupMessage" style="display: none;">&nbsp;</span>
						</div>
					</div>	
					<div class="control-group" id="groupUserGroupDescription">
						<label class="control-label" for="userGroupDescription">User Group Description</label>
						<div class="controls">
							<textarea name="userGroupDescription" id="userGroupDescription" class="input-xlarge" rows="3"><?php echo $myData[0]['group_description']; ?></textarea>
							<span class="help-inline" id="userGroupDescriptionMessage" style="display: none;">&nbsp;</span>
						</div>
					</div>					
					<div class="control-group">
						<div class="controls">
							<a class="btn btn-success" href="#" name="cmdSave" id="cmdSave"><i class="icon-ok-sign icon-white"></i> Save</a>
							<a class="btn btn-danger" href="<?php echo current_url(); ?>" name="cmdCancel" id="cmdCancel"><i class="icon-remove-sign icon-white"></i> Cancel</a>
						</div>
					</div>
				</fieldset>												
			</form>  
		</div>
   	</div>
</div>

<script type="text/javascript">
	$('#cmdSave').click
	(
		function()
		{
			var formError = 0;
			if($('#userGroup').val() == ''){
				$('#groupUserGroup').addClass('error');
				$('#userGroupMessage').html('Please type the <b>User Group.</b>');
				$('#userGroupMessage').fadeIn('slow');
				formError = 1;
			}	
			
			if(formError == 1){
				$('#messageContent').html('Please correct the errors. Check if you have entered on the required fields.');
				$('#message').addClass('alert-error');
				$('#message').fadeIn('fast');
			} else {
			
				$.post
				(
					'<?php echo site_url('user/user_group/update'); ?>',
					{
						userGroupId: $('#userGroupId').val(),
						userGroup: $('#userGroup').val(),
						userGroupDescription: $('#userGroupDescription').val()
					},
					function(data)
					{
						$('#message').removeClass('alert-error');
						$('#message').removeClass('alert-warning');	
						$('#message').removeClass('alert-success');	
						$('#userGroupMessage').fadeOut('slow');
						$('#groupUserGroup').removeClass('error');
						$('#groupUserGroup').removeClass('warning');
						
						if(data == 'EXIST'){
							$('#messageContent').html('User Group <b>' + $('#userGroup').val() + '</b> already exist. Please type new <b>Module Name.</b>');
							$('#message').addClass('alert-warning');
							$('#message').fadeIn('slow');
						} else if(data == 'ERROR'){
							$('#messageContent').html('There was an error found in updating the User Group Information.');
							$('#message').addClass('alert-error');
							$('#message').fadeIn('slow');
						} else if(data == 'SAVE'){
							$('#messageContent').html('User Group Information successfully updated.');
							$('#message').addClass('alert-success');
							$('#message').fadeIn('slow');
							setTimeout('hideMessage()', 3000);	
						}		
					}
					
				);
			}	
		}
	);
	
	
</script>