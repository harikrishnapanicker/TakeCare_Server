<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| API: Member Device Model
|--------------------------------------------------------------------------
|
*/
class Member_device_model extends MY_Model
{	
   
    /**
     * @Constructor. Loads initailly when call comes to this Model Class
     */   
    function __construct()
    {

        parent::__construct(); // parent constructor calling
        $this->table = $this->tables['member_device']; // current table for this model
        
    }

    /**
     * Get All Data List
     * returns result array 
     */
    function findAll($fields,$condition){ 
    	if (!empty($condition)) {
    		return $this->db->select($fields)->get_where($this->table,$condition)->result_array();
    	}
    }

    /**
     * Get All Data List BY ID
     * returns row array 
     */
    function findAllById($fields,$condition){
    	if (!empty($condition)) {
    		return $this->db->select($fields)->get_where($this->table,$condition)->result_array();
    	}
    }


    /**
     * Get Data Details By ID
     * returns row array 
     */
    function findById($fields,$condition){
        if (!empty($condition)) {
            return $this->db->select($fields)->get_where($this->table,$condition)->row_array();
        }
    }

    /**
     * Add Post Data
     * returns boolean
     */
    function save($input){
    	if (!empty($input)) { 
    		return $this->db->insert($this->table,$input);
    	}
    }

    /**
     * Batch Insert
     * returns boolean
     */
    function batchInsert($input){
        if (!empty($input)) { 
            return $this->db->insert_batch($this->table, $input);
        }
    }

    /**
     * Update Post Data
     * returns boolean
     */
    function update($condition,$input){ 
        if(!empty($condition)){
        	return $this->db->where($condition)->update($this->table,$input);
        }
    }

    /**
     * Batch Update
     * returns boolean
     */
    function batchUpdate($array,$field){
      if (!empty($array)) { 
         return $this->db->update_batch($this->table, $array, $field);
      }
    }

    /**
     * Delete Data
     * returns boolean
     */
    function delete($condition){
      if(!empty($condition)){
        return $this->db->where($condition)->delete($this->table);
      }
    }

    /**
     * Multiple Delete
     * returns boolean
     */
    function multipleDelete($array,$field){
      if(!empty($array)){
        return $this->db->where_in($field,$array)->delete($this->table);
      }
    }

    /**
     * Field Exists Check 
     * returns integer
     */
    function field_exists($condition)
    {
        return $this->db->where($condition)->count_all_results($this->table);
    }
    
}