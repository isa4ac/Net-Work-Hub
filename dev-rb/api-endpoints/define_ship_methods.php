<?php
/*
*   Endpoint URL: https://app.networkhub.me/wp-json/v1/ship_methods/get
*/

add_action('rest_api_init', function(){

    register_rest_route( 'v1', '/ship_methods/get', array(
        'methods' => 'GET',                                 // can be GET, POST, PUT, DELETE
        'callback' => 'func_get_ship_methods',             // call back function to do the required task
    ) );

});

/*
$data parameter holds the parameters being passed to the endpoint.
*/
function func_get_ship_methods($data) {

    global $clsDefineShipMethods;
    $arrShipMethods = $clsDefineShipMethods->get_records();


    # return response in json;
    return [
        'success' => true,
        'data' => $arrShipMethods
    ];

}