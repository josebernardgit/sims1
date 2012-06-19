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
	    <li><a href="<?php echo site_url('admin/module/create'); ?>">Create Module</a></li>
	    <li class="active"><a href="<?php echo current_url(); ?>">List of Modules</a></li>
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
		    <h3>Delete Module</h3>
		</div>
		<div class="modal-body">
		    <p>Proceed in deleting the Module Information from the database?</p>
		    </div>
		    <div class="modal-footer">
		    <a href="#" class="btn btn-success" id="cmdYes"><i class="icon-ok icon-white"></i> Yes</a>
		    <a href="#" class="btn btn-danger" data-dismiss="modal"><i class="icon-remove icon-white"></i> No</a>
	    </div>
    </div>
  
  	<div class="row">	
         <div class="span12">
		 	<input type="hidden" name="moduleId" id="moduleId" value=""/>
			<legend>List of Modules</legend>
			<?php
				if($myData){
			?>
					<table class="table table-bordered">
						<tr>
							<th>Module Name</th>
							<th>Module Description</th>
							<th>&nbsp;</th>
						</tr>
						<?php
							foreach($myData as $indexmyData){
						?>
								<tr>
									<td><?php echo $indexmyData['module_name']; ?></td>
									<td><?php echo $indexmyData['module_description']; ?></td>
									<td>
										<a href="<?php echo site_url('admin/module/edit/' . $indexmyData['id']); ?>" class="btn btn-warning"><i class="icon-pencil icon-white"></i> Edit</a>
										<a href="#" class="btn btn-warning" data-toggle="modal" onclick="deleteModule('<?php echo $indexmyData['id']; ?>')"><i class="icon-trash icon-white"></i> Delete</a>
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
	function deleteModule(moduleId)
	{
		$('#moduleId').val(moduleId);
		$('#myModal').modal('show');
	}
	
	$('#cmdYes').click
	(
		function()
		{
			$('#myModal').modal('hide');
			$.post
			(
				'<?php echo site_url('admin/module/delete'); ?>',
				{
					moduleId: $('#moduleId').val()
				},
				function(data)
				{
					if(data == 'DELETE'){
						$('#messageContent').html('Module Information successfully deleted from the database.');
						$('#message').addClass('alert-success');
						$('#message').fadeIn('slow');	
						setTimeout('hideMessage()', 3000);	
					} else if(data == 'ERROR'){
						$('#messageContent').html('There was an error found in deleting the Module Information.');
						$('#message').addClass('alert-error');
						$('#message').fadeIn('slow');		
					}
				}
			);
		}
	)
</script>