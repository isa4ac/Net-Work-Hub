<?php
/*
*   Endpoint URL: https://app.networkhub.me/wp-json/v1/user-login
*/

add_action('rest_api_init', function(){

    register_rest_route( 'v1', '/engineer-profile', array(
        'methods' => 'GET',                                 // can be GET, POST, PUT, DELETE
        'callback' => 'func_get_engineer',             // call back function to do the required task
    ) );

    // Pass in: Engineer ID : engID

});

/*
$data parameter holds the parameters being passed to the endpoint.
*/
function func_get_engineer($data) {

    global $clsUserData;

    $objResponse = $clsUserData->getEngineerData( $data['engID']);

    return $objResponse;
}