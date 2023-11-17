<?php
/*
*   Endpoint URL: https://app.networkhub.me/wp-json/v1/job-engineer-list-finished
*/

add_action('rest_api_init', function(){

    register_rest_route( 'v1', '/job-engineer-list-finished', array(
        'methods' => 'POST',                                 // can be GET, POST, PUT, DELETE
        'callback' => 'func_job_engineer_list_finished',             // call back function to do the required task
    ) );

});

/*
$data parameter holds the parameters being passed to the endpoint.
*/
function func_job_engineer_list_finished($data) {

    global $clsJobDetails, $clsUserData;
    $arrJobsEngineerFinished = $clsJobDetails->getJobsEngineerFinished( $data['user_id'] );

    if ($arrJobsEngineerFinished)
    {
        $arrReturn = [];

        foreach ($arrJobsEngineerFinished as $objJob)
        {
            $userData_Name_Business = "";
            if (!empty($objJob->jobDetail_Business_UserId_FK))
            {
                $objUser = $clsUserData->getUserDataByWPUserId($objJob->jobDetail_Business_UserId_FK);
                $userData_Name_Business = $objUser->userData_Name_Business;
            }

            $arrReturn[] = [
                'jobDetail_Id_PK' => $objJob->jobDetail_Id_PK,
                'userData_Name_Business' => $userData_Name_Business,
                'jobDetail_Title' => $objJob->jobDetail_Title,
                'jobDetail_Posted_DT' => ($objJob->jobDetail_Posted_DT) ? date("d M, Y", strtotime($objJob->jobDetail_Posted_DT)) : '',
                'jobDetail_Proposal_Target_Budget' => $objJob->jobDetail_Proposal_Target_Budget,
                'jobDetail_Proposal_Target_Date' => ($objJob->jobDetail_Proposal_Target_Date) ? date("d M, Y", strtotime($objJob->jobDetail_Proposal_Target_Date)) : '',
                'jobDetail_Proposal_Agreed_Budget' => $objJob->jobDetail_Proposal_Agreed_Budget,
                'jobDetail_Proposal_Agreed_Date' => ($objJob->jobDetail_Proposal_Agreed_Date) ? date("d M, Y", strtotime($objJob->jobDetail_Proposal_Agreed_Date)) : '',
                'jobDetail_Proposal_Final_Budget' => $objJob->jobDetail_Proposal_Final_Budget,
                'jobDetail_Proposal_Final_Date' => ($objJob->jobDetail_Proposal_Final_Date) ? date("d M, Y", strtotime($objJob->jobDetail_Proposal_Final_Date)) : ''
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
            'message' => "No finished jobs found"
        ];
    }


    

}