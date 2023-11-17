<?php
class clsJobDetails
{
    public $child_theme             = "dev-rb";
    private $table                  = "job_Details";
    
    function __construct() {
        
        global $wpdb;

        //add_action( 'admin_menu', [$this, 'func_admin_menu'], 20, 1 );
        //add_action( 'admin_init', [$this, 'func_admin_init'] );

        add_action( 'template_redirect', [$this, 'func_template_redirect'] );
        
    }

    function func_template_redirect() {

        # Post Job form submission;
        if (isset($_POST['sbtAddJob']))
        {
            global $clsNetworkHub, $post;

            $jobDetail_Id_PK = $clsNetworkHub->generate_uuid("job-detail-");

            $this->addJobDetails([
                "jobDetail_Id_PK" => $jobDetail_Id_PK,
                "jobDetail_Business_UserId_FK" => $_POST['jobDetail_Business_UserId_FK'],
                "jobDetail_Engineer_UserId_FK" => $_POST['jobDetail_Engineer_UserId_FK'],
                "jobDetail_Defined_Job_Status_FK" => $_POST['jobDetail_Defined_Job_Status_FK'],
                "jobDetail_Posted_DT" => date("Y-m-d H:i:s"),
                "jobDetail_Title" => $_POST['jobDetail_Title'],
                "jobDetail_Description_from_Business" => $_POST['jobDetail_Description_from_Business'],
                "jobDetail_Description_from_Engineer" => $_POST['jobDetail_Description_from_Engineer'],
                "jobDetail_Proposal_Target_Budget" => $_POST['jobDetail_Proposal_Target_Budget'],
                "jobDetail_Proposal_Target_Date" => $_POST['jobDetail_Proposal_Target_Date']
            ]);

            wp_redirect( add_query_arg(['added'=>1], get_permalink($post->ID)) );
            exit;
        }

    }

    function get_records() {
        global $wpdb;
        return $wpdb->get_results( "SELECT * FROM {$this->table}" );
    }

    function addJobDetails( $data ) {
        global $wpdb;
        $wpdb->insert( $this->table, $data );

        return true;
    }

    function getActiveJobs($intUserId) {

        global $wpdb, $clsDefineJobStatus;
        $query = "SELECT * FROM {$this->table} AS job_info "
        . "LEFT JOIN {$clsDefineJobStatus->getTable()} AS job_status ON job_info.jobDetail_Defined_Job_Status_FK = job_status.define_Job_Status_Id_PK "
        . "WHERE job_info.jobDetail_Business_UserId_FK = '%s' AND 
        job_info.jobDetail_is_Finished_by_Business_Bool = 0 AND 
        job_info.jobDetail_is_Finished_by_Engineer_Bool = 0";

        return $wpdb->get_results(
            $wpdb->prepare($query, [$intUserId])
        );
    }

    function getClosedJobs($intUserId) {

        global $wpdb, $clsDefineJobStatus;
        $query = "SELECT * FROM {$this->table} AS job_info "
        . "LEFT JOIN {$clsDefineJobStatus->getTable()} AS job_status ON job_info.jobDetail_Defined_Job_Status_FK = job_status.define_Job_Status_Id_PK "
        . "WHERE job_info.jobDetail_Business_UserId_FK = '%s' AND 
        job_info.jobDetail_is_Finished_by_Business_Bool = 1 AND 
        job_info.jobDetail_is_Finished_by_Engineer_Bool = 1";

        return $wpdb->get_results(
            $wpdb->prepare($query, [$intUserId])
        );
    }

    function getJobsEngineerAvailable() {

        global $wpdb, $clsDefineJobStatus;
        $query = "SELECT * FROM {$this->table} AS job_info "
        . "LEFT JOIN {$clsDefineJobStatus->getTable()} AS job_status ON job_info.jobDetail_Defined_Job_Status_FK = job_status.define_Job_Status_Id_PK "
        . "WHERE  
                (job_info.jobDetail_is_Accepted_by_Business_Bool = 0 AND job_info.jobDetail_is_Accepted_by_Engineer_Bool = 0) 
            OR 
                (job_info.jobDetail_is_Finished_by_Business_Bool = 0 AND job_info.jobDetail_is_Finished_by_Engineer_Bool = 0) 
            ";

        return $wpdb->get_results(
            $wpdb->prepare($query)
        );
    }

    function getJobsEngineerInprogress( $intUserId ) {

        global $wpdb, $clsDefineJobStatus;
        $query = "SELECT * FROM {$this->table} AS job_info "
        . "LEFT JOIN {$clsDefineJobStatus->getTable()} AS job_status ON job_info.jobDetail_Defined_Job_Status_FK = job_status.define_Job_Status_Id_PK "
        . "WHERE  
            job_info.jobDetail_Engineer_UserId_FK = '%s' AND
            job_info.jobDetail_is_Accepted_by_Business_Bool = 1 AND job_info.jobDetail_is_Accepted_by_Engineer_Bool = 1 
            ";

        return $wpdb->get_results(
            $wpdb->prepare($query, [$intUserId])
        );
    }

    function getJobsEngineerFinished( $intUserId ) {

        global $wpdb, $clsDefineJobStatus;
        $query = "SELECT * FROM {$this->table} AS job_info "
        . "LEFT JOIN {$clsDefineJobStatus->getTable()} AS job_status ON job_info.jobDetail_Defined_Job_Status_FK = job_status.define_Job_Status_Id_PK "
        . "WHERE  
            job_info.jobDetail_Engineer_UserId_FK = '%s' AND
            job_info.jobDetail_is_Finished_by_Business_Bool = 1 AND job_info.jobDetail_is_Finished_by_Engineer_Bool = 1 
            ";

        return $wpdb->get_results(
            $wpdb->prepare($query, [$intUserId])
        );
    }

}

global $clsJobDetails;
$clsJobDetails = new clsJobDetails();