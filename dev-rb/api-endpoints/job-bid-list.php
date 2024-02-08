    <?php
/*
*   Endpoint URL: https://app.networkhub.me/wp-json/v1/job-business-list-active
*/

add_action('rest_api_init', function(){

    register_rest_route( 'v1', '/job-business-list-active', array(
        'methods' => 'POST',                                 // can be GET, POST, PUT, DELETE
        'callback' => 'func_job_business_list_active',             // call back function to do the required task
    ) );

});

/*
$data parameter holds the parameters being passed to the endpoint.
*/
function func_job_business_list_active($data) {

    global $clsJobDetails;
    $arrActiveJobs = $clsJobDetails->getActiveJobs( $data['user_id'] );

    if ($arrActiveJobs)
    {
        $arrReturn = [];

        foreach ($arrActiveJobs as $objActiveJob)
        {
            $jobDetail_Engineer_UserId_FK = "";
            if (!empty($objActiveJob->jobDetail_Engineer_UserId_FK))
            {
                $objUser = get_user_by('ID', $objActiveJob->jobDetail_Engineer_UserId_FK);
                $jobDetail_Engineer_UserId_FK = $objUser->display_name;
            }

            // do not want to return 'null'
            if(is_null($objActiveJob->jobDetail_Proposal_Target_Budget) || empty($objActiveJob->jobDetail_Proposal_Target_Budget)){
                $objActiveJob->jobDetail_Proposal_Target_Budget = "0";
            }

            if(is_null($objActiveJob->jobDetail_Proposal_Agreed_Budget) || empty($objActiveJob->jobDetail_Proposal_Agreed_Budget)){
                $objActiveJob->jobDetail_Proposal_Agreed_Budget = "0";
            }

            if(is_null($objActiveJob->jobDetail_Proposal_Final_Budget) || empty($objActiveJob -> jobDetail_Proposal_Final_Budget)){
                $objActiveJob->jobDetail_Proposal_Final_Budget = "0";
            }

            $arrReturn[] = [
                'jobDetail_Id_PK' => $objActiveJob->jobDetail_Id_PK,
                'jobDetail_Engineer_UserId_FK' => $jobDetail_Engineer_UserId_FK,
                'define_Job_Status_Name' => $objActiveJob->define_Job_Status_Name,
                'jobDetail_Posted_DT' => ($objActiveJob->jobDetail_Posted_DT) ? date("d M, Y", strtotime($objActiveJob->jobDetail_Posted_DT)) : '',
                'jobDetail_Title' => $objActiveJob->jobDetail_Title,
                'jobDetail_Description' => $objActiveJob->jobDetail_Description_from_Business,
                'jobDetail_Proposal_Target_Budget' => $objActiveJob->jobDetail_Proposal_Target_Budget,
                'jobDetail_Proposal_Target_Date' => ($objActiveJob->jobDetail_Proposal_Target_Date) ? date("d M, Y", strtotime($objActiveJob->jobDetail_Proposal_Target_Date)) : '',
                'jobDetail_Proposal_Agreed_Budget' => $objActiveJob->jobDetail_Proposal_Agreed_Budget,
                'jobDetail_Proposal_Agreed_Date' => ($objActiveJob->jobDetail_Proposal_Agreed_Date) ? date("d M, Y", strtotime($objActiveJob->jobDetail_Proposal_Agreed_Date)) : '',
                'jobDetail_Proposal_Final_Budget' => $objActiveJob->jobDetail_Proposal_Final_Budget,
                'jobDetail_Proposal_Final_Date' => ($objActiveJob->jobDetail_Proposal_Final_Date) ? date("d M, Y", strtotime($objActiveJob->jobDetail_Proposal_Final_Date)) : '',
                'jobDetail_is_Accepted_by_Business_Bool' => $objActiveJob->jobDetail_is_Accepted_by_Business_Bool,
                'jobDetail_is_Accepted_by_Business_DT' => ($objActiveJob->jobDetail_is_Accepted_by_Business_DT) ? date("d M, Y", strtotime($objActiveJob->jobDetail_is_Accepted_by_Business_DT)) : '',
                'jobDetail_is_Accepted_by_Engineer_Bool' => $objActiveJob->jobDetail_is_Accepted_by_Engineer_Bool,
                'jobDetail_is_Accepted_by_Engineer_DT' => ($objActiveJob->jobDetail_is_Accepted_by_Engineer_DT) ? date("d M, Y", strtotime($objActiveJob->jobDetail_is_Accepted_by_Engineer_DT)) : ''
            ];
        }

        if ($data['flatten'] == 'true') {
            return $arrReturn;
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
            'message' => "No active jobs found"
        ];
    }
}