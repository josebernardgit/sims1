<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Filehandling
{
	var $filename; // the text file for the logs
	var $filedata;
	
	var $result;
	
	/**
	 * 	writefile()
	 * 	Write data to the file
	 */
	function writedatafile()
	{
		// Check if filename exist
		$this->fileexist();
		if($this->result == 1){
			// File is exist
			// Set file to writeable
			//$this->filewriteable();
			// Write data to the file
			$filehandle = fopen($this->filename, "a");
			fwrite($filehandle, $this->filedata);
			fclose($filehandle);
		} else {
			// File does not exist
			// Create the file
			$this->createfile();
		}
	}
	
	/**
	 * 	getlogdate()
	 * 	Get the log date
	 */
	function getlogdate()
	{
		$fcontents = file($this->filename);
		for($i=0; $i<sizeof($fcontents); $i++) { 
		    $line = trim($fcontents[$i]); 
		    $arr = explode("\t", $line); 
		    // if your data is comma separated
		    // instead of tab separated, 
		    // change the '\t' above to ',' 
            
            $total_arr = count($arr);
            
		    $log_data[$i]["username"] = $arr[0];
		    $log_data[$i]["logdate"] = $arr[1];
		    $log_data[$i]["activity"] = $arr[2];
            
            if($total_arr == 4){
                $log_data[$i]["module"] = $arr[3];    
            } else {
                $log_data[$i]["module"] = '';
            }
            
		    
		}
		
		$this->result = $log_data;
	}
	
	/**
	 * 	fileexist()
	 * 	Check if file is exist
	 */
	function fileexist()
	{
		if(file_exists($this->filename)){
			$this->result = 1;
		} else {
			$this->result = 0;
		}
	}
	
	/**
	 * 	createfile()
	 * 	Create a file
	 */
	function createfile()
	{
		$createfile = fopen($this->filename, "a");
		fwrite($createfile, $this->filedata);
		fclose($createfile);
	}
	
	/**
	 * 	filewriteable()
	 * 	Set the file to writeable
	 */
	function filewriteable()
	{
		chmod($this->filename, 0777);
	}
}


?>