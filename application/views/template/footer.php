<footer id="footer" class="container">
	<div class="row">
		<div class="span12">
			<p><b>Sunpride Information Management System &copy; <?php echo date('Y'); ?></b></p>
			<p>Version 3.0</p>
			<p>All Rights Reserved</p>
		</div>
	</div>
</footer>

<script type="text/javascript">
	function hideMessage()
	{
		$('#message').fadeOut('slow');	
		
		<?php
			if($this->uri->segment(3) == 'edit'){
		?>
				window.location = '<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/list_'.$this->uri->segment(2)); ?>'
		<?php
			} else {
		?>
				window.location = '<?php echo current_url(); ?>';
		<?php
			}
		?>
	}
</script>