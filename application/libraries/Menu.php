<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Library Files: Menu Library
|--------------------------------------------------------------------------
|
*/

class Menu{

	public  $dashboard='', $city='', $area='', $user='', $member='', $group='', $settings='', $permission='',
     $cms='', $prototype='', $etemplate='', $newsletter='', $subscriber='', $embassies='', 
     $articles='', $tourandtravel='', $moneyexchangers='', $carrentals='', $eatingout='',
     $thingstodo='',$nightlife='',$hotels='', $aminities='', $freebies='',$airlines='', $terminals='',$airports='',$types='',
     $spa='',$spa_type='',$shop='',$shop_cat='',$shop_loc='',$eat_cuisine = '',
     $eat_est='',$night_cat='',$night_spec='',$night_door='',$things_cat='',$event='',
     $event_cat='',$ticket_cat='',$ticket_cost='' ,$business = '' ,$business_category = '' ,$emergencies = '',$emergency_category= '',  
     $realestate = '' , $realestate_developer = '' ,$realestate_agent = '', $project_status = '', $project_purpose='',
     $realestate_project = '',$keyword ='',$keywordtag = '',$advertise ='',$advertisetag ='',$essentials='',$tips='', $ordersettings='',$review='',$profile='',$magazine='',$my_story='',$report_airline='',$report_hotel='',$report_spa='',$report_shopping='',$report_embassies='',$report_tourandtravel='',$report_moneyexchanger='',$report_carrental='',$report_nightlife='',$report_thingstodo='',$report_eatingout='',$report_event='',$report_real_estate='',$report_business='',$report_emergencies='',$article_report='',$keyword_report='';

    public $city_permission, $area_permission,$user_permission,   
           $airline_permission='', $hotel_permission='',$spa_permission='',
           $shopping_permission='',$embassy_permission='', $travel_permission='', 
           $money_permission='', $rental_permission='',$nightlife_permission='',
           $todo_permission ='',$eatingout_permission ='',$event_permission ='',
           $realestate_permission ='', $business_permission ='',$emergency_permission ='',
           $keyword_permission ='',$advertisement_permission ='',$article_permission ='',
           $tips_permission='',$essentials_permission='',$review_permission='',$cms_permission='',
           $question_permission='',$etemplate_permission='',$newsletter_permission='',
           $subscriber_permission='',$ordersettings_permission='',$profile_permission='',
           $settings_permission='';

    public $user_areas = array(),$user_categories=array();

	public function __construct() {
		$url = current_url(); 
		$url_array = explode('/', $url); 
        
		
		if (in_array('dashboard', $url_array)) { 
            $this->dashboard = 'active';
        }elseif (in_array('city', $url_array)) {
            $this->city = 'active';    
        }elseif (in_array('area', $url_array)) {
            $this->area = 'active';    
        }elseif (in_array('group', $url_array)) {
            $this->group = 'active';    
        }elseif (in_array('member', $url_array)) {
            $this->member = 'active';    
        }elseif (in_array('settings', $url_array)) {           
            if(in_array('order_settings', $url_array)){
                $this->ordersettings = 'active'; 
            }else{
                $this->settings = 'active';  
            }     
        }elseif (in_array('user', $url_array)) {
            if(in_array('permission', $url_array)){
                $this->permission = 'active'; 
            }else{
                $this->user = 'active';  
            }       	  
        }elseif (in_array('cms', $url_array)) {
            $this->cms = 'active';    
        }elseif (in_array('review', $url_array)) {
            $this->review = 'active';    
        }elseif (in_array('profile', $url_array)) {
            $this->profile = 'active';    
        }elseif (in_array('my_story', $url_array)) {
            $this->my_story = 'active';    
        }
        elseif (in_array('prototype', $url_array)) {
            $this->prototype = 'active';    
        }elseif (in_array('etemplate', $url_array)) {
            $this->etemplate = 'active';    
        }elseif (in_array('newsletter', $url_array)) {
            if(in_array('subscriber', $url_array)){
                $this->subscriber = 'active';
            }else{
                $this->newsletter = 'active';
            }  
        }elseif (in_array('embassies', $url_array)) {
            $this->embassies = 'active';    
        }elseif (in_array('articles', $url_array)) {
            $this->articles = 'active';    
        }elseif (in_array('magazine', $url_array)) {
            $this->magazine = 'active';    
        }elseif (in_array('nightlife', $url_array)) {
            if(in_array('night_specialities', $url_array)){
                $this->night_spec = 'active';
            }elseif(in_array('night_categories', $url_array)){
                $this->night_cat = 'active';
            }elseif(in_array('night_door_policies', $url_array)){
                $this->night_door = 'active';
            }else{
                $this->nightlife = 'active';  
            } 
             
        }elseif (in_array('tourandtravel', $url_array)) {
            $this->tourandtravel = 'active';    
        }elseif (in_array('moneyexchangers', $url_array)) {
            $this->moneyexchangers = 'active';    
        }elseif (in_array('carrentals', $url_array)) {
            $this->carrentals = 'active';    
        }elseif (in_array('eatingout', $url_array)) { 
            if(in_array('eating_establishments', $url_array)){
                $this->eat_est = 'active';
            }elseif(in_array('eating_cuisine', $url_array)){
                $this->eat_cuisine = 'active';
            }else{
                $this->eatingout = 'active';
            } 
        }elseif (in_array('thingstodo', $url_array)) {
             
            if(in_array('things_category', $url_array)){
                $this->things_cat = 'active';
            }else{
                $this->thingstodo = 'active'; 
            }          
        }elseif (in_array('nightlife', $url_array)) {
            $this->nightlife = 'active';
           
        }elseif (in_array('spa', $url_array)) {
            if (in_array('spa_types', $url_array)) {
                $this->spa_type = 'active';
            }else{
                $this->spa = 'active';
            }     
            
        }elseif (in_array('airlines', $url_array)) {
            if(in_array('terminals', $url_array)){
                $this->terminals = 'active';
            }
            elseif(in_array('airports', $url_array)){
                $this->airports = 'active';
                
            }else{
                $this->airlines = 'active';
            }  
        }elseif (in_array('hotels', $url_array)) {
            if(in_array('aminities', $url_array)){
                $this->aminities = 'active';
            }elseif(in_array('freebies', $url_array)){
                $this->freebies = 'active';
            }elseif(in_array('types', $url_array)){
                $this->types = 'active';
            }else{
                $this->hotels = 'active';
            }  
        }elseif (in_array('keywords', $url_array)) {
            if(in_array('keywords_tag', $url_array)){
                $this->keywordtag = 'active';
            }else{
                $this->keyword = 'active';
            }  
        }elseif (in_array('advertisement', $url_array)) {
            if(in_array('advertisement_tag', $url_array)){
                $this->advertisetag = 'active';
            }else{
                $this->advertise = 'active';
            }  
        }elseif (in_array('shopping', $url_array)) {
            if(in_array('shopping_category', $url_array)){
                $this->shop_cat = 'active';
            }elseif(in_array('shopping_location', $url_array)){
                $this->shop_loc = 'active';
            }else{
                $this->shop = 'active';
            }
        }elseif (in_array('events', $url_array)) {
            if(in_array('ticket_cost', $url_array)){
                $this->ticket_cost = 'active';
            }elseif(in_array('event_category', $url_array)){
                $this->event_cat = 'active';
            }elseif(in_array('tickets_category', $url_array)){
                $this->ticket_cat = 'active';
            }else{
                $this->event = 'active';  
            } 
             
        }
       
        elseif (in_array('emergencies', $url_array)) {
             
            if(in_array('emergency_category', $url_array)){
                $this->emergency_category = 'active';
            }else{
                $this->emergencies = 'active'; 
            }  
        }
        elseif (in_array('business', $url_array)) {
            if(in_array('business_category', $url_array)){
                $this->business_category = 'active'; 
            }else{
                 $this->business = 'active';  
            }
             
        }
        elseif (in_array('realestate', $url_array)) {
            if(in_array('realestate_developer', $url_array)){
                $this->realestate_developer = 'active';
            }elseif(in_array('project_purpose', $url_array)){
                $this->project_purpose = 'active';
            }elseif(in_array('project_status', $url_array)){
                $this->project_status = 'active';
            }elseif(in_array('realestate_agent', $url_array)){
                $this->realestate_agent = 'active';
            }elseif(in_array('realestate_project', $url_array)){
                $this->realestate_project = 'active';
            }else{
                $this->realestate = 'active';  
            } 
             
        }
        elseif (in_array('tips', $url_array)) {
            $this->tips = 'active';
        }
         elseif (in_array('essentials', $url_array)) {
            $this->essentials = 'active';
        }

        elseif (in_array('report', $url_array)) {
            if(in_array('airline', $url_array)){
                $this->report_airline = 'active';
            }elseif(in_array('hotel', $url_array)){
                $this->report_hotel = 'active';
            }elseif(in_array('spa_report', $url_array)){
                $this->report_spa = 'active';
            }elseif(in_array('shopping_report', $url_array)){
                $this->report_shopping = 'active';
            }elseif(in_array('embassies_report', $url_array)){
                $this->report_embassies = 'active';
            }elseif(in_array('tourandtravel_report', $url_array)){
                $this->report_tourandtravel = 'active';
            }elseif(in_array('moneyexchanger', $url_array)){
                $this->report_moneyexchanger = 'active';
            }elseif(in_array('carrental', $url_array)){
                $this->report_carrental = 'active';
            }elseif(in_array('nightlife_report', $url_array)){
                $this->report_nightlife = 'active';
            }elseif(in_array('thingstodo_report', $url_array)){
                $this->report_thingstodo = 'active';
            }elseif(in_array('eatingout_report', $url_array)){
                $this->report_eatingout = 'active';
            }elseif(in_array('event', $url_array)){
                $this->report_event = 'active';
            }elseif(in_array('real_estate', $url_array)){
                $this->report_real_estate = 'active';
            }elseif(in_array('business_report', $url_array)){
                $this->report_business = 'active';
            }elseif(in_array('emergencies_report', $url_array)){
                $this->report_emergencies = 'active';
            }elseif(in_array('keyword_report', $url_array)){
                $this->keyword_report = 'active';
            }elseif(in_array('article_report', $url_array)){
                $this->article_report = 'active';
            }else{
                $this->event = 'active';  
            } 
             
        }


        $this->CI = &get_instance(); 
        if($this->CI->session->has_userdata('group_id') && $this->CI->session->userdata('group_id') !='' ){
            $groupID = $this->CI->session->userdata('group_id');
            $condition=array("permissions_group_id"=>$groupID);
            $fields="permissions.*,modules.modules_name";
            $permissions_details = $this->CI->login->getPermission($condition,$fields);
            $permission= array();
            foreach ($permissions_details as $key => $val) {
                $permission[$val['modules_name']]['create']  = $val['permissions_create'];
                $permission[$val['modules_name']]['read']    = $val['permissions_read'];
                $permission[$val['modules_name']]['update']  = $val['permissions_update'];
                $permission[$val['modules_name']]['delete']  = $val['permissions_delete'];
                $permission[$val['modules_name']]['import']  = $val['permissions_import'];
                $permission[$val['modules_name']]['export']  = $val['permissions_export'];                            
            }
            foreach ($permission as $key => $value) {                
                if($key == 'city') {
                    $this->city_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->city_permission['status']=1;
                    }
                }else if($key == 'area') {
                    $this->area_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->area_permission['status']=1;
                    }
                }else if($key == 'user') {
                    $this->user_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->user_permission['status']=1;
                    }
                }else if($key == 'airline') {
                    $this->airline_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->airline_permission['status']=1;
                    }
                }else if($key == 'hotel') {
                    $this->hotel_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->hotel_permission['status']=1;
                    }
                }else if($key == 'spa') {
                    $this->spa_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->spa_permission['status']=1;
                    }
                }else if($key == 'shopping') {
                    $this->shopping_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->shopping_permission['status']=1;
                    }
                }else if($key == 'embassy') {
                    $this->embassy_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->embassy_permission['status']=1;
                    }
                }else if($key == 'travel') {
                    $this->travel_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->travel_permission['status']=1;
                    }
                }else if($key == 'moneyexchange') {
                    $this->money_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->money_permission['status']=1;
                    }
                }else if($key == 'rental') {
                    $this->rental_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->rental_permission['status']=1;
                    }
                }else if($key == 'nightlife') {
                    $this->nightlife_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->nightlife_permission['status']=1;
                    }
                }else if($key == 'todo') {
                    $this->todo_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->todo_permission['status']=1;
                    }
                }else if($key == 'eatingout') {
                    $this->eatingout_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->eatingout_permission['status']=1;
                    }
                }else if($key == 'event') {
                    $this->event_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->event_permission['status']=1;
                    }
                }else if($key == 'realestate') {
                    $this->realestate_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->realestate_permission['status']=1;
                    }
                }else if($key == 'business') {
                    $this->business_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->business_permission['status']=1;
                    }
                }else if($key == 'emergency') {
                    $this->emergency_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->emergency_permission['status']=1;
                    }
                }else if($key == 'keyword') {
                    $this->keyword_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->keyword_permission['status']=1;
                    }
                }else if($key == 'advertisement') {
                    $this->advertisement_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->advertisement_permission['status']=1;
                    }
                }else if($key == 'article') {
                    $this->article_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->article_permission['status']=1;
                    }
                }else if($key == 'tips') {
                    $this->tips_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->tips_permission['status']=1;
                    }
                }else if($key == 'essentials') {
                    $this->essentials_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->essentials_permission['status']=1;
                    }
                }else if($key == 'review') {
                    $this->review_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->review_permission['status']=1;
                    }
                }else if($key == 'cms') {
                    $this->cms_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->cms_permission['status']=1;
                    }
                }else if($key == 'question') {
                    $this->question_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->question_permission['status']=1;
                    }
                }else if($key == 'etemplate') {
                    $this->etemplate_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->etemplate_permission['status']=1;
                    }
                }else if($key == 'newsletter') {
                    $this->newsletter_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->newsletter_permission['status']=1;
                    }
                }else if($key == 'subscriber') {
                    $this->subscriber_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->subscriber_permission['status']=1;
                    }
                }else if($key == 'ordersettings') {
                    $this->ordersettings_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->ordersettings_permission['status']=1;
                    }
                }else if($key == 'profile') {
                    $this->profile_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->profile_permission['status']=1;
                    }
                }else if($key == 'settings') {
                    $this->settings_permission = $permission[$key];
                    if(in_array(1, $value)){
                        $this->settings_permission['status']=1;
                    }
                }
              
            }
                    // For data Agents
                        
                        if($this->CI->session->has_userdata('group_name') && ($this->CI->session->userdata('group_name') == 'dataAgent' || $this->CI->session->userdata('group_name') == '3') ){
                            $this->CI->load->model('user/Usersarea_model','usersarea');
                            $this->CI->load->model('user/Userscategory_model','userscategory'); 
                            $area = array();
                            $cats = array();
                            $loginID = getLoginID();
                            $areacond =  array('users_area_user_id'=>$loginID,'users_area_status'=>'1');
                            $usersarea = $this->CI->usersarea->findAllByJoin('users_area.*',$areacond);
                            
                            foreach ($usersarea as $uakey => $uavalue) {
                                array_push($area, $uavalue['area_id']);
                            }
                            $catcond =  array('users_category_user_id'=>$loginID,'users_category_status'=>'1');
                            $userscategory = $this->CI->userscategory->findAllByJoin('users_category.*,category.category_key',$catcond);
                            
                            foreach ($userscategory as $uckey => $ucvalue) {
                                array_push($cats, $ucvalue['category_key']);
                            }
                            $this->user_areas = $area;
                            $this->user_categories = $cats;
                        }
            //printr($this->review_permission); exit;
        }


	}
}

/* End of file library Menu.php */
/* Location: ./application/libraries/Menu.php */
