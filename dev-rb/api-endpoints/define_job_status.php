<?php
/*
*   Endpoint URL: https://app.networkhub.me/wp-json/v1/job_status/get
*/

add_action('rest_api_init', function(){

    register_rest_route( 'v1', '/job_status/get', array(
        'methods' => 'GET',                                 // can be GET, POST, PUT, DELETE
        'callback' => 'func_get_job_status',             // call back function to do the required task
    ) );

});

/*
$data parameter holds the parameters being passed to the endpoint.
*/
function func_get_job_status($data) {

    global $clsDefineJobStatus;
    $arrJobStatus = $clsDefineJobStatus->get_records();


    # return response in json;
    return [
        'success' => true,
        'data' => $arrJobStatus
    ];

}