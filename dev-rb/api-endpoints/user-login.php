<?php
/*
*   Endpoint URL: https://app.networkhub.me/wp-json/v1/user-login
*/

add_action('rest_api_init', function(){

    register_rest_route( 'v1', '/user-login', array(
        'methods' => 'POST',                                 // can be GET, POST, PUT, DELETE
        'callback' => 'func_user_login',             // call back function to do the required task
    ) );

});

/*
$data parameter holds the parameters being passed to the endpoint.
*/
function func_user_login($data) {

    global $clsUserData;



    $objResponse = $clsUserData->attemptLogin( $data['email'], $data['pw'] );
//    $objResponse = json_decode($objResponse);

    return $objResponse;

//    if ($objResponse->success)
//    {
//        if ($data['flatten'] == 'true') {
//            return $objResponse['user']['data'];
//        } else {
//            return [
//                'success' => true,
//                'user' => $objResponse->user,
//                'username' => $data['username'],
//                'password' => $data['password']
//            ];
//        }
//    }
//    else
//    {
//        return [
//            'success' => false,
//            'message' => $objResponse->message,
//            'username' => $data['username'],
//            'password' => $data['password']
//        ];
//    }
}