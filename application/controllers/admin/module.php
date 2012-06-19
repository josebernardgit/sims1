<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module extends MY_Controller 
{
	
	
	/**
		UI METHODS
	*/ 
	
	/**
		@name: index()
		@uses: Default page for Module
	*/ 
	public function index()
	{	
		$this->listModules();		
	}
	
	/**
		@name: create()
		@uses: Create a new Module	
	*/ 
	public function create()
	{
		$this->title = 'SIMS - Create Module';
		
		if($this->isAdmin){
			$this->_render('pages/admin/module/create');
		} else {
			redirect(site_url('home/login/admin'));			
		}
	}
	
	/**
		@name: list_module()
		@uses: Display the list of Roles
	*/
	public function list_module()
	{
		$this->title = 'SIMS - List of Modules';
		
		// Get the list of Modules
		$modules = new Generalmodel();
		$modules->tables = 'sims_module';
		$modules->orderby = 'module_name ASC';
		$modules->datalist();
		$modulesList = $modules->result;
		$hasModules = $modules->numrows;
		
		if($hasModules){
			$this->data = $modulesList;
		}
		
		if($this->isAdmin){
			$this->_render('pages/admin/module/list');	
		} else {
			redirect(site_url('home/login/admin'));			
		}	
	}
	
	/**
		@name: edit()
		@uses: Edit the Module information
	*/ 
	public function edit()
	{
		$this->title = 'SIMS - Edit Module';
		
		// Get the Module information
		$module = new Generalmodel();
		$conditions = array(
			'id' => $this->uri->segment(4)
		);		
		$module->tables = 'sims_module';
		$module->conditions = $conditions;
		$module->getrecordinformation();
		$moduleInfo = $module->result;
		$hasInfo = $module->numrows;
		
		if($hasInfo){
			$this->data = $moduleInfo;
		}
		
		if($this->isAdmin){
			$this->_render('pages/admin/module/edit');	
		} else {
			redirect(site_url('home/login/admin'));			
		}		
	}
	
	
	
	/**
		DATABASE METHODS
	*/
	
	/**
		@name: save()
		@uses: Save the Module information to the database
	*/
	public function save()
	{
		$module = new Generalmodel();
		
		// Check if Module exist
		$conditions = array(
			'module_name' => $_POST['moduleName']
		);
		$module->tables = 'sims_module';
		$module->conditions = $conditions;
		$module->getrecordinformation();
		$isExist = $module->numrows;
		
		if($isExist){
			echo 'EXIST';
		} else {
			// Save the Module information
			$tabledata = array(
				'module_name' => $_POST['moduleName'],
				'module_description' => $_POST['moduleDescription']
			);			
			
			$module->tables = 'sims_module';
			$module->tabledata = $tabledata;
			$module->save();
			$isSave = $module->result;
			
			if($isSave){
				
				// Log the operation
				$username = $this->session->userdata("firstname")." ".$this->session->userdata("lastname");
				$time = time();
				$logdate = date("m/d/Y h:i a", $time);
				$activity = "Add ".$_POST["moduleName"]." module";
				$filedata = $username."\t".$logdate."\t".$activity."\tModule\r\n";
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
		@uses: Update the Module information to the database
	*/
	public function update()
	{
		$module = new Generalmodel();
		
		// Check if Module exist
		$conditions = array(
			'module_name ' => $_POST['moduleName'],
			'id !=' => $_POST['moduleId']
		);
		$module->tables = 'sims_module';
		$module->conditions = $conditions;
		$module->getrecordinformation();
		$isExist = $module->numrows;
		
		if($isExist){
			echo 'EXIST';
		} else {
			// Update the Module information
			unset($conditions);
			$tabledata = array(
				'module_name' => $_POST['moduleName'],
				'module_description' => $_POST['moduleDescription']
			);	
			$conditions = array(
				'id' => $_POST['moduleId']
			);		
			
			$module->tables = 'sims_module';
			$module->tabledata = $tabledata;
			$module->conditions = $conditions;
			$module->update();
			$isUpdate = $module->result;
			
			if($isUpdate){
				
				// Log the operation
				$username = $this->session->userdata("firstname")." ".$this->session->userdata("lastname");
				$time = time();
				$logdate = date("m/d/Y h:i a", $time);
				$activity = "Update ".$_POST["moduleName"]." module";
				$filedata = $username."\t".$logdate."\t".$activity."\tModule\r\n";
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
		@uses: Delete the Module
	*/
	public function delete()
	{
		$module = new Generalmodel();
		$conditions = array(
			'id' => $_POST['moduleId']
		);
		$module->tables = 'sims_module';
		$module->conditions = $conditions;
		
		// Get the Module information
		$module->getrecordinformation();
		$moduleInfo = $module->result;
		
		// Delete the Module
		$module->delete();
		$isDelete = $module->result;
		
		if($isDelete){
			// Log the operation
			$username = $this->session->userdata("firstname")." ".$this->session->userdata("lastname");
			$time = time();
			$logdate = date("m/d/Y h:i a", $time);
			$activity = "Delete ".$moduleInfo[0]['module_name']." module";
			$filedata = $username."\t".$logdate."\t".$activity."\tModule\r\n";
			$filename = "logs/".date("mdY")."logs.txt";
			$this->filehandling->filename = $filename;
			$this->filehandling->filedata = $filedata;
			$this->filehandling->writedatafile();
			
			echo 'DELETE';	
		} else {
			echo 'ERROR';			
		}
	}
}

?>