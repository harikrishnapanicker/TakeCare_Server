<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Library Files: Admin Library
|--------------------------------------------------------------------------
|
*/
class Admin{

    function  __construct(){
    	$this->CI = &get_instance();
      $this->CI->config->load('category_links');
    }

    /**
     * check User Loged or not
     */
    function is_logged_in(){
     	if( !($this->CI->session->has_userdata('status') && $this->CI->session->userdata('status')==1 ) ){ 
        	return false;
  		}else{
  			return true;
  		}
    }
	
	/**
   * Loading Layout view
   */
	function load_view($cont,$title=''){ 
        $this->CI->load->view('../../common/layout',array('content'=>$cont,'title' => $title));
	}

    /**
     * Logout Process & Session Destroy
     */
	function logout(){
    if($this->CI->session->has_userdata('status')){ 
		  $this->session->sess_destroy();
    }
	   redirect('admin');
	}

   
    /**
     * check User CityAdmin or not
     */
    function is_city_admin(){
        if($this->CI->session->has_userdata('group_name') && $this->CI->session->userdata('group_name')=='cityAdmin') { 
            return true;
        }else{           
            return false;
        }
    }
     /**
     * check User dataAgent or not
     */
    function is_data_agent(){
        if($this->CI->session->has_userdata('group_name') && $this->CI->session->userdata('group_name')=='dataAgent') { 
            return true;
        }else{           
            return false;
        }
    }

     /**
     * check User saleAgent or not
     */
    function is_sale_agent(){
        if($this->CI->session->has_userdata('group_name') && $this->CI->session->userdata('group_name')=='saleAgent') { 
            return true;
        }else{           
            return false;
        }
    }


    /**
     * check User Admin or not
     */
    function is_admin(){
        if($this->CI->session->has_userdata('group_name') && $this->CI->session->userdata('group_name')=='admin') { 
            return true;
        }else{           
            return false;
        }
    }

    /**
     * check User Admin or not
     */
    function is_super_admin(){
        if($this->CI->session->has_userdata('user_id') && $this->CI->session->userdata('user_id')==1) { 
            return true;
        }else{           
            return false;
        }
    }
     /**
     * get Acces Role Permission
     */
    public function getAccesRolePermission($module=''){
        $CI = &get_instance();
        $groupID = $CI->session->userdata('group_id');
        $groupName = $CI->session->userdata('group_name');
        $condition=array("permissions_group_id"=>$groupID);
        $fields="permissions.*,modules.modules_name";
        $permissions_details = $CI->login->getPermission($condition,$fields);
        //printr($permissions_details); exit;
        $permissions= array();
        if(!empty($module)){
            foreach ($permissions_details as $key => $val) {
                if($module == $val['modules_name']){
                    define('MODULE', $groupName);
                    define('CREATE', $val['permissions_create']);
                    define('READ', $val['permissions_read']);
                    define('EDIT', $val['permissions_update']);
                    define('REMOVE', $val['permissions_delete']);
                    define('IMPORT', $val['permissions_import']);
                    define('EXPORT', $val['permissions_export']);
                }           
            } 
        }
    }

     /**
     * get Acces Role Permission
     */
    public function checkPermission($module=''){ //echo $module; exit;
        $CI = &get_instance();
        switch ($module) {
          case 'read':
            if( defined('READ') && (READ==1) ){
              return TRUE;
            }else{
              return FALSE;
            }
            break;
          case 'create':
            if( defined('CREATE') && (CREATE==1) ){
              return TRUE;
            }else{
              return FALSE;
            }
            break;
          case 'update':
            if( defined('EDIT') && (EDIT==1) ){
              return TRUE;
            }else{
              return FALSE;
            }
            break;
          case 'delete':
            if( defined('REMOVE') && (REMOVE==1) ){
              return TRUE;
            }else{
              return FALSE;
            }
            break;
          case 'import':
            if( defined('IMPORT') && (IMPORT==1) ){
              return TRUE;
            }else{
              return FALSE;
            }
            break;
          case 'export':
            if( defined('EXPORT') && (EXPORT==1) ){
              return TRUE;
            }else{
              return FALSE;
            }
            break;
          default:
            return FALSE;
            break;
      }
        
    }

    /**
     * check User Admin or not
     */
    function getCategoryLinkModules($module='',$flag=''){
            $cat_array =array();
            $cat_array['nightlife']  = array('hotel');
            $cat_array['shopping']   = array('shop_mall','shop_souq','hotel','airline_terminal');
            $cat_array['spa']        = array('shop_mall','hotel','airline_terminal');
            $cat_array['thingstodo'] = array('shop_mall','hotel','nightlife');
            $cat_array['eatingout']  = array('shop_mall','hotel','shop_souq','airline_terminal');
            $cat_array['events']     = array('embassy','consulate','travel','eatingout','hotel','nightlife','spa','shop_mall','shop_souq','airline_terminal','airport');
            $cat_array['travel']  = array('airline_terminal','shop_mall','hotel');
            $cat_array['moneyexchange']  = array('airline_terminal','shop_mall');
            $cat_array['rental']  = array('airline_terminal');

            $cond      = array('status' => 1);
            $this->CI->load->model('Category_model');
            $links     = $this->CI->Category_model->get_category_links($cond);
            if(isset($flag) && $flag=="update"){
                $tag_links= array();
                foreach ($links as $key => $value) {
                    if(in_array($value['category'], $cat_array[$module])){
                        $tag_links[]=$value;
                    }
                }
                return $tag_links;
            }else{
                if(count($links )>0){
                $option='<option value="">Other</option>';
                }else{
                    $option='';
                }
                //printr($cat_array[$module]); exit;
                
                foreach ($links as $key => $value) {
                    $sel='';
                       if(in_array($value['category'], $cat_array[$module])){
                        
                          $option.= '<option value="'.$value['category'].'"  >'.$value['link_keyword'].'</option>';
                        
                        
                       }
                                    
                }
                return  $option;
            }            
       
    }
     /**
     * check User Admin or not
     */

    public function findHotelTag($row,$area){
        $hotel= array();
        $con = array('LOWER(hotels.hotels_title)'=>strtolower(trim($row['Tag To'])),
                      'hotels.hotels_area'=> $area,
                      'hotels.hotels_status'=>'1',
                      'hoteltypes.hotels_type_status'=>'1',
                      'city.city_status'=>'1',
                      'area.area_status'=>'1'
                  ); 
        $fields = 'hotels.hotels_title,hotels.hotels_id,hotels.hotels_address,hotels.longitude,hotels.latitude';
        $hotel_details = $this->CI->hotel->findByIdJoin($fields,$con);
        if(!empty($hotel_details )) {
            $tag      = $this->CI->config->item(strtolower(trim($row['Located At'])));
            $tag_item = $hotel_details['hotels_id'];
            $tag_address = $hotel_details['hotels_address'];
            $longitude  = $hotel_details['longitude'];
            $latitude   = $hotel_details['latitude'];
            $hotel=array('tag'=>$tag,'tag_item'=> $tag_item,'tag_address'=>$tag_address,'longitude'=>$longitude,'latitude' =>$latitude);
        }
        return $hotel;
    }
     /**
     * check User Admin or not
     */

    public function findMallTag($row,$area){ 
        $mall= array();
        $con = array('LOWER(shopping.shopping_name)'=>strtolower(trim($row['Tag To'])),
                      'shopping.shopping_area'=> $area,
                      'LOWER(shopping_location.shopping_location_name)'=>'mall',
                      'shopping_location.shopping_location_status'=>'1',
                      'shopping.shopping_status'=>'1',
                      'city.city_status'=>'1',
                      'area.area_status'=>'1'
                ); 

        $fields = 'shopping.shopping_name,shopping.shopping_id,shopping.shopping_address,shopping.latitude,shopping.longitude';
        $mall_details = $this->CI->shopping->findByIdJoin($fields,$con);        
        if(!empty($mall_details )) {
            $tag      = $this->CI->config->item(strtolower(trim($row['Located At'])));
            $tag_item = $mall_details['shopping_id'];
            $tag_address = $mall_details['shopping_address'];
            $mall=array('tag'=>$tag,'tag_item'=> $tag_item,'tag_address'=>$tag_address,'latitude'=>$mall_details['latitude'],'longitude'=>$mall_details['longitude']);
        }
        return $mall;
    }


     public function findSoukTag($row,$area){
        $souq= array();
        $con = array('LOWER(shopping.shopping_name)'=>strtolower(trim($row['Tag To'])),
                      'shopping.shopping_area'=> $area,
                      'LOWER(shopping_location.shopping_location_name)'=>'souq',
                      'shopping_location.shopping_location_status'=>'1',
                      'shopping.shopping_status'=>'1',
                      'city.city_status'=>'1',
                      'area.area_status'=>'1'
                ); 
        $fields = 'shopping.shopping_name,shopping.shopping_id,shopping.shopping_address,shopping.latitude,shopping.longitude';
        $souq_details = $this->CI->shopping->findByIdJoin($fields,$con);
        if(!empty($souq_details )) {
            $tag      = $this->CI->config->item(strtolower(trim($row['Located At'])));
            $tag_item = $souq_details['shopping_id'];
            $tag_address = $souq_details['shopping_address'];
            $souq=array('tag'=>$tag,'tag_item'=> $tag_item,'tag_address'=>$tag_address,'latitude'=>$souq_details['latitude'],'longitude'=>$souq_details['longitude']);
        }
        return $souq;
    }

    /**
     * check User Admin or not
     */

    public function findTerminalTag($row,$area){
        $terminal= array();
        $csvdata = explode('-', $row['Tag To']);
        $row['Tag To'] = $csvdata[1];
        $con = array('LOWER(terminals.terminals_title)'=>strtolower(trim($row['Tag To'])),
                      'airports.airports_area'=> $area,
                      'terminals.terminals_status'=>'1',
                      'airports.airports_status'=>'1',
                      'city.city_status'=>'1',
                      'area.area_status'=>'1'
                ); 
        $fields = 'terminals.terminals_title,terminals.terminals_id,terminals.terminals_address,terminals.longitude,terminals.latitude';
        $terminal_details = $this->CI->terminal->findByIdJoin($fields,$con);
        if(!empty($terminal_details )) {
            $tag      = $this->CI->config->item(strtolower(trim($row['Located At'])));
            $tag_item = $terminal_details['terminals_id'];
            $tag_address = $terminal_details['terminals_address'];
            $terminal=array('tag'=>$tag,'tag_item'=> $tag_item,'tag_address'=>$tag_address);
        }
        return $terminal;
    }


    public function findAirportTag($row,$area){
        $airport= array();
        $con = array('LOWER(airports.airports_code)'=>strtolower(trim($row['Tag To'])),
                      'airports.airports_area'=> $area,
                      'airports.airports_status'=>'1',
                      'city.city_status'=>'1',
                      'area.area_status'=>'1'
                ); 
        $fields = 'airports.airports_code,airports.airports_id,airports.airports_name,area.area';
        $airport_details = $this->CI->airport->findByIdJoin($fields,$con);
        if(!empty($airport_details )) {
            $tag      = $this->CI->config->item(strtolower(trim($row['Located At'])));
            $tag_item = $airport_details['airports_id'];
            $tag_address = $airport_details['airports_name'];
            $airport=array('tag'=>$tag,'tag_item'=> $tag_item,'tag_address'=>$tag_address);
        }
        return $airport;
    }


    public function findNightTag($row,$area)
    {
        $night = array();
        $con = array('LOWER(night_life_name)'=>strtolower(trim($row['Tag To'])),
                      'night_life_area'=> $area,
                      'night_life_status'=>'1'
                  ); 
        $fields = 'night_life_name,night_life_id,night_life_address,longitude,latitude';
        $night_details = $this->CI->nightlife->findById($con);
        if(!empty($night_details )) {
            $tag         = $this->CI->config->item(strtolower(trim($row['Located At'])));
            $tag_item    = $night_details['night_life_id'];
            $tag_address = $night_details['night_life_address'];
            $night=array('tag'=>$tag,'tag_item'=> $tag_item,'tag_address'=>$tag_address,'longitude'=>$night_details['longitude'],'latitude'=>$night_details['latitude']);
        }
        return $night;
    }


    public function findSpaTag($row,$area)
    {
        $night = array();
        $con = array('LOWER(spa_name)'=>strtolower(trim($row['Tag To'])),
                      'spa_area'=> $area,
                      'spa_status'=>'1'
                  ); 
        $fields = 'spa_name,spa_id,spa_address';
        $spa_details = $this->CI->spa->findById($fields,$con);
        if(!empty($spa_details )) {
            $tag         = $this->CI->config->item(strtolower(trim($row['Located At'])));
            $tag_item    = $spa_details['spa_id'];
            $tag_address = $spa_details['spa_address'];
            $spa=array('tag'=>$tag,'tag_item'=> $tag_item,'tag_address'=>$tag_address);
        }
        return $spa;
    }

    public function findEatTag($row,$area)
    {
        $night = array();
        $con = array('LOWER(eating_out_title)'=>strtolower(trim($row['Tag To'])),
                      'eating_out_area'=> $area,
                      'eating_out_status'=>'1'
                  ); 
        $fields = 'eating_out_title,eating_out_id,eating_out_address';
        $eating_details = $this->CI->eatingout->findById($con,'eating_out');
        if(!empty($eating_details )) {
            $tag         = $this->CI->config->item(strtolower(trim($row['Located At'])));
            $tag_item    = $eating_details['eating_out_id'];
            $tag_address = $eating_details['eating_out_address'];
            $eat=array('tag'=>$tag,'tag_item'=> $tag_item,'tag_address'=>$tag_address);
        }
        return $eat;
    }

    public function findTravelTag($row,$area)
    {
        $night = array();
        $con = array('LOWER(tourandtravel_name)'=>strtolower(trim($row['Tag To'])),
                      'tourandtravel_area'=> $area,
                      'tourandtravel_status'=>'1'
                  ); 
        $fields = 'tourandtravel_name,tourandtravel_id,tourandtravel_address';
        $travel_details = $this->CI->tourandtravel->findById($con);
        if(!empty($travel_details )) {
            $tag         = $this->CI->config->item(strtolower(trim($row['Located At'])));
            $tag_item    = $travel_details['tourandtravel_id'];
            $tag_address = $travel_details['tourandtravel_address'];
            $eat=array('tag'=>$tag,'tag_item'=> $tag_item,'tag_address'=>$tag_address);
        }
        return $eat;
    }  

     public function findEmbassyTag($row,$area)
    {
       $csvdata = explode('-', $row['Tag To']);
        // $row['type'] = $csvdata[0];
        $row['of country'] = $csvdata[0];
        $row['in country'] = $csvdata[1];
        $emb = array();

        $fields = 'embassies.*,countries.country_name,em.country_name as countryname,countries.country_name';
        $condition = array('embassies.type_name'=> "consulate",'em.country_name'=>$row['of country'],'countries.country_name'=>$row['in country'],'embassies.embassies_status'=>'1','embassies.embassies_status!='=>'0');  // condition for findAll
    
        $empassies_details = $this->CI->embassies->findIdByJoin($fields,$condition);
        if(!empty($empassies_details )) {
            $tag         = $this->CI->config->item(strtolower(trim($row['Located At'])));
            $tag_item    = $empassies_details['embassies_id'];
            $tag_address = $empassies_details['embassies_address'];
            $emb=array('tag'=>$tag,'tag_item'=> $tag_item,'tag_address'=>$tag_address);
        }
        return $emb;
    }

    public function findConsulateTag($row,$area)
    {
       $csvdata = explode('-', $row['Tag To']);
        // $row['type'] = $csvdata[0];
        $row['of country'] = $csvdata[0];
        $row['in country'] = $csvdata[1];
        $emb = array();

        $fields = 'embassies.*,countries.country_name,em.country_name as countryname,countries.country_name';
        $condition = array('embassies.type_name'=> "consulate",'em.country_name'=>$row['of country'],'countries.country_name'=>$row['in country'],'embassies.embassies_status'=>'1','embassies.embassies_status!='=>'0');  // condition for findAll
    
        $empassies_details = $this->CI->embassies->findIdByJoin($fields,$condition);
        if(!empty($empassies_details )) {
            $tag         = $this->CI->config->item(strtolower(trim($row['Located At'])));
            $tag_item    = $empassies_details['embassies_id'];
            $tag_address = $empassies_details['embassies_address'];
            $emb=array('tag'=>$tag,'tag_item'=> $tag_item,'tag_address'=>$tag_address);
        }
        return $emb;
    }


    public function checkFieldExists($post,$model_tag,$table,$field_name,$field_id)
    {
      if(decrypt($post[$field_id]) != '')
      {
         $chkDupCondition = array('latitude'=>trim($post['latitude']),
                                  'longitude'=>trim($post['longitude']),
                                  'LOWER('.$field_name.')'=>trim(strtolower($post[$field_name])),
                                  $field_id.' !=' => decrypt($post[$field_id]),
                            );
       } else {
           $chkDupCondition = array('latitude'=>trim($post['latitude']),
                               'longitude'=>trim($post['longitude']),
                               'LOWER('.$field_name.')'=>trim(strtolower($post[$field_name])),
                            );
       }

     // printr($chkDupCondition);exit;
      $chkDup = $this->CI->$model_tag->field_exists($chkDupCondition);
      return $chkDup;
    }


    public function tagFieldExist($post,$model_tag,$table,$field_name,$field_id)
    {
        if(decrypt($post[$field_id]) != '')
        {
            $chkDupCondition = array('tag'      =>trim($post['tag']),
                                     'tag_item' =>trim($post['tag_item']),
                                     'LOWER('.$field_name.')'=>strtolower($post[$field_name]),
                                      $field_id.' !=' => decrypt($post[$field_id]),
                               );
        } else {
            $chkDupCondition = array('tag'      =>trim($post['tag']),
                                     'tag_item' =>trim($post['tag_item']),
                                     'LOWER('.$field_name.')'=>strtolower($post[$field_name]),
                                );
         }
         //printr($chkDupCondition);exit;
         $chkDup = $this->CI->$model_tag->field_exists($chkDupCondition);
         return $chkDup;
    }

    function getCategories()
    {
        $this->CI->load->model('Category_model');
        $cond      = array('category_status' => '1');
        $links  = $this->CI->Category_model->get_category($cond);
        //printr($links);exit;
        $option = '<option value="">Select One</option>';
         foreach ($links as $key => $value) {
            $sel='';
            $option.= '<option value="'.$value['category_id'].'"  >'.$value['category_name'].'</option>';
            
        }
        return  $option;
    }

    function getAllkeywords($key)
    {
        $this->CI->load->model('Category_model');
        $fields='category_id';
        $cond      = array('category_key' =>$key);
        $category  = $this->CI->Category_model->findById($fields,$cond);
        $cat_id = $category['category_id'];

        $fields='keywords_id,category_keyword';
        $cond      = array('category' =>$cat_id,'keywords_status'=>'1');
        $keywords = $this->CI->Category_model->findCategoryKeys($fields,$cond,'keywords');
        return $keywords;
    }


}

/* End of file library Admin.php */
/* Location: ./application/libraries/Admin.php */
