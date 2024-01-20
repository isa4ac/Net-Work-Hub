<?php
/*
*   Endpoint URL: https://app.networkhub.me/wp-json/v1/job-business-remove
*/

add_action('rest_api_init', function(){

    register_rest_route( 'v1', '/job-business-remove', array(
        'methods' => 'POST',                                 // can be GET, POST, PUT, DELETE
        'callback' => 'func_job_business_remove',             // call back function to do the required task
    ) );

});

/*
$data parameter holds the parameters being passed to the endpoint.
*/
function func_job_business_remove($data) {

    global $clsJobDetails;

    $boolAdded = $clsJobDetails->removeJob( $data['job_id'] );

    return [
        'success' => true,
        'message' => 'Job has been removed'
    ];

}