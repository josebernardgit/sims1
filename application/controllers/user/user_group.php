<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_group extends MY_Controller
{
	
	
	
	/**
		UI METHODS
	*/
	
	/**
		@name: index()
		@uses: Default page for User Group
	*/
	public function index()
	{
		$this->list_user_group();	
	}
	
	/**
		@name: list_user_group()
		@uses: Display the list of User Group
	*/
	public function list_user_group()
	{
		$this->title = 'SIMS - List of User Group';
		
		// Get the list of User Group
		$userGroup = new Generalmodel();
		$userGroup->tables = 'sims_user_group';
		$userGroup->orderby = 'group_name ASC';
		$userGroup->datalist();
		$userGroupList = $userGroup->result;
		$haUserGroup = $userGroup->numrows;
		
		if($haUserGroup){
			$this->data = $userGroupList;
		}
		
		if($this->isAdmin){
			$this->_render('pages/user/user_group/list');	
		} else {
			redirect(site_url('home/login/admin'));			
		}		
	}
	
	/**
		@name: create()
		@uses: Create new User Group
	*/
	public function create()
	{
		$this->title = 'SIMS - Create User Group';
		
		if($this->isAdmin){
			$this->_render('pages/user/user_group/create');	
		} else {
			redirect(site_url('home/login/admin'));			
		}
	}
	
	/**
		@name: edit()
		@uses: Edit the User Group
	*/ 
	public function edit()
	{
		$this->title = 'SIMS - Edit User Group';
		
		// Get the User Group Information
		$userGroup = new Generalmodel();
		$conditions = array(
			'id' => $this->uri->segment(4)
		);
		$userGroup->tables = 'sims_user_group';
		$userGroup->conditions = $conditions;
		$userGroup->getrecordinformation();
		$userGroupInfo = $userGroup->result;
		$hasUserGroup = $userGroup->numrows;
		
		if($hasUserGroup){
			$this->data = $userGroupInfo;
		}
		
		if($this->isAdmin){
			$this->_render('pages/user/user_group/edit');	
		} else {
			redirect(site_url('home/login/admin'));			
		}	
	}
	
	
	
	
	
	
	
	/**
		DATABASE METHODS
	*/
	
	/**
		@name: save()
		@uses: Save the User Group information to the database
	*/
	public function save()
	{
		$userGroup = new Generalmodel();
		
		// Check if User Group exist
		$conditions = array(
			'group_name' => $_POST['userGroup']
		);
		$userGroup->tables = 'sims_user_group';
		$userGroup->conditions = $conditions;
		$userGroup->getrecordinformation();
		$isExist = $userGroup->numrows;
		
		if($isExist){
			echo 'EXIST';
		} else {
			// Save the User Group information
			$tabledata = array(
				'group_name' => $_POST['userGroup'],
				'group_description' => $_POST['userGroupDescription']
			);			
			
			$userGroup->tables = 'sims_user_group';
			$userGroup->tabledata = $tabledata;
			$userGroup->save();
			$isSave = $userGroup->result;
			
			if($isSave){
				
				// Log the operation
				$username = $this->session->userdata("firstname")." ".$this->session->userdata("lastname");
				$time = time();
				$logdate = date("m/d/Y h:i a", $time);
				$activity = "Add ".$_POST["userGroup"]." User Group";
				$filedata = $username."\t".$logdate."\t".$activity."\tUser Group\r\n";
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
		@uses: Update the User Group information to the database
	*/
	public function update()
	{
		$userGroup = new Generalmodel();
		
		// Check if User Group exist
		$conditions = array(
			'id !=' 		=> $_POST['userGroupId'],
			'group_name' 	=> $_POST['userGroup']
		);
		$userGroup->tables = 'sims_user_group';
		$userGroup->conditions = $conditions;
		$userGroup->getrecordinformation();
		$isExist = $userGroup->numrows;
		
		if($isExist){
			echo 'EXIST';
		} else {
			// Save the User Group information
			unset($conditions);
			$conditions = array(
				'id' => $_POST['userGroupId']
			);
			$tabledata = array(
				'group_name' => $_POST['userGroup'],
				'group_description' => $_POST['userGroupDescription']
			);			
			
			$userGroup->tables = 'sims_user_group';
			$userGroup->tabledata = $tabledata;
			$userGroup->conditions = $conditions;
			$userGroup->update();
			$isUpdate = $userGroup->result;
			
			if($isUpdate){
				
				// Log the operation
				$username = $this->session->userdata("firstname")." ".$this->session->userdata("lastname");
				$time = time();
				$logdate = date("m/d/Y h:i a", $time);
				$activity = "Update ".$_POST["userGroup"]." User Group";
				$filedata = $username."\t".$logdate."\t".$activity."\tUser Group\r\n";
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
		@uses: Delete the User Group from the database
	*/
	public function delete()
	{
		$userGroup = new Generalmodel();
		$conditions = array(
			'id' => $_POST['userGroupId']
		);
		$userGroup->tables = 'sims_user_group';
		$userGroup->conditions = $conditions;
		$userGroup->delete();
		$isDelete = $userGroup->result;
		
		if($isDelete){
			// Log the operation
			$username = $this->session->userdata("firstname")." ".$this->session->userdata("lastname");
			$time = time();
			$logdate = date("m/d/Y h:i a", $time);
			$activity = "Delete ".$_POST['userGroupName']." User Group";
			$filedata = $username."\t".$logdate."\t".$activity."\tUser Group\r\n";
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