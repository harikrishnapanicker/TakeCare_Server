<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class User_api extends REST_Controller
{
    function __construct()
    {
        // Construct our parent class
        parent::__construct();
        $this->methods['member_get']['limit'] = 500; //500 requests per hour per member/key
        $this->methods['member_post']['limit'] = 100; //100 requests per hour per member/key
        $this->methods['member_delete']['limit'] = 50; //50 requests per hour per member/key
        $this->load->library('Tableidgen');
        $this->config->load("tables", true);
        $this->tables = $this->config->item("tables");
        $this->load->model('User_model','member');
        ob_start();

    }
     /**
     * Get Method: Listing
     */
    function userlistnear_post()
    {
        /*$postarray = array(
            'user_id'=>2,
            'latitude'=>'9.9312',
            'longitude'=>'76.2673'
        );*/
        
        $postarray = array(
            'user_id'=>isset($this->post('user_id'))?addslashes($this->post('user_id')):'',
            'latitude'=>isset($this->post('latitude'))?addslashes($this->post('latitude')):'',
            'longitude'=>isset($this->post('longitude'))?addslashes($this->post('longitude')):''
        );

        $fields='login_history.user_id ,login.name,login_history.latitude, login_history.longitude,SQRT(
    POW(69.1 * (latitude - '.$postarray['latitude'].'), 2) +
    POW(69.1 * (76.2673 - '.$postarray['longitude'].') * COS(latitude / 57.3), 2)) AS distance';
        $having='distance < 25';
        $orderby ='distance';
        $join=array("login"=>"login.id=login_history.user_id");
        $condition =array('status'=>'1','login_history.user_id!='=>$postarray['user_id']);
        $result = $this->member->findAllByJoin($fields,$condition,$join,$having,$orderby);
        if(!empty($result)){
            $message=array("message"=>'Success');
            $result = array('status'=>1, 'result' => $result,'message' => $message);
        }else{
            $message=array("message"=>'Failure');
            $result = array('status'=>0, 'message' => $message);
        }
	$this->response($result);
    }


    /*********************************************End************************************************/
}
