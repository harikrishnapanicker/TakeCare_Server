<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Library Files: Admin Library
|--------------------------------------------------------------------------
|
*/
class Admin{

    // Initilaize when call comes to this class
    function  __construct()
    {
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
        if( $this->CI->session->has_userdata()  ){ 
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
    function getCategoryLinkModules($module='',$flag){
            $cat_array =array();
            $cat_array['nightlife']  = array('hotel');
            $cat_array['shopping']   = array('shop_mall','shop_souq','hotel','airline_terminal');
            $cat_array['spa']        = array('shop_mall','hotel','airline_terminal');
            $cat_array['thingstodo'] = array('shop_mall','hotel','nightlife');
            $cat_array['eatingout']  = array('shop_mall','hotel','shop_souq','airline_terminal');
            $cat_array['events']     = array('airline','embassy','travel','eatingout','hotel','nightlife','spa','shopping');
            $cat_array['travel']  = array('airline_terminal','shop_mall','hotel');
            $cat_array['moneyexchange']  = array('airline_terminal','shop_mall');
            $cat_array['rental']  = array('airline_terminal');

            $cond      = array('status' => 1);
            $this->CI->load->model('Category_model');
            $links     = $this->CI->Category_model->get_category_links($cond);
            if(isset($flag) && $flag="update"){
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
        $fields = 'hotels.hotels_title,hotels.hotels_id,hotels.hotels_address';
        $hotel_details = $this->CI->hotel->findByIdJoin($fields,$con);
        if(!empty($hotel_details )) {
            $tag      = $this->CI->config->item(strtolower(trim($row['Located At'])));
            $tag_item = $hotel_details['hotels_id'];
            $tag_address = $hotel_details['hotels_address'];
            $hotel=array('tag'=>$tag,'tag_item'=> $tag_item,'tag_address'=>$tag_address);
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
        $fields = 'shopping.shopping_name,shopping.shopping_id,shopping.shopping_address';
        $mall_details = $this->CI->shopping->findByIdJoin($fields,$con);        
        if(!empty($mall_details )) {
            $tag      = $this->CI->config->item(strtolower(trim($row['Located At'])));
            $tag_item = $mall_details['shopping_id'];
            $tag_address = $mall_details['shopping_address'];
            $mall=array('tag'=>$tag,'tag_item'=> $tag_item,'tag_address'=>$tag_address);
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
        $fields = 'shopping.shopping_name,shopping.shopping_id,shopping.shopping_address';
        $souq_details = $this->CI->shopping->findByIdJoin($fields,$con);
        if(!empty($souq_details )) {
            $tag      = $this->CI->config->item(strtolower(trim($row['Located At'])));
            $tag_item = $souq_details['shopping_id'];
            $tag_address = $souq_details['shopping_address'];
            $souq=array('tag'=>$tag,'tag_item'=> $tag_item,'tag_address'=>$tag_address);
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
        $fields = 'terminals.terminals_title,terminals.terminals_id,terminals.terminals_address';
        $terminal_details = $this->CI->terminal->findByIdJoin($fields,$con);
        if(!empty($terminal_details )) {
            $tag      = $this->CI->config->item(strtolower(trim($row['Located At'])));
            $tag_item = $terminal_details['terminals_id'];
            $tag_address = $terminal_details['terminals_address'];
            $terminal=array('tag'=>$tag,'tag_item'=> $tag_item,'tag_address'=>$tag_address);
        }
        return $terminal;
    }


    public function findNightTag($row,$area)
    {
        $night = array();
        $con = array('LOWER(night_life_name)'=>strtolower(trim($row['Tag To'])),
                      'night_life_area'=> $area,
                      'night_life_status'=>'1'
                  ); 
        $fields = 'night_life_name,night_life_id,night_life_address';
        $night_details = $this->CI->nightlife->findById($con);
        if(!empty($night_details )) {
            $tag         = $this->CI->config->item(strtolower(trim($row['Located At'])));
            $tag_item    = $night_details['night_life_id'];
            $tag_address = $night_details['night_life_address'];
            $night=array('tag'=>$tag,'tag_item'=> $tag_item,'tag_address'=>$tag_address);
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
            $night=array('tag'=>$tag,'tag_item'=> $tag_item,'tag_address'=>$tag_address);
        }
        return $night;
    }

    public function checkFieldExists($post,$model_tag,$table,$field_name,$field_id)
    {
      if(decrypt($post[$field_id]) != '')
      {
         $chkDupCondition = array('latitude'=>trim($post['latitude']),
                                  'longitude'=>trim($post['longitude']),
                                  'LOWER('.$field_name.')'=>strtolower($post[$field_name]),
                                  $field_id.' !=' => decrypt($post[$field_id]),
                            );
       } else {
           $chkDupCondition = array('latitude'=>trim($post['latitude']),
                               'longitude'=>trim($post['longitude']),
                               'LOWER('.$field_name.')'=>strtolower($post[$field_name]),
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
	
	 
}

/* End of file library Admin.php */
/* Location: ./application/libraries/Admin.php */
