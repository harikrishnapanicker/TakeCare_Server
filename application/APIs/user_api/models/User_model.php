<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| API: Memeber Model
|--------------------------------------------------------------------------
|
*/
class User_model extends MY_Model
{	
   
    /**
     * @Constructor. Loads initailly when call comes to this Model Class
     */   
    function __construct()
    {

        parent::__construct(); // parent constructor calling
        $this->table = 'login'; // current table for this model
        $this->tableJoin = 'login_history';
        
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
    
    public function findAllByJoin($fields,$condition=null,$join=null,$having=null,$orderby=null) {
        if($fields) {
            $this->db->select($fields);
        }else{
            $this->db->select('*');
        }        
        $this->db->from($this->tableJoin);
        if($join){
            foreach($join as $key=>$val)
            {
                $this->db->join($key,$val);
            }
        }
        $this->db->where($condition);
        if($having){
            $this->db->having($having);
        }
        if($orderby){
            $this->db->order_by($orderby);
        }
        
        $query = $this->db->get();
        return $query->result_array();
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
        else {
            return 0 ;
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