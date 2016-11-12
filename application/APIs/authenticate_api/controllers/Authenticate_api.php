<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authenticate_api extends MX_Controller {

    protected $methods = array(
        'add_tokenkey' => array('level' => 10, 'limit' => 10),
        'delete_tokenkey' => array('level' => 10),
        'setlevel' => array('level' => 10),
        'renew_key' => array('level' => 10),
    );

    /**
     * Constructor     */

    public function __construct()
    {
       parent::__construct();
       $this->load->model('authentication_model','auth');
       $this->load->library('curl');
       $this->load->library('tableidgen');

        ob_start();
    }

    /**
     * Registration 
     */
    public function register()
    {       
            $entry_data = array();
            $entry_data = get_object_vars( json_decode(@file_get_contents("php://input")) );
            $otp = $this->randomNumber(4);
            $entry_data =  array(
                
                'name' => isset($entry_data['name'])?addslashes($entry_data['name']):'hari',
                'number' => isset($entry_data['number'])?addslashes($entry_data['number']):'8129667466',
                'type' => isset($entry_data['type'])?addslashes($entry_data['type']):'user',
                'gender' => isset($entry_data['gender'])?addslashes($entry_data['gender']):'male',
                'pid' => isset($entry_data['pid'])?addslashes($entry_data['pid']):'',
                'vnumber' => isset($entry_data['vnumber'])?addslashes($entry_data['vnumber']):'',
                'date' => isset($entry_data['date'])?addslashes($entry_data['date']):date('Y-m-d H:i:s'),
            );
                      
            $insert = $this->auth->save($entry_data);
            $insertID = $this->db->insert_id();
            
            if($insertID){
                $message = array("message" => 'ADDED!');
                echo json_encode(array('status' => 1, 'id' => $insertID,'otp'=>$otp ,'result' => $message), 200); // 200 being the HTTP response code
                exit();
            }else{
                $message = array("message" => 'FAILED!');
                $result = array('status' => 0, 'result' => $message);
                echo $json_encode($result, 500); // 200 being the HTTP response code // 500 = Internal Server Error
                exit();
            }
    }
    

    
    function randomNumber($length) {
        $result = '';
        for($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }
        return $result;
    }

 
    /**
     * Login
     */
    
    public function verifyotp()
    {
        $postarray = array();
       $postarray = json_decode(@file_get_contents("php://input"));

       /*$postarray = array(
            'id'=>2,
            'otp'=>6546,
        );*/
        
        $postarray = array(
            'id'=>isset($postarray['id'])?addslashes($postarray['id']):'',
            'otp'=>isset($postarray['otp'])?addslashes($postarray['otp']):'',
        );

        if(!empty($postarray['id'])) {
            $updateCondition = array('id'=>$postarray['id'],'otp'=>$postarray['otp']);
               $post= array('status'=>'1');
                if($this->auth->update($updateCondition,$post)){
                    $message = array("Success");
                    $response = array('status' => 1,
                                      'message' => $message,
                                );
                }else{
                    $message = array("message" => 'Failure');
                    $response = array('status' => 0,
                                      'message' => $message,
                                );
                }
        }
        else{
                $message = array("message" => 'No User');
                $response = array('status' => 0,
                                  'message' => $message,
                            );
        }

        echo json_encode($response);
    }
    
    
    


    public function generateRandomString($length = 5)
    {
        //return substr( str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
        return rand(1000,10000);
    }

}
