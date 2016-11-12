<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Admin Module : Custom Core Controller
|--------------------------------------------------------------------------
|created at : 10 November 2015
|
*/

class MY_Controller extends MX_Controller {

    // Initilaize when call comes to this class
    function __construct()
    {             
        parent::__construct(); // parent constructor calling

        $this->load->library('admin'); 
        if ($this->admin->is_logged_in()) {
            $this->load->library('breadcrumb');
            $this->load->library('Tableidgen'); 
            $this->load->library('image_uploads'); 
            $this->load->library('Import_export'); 
            $this->load->model('authentication/Login','login'); 
            //$this->getAccesRolePermission(); 
            $this->config->load("tables", true);  
            $this->tables = $this->config->item("tables");
           
        }else{
            $this->admin->logout();
        }
    }

    final protected function _access_denied()
    {
        show_error("Oops! You don't have any permission to access this page.", 500, 'Access Denied!');
    }
	
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */