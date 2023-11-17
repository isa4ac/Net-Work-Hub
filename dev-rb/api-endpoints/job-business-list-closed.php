<?php
/*
*   Endpoint URL: https://app.networkhub.me/wp-json/v1/job-business-list-closed
*/

add_action('rest_api_init', function(){

    register_rest_route( 'v1', '/job-business-list-closed', array(
        'methods' => 'POST',                                 // can be GET, POST, PUT, DELETE
        'callback' => 'func_job_business_list_closed',             // call back function to do the required task
    ) );

});

/*
$data parameter holds the parameters being passed to the endpoint.
*/
function func_job_business_list_closed($data) {

    global $clsJobDetails;
    $arrClosedJobs = $clsJobDetails->getClosedJobs( $data['user_id'] );

    if ($arrClosedJobs)
    {
        $arrReturn = [];

        foreach ($arrClosedJobs as $objClosedJob)
        {
            $jobDetail_Engineer_UserId_FK = "";
            if (!empty($objClosedJob->jobDetail_Engineer_UserId_FK))
            {
                $objUser = get_user_by('ID', $objClosedJob->jobDetail_Engineer_UserId_FK);
                $jobDetail_Engineer_UserId_FK = $objUser->display_name;
            }

            $arrReturn[] = [
                'jobDetail_Id_PK' => $objClosedJob->jobDetail_Id_PK,
                'jobDetail_Engineer_UserId_FK' => $jobDetail_Engineer_UserId_FK,
                'define_Job_Status_Name' => $objClosedJob->define_Job_Status_Name,
                'jobDetail_Posted_DT' => ($objClosedJob->jobDetail_Posted_DT) ? date("d M, Y", strtotime($objClosedJob->jobDetail_Posted_DT)) : '',
                'jobDetail_Title' => $objClosedJob->jobDetail_Title,
                'jobDetail_Proposal_Target_Budget' => $objClosedJob->jobDetail_Proposal_Target_Budget,
                'jobDetail_Proposal_Target_Date' => ($objClosedJob->jobDetail_Proposal_Target_Date) ? date("d M, Y", strtotime($objClosedJob->jobDetail_Proposal_Target_Date)) : '',
                'jobDetail_Proposal_Agreed_Budget' => $objClosedJob->jobDetail_Proposal_Agreed_Budget,
                'jobDetail_Proposal_Agreed_Date' => ($objClosedJob->jobDetail_Proposal_Agreed_Date) ? date("d M, Y", strtotime($objClosedJob->jobDetail_Proposal_Agreed_Date)) : '',
                'jobDetail_Proposal_Final_Budget' => $objClosedJob->jobDetail_Proposal_Final_Budget,
                'jobDetail_Proposal_Final_Date' => ($objClosedJob->jobDetail_Proposal_Final_Date) ? date("d M, Y", strtotime($objClosedJob->jobDetail_Proposal_Final_Date)) : '',
                'jobDetail_is_Accepted_by_Business_Bool' => $objClosedJob->jobDetail_is_Accepted_by_Business_Bool,
                'jobDetail_is_Accepted_by_Business_DT' => ($objClosedJob->jobDetail_is_Accepted_by_Business_DT) ? date("d M, Y", strtotime($objClosedJob->jobDetail_is_Accepted_by_Business_DT)) : '',
                'jobDetail_is_Accepted_by_Engineer_Bool' => $objClosedJob->jobDetail_is_Accepted_by_Engineer_Bool,
                'jobDetail_is_Accepted_by_Engineer_DT' => ($objClosedJob->jobDetail_is_Accepted_by_Engineer_DT) ? date("d M, Y", strtotime($objClosedJob->jobDetail_is_Accepted_by_Engineer_DT)) : ''
            ];
        }

        return [
            'success' => true,
            'data' => $arrReturn
        ];
    }
    else
    {
        return [
            'success' => false,
            'message' => "No closed jobs found"
        ];
    }


    

}