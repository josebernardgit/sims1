<?php
  
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
  
  class Generalmodel extends CI_Model
  {
      
        var $tables;
        var $tabledata;    
        var $fields;
        var $conditions;
        var $likeconditions;
        var $groupby;
        var $offset;
        var $numrows;
        var $limit;
        var $result;
        var $totalrecords;
        var $lastinsertid;
        var $orderby;
        var $selecteddata;
        var $fielddb;
        var $jointable;
        var $joincondition;
        var $select;
		var $notin;
		var $notinid;

        
        public function __construct()
        {
          parent::__construct();
        }
        
        /**
         * @name    : attrresetter()
         * @uses    : Use to reset the attributes 
         */ 
        function attrresetter()
        {
            $this->tables = "";
            $this->tabledata = "";        
            $this->fields = "";
            $this->conditions = "";
            $this->likeconditions = "";
            $this->groupby = "";
            $this->offset = "";
            $this->numrows = "";
            $this->result = "";
            $this->totalrecords = "";
            $this->lastinsertid = "";
            $this->orderby = "";
            $this->selecteddata = "";
            $this->fielddb = "";
            $this->jointable = "";
            $this->joincondition = "";
			$this->notin = '';
			$this->notinid = '';
        }

        /**
         *     @name     : checkduplicate()
         *     @uses     : General model for check duplicate entry
         */
        function checkduplicate()
        {
            $this->db->where($this->conditions);
            $result = $this->db->get($this->tables);
            if($result->num_rows() > 0){
                $this->result = 1;
            } else {
                $this->result = 0;
            }
        }

        /**
         *     @name     : save()
         *     @uses     : General model for saving data
         */
        function save()
        {
            $this->result = $this->db->insert($this->tables, $this->tabledata);
            $this->lastinsertid = $this->db->insert_id();
        }

        /**
         *     @name     : gettotaldatarecords()
         *     @uses     : Get the total records
         */
        function gettotaldatarecords()
        {
            if($this->conditions)
                $this->db->where($this->conditions);
                
            if($this->likeconditions)
                $this->db->like($this->likeconditions);
                
            $this->db->from($this->tables);
            $this->totalrecords = $this->db->count_all_results();
            
        }

        /**
         *     @name     : datalist()
         *     @uses     : General model for listing
         */
        function datalist()
        {
            if($this->fields)        
                $this->db->select($this->fields);    
            
            if($this->conditions)
                $this->db->where($this->conditions);
                
            if($this->likeconditions)
                $this->db->like($this->likeconditions);
                
            if($this->orderby)
                $this->db->order_by($this->orderby);
                
            if($this->groupby)
                $this->db->group_by($this->groupby);
                
            if($this->jointable)
                $this->db->join($this->jointable,$this->joincondition);
				
			if($this->notin)
				$this->db->where_not_in($this->notinid, $this->notin);
                
            $result = $this->db->get($this->tables,$this->limit, $this->offset);
            $this->result = $result->result_array();
            $this->numrows = $result->num_rows();
        }

        /**
         *     @name     : getrecordinformation()
         *     @uses     : Get the record information
         */
        function getrecordinformation()
        {
            if($this->fields)
                $this->db->select($this->fields);
                
            if($this->conditions)
                $this->db->where($this->conditions);
                
            if($this->jointable)
                $this->db->join($this->jointable,$this->joincondition);
                
            $result = $this->db->get($this->tables);
            $this->result = $result->result_array();
            $this->numrows = $result->num_rows();
        }

        /**
         *     @name     : update()
         *     @uses     : General model for updating records
         */
        function update()
        {
            $this->db->where($this->conditions);
            $this->result = $this->db->update($this->tables, $this->tabledata);
        }

        /**
         *     @name     : delete()
         *     @uses     : Delete the record
         */
        function delete()
        {
            $this->db->where($this->conditions);
            $this->result = $this->db->delete($this->tables);
        }

        /**
         *  @name   : getrecordsselecteddata()
         *  @uses   : Get the records that belongs to a group or selected data
         */ 
        function getrecordsselecteddata()
        {
            $this->db->where($this->conditions);
            $this->db->where_in("customerid",$this->selecteddata);
            $result = $this->db->get($this->tables);
            $this->result = $result->result_array();
            $this->numrows = $result->num_rows();
        }

        /**
         *  @name   : getrecordnotbelongto()
         *  @uses   : Get the records that are not belong to a particular set of data
         */ 
        function getrecordnotbelongto()
        {
            if($this->conditions)        
                $this->db->where($this->conditions);
                
            if($this->fielddb && $this->selecteddata)
                $this->db->where_not_in($this->fielddb,$this->selecteddata);
                
            if($this->orderby)
                $this->db->orderby($this->orderby);
            
            $result = $this->db->get($this->tables);
            $this->result = $result->result_array();
            $this->numrows = $result->num_rows();
        }
      
  }
  
?>
