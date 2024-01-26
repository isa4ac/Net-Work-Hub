<?php
/*
*   Endpoint URL: https://app.networkhub.me/wp-json/v1/job-business-post
*/

add_action('rest_api_init', function(){

    register_rest_route( 'v1', '/job-business-post', array(
        'methods' => 'POST',                                 // can be GET, POST, PUT, DELETE
        'callback' => 'func_job_business_post',             // call back function to do the required task
    ) );

});

/*
$data parameter holds the parameters being passed to the endpoint.
*/
function func_job_business_post($data) {

    global $clsJobDetails, $clsNetworkHub;

    $jobDetail_Id_PK = $clsNetworkHub->generate_uuid("job-detail-");
    
    $boolAdded = $clsJobDetails->addJobDetails([
        "jobDetail_Id_PK" => $jobDetail_Id_PK,
        "jobDetail_Business_UserId_FK" => $data['business_user_id'],
        "jobDetail_Engineer_UserId_FK" => "",
        "jobDetail_Defined_Job_Status_FK" => $data['job_status'],
        "jobDetail_Posted_DT" => date("Y-m-d H:i:s"),
        "jobDetail_Title" => $data['job_title'],
        "jobDetail_Description_from_Business" => $data['job_description'],
        "jobDetail_Description_from_Engineer" => "",
        "jobDetail_Proposal_Target_Budget" => $data['target_budget'],
        "jobDetail_Proposal_Target_Date" => date("Y-m-d H:i:s", strtotime($data['target_date']))
    ]);

    if ($boolAdded)
    {
        return [
            'success' => true,
            'job_id' => $jobDetail_Id_PK
        ];
    }
    else
    {
        return [
            'success' => false,
            'message' => 'Error adding job'
        ];
    }
    
    

}