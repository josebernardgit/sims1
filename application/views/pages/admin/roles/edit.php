<div class="container widgets">

	<div class="subnav subnav-fixed">
	  <ul class="nav nav-pills">
	    <li><a href="<?php echo site_url('admin/roles/create'); ?>">Create Role</a></li>
	    <li><a href="<?php echo site_url('admin/roles/list_roles'); ?>">List of Roles</a></li>
	  </ul>
	</div>
  
  
  	<div style="height: 20px;"></div>
  
  	<div class="alert alert-block" style="display: none;" id="message">
		<button class="close" data-dismiss="alert">×</button>
		<h4 class="alert-heading">System Message</h4>
		<p id="messageContent">&nbsp;</p>
	</div>
  
  	<div class="row">	
		<div class="span8">
			<form name="frmRoles" id="frmRoles" action="" method="post" class="form-horizontal">
				<input type="hidden" name="roleId" id="roleId" value="<?php echo $this->uri->segment(4); ?>"/>
				<fieldset>
					<legend>Edit Role</legend>
					<div class="control-group" id="groupModule">
						<label class="control-label" for="module"><span class="required">*</span> Module Name</label>
						<div class="controls">
							<select name="module" id="module" class="input-xlarge">
								<option value=""> - select - </option>
								<?php
									if($modules){
										foreach($modules as $indexModules){
								?>
											<option value="<?php echo $indexModules['id']; ?>" <?php if($myData[0]['module'] == $indexModules['id']){ echo 'selected="selected"'; } ?>><?php echo $indexModules['module_name']; ?></option>
								<?php
										}
									}
								?>
							</select>
							<span class="help-inline" id="moduleMessage" style="display: none;">&nbsp;</span>
						</div>
					</div>	
					<div class="control-group" id="groupRoleName">
						<label class="control-label" for="roleName"><span class="required">*</span> Role Name</label>
						<div class="controls">
							<input type="text" name="roleName" id="roleName" value="<?php echo $myData[0]['role_name']; ?>" class="input-xlarge"/>
							<span class="help-inline" id="roleNameMessage" style="display: none;">&nbsp;</span>
						</div>
					</div>
					<div class="control-group" id="groupRoleDescription">
						<label class="control-label" for="input01">Role Description</label>
						<div class="controls">
							<textarea name="roleDescription" id="roleDescription" class="input-xlarge" rows="3"><?php echo $myData[0]['role_description']; ?></textarea>
							<span class="help-inline" id="roleDescriptionMessage" style="display: none;">&nbsp;</span>
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
		<div class="span4">
			<legend>Short Links</legend>
			<a href="<?php echo site_url('admin/module/create'); ?>" class="btn btn-inverse"><i class="icon-plus-sign icon-white"></i> Add New Module</a>	
		</div>
   	</div>
</div>

<script type="text/javascript">
	$('#cmdSave').click
	(
		function()
		{
			var formError = 0;
			if($('#module').val() == ''){
				$('#groupModule').addClass('error');
				$('#moduleMessage').html('Please select the <b>Module.</b>');
				$('#moduleMessage').fadeIn('slow');
				formError = 1;	
			}
			
			if($('#roleName').val() == ''){
				$('#groupRoleName').addClass('error');
				$('#roleNameMessage').html('Please type the <b>Role Name.</b>');
				$('#roleNameMessage').fadeIn('slow');
				formError = 1;
			}	
			
			if(formError == 1){
				$('#messageContent').html('Please correct the errors. Check if you have entered on the required fields.');
				$('#message').addClass('alert-error');
				$('#message').fadeIn('fast');
			} else {
			
				$.post
				(
					'<?php echo site_url('admin/roles/update'); ?>',
					{
						roleId: $('#roleId').val(),
						module: $('#module').val(),
						roleName: $('#roleName').val(),
						roleDescription: $('#roleDescription').val()
					},
					function(data)
					{
						$('#message').removeClass('alert-error');
						$('#message').removeClass('alert-warning');	
						$('#message').removeClass('alert-success');	
						$('#moduleNameMessage').fadeOut('slow');
						$('#groupModuleName').removeClass('error');
						$('#groupModuleName').removeClass('warning');
						
						if(data == 'EXIST'){
							$('#messageContent').html('Role <b>' + $('#roleName').val() + '</b> already exist. Please type new <b>Role Name.</b>');
							$('#message').addClass('alert-warning');
							$('#message').fadeIn('slow');
						} else if(data == 'ERROR'){
							$('#messageContent').html('There was an error found in updating the Module Information.');
							$('#message').addClass('alert-error');
							$('#message').fadeIn('slow');
						} else if(data == 'SAVE'){
							$('#messageContent').html('Role Information successfully updated.');
							$('#message').addClass('alert-success');
							$('#message').fadeIn('slow');
							$('#moduleName').val('');
							$('#moduleDescription').val('');
							setTimeout('hideMessage()', 3000);	
						}		
					}
					
				);
			}	
		}
	);
	
	
</script>