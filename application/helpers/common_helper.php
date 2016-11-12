<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Helper Files: Common Helper Functions
|--------------------------------------------------------------------------
|
*/

/**
 * Returns Asset path location of dashboard
 */
if ( ! function_exists('asset_path_dashboard'))
{
    function asset_path_dashboard()
    {
      $url = base_url().'assets/admin/';
      return $url;
    }
}

/**
 * Returns Asset path location of Web
 */
if ( ! function_exists('asset_path_web'))
{
    function asset_path_web()
    {
      $url = base_url().'assets/web/';
      return $url;
    }
}

/**
 * Returns Upload path location
 */
if ( ! function_exists('upload_path'))
{
    function upload_path()
    {
      $url = base_url().'uploads';
      return $url;
    }
}

/**
 * Print Output as Array format
 */
if ( ! function_exists('printr'))
{
    function printr($result)
    {
      if( count($result) >0 ){
        echo '<pre>'; print_r($result); 
      }
      
    }
}

/**
 * Print Output as Object format
 */
if ( ! function_exists('printobj'))
{
    function printobj($result)
    {
      if( count($result) >0 ){
       echo '<pre>'; var_dump($result); exit;
      }
    }
}

/**
 * Returns encrypted string
 */
if ( ! function_exists('encrypt'))
{
    function encrypt($string)
    {
        if($string !=''){
            $output = false;
            $encrypt_method = "AES-256-CBC";
            $secret_key = 'sdg123@#$rteryery';
            $secret_iv = 'sdg123@#$rteryery';
            $key = hash('sha256', $secret_key);
            $iv = substr(hash('sha256', $secret_iv), 0, 16);
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
            return $output;
        }
    }
}



function ecrypt($sData, $sKey){ 
    $sResult = ''; 
    for($i=0;$i<strlen($sData);$i++){ 
        $sChar    = substr($sData, $i, 1); 
        $sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1); 
        $sChar    = chr(ord($sChar) + ord($sKeyChar)); 
        $sResult .= $sChar; 
    } 
    return encode_base64($sResult); 
} 
function dcrypt($sData, $sKey){ 
    $sResult = ''; 
    $sData   = decode_base64($sData); 
    for($i=0;$i<strlen($sData);$i++){ 
        $sChar    = substr($sData, $i, 1); 
        $sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1); 
        $sChar    = chr(ord($sChar) - ord($sKeyChar)); 
        $sResult .= $sChar; 
    } 
    return $sResult; 
} 

function encode_base64($sData){ 
    $sBase64 = base64_encode($sData); 
    return strtr($sBase64, '+/', '-_'); 
} 
function decode_base64($sData){ 
    $sBase64 = strtr($sData, '-_', '+/'); 
    return base64_decode($sBase64); 
}  


/**
 * Returns decrypted string
 */
if ( ! function_exists('decrypt'))
{
    function decrypt($string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'sdg123@#$rteryery';
        $secret_iv = 'sdg123@#$rteryery';
        // hash
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        return $output;
    }
}

/**
 * check input null or not if not then dycrypt and returns intval
 */
if ( ! function_exists('checkID_Decrypt'))
{
    function checkID_Decrypt($val)
    {
        $ID='';
        if(isset($val) && $val !=''){  
            $val =decrypt($val);  
            $ID = $val;   
        } 
        return $ID;
    }
}


/**
 * Json to Array
 */
if ( ! function_exists('json_to_array'))
{
    function json_to_array($request){
        if(isset($request) && $request !=''){       
             return json_decode($request, true);
        }
    }
}

/**
 * removeAllCSVFiles from a directory
 */
if ( ! function_exists('removeAllFilesByType'))
{
    function removeAllFilesByType($path,$type){
        if(isset($path) && $path !=''){       
            $files = glob($path.'*.'.$type); // get all file names
            foreach($files as $file){ // iterate files
              if(is_file($file))
                @unlink($file);

            }
        }
    }
}


/**
 * Ajax data table  Edit & Delete Buttons
 */
if ( ! function_exists('getActionButtons'))
{

	function getActionButtons($id,$module, $creator='',$gallery='',$parent_id='') {
		$ci = & get_instance();
    	$html = '<div class="btn-group">';

        if($gallery=='gallery'){
            //if( (MODULE_PERMISSION=='') || ((intval(MODULE_PERMISSION)>=4)) ){

                if(($creator == $ci->session->userdata('user_id')) || ($ci->session->userdata('group_name') == 'admin') || ($ci->session->userdata('group_name') == 'cityAdmin') || ($ci->session->userdata('group_name') == 'dataAgent') ){
                    if($parent_id!=''){
                        $html .= '<a href="'.base_url() . $module.'/gallery/'.encrypt($id).'/'.encrypt($parent_id).'" title="gallery"  class="btn btn-xs btn-success gallery" data-toggle="tooltip"  data-module="'.$module.'" data-id="'.encrypt($id).'" ><i class="fa fa-image"></i></a>';
                    }else{
                        $html .= '<a href="'.base_url() . $module.'/gallery/'.encrypt($id).'" title="gallery"  class="btn btn-xs btn-success gallery" data-toggle="tooltip"  data-module="'.$module.'" data-id="'.encrypt($id).'" ><i class="fa fa-image"></i></a>';
                    }
                }
            //}
        }
        if($creator!='trash'){
            if( $ci->admin->is_super_admin() || $ci->admin->is_admin() || $ci->admin->checkPermission('update') ) {
                if($module != 'newsletter/subscriber' && $module != 'tips' && $module!='review' && $module!='my_story'){
                    if($parent_id!=''){
                         $html .= '<a href="' . base_url() . $module.'/update/' . encrypt($id) . '/'.encrypt($parent_id).'" title="edit" data-toggle="tooltip" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
                    }else{
                         $html .= '<a href="' . base_url() . $module.'/update/' . encrypt($id) . '" title="edit" data-toggle="tooltip" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
                    } 
                }
        	}
        }
        if( $ci->admin->is_super_admin() || $ci->admin->is_admin() || $ci->admin->checkPermission('read') ) {
              if(($module !='thingstodo/category') && ($module !='tips') && ($module !='newsletter/subscriber') && ($module!='magazine') && ($module!='etemplate')){
                 $html .= '<a title="view" data-toggle="tooltip" class="btn btn-xs btn-default view" data-module="'.$module.'" data-id="'.encrypt($id).'"><i class="fa fa-eye"></i></a>';
              }
              
        }
        
        if($creator!='trash'){
            if( $ci->admin->is_super_admin() || $ci->admin->is_admin() || $ci->admin->checkPermission('delete') ) { 
                //if(($creator == $ci->session->userdata('user_id')) || ($ci->session->userdata('group_name') == 'admin') ){
                    if(($module !='tips' && $module !='tourandtravel' && $module !='moneyexchangers' && $module !='carrentals' )){
                        $html .= '<a href="javascript:void(0);" title="delete"  class="btn btn-xs btn-danger trash" data-toggle="tooltip"  data-module="'.$module.'" data-id="'.encrypt($id).'" ><i class="fa fa-times"></i></a>';
                    }
                    if($module =='tourandtravel' || $module =='moneyexchangers' || $module =='carrentals'){
                        $html .= '<a href="javascript:void(0);" title="delete"  class="btn btn-xs btn-danger trashwithBranches" data-toggle="tooltip"  data-module="'.$module.'" data-id="'.encrypt($id).'" ><i class="fa fa-times"></i></a>';
                    }
                // }
            }
        }else{
            if(($ci->session->userdata('group_name') == 'admin') ){
                $html .= '<a href="javascript:void(0);" title="restore"  class="btn btn-xs btn-default restore" data-toggle="tooltip"  data-module="'.$module.'" data-id="'.encrypt($id).'" ><i class="fa fa-reply"></i></a>';
            }
        }
        

        $html .= '</div>';
    	return $html;
	}
}
//Data table  Status  Button
if ( ! function_exists('getStatusButton'))
{

    function getStatusButton($id,$key,$status) {  
        $ci = & get_instance();
        $html ='';
        $success = '';
        if( $ci->admin->is_super_admin() || $ci->admin->is_admin() || $ci->admin->checkPermission('update') ) {
            $html .= '<a  class="change_status" data-label="change" data-id="'.encrypt($id).'"  data-module="'.$key.'" >';

            if($status == 1) {
                $status='active';
                $success = "btn-success";
                $html .= '<button type="button" title="inactive" class="btn btn-xs '.$success.' st_class">'.$status.' </button>';
            }elseif($status == 2){
                $status='inactive';
                $success='btn-warning';
                $html .= '<button type="button" title="active" class="btn btn-xs '.$success.' st_class">'.$status.' </button>';
            }elseif($status == 4){
                $statuses='pending';
                $success='btn-info';
                $html .= '<button type="button" title="activate" class="btn btn-xs '.$success.' st_class">'.$statuses.' </button>';
            }elseif($status == 3){
                $statuses='rejected';
                $success='btn-info';
                $html .= '<button type="button" title="re-submit" class="btn btn-xs '.$success.' st_class">'.$statuses.' </button>';
            }
           
            $html .= '</a>';
            if($status == 4){
                 $html .= ' <a  class="change_status reject" data-label="reject" data-id="'.encrypt($id).'"  data-module="'.$key.'" >';
                 $status1='reject';
                 $restore='btn-primary';
                 $html .= '<button type="button" title="reject" class="btn btn-xs '.$restore.' st_class">'.$status1.' </button>';
                 $html .= '</a>';
            }
        }else{
            $html .= '<button type="button" class="btn btn-xs btn-danger st_class">No Permision </button>';
        }
        return $html;
    }
}

//Data table  Feature  Button
if ( ! function_exists('getFeatureStatusButton'))
{

    function getFeatureStatusButton($id,$key,$status,$class='',$category=null) {  
        $ci = & get_instance();
        $html ='';
        $success = '';
        if ($class!='') {
            $html .= '<a  class="change_home_status" data-id="'.encrypt($id).'"  data-module="'.$key.'" data-cat="'.$category.'">';
        }else{
            $html .= '<a  class="change_feature_status" data-id="'.encrypt($id).'"  data-module="'.$key.'" >';
        }
        if($status == 1) {
            $status='Yes';
            $success = "btn-success";
            $html .= '<button type="button" class="btn btn-xs '.$success.' st_class">'.$status.' </button>';
        }elseif($status == 0){
            $status='No';
            $success='btn-warning';
            $html .= '<button type="button" class="btn btn-xs '.$success.' st_class">'.$status.' </button>';
        }
           
            $html .= '</a>';

        return $html;
    }
}

/**
 * Get Logedin User ID
 */
if ( ! function_exists('getLoginID'))
{
    function getLoginID() {
        $ci = & get_instance();
        $ID = '';
        if($ci->session->has_userdata('user_id')){
            $ID = $ci->session->userdata('user_id');       
        }
        return $ID;
    }
}

/**
 * Get Logedin User ID
 */
if ( ! function_exists('getID'))
{
    function getID() {
        $ci = & get_instance();
        $ID = '';
        if($ci->session->has_userdata('member_id')){
            $ID = $ci->session->userdata('member_id');       
        }
        return $ID;
    }
}


/**
 * Get Logedin User ID
 */
if ( ! function_exists('getCityID'))
{
    function getCityID() {
        $ci = & get_instance();
        $city_id = '';
        if($ci->session->has_userdata('city_id')){
            $city_id = $ci->session->userdata('city_id');       
        }
        return $city_id;
    }
}
/**
 * Get Logedin User ID
 */
if ( ! function_exists('getLoginImage'))
{
    function getLoginImage() {
        $ci = & get_instance();
        $image = '';
        if($ci->session->has_userdata('user_image')){
            $image = $ci->session->userdata('user_image');       
        }
        return $image;
    }
}


if ( ! function_exists('getLoginImageweb'))
{
    function getLoginImageweb($id='') {
        $ci = & get_instance();
            $ci->load->model('User_model','user');
            $condition = array('member_id'=>$id); 
            $response = $ci->user->findById('member.member_profile_image',$condition);
        return isset($response['member_profile_image']) && $response['member_profile_image']!=''?$response['member_profile_image']:'';
    }
}

/**
 * Get Creater Name
 */
if ( ! function_exists('getCreaterName'))
{
    function getCreaterName($id='') {
        $response= array();
        if(!empty($id)){
            $ci = & get_instance();
            $ci->load->model('user/User_model','user');
            $condition = array('users_id'=>$id); 
            $response = $ci->user->findByIdByJoin('groups.groups_description',$condition);
        }
       
        return isset($response['groups_description']) && $response['groups_description']!=''?$response['groups_description']:'';
    }
}

if ( ! function_exists('getCreater'))
{
    function getCreater($id='') {
        $response= array();
        if(!empty($id)){
            $ci = & get_instance();
            $ci->load->model('user/User_model','user');
            $condition = array('users_id'=>$id); 
            $response = $ci->user->findByIdByJoin('users.users_first_name',$condition);
        }
       
        return isset($response['users_first_name']) && $response['users_first_name']!=''?$response['users_first_name']:'';
    }
}

if ( ! function_exists('getCityName'))
{
    function getCityName($id='') {
        $response= array();
        if(!empty($id)){
            $ci = & get_instance();
            $ci->load->model('city/City_web_model','city');
            $condition = array('city_id'=>$id); 
            $response = $ci->city->findById($condition);
        }
       
        return isset($response['city']) && $response['city']!=''?$response['city']:'';
    }
}


/**
 * Get Site Logo
 */
if ( ! function_exists('getSiteSettings'))
{
    function getSiteSettings() {
        $ci = & get_instance();
        $ci->load->model('settings/Settings_model','settings');
        $condition = array('site_settings_id'=>'1'); 
        $response = $ci->settings->findById($condition); // get list data by ID
        return $response;
    }
}

/**
 * File Upload Process
 */
if ( ! function_exists('fileUpload'))
{
    function fileUpload($value,$field,$module,$old_image) { 
        $ci = & get_instance();
        $config['upload_path']     = 'uploads/'.$module."/";
        if(!is_dir($config['upload_path'])){
            mkdir($config['upload_path'], 0777, TRUE);
        }
        $config['allowed_types']   = 'gif|jpg|png|jpeg|png|csv';
        $config['max_size']        =  100000;
        //$config['max_width']       =  '1024';
        //$config['max_height']      =  '768';
        $config['file_name']       =  rand().$value;
        //$config['overwrite']       =  TRUE; 
        $ci->load->library('upload', $config); 
        $ci->upload->initialize($config);               
        if ( ! $ci->upload->do_upload($field)) {
            $result['error'] = $ci->upload->display_errors();
        }else {
            $upload = $ci->upload->data();
            if(isset($upload['file_name']) && $upload['file_name']!='') {
                @unlink($config['upload_path'].$old_image);
                @unlink($config['upload_path'].'thumb/'.$old_image);
                $result = $upload; 
                $result['image'] = $upload['file_name'];
            }
        }
        return $result;
    }
}
/**
 * File Upload Process
 */
if ( ! function_exists('imageResize'))
{
    function imageResize($image,$width,$height,$fullpath,$filepath,$upload_width,$upload_height) { 
        $ci = & get_instance();
        $new_image_path = $filepath.'thumb/';
      //  echo $new_image_path.'full'.$fullpath;exit();
        if(!is_dir($new_image_path)){
            mkdir($new_image_path, 0777, TRUE);
        }
        $config['image_library'] = 'gd2';
        $config['source_image'] = $fullpath;
        $config['new_image'] = $new_image_path.$image;
        $config['maintain_ratio'] = TRUE;
        $config['quality'] = "100%";
        $config['width']    = $width;
        $config['height']   = $height;
        $dim = (intval($upload_width) / intval($upload_width)) - ($config['width'] / $config['height']);
        $config['master_dim'] = ($dim > 0)? "height" : "width";
        $ci->load->library('image_lib', $config); 
        if($ci->image_lib->resize()){
            return true;
        }
        
    }
}

if ( ! function_exists('imageResize1'))
{ 
    function imageResize1($image,$width,$height,$fullpath,$filepath,$upload_width,$upload_height) { 
        //echo "string";exit();
        $ci = & get_instance();
        $new_image_path = $filepath.'thumb/';
        echo $new_image_path.'full'.$fullpath;exit();
        if(!is_dir($new_image_path)){
            mkdir($new_image_path, 0777, TRUE);
        }
        $config['image_library'] = 'gd2';
        $config['source_image'] = $fullpath;
        $config['new_image'] = $new_image_path.$image;
        $config['maintain_ratio'] = TRUE;
        $config['quality'] = "100%";
        $config['width']    = $width;
        $config['height']   = $height;
        $dim = (intval($upload_width) / intval($upload_width)) - ($config['width'] / $config['height']);
        $config['master_dim'] = ($dim > 0)? "height" : "width";
        $ci->load->library('image_lib', $config); 
        if($ci->image_lib->resize()){
            return true;
        }
        
    }
}

/**
 * Data Table Empty Message
 */
if ( ! function_exists('dataTableEmptyMsg'))
{
    function dataTableEmptyMsg() {
       echo '{
                "sEcho": 1,
                "iTotalRecords": "0",
                "iTotalDisplayRecords": "0",
                "aaData": []
            }';
    }

}
/**
 * Error flash data message display
 */
if ( ! function_exists('form_error_flash'))
{
    function form_error_flash($mess="")
    {
      $dat ='';
      if( trim($mess) !="" ){
        $dat ='<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="fa fa-check-circle"></i>Failed</h4>'.$mess.'</div>';
      }
      return $dat;
    }
}

/**
 * Success flash data message display
 */
if ( ! function_exists('flash_success'))
{
    function flash_success($mess="")
    {
      $dat ='';
      if( trim($mess) !="" ){
        $dat ='<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="fa fa-check-circle"></i>Success</h4>'.$mess.'</div>';
      }
      return $dat;
    }
}

/**
 * get Pagination Array
 */
if ( ! function_exists('getPaginationArray'))
{
    function getPaginationArray()
    {
        $ci = & get_instance();

        $config["per_page"] = $ci->config->item('items_per_page');
        //$config["uri_segment"] = 3;    
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '<i class="left"></i>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '<i class="right"></i>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        return $config;
    }
}

if ( ! function_exists('getPaginationArraySearch'))
{
    function getPaginationArraySearch()
    {
        $ci = & get_instance();

        $config["per_page"] = $ci->config->item('items_per_page');
        //$config["uri_segment"] = 3;    
        $config['full_tag_open'] = '<ul class="pagination ajx_page">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '<i class="left"></i>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '<i class="right"></i>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        return $config;
    }
}

// Mail Sending Function

if ( ! function_exists('sendingEmail'))
{
   function sendingEmail($category, $to, $name, $subject, $content, $from, $bcc_enabled = FALSE)
    {
        $ci = & get_instance();
        $ci->load->model('etemplate/Etemplate_model','etemplate');

        $settings = getSiteSettings();

        $site_logo = "";
        $site_name = "";
        $from_name = "";

        if(count($settings) > 0) {
            $site_logo = $settings['site_logo'];
            $site_name = $settings['site_name'];
            $from_name = $settings['site_email_from_name'];
        }

        $condition = array('etemplate_category' => $category, 'etemplate_status' => '1'); 
        $template = $ci->etemplate->findAll($condition);

        $subject = "";
        $message = "";

        if(count($template) > 0) {
            $subject = $template[0]["etemplate_title"];
            $message = $template[0]["etemplate_content"];

            $message = str_replace('{{ site_logo }}',$site_logo,$message);
            $message = str_replace('{{ name }}',$name,$message);
            $message = str_replace('{{ site_name }}',$site_name,$message);
            $message = str_replace('{{ content }}',$content,$message);
            $message = str_replace('{{ contact_email }}',$to,$message);
            $message = str_replace('{{ unsubscribe_email }}',encrypt($to),$message);
        }
            
        /*$CI =& get_instance();
        $CI->load->library('email');
        $config = Array(
          'protocol' => 'smtp',
          'smtp_host' => 'smtp.sendgrid.net',
         /* 'smtp_user' => 'TeamLead',
          'smtp_pass' => 'sendgrid@786',*/
          
      /*    'smtp_user' => 'siva@travex.org',
          'smtp_pass' => 'Travex@#2016',

          'smtp_port' => 587,
          'mailtype' => 'html',
          'crlf' => "\r\n",
          'newline' => "\r\n"
       );*/


    /*    $CI->email->initialize($config);
        $CI->email->from($from, $name);*/
        //$CI->email->to($to);
        //$emails = $to;
               /* if($bcc_enabled == TRUE) {
                   $emails = array_merge($emails,array(WEBMASTER_EMAIL));
                }*/
/*
        $CI->email->bcc($to);
        $CI->email->subject($subject);
        $CI->email->message($message);

        return $CI->email->send();*/

        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
        //$headers .= 'To: '.$name.' <'.$to.'>' . "\r\n";
        $headers .= 'From: Travex <'.$from.'>' . "\r\n";

        return mail($to,$subject,$message,$headers);exit();

        
    }


}

/* End of file flashdata_helper.php */
/* Location: ./application/helpers/common_helper.php */



