<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roles extends MY_Controller {
	
	protected $userList;
	protected $roleId;
	protected $currentUrl;
	
	/**
		UI METHODS
	*/ 
	
	/**
		@name: index()
		@uses: Default page for Roles
	*/ 
	public function index()
	{	
		$this->list_roles();		
	}
	
	/**
		@name: create()
		@uses: Create a new Role	
	*/ 
	public function create()
	{
		$this->title = 'SIMS - Create Role';
		
		// Get the Module
		$module = new Generalmodel();
		$module->tables = 'sims_module';
		$module->orderby = 'module_name ASC';
		$module->datalist();
		$moduleList = $module->result;
		$hasModules = $module->numrows;
		
		if($hasModules){
			$this->module = $moduleList;
		}
		
		if($this->isAdmin){
			$this->_render('pages/admin/roles/create');
		} else {
			redirect(site_url('home/login/admin'));			
		}
	}
	
	/**
		@name: listRoles()
		@uses: Display the list of Roles
	*/
	public function list_roles()
	{
		$this->title = 'SIMS - List of Roles';
		
		// Get the Roles
		$roles = new Generalmodel();
		$roles->tables = 'sims_roles';
		$roles->fields = 'sims_roles.*, sims_module.module_name';
		$roles->jointable = 'sims_module';
		$roles->joincondition = 'sims_module.id = sims_roles.module';
		$roles->orderby = 'module_name, role_name ASC';
		$roles->datalist();
		$rolesList = $roles->result;
		$hasRoles = $roles->numrows;
		
		if($hasRoles){
			$this->data = $rolesList;
		}
		
		if($this->isAdmin){
			$this->_render('pages/admin/roles/list');
		} else {
			redirect(site_url('home/login/admin'));			
		}
	}
	
	/**
		@name: edit()
		@uses: Edit the Role information
	*/ 
	public function edit()
	{
		$this->title = 'SIMS - Edit Role';
		
		// Get the Module
		$module = new Generalmodel();
		$module->tables = 'sims_module';
		$module->orderby = 'module_name ASC';
		$module->datalist();
		$moduleList = $module->result;
		$hasModules = $module->numrows;
		
		if($hasModules){
			$this->module = $moduleList;
		}
		
		// Get the Role Information
		$role = new Generalmodel();
		$conditions = array(
			'id' => $this->uri->segment(4)
		);
		$role->tables = 'sims_roles';
		$role->conditions = $conditions;
		$role->getrecordinformation();
		$roleInfo = $role->result;
		$hasRole = $role->numrows;
		
		if($hasRole){
			$this->data = $roleInfo;
		}
		
		if($this->isAdmin){
			$this->_render('pages/admin/roles/edit');
		} else {
			redirect(site_url('home/login/admin'));			
		}		
	}
	
	/**
		@name: add_users()
		@uses: Add users to the role selected
	*/ 
	public function add_users()
	{
		$users = new Generalmodel();
		$this->roleId = $_POST['roleId'];
		$this->currentUrl = $_POST['currentUrl'];
		
		// Get all the Users that has the role selected
		$conditions = array(
			'roleid' => $_POST['roleId']
		);
		$users->tables = 'sims_user_role';
		$users->conditions = $conditions;
		$users->datalist();
		$userList = $users->result;
		$hasUsers = $users->numrows;
		
		if($hasUsers){
			// Get the Users that does not have the role selected
			$usersNotIn = array();
			foreach($userList as $indexUserList){
				$usersNotIn[] = $indexUserList['userid'];
			}
			$users->attrresetter();	
			unset($conditions);
			$conditions = array(
				'status' => 'Active'
			);
			$users->tables = 'users';
			$users->fields = 'id, last_name, first_name';
			$users->notinid = 'id';
			$users->notin = $usersNotIn;
			$users->orderby = 'last_name, first_name ASC';
			$users->conditions = $conditions;
			$users->datalist();
			$addUsers = $users->result;
			$hasAddUsers = $users->numrows;
			
			if($hasAddUsers){
				$this->userList = $addUsers;
				$this->displayAddUsers();
			}
		} else {
			// Get all Users			
			$users->attrresetter();
			unset($conditions);
			$conditions = array(
				'status' => 'Active'
			);
			$users->tables = 'users';
			$users->fields = 'id, last_name, first_name';
			$users->orderby = 'last_name, first_name ASC';
			$users->conditions = $conditions;
			$users->datalist();
			$addUsers = $users->result;
			$hasAddUsers = $users->numrows;	
			
			if($hasAddUsers){
				$this->userList = $addUsers;
				$this->displayAddUsers();
			}
		}
	}
	
	/**
		@name: remove_users()
		@uses: Remove the Users from the Role selected
	*/ 
	public function remove_users()
	{
		$users = new Generalmodel();
		$this->roleId = $_POST['roleId'];
		$this->currentUrl = $_POST['currentUrl'];
		
		// Get all the Users that has the role selected
		$conditions = array(
			'roleid' => $_POST['roleId']
		);
		$users->tables = 'sims_user_role';
		$users->fields = 'userid, last_name, first_name';
		$users->jointable = 'users';
		$users->joincondition = 'users.id = sims_user_role.userid';
		$users->fields = 'id, last_name, first_name';
		$users->conditions = $conditions;
		$users->datalist();
		$userList = $users->result;
		$hasUsers = $users->numrows;
		
		if($hasUsers){
			$this->userList = $userList;
			$this->displayDeleteUsers();
		}	
	}
	
	/**
		@name: displayAddUsers()
		@uses: Display the Users for Add
	*/ 
	
	public function displayAddUsers()
	{
		$usersList = $this->userList;
		echo '<input type="hidden" name="roleIdUser" id="roleIdUser" value="'. $this->roleId .'"/>';
		echo '<input type="hidden" name="currentUrlUser" id="currentUrlUser" value="'. $this->currentUrl .'"/>';
		echo '
			<table class="table table-bordered">
				<tr>
					<th>&nbsp;</th>
					<th>User</th>
				</tr>
		';
			foreach($usersList as $indexUsersList){
				echo '<tr>';
					echo '<td><input type="checkbox" name="addNewUsers[]" id="addNewUsers[]" value="'.$indexUsersList['id'].'"/></td>';
					echo '<td>'. $indexUsersList['last_name'] .', '. $indexUsersList['first_name'] .'</td>';
				echo '</tr>';
			}
		echo '</table>';
	}
	
	/**
		@name: displayDeleteUsers()
		@uses: Display the Users for Delete
	*/ 
	
	public function displayDeleteUsers()
	{
		$usersList = $this->userList;
		echo '<input type="hidden" name="roleIdDeleteUser" id="roleIdDeleteUser" value="'. $this->roleId .'"/>';
		echo '<input type="hidden" name="currentUrlDeleteUser" id="currentUrlDeleteUser" value="'. $this->currentUrl .'"/>';
		echo '
			<table class="table table-bordered">
				<tr>
					<th>&nbsp;</th>
					<th>User</th>
				</tr>
		';
			foreach($usersList as $indexUsersList){
				echo '<tr>';
					echo '<td><input type="checkbox" name="removeNewUsers[]" id="removeNewUsers[]" value="'.$indexUsersList['id'].'"/></td>';
					echo '<td>'. $indexUsersList['last_name'] .', '. $indexUsersList['first_name'] .'</td>';
				echo '</tr>';
			}
		echo '</table>';
	}
	
	
	
	
	
	/**
		DATABASE METHODS	
	*/ 
	
	
	
	/**
		@name: save()
		@uses: Save the Role Information
	*/
	public function save()
	{
		$role = new Generalmodel();
		
		// Check if Module exist
		$conditions = array(
			'module' => $_POST['module'],
			'role_name' => $_POST['roleName']
		);
		$role->tables = 'sims_roles';
		$role->conditions = $conditions;
		$role->getrecordinformation();
		$isExist = $role->numrows;
		
		if($isExist){
			echo 'EXIST';
		} else {
			// Save the Role information
			$tabledata = array(
				'module' => $_POST['module'],
				'role_name' => $_POST['roleName'],
				'role_description' => $_POST['roleDescription']
			);			
			
			$role->tables = 'sims_roles';
			$role->tabledata = $tabledata;
			$role->save();
			$isSave = $role->result;
			
			if($isSave){
				
				// Log the operation
				$username = $this->session->userdata("firstname")." ".$this->session->userdata("lastname");
				$time = time();
				$logdate = date("m/d/Y h:i a", $time);
				$activity = "Add ".$_POST["roleName"]." role";
				$filedata = $username."\t".$logdate."\t".$activity."\tRoles\r\n";
				$filename = "logs/".date("mdY")."logs.txt";
				$this->filehandling->filename = $filename;
				$this->filehandling->filedata = $filedata;
				$this->filehandling->writedatafile();
				
				echo 'SAVE';
				
			} else {
				echo 'ERROR';
			}
		}
	}
	
	
	/**
		@name: update()
		@uses: Update the Role Information
	*/
	public function update()
	{
		$role = new Generalmodel();
		
		// Check if Module exist
		$conditions = array(
			'id !=' 	=> $_POST['roleId'],
			'module' 	=> $_POST['module'],
			'role_name' => $_POST['roleName']
		);
		$role->tables = 'sims_roles';
		$role->conditions = $conditions;
		$role->getrecordinformation();
		$isExist = $role->numrows;
		
		if($isExist){
			echo 'EXIST';
		} else {
			// Update the Role information
			unset($conditions);
			$tabledata = array(
				'module' => $_POST['module'],
				'role_name' => $_POST['roleName'],
				'role_description' => $_POST['roleDescription']
			);			
			$conditions = array(
				'id' => $_POST['roleId']			
			);
			
			$role->tables = 'sims_roles';
			$role->tabledata = $tabledata;
			$role->conditions = $conditions;
			$role->update();
			$isUpdate = $role->result;
			
			if($isUpdate){
				
				// Log the operation
				$username = $this->session->userdata("firstname")." ".$this->session->userdata("lastname");
				$time = time();
				$logdate = date("m/d/Y h:i a", $time);
				$activity = "Update ".$_POST["roleName"]." role";
				$filedata = $username."\t".$logdate."\t".$activity."\tRoles\r\n";
				$filename = "logs/".date("mdY")."logs.txt";
				$this->filehandling->filename = $filename;
				$this->filehandling->filedata = $filedata;
				$this->filehandling->writedatafile();
				
				echo 'SAVE';
				
			} else {
				echo 'ERROR';
			}
		}
	}
	
	/**
		@name: delete()
		@uses: Delete the Role Information
	*/
	public function delete()
	{
		$role = new Generalmodel();
		$conditions = array(
			'id ' 	=> $_POST['roleId'],
		);
		$role->tables = 'sims_roles';
		$role->conditions = $conditions;
				
		// Get the Role information
		$role->getrecordinformation();
		$roleInfo = $role->result;
		
		// Delete the Role
		$role->delete();
		$isDeleted = $role->result;
		
		if($isDeleted){
			// Log the operation
			$username = $this->session->userdata("firstname")." ".$this->session->userdata("lastname");
			$time = time();
			$logdate = date("m/d/Y h:i a", $time);
			$activity = "Delete ".$roleInfo[0]["role_name"]." role";
			$filedata = $username."\t".$logdate."\t".$activity."\tRoles\r\n";
			$filename = "logs/".date("mdY")."logs.txt";
			$this->filehandling->filename = $filename;
			$this->filehandling->filedata = $filedata;
			$this->filehandling->writedatafile();	
		
			echo 'DELETE';
		} else {
			echo 'ERROR';
		}
	}
	
	/**
		@name: save_users()
		@uses: Save users to the role selected
	*/
	public function save_users()
	{
		$users = new Generalmodel();
		$usersList = $this->input->post('addNewUsers');
		$roleId = $this->input->post('roleIdUser');
		
		if($usersList){
			foreach($usersList as $indexUsersList => $value){
				$tabledata = array(
					'userid' => $value,
					'roleid' => $roleId
				);
				$users->tables = 'sims_user_role';
				$users->tabledata = $tabledata;
				$users->save();
			}
			redirect($this->input->post('currentUrlUser'));
		}		
	}
	
	/**
		@name: delete_users()
		@uses: Delete the users based on the role selected
	*/
	public function delete_users()
	{
		$users = new Generalmodel();
		$usersList = $this->input->post('removeNewUsers');
		$roleId = $this->input->post('roleIdDeleteUser');
			
		if($usersList){
			foreach($usersList as $indexUsersList => $value){
				$conditions = array(
					'userid' => $value,
					'roleid' => $roleId
				);
				$users->tables = 'sims_user_role';
				$users->conditions = $conditions;
				$users->delete();
			}
			redirect($this->input->post('currentUrlDeleteUser'));
		}
	}
	
}

?>