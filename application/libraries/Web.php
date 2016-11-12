<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Library Files: Web  Library
|--------------------------------------------------------------------------
|
*/
class Web{

    // Initilaize when call comes to this class
    function  __construct()
    {
    	$this->CI = &get_instance();		    			
    }


	
	/**
     * Loading Layout view
     */
	function load_view($cont,$title=''){ 
        $settings = getSiteSettings();
        $this->CI->load->view('../common/layout',array('content'=>$cont,'title' => $title,'settings'=>$settings));
	}

    
	
	 
}

/* End of file library Web.php */
/* Location: ./application/libraries/Web.php */
