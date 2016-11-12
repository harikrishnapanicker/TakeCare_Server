<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| API: Authentication Model
|--------------------------------------------------------------------------
|
*/
class Authentication_Model extends MY_Model{
	 /**
     * @Constructor. Loads initailly when call comes to this Model Class
     */   
    function __construct()
    {

        parent::__construct(); // parent constructor calling
        $this->table = 'login'; // current table for this model
        
    }
    /**
     * Field Exists Check 
     * returns integer
     */
    function field_exists($condition)
    {
        return $this->db->where($condition)->count_all_results($this->table);
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
     * Update Post Data
     * returns boolean
     */
    function update($condition,$input){ 
        if(!empty($condition)){
        	return $this->db->where($condition)->update($this->table,$input);
        }
    }
}
?>
