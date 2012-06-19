<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
</a>
<a class="brand" href="<?php echo current_url(); ?>"><span style="font-weight: bold; color: #ff0000;">Sunpride</span> Foods</a>

<?php
	if($this->session->userdata('id')){
?>
		<div class="nav-collapse collapse">
			<ul class="nav">
				<li class="dropdown" id="user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-user icon-white"></i> <?php echo $this->session->userdata('firstname'); ?><b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('user/user/myRoles') ?>"><i class="icon-film icon-black"></i> My Roles</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo site_url('user/user/editProfile') ?>"><i class="icon-th-large icon-black"></i> Edit Profile</a></li>
						<li><a href="#" id="changePassword"><i class="icon-road icon-black"></i> Change Password</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo site_url('home/logout') ?>"><i class="icon-off icon-black"></i> Log Out</a></li>
					</ul>
				</li>
				<li class="active">
					<a href="/app/index.html"><i class="icon-th icon-white"></i> Dashboard</a>
				</li>
				<li class="dropdown" id="product-menu">
					<a href="/app/tasks.html" class="dropdown-toggle" data-toggle="dropdown" href="#task-menu">
						<i class="icon-barcode icon-white"></i> Products<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="/app/view-task.html?id=1"><i class="icon-barcode icon-black"></i> Products</a></li>
						<li><a href="/app/view-task.html?id=1"><i class="icon-barcode icon-black"></i> Depot Products</a></li>
						<li class="divider"></li>
						<li><a href="/app/view-task.html?id=2"><i class="icon-list-alt icon-black"></i> Depot Price Memo</a></li>
						<li><a href="/app/view-task.html?id=2"><i class="icon-list-alt icon-black"></i> Customer Price Memo</a></li>
						<li><a href="/app/view-task.html?id=2"><i class="icon-list-alt icon-black"></i> Price Survey</a></li>
						<li class="divider"></li>
						<li><a href="/app/view-tasks.html"><i class="icon-th icon-black"></i> Category</a></li>
						<li><a href="/app/view-tasks.html"><i class="icon-th icon-black"></i> Brandname</a></li>
						<li><a href="/app/view-tasks.html"><i class="icon-th icon-black"></i> Type</a></li>
						<li><a href="/app/view-tasks.html"><i class="icon-th icon-black"></i> Unit Msr</a></li>
					</ul>
				</li>
				<li class="dropdown" id="customer-menu">
					<a href="/app/tasks.html" class="dropdown-toggle" data-toggle="dropdown" href="#task-menu">
						<i class="icon-eye-open icon-white"></i> Customer<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="/app/view-task.html?id=1"><i class="icon-barcode icon-black"></i> Customer</a></li>
						<li><a href="/app/view-task.html?id=1"><i class="icon-barcode icon-black"></i> Customer Order Specs</a></li>
						<li><a href="/app/view-task.html?id=1"><i class="icon-barcode icon-black"></i> Customer Price List</a></li>
						<li class="divider"></li>
						<li><a href="/app/view-task.html?id=2"><i class="icon-list-alt icon-black"></i> Terms</a></li>
						<li><a href="/app/view-task.html?id=2"><i class="icon-list-alt icon-black"></i> Customer Price Memo</a></li>
						<li><a href="/app/view-task.html?id=2"><i class="icon-list-alt icon-black"></i> Price Survey</a></li>
						<li class="divider"></li>
						<li><a href="/app/view-tasks.html"><i class="icon-th icon-black"></i> Category</a></li>
						<li><a href="/app/view-tasks.html"><i class="icon-th icon-black"></i> Brandname</a></li>
						<li><a href="/app/view-tasks.html"><i class="icon-th icon-black"></i> Type</a></li>
						<li><a href="/app/view-tasks.html"><i class="icon-th icon-black"></i> Unit Msr</a></li>
					</ul>
				</li>
				<li class="">
					<a href="/reports/"><i class="icon-signal icon-white"></i> Reports</a>
				</li>
				<li class="">
					<a href="/app/training.html"><i class="icon-question-sign icon-white"></i> Training</a>
				</li>
				<li class="">
					<a href="/app/calendar.html"><i class="icon-time icon-white"></i> Calendar</a>
				</li>
				<li class="dropdown" id="admin-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" href="#admin-menu">
						<i class="icon-user icon-white"></i> Admin<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?php ?>"><i class="icon-user icon-black"></i> User</a></li>
						<li><a href="<?php echo site_url('user/user_group/list_user_group'); ?>"><i class="icon-user icon-black"></i> User Group</a></li>
						<li><a href="<?php echo site_url('user/user/my_roles'); ?>"><i class="icon-user icon-black"></i> User Roles</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo site_url('admin/module/list_module'); ?>"><i class="icon-list icon-black"></i> Modules</a></li>
						<li><a href="<?php echo site_url('admin/roles/list_roles'); ?>"><i class="icon-list-alt icon-black"></i> Roles</a></li>
						<li class="divider"></li>
						<li><a href="/app/view-task.html?id=2"><i class="icon-list icon-black"></i> System Logs</a></li>
					</ul>
				</li>
			</ul>
		</div>
<?php
	}
?>