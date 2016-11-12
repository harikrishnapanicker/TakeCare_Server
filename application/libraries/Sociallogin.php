<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Library Files: Sociallogin Library
|--------------------------------------------------------------------------
|
*/

class Sociallogin{

    // Initilaize when call comes to this class
    function  __construct()
    {

    }


    public function get_fb_appdata($facebook)
    {
        $CI = &get_instance();
        require_once APPPATH.'third_party/facebook/src/facebook.php';
        $CI->facebook = new Facebook(array(
            'appId'  => $facebook['id'],
            'secret' => $facebook['secret'],
        ));
        return true;

    }

    public function get_google_appdata($google)
    {

        $CI = &get_instance();
        require_once APPPATH.'third_party/google-login/src/Google_Client.php';
        require_once APPPATH.'third_party/google-login/src/contrib/Google_Oauth2Service.php';
        $CI->gClient = new Google_Client();
        $CI->gClient->setApplicationName('Travex');
        $CI->gClient->setClientId($google['id']);
        $CI->gClient->setClientSecret($google['secret']);
        $CI->gClient->setRedirectUri(site_url().'User/getGooglePlusDetails');
        $CI->gClient->setDeveloperKey($google['key']);
        $CI->google_oauthV2 = new Google_Oauth2Service($CI->gClient);
        return true;
    }


    public function get_fb_memberdetails()
    {

       $CI = &get_instance();
       $user = $CI->facebook->getUser();
       $data = $CI->facebook->api('/me?fields=id,first_name,email');
       $user_id = $data['id'];
       $profile_pic = "https://graph.facebook.com/$user_id/picture?type=large";
       $data['profile_pic'] = $profile_pic ;
       return $data;


   }


    public function geturl() {
        $CI = &get_instance();
        return $CI->gClient->createAuthUrl();


    }
    public function authenticate($code) {
        $CI = &get_instance();
        $gClient=$CI->gClient;
        $gClient->authenticate($code);
        
        $_SESSION['token'] = $gClient->getAccessToken();
        $gClient->setAccessToken($_SESSION['token']);


    }
     public function getuserdetails()
    {
       $CI = &get_instance();
       return $user = $CI->google_oauthV2->userinfo->get();
    }
       
    
    /**
     * Social Media Login
     */
    
    
     
}







/* End of file library Sociallogin.php */
/* Location: ./application/libraries/Sociallogin.php */
