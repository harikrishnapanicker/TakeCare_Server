<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Validation Rule for Each Controller
|--------------------------------------------------------------------------
|
*/
$config = array(
                 'auth' => array(
                                    array(
                                            'field' => 'username',
                                            'label' => 'User Name',
                                            'rules' => 'trim|required'
                                         ),
                                    array(
                                            'field' => 'password',
                                            'label' => 'Password',
                                            'rules' => 'trim|required'
                                         ),                                                          
                                ),

                

               );