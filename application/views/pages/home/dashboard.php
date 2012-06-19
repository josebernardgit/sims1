<div class="container widgets">

  	<div style="height: 20px;"></div>
  
  	<div class="alert alert-block" style="display: none;" id="message">
		<button class="close" data-dismiss="alert">×</button>
		<h4 class="alert-heading">You got an error!</h4>
		<p id="messageContent">&nbsp;</p>
	</div>
  
  	<div class="row">	
		<div class="span12">
			<form name="frmLogin" id="frmLogin" action="" method="post" class="form-horizontal">
				<fieldset>
					<legend>Login</legend>
					<div class="control-group" id="groupUserName">
						<label class="control-label" for="userName">User Name</label>
						<div class="controls">
							<input name="userName" id="userName" class="input-xlarge" type="text">
							<span class="help-inline" id="userNameMessage" style="display: none;">&nbsp;</span>
						</div>
					</div>	
					<div class="control-group" id="groupPassword">
						<label class="control-label" for="userPassword">Password</label>
						<div class="controls">
							<input name="userPassword" id="userPassword" class="input-xlarge" type="password">
							<span class="help-inline" id="passwordMessage" style="display: none;">&nbsp;</span>
						</div>
					</div>					
					<div class="control-group">
						<div class="controls">
							<a class="btn btn-success" href="#" name="cmdLogin" id="cmdLogin"><i class="icon-share-alt icon-black"></i> Login</a>
						</div>
					</div>
				</fieldset>												
			</form>  
		</div>
   	</div>
</div>

<script type="text/javascript">
	$('#cmdLogin').click
	(
		function()
		{
			var formError = 0;
			if($('#userName').val() == ''){
				$('#groupUserName').addClass('error');
				$('#userNameMessage').html('Please type your <b>User Name</b>.');
				$('#userNameMessage').fadeIn('slow');
				formError = 1;
			}	
			
			if($('#userPassword').val() == ''){
				$('#groupPassword').addClass('error');
				$('#passwordMessage').html('Please type your <b>Password</b>.');
				$('#passwordMessage').fadeIn('slow');
				formError = 1;
			}
			
			if(formError == 1){
				$('#messageContent').html('Please correct the errors. Check if you have entered on the required fields.');
				$('#message').addClass('alert-error');
				$('#message').fadeIn('fast');
			} else {
				
				// hide the textbox messages
				$('#userNameMessage').fadeOut('slow');
				$('#passwordMessage').fadeOut('slow');
				
				$.post
				(
					'<?php echo site_url('home/authenticate'); ?>',
					{
						userName: $('#userName').val(),
						userPassword: $('#userPassword').val()
					},
					function(data)
					{
						if(data == 'EXIST'){
							window.location = '<?php echo site_url('home/dashboard'); ?>'
						} else if(data == 'NOT EXIST') {
							$('#messageContent').html('User Name does not exist. Please type again.');
							$('#message').addClass('alert-error');
							$('#message').fadeIn('fast');		
						}		
					}
					
				);
			}	
		}
	);
</script>