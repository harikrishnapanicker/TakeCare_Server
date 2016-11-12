<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tableidgen {

    private $CI;

    function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('key_model');
    }
    /** Clear the old cache (usage optional) **/
    public function no_cache()
    {
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0',false);
        header('Pragma: no-cache');
    }
    //function no_cache ends here

    public function genetareTableID($table_name)
    {
        if($table_name)
        {

            $table_val = $this->CI->key_model->get_tableid($table_name) ;
            //echo $table_val; exit;
          $l=count($table_val);

            if($table_val){

                $id_field = $table_name.'_id' ;

                foreach ($table_val as $tbval) {
                    $idval = $tbval[$id_field];
                    $val=explode("_",$idval);
                    $n=count($val);
                    $intval= $val[$n-1];
                    $recCountArray[] =$intval;
                }
                $maxCount = max($recCountArray);

                $intval= $maxCount+1;
                $new_id = str_rot13($id_field).'_'.$intval  ;


            }
            else{

                /* if(	$table_name == 'tbl_userdata'){

                     $id_field = 'user';
                 }
                 else{
                     $id_field = substr($table_name,4);
                 }*/
                $id_field = $table_name;
                $new_id = str_rot13($id_field.'_id').'_1' ;
            }
            return $new_id ;
        }

    }

    public function get_tableId($table)
    {
        if($table){
         $table_val = $this->CI->key_model->get_tableid_latest($table) ;

        return $table_val;
        }

    }

    public function get_TableId_Batch($table_name)
    {
        $result =array(); 

        $idSet = $this->get_tableId($table_name);

        //print_r($tourandtravel_videos_id) ;

        $field = $table_name.'_id' ;

        $curr_id = $idSet[$field] ;

        $pos = explode( '_', strrev($curr_id) ) ;

        //print_r($pos) ;

        $newid_prefix = str_rot13($table_name.'_id_') ;

       // print_r($newid_prefix) ;  exit(); 

        $result = array ( 'id' => $pos[0] , 'prefix' => $newid_prefix );

        return $result ;
    }


    public function getNextID($tbl)
    {
        if(!empty($tbl)){
            $nextID='';
                  $table = $this->get_tableId($tbl);
                    if(!empty($table)){
                        $table_ID = $table[$tbl.'_id'];
                        $table_str = substr($table_ID,0,strrpos($table_ID,'_')+1);
                    
                        $lastInsertID = isset($table_ID) && $table_ID!=''?$table_ID:$table_str.'0';
                        $nextID  = str_replace($table_str,'',$lastInsertID)+1;
                    }

                    return $nextID;
                }

    }
    public function getTableString($tbl)
    {
        if(!empty($tbl)){
            $table_str='';
                  $table = $this->get_tableId($tbl);
                    if(!empty($table)){
                        $table_ID = $table[$tbl.'_id'];
                        $table_str = substr($table_ID,0,strrpos($table_ID,'_')+1);
                    }
                   

                    return $table_str;
        }
   }
}

/* End of file Someclass.php */