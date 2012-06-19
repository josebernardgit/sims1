<div class="container widgets">

	<div class="subnav subnav-fixed">
	  <ul class="nav nav-pills">
	    <li class="active"><a href="<?php echo current_url(); ?>">Create Module</a></li>
	    <li><a href="<?php echo site_url('admin/module/list_module'); ?>">List of Modules</a></li>
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
			<form name="frmModules" id="frmModules" action="" method="post" class="form-horizontal">
				<fieldset>
					<legend>Create Module</legend>
					<div class="control-group" id="groupModuleName">
						<label class="control-label" for="input01"><span class="required">*</span> Module Name</label>
						<div class="controls">
							<input name="moduleName" id="moduleName" class="input-xlarge" type="text">
							<span class="help-inline" id="moduleNameMessage" style="display: none;">&nbsp;</span>
						</div>
					</div>	
					<div class="control-group" id="groupModuleDescription">
						<label class="control-label" for="input01">Module Description</label>
						<div class="controls">
							<textarea name="moduleDescription" id="moduleDescription" class="input-xlarge" rows="3"></textarea>
							<span class="help-inline" id="moduleDescriptionMessage" style="display: none;">&nbsp;</span>
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
			if($('#moduleName').val() == ''){
				$('#groupModuleName').addClass('error');
				$('#moduleNameMessage').html('Please type the <b>Module Name.</b>');
				$('#moduleNameMessage').fadeIn('slow');
				formError = 1;
			}	
			
			if(formError == 1){
				$('#messageContent').html('Please correct the errors. Check if you have entered on the required fields.');
				$('#message').addClass('alert-error');
				$('#message').fadeIn('fast');
			} else {
			
				$.post
				(
					'<?php echo site_url('admin/module/save'); ?>',
					{
						moduleName: $('#moduleName').val(),
						moduleDescription: $('#moduleDescription').val()
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
							$('#messageContent').html('Module <b>' + $('#moduleName').val() + '</b> already exist. Please type new <b>Module Name.</b>');
							$('#message').addClass('alert-warning');
							$('#message').fadeIn('slow');
						} else if(data == 'ERROR'){
							$('#messageContent').html('There was an error found in saving the Role Information.');
							$('#message').addClass('alert-error');
							$('#message').fadeIn('slow');
						} else if(data == 'SAVE'){
							$('#messageContent').html('Module Information successfully saved.');
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