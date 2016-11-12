<?php
function call_data($method , $uri ,$data)
{
    $CI =& get_instance();
    // Set config options (only 'server' is required to work)

    $server = base_url();

    if(isset($data['api_key'])){
        $api_key = $data['api_key'];
    }
    else{
        $result = file_get_contents($server.'authenticate_api/defaultkey');
        $default_key = json_decode($result, true);
        $api_key = $default_key['result']['key'];
    }

    //$api_key = '298b26c2128e407fde40b27125f7df904e8ff924';


    $config = array('server' => $server,
        'api_key' => $api_key,
        'api_name' => 'X-API-KEY',
        //'http_user'       => 'username',
        //'http_pass'       => 'password',
        //'http_auth'       => 'basic',
        //'ssl_verify_peer' => TRUE,
        //'ssl_cainfo'      => '/certs/cert.pem'
    );

    $CI->rest->initialize($config);

    // set format you sending data
    $CI->rest->format('application/json');

    // send your param data to given url using this

    if ($method == 'get' || $method == 'delete') {

        /*$result = $CI->rest->get($uri);

        var_dump($result) ;

        echo "<br>". $CI->rest->debug(); exit;*/

        //$result = $CI->rest->{$method}($uri);

        //$result = file_get_contents($server.$uri);


        $opts = array('http' =>
            array(
                'method'  => strtoupper($method),
                'header'  => 'Content-type: application/json',
                'header'  => 'X-API-KEY: '.$api_key,
            )
        );

        $result = $CI->rest->{$method}($uri);
        //$context  = stream_context_create($opts);
        //$content = @file_get_contents($server.$uri, false, $context);

       /* if (strpos($http_response_header[0], "200")) {
            //echo "SUCCESS";
            $result = $content;
        } else {
            $message = array("message"=>"No results found!");
            $result = array('status'=>0 , 'result'=>$message);
        }*/

        //exit;

        //print_r($result) ; exit;
    }
    elseif ($method == 'post' || $method == 'put') {

        $params = json_encode($data['params']);

        $result = $CI->rest->{$method}($uri, $params);
    }

    //print_r($result); exit;

    if (is_array($result)) {
        //converting json results to array
        return($result);
    }
    elseif(is_object($result)) {
        $result = json_decode(json_encode($result), true);
        return($result);
    }
    else{
        $result = json_decode($result, true);
        return($result);
    }
}