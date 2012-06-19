<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller 
{

	/**
		UI METHODS
	*/	
	
	/**
		@name: index()
		@uses: Default page for Home
	*/
	public function index()
	{
		$this->login();		
	}
	
	/**
		@name: login()
		@uses: Page for login
	*/
	public function login()
	{
		// Empty the current session
		$newdata = array(
			'id' 		=> '',
		   	'username'  => '',
		   	'firstname' => '',
		   	'lastname' => '',
		   	'group' 	=> '',
		   	'is_admin' 	=> '',
		);
		$this->session->set_userdata($newdata);
		
		$this->title = 'SIMS - Login';
		$this->keywords = '';
		$this->_render('pages/home/login');
	}
	
	
	/**
		@name: dashboard()
		@uses: Dashboard for Home
	*/ 
	public function dashboard()
	{
		if($this->isLogin){
			$this->title = 'SIMS - Dashboard';
			$this->_render('pages/home/dashboard');	
		} else {
			redirect(site_url('home'));
		}
	}
	
	/**
		@name: logout()
		@uses: Logout on the system
	*/ 
	public function logout()
	{
		redirect(site_url('home'));
	}
	
	
	
	
	/**
		DATABASE METHODS	
	*/ 
	
	/**
		@name: authenticate()
		@uses: Authenticate user login information
	*/
	public function authenticate()
	{
		$authenticate = new Generalmodel();
		$conditions = array(
			'user_name' => $_POST['userName'],
			'user_hash' => md5($_POST['userPassword'])
		);
		$authenticate->tables = 'users';
		$authenticate->conditions = $conditions;
		$authenticate->getrecordinformation();
		$userInfo = $authenticate->result;
		$isExist = $authenticate->numrows;
		
		if($isExist){
			// Store to the session
			$newdata = array(
				'id' 		=> $userInfo[0]['id'],
			   	'username'  => $userInfo[0]['user_name'],
			   	'firstname' => $userInfo[0]['first_name'],
			   	'lastname' => $userInfo[0]['last_name'],
			   	'group' 	=> $userInfo[0]['posId'],
			   	'is_admin' 	=> $userInfo[0]['is_admin']
			);
			
			$this->session->set_userdata($newdata);
			
			// Log the operation
			$username = $this->session->userdata("firstname")." ".$this->session->userdata("lastname");
			$time = time();
			$logdate = date("m/d/Y h:i a", $time);
			$activity = "User Login";
			$filedata = $username."\t".$logdate."\t".$activity."\tLogin\r\n";
			$filename = "logs/".date("mdY")."logs.txt";
			$this->filehandling->filename = $filename;
			$this->filehandling->filedata = $filedata;
			$this->filehandling->writedatafile();
			
			echo 'EXIST';
		} else {
			echo 'NOT EXIST';
		}
	}
		
}