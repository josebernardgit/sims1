<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller
{
	
	/**
		UI METHODS
	*/
	
	/**
		@name: index()
		@uses: Default page for User
	*/
	public function index()
	{
		
	}
	
	/**
		@name: editProfile()
		@uses: Edit the user profile via account
	*/
	public function editProfile()
	{
		$this->title = 'SIMS - Edit User Profile';
		
		// Get the User Account information
		$user = new Generalmodel();
		$conditions = array(
			'id' => $this->session->userdata('id')
		);
		$user->tables = 'users';
		$user->conditions = $conditions;
		$user->getrecordinformation();
		$userInfo = $user->result;
		$isExist = $user->numrows;
		
		if($isExist){
			
		} else {
			
		}
		
	}
	
}

?>