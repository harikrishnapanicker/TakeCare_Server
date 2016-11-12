<?php
class Key_Model extends CI_Model{
	function __construct(){
	    parent::__construct();
	}

	function get_rownos($table_name){	
		return $this->db->count_all_results($table_name) > 0;
	}
	
	function id_exists($table_name,$id)
	{
	    $fld_name = $table_name.'_id' ;
	    return $this->db->where($fld_name, $id)->count_all_results($table_name) > 0;
	}
	function get_tableid($table_name){
	    
	   /* if(	$table_name == 'tbl_userdata'){
	        
	        $id_field = 'user';
	    }
	    else{  
	        $id_field = substr($table_name,4);
	    }*/
        $id_field=$table_name;
	    $this->db->select($id_field.'_id');
	    $this->db->from($table_name);
	   $this->db->order_by($id_field.'_created_at','asc');
	    $query=  $this->db->get();
        //echo $this->db->last_query();
	   // return $query->result_array();
	    if ($query->num_rows() > 0){
	
	        return $query->result_array();
	    }
	    else
	    {
	        return 0;
	    }
	}
	function get_tableid_latest($table_name){
	    
	   /* if(	$table_name == 'tbl_userdata'){
	        
	        $id_field = 'user';
	    }
	    else{  
	        $id_field = substr($table_name,4);
	    }*/

	    /*$split_point = '_'; 
	    $string = $table_name.'_id_15'; 
	    $result = array_map('strrev', explode($split_point, strrev($string)));
	    printr($result) ; exit;*/
	    $this->db->select($table_name.'_id');
	    $this->db->from($table_name);
	    
	    $query=  $this->db->get();
	    $result = $query->result_array();
	    if(count($result)>0){
	    	foreach ($result  as $key => $value) {
	    	//$kk[] = explode(str_rot13($table_name.'_id_'),$value[$table_name.'_id'] );
	    	$split_point = '_'; 
	    	$string = $value[$table_name.'_id']; 
	    	$result1[] = array_map('strrev', explode($split_point, strrev($string)));

		    }
		    //printr($result1); exit;
		    foreach ($result1 as $key1 => $value1) {
		    	$kk[]=  $value1[0];
		    }

		    $data[$table_name.'_id'] = str_rot13($table_name.'_id_').max($kk);
	    }else{
	    	$data[$table_name.'_id'] = str_rot13($table_name.'_id_0');
	    }
	    
	    //echo str_rot13($table_name);exit;
	    //printr($data); exit;

	    //$query= $this->db->query('SELECT MAX('.$table_name.'_id) AS `'.$table_name.'_id` FROM '.$table_name);
	   if (count($data) > 0){
	
	        return $data;
	    }
	    else
	    {
	        return 0;
	    }
       /* $id_field=$table_name;
	    $this->db->select($id_field.'_id');
	    $this->db->from($table_name);
	    $this->db->order_by($id_field.'_created_at','desc');
	    $query=  $this->db->get();
        //echo $this->db->last_query();
	   // return $query->result_array();
	    if ($query->num_rows() > 0){
	
	        return $query->row_array();
	    }
	    else
	    {
	        return 0;
	    }*/
	}

}
?>
