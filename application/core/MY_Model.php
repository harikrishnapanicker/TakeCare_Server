<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Admin Login Page: MY Model
|--------------------------------------------------------------------------
|
*/
class MY_model extends CI_Model
{   

    public $tables;
   
    /**
     * @Constructor. Loads initailly when call comes to this Model Class
     */   
    function __construct()
    {
        parent::__construct(); // parent constructor calling
        $this->config->load("tables", true);  
        $this->tables = $this->config->item("tables");
             
    }




}