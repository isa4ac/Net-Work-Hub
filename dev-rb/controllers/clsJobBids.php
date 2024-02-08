<?php

class clsJobBids
{
    public $child_theme             = "dev-rb";
    private $table                  = "job_Bids";

    function __construct() {
        global $wpdb;
        add_action( 'template_redirect', [$this, 'func_template_redirect'] );
    }

    function get_records() {
        global $wpdb;
        return $wpdb->get_results( "SELECT * FROM {$this->table}" );
    }

    function removeJobBid( $id ) {
        global $wpdb;
        return $wpdb->delete( $this->table, [
            "jobBid_Id_PK" => $id
        ] );
    }

    function getJobBids($intUserId) {

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

    function getClosedJobs($jobID) {

        global $wpdb, $clsDefineJobStatus;
        $query = "SELECT * FROM {$this->table} as job_Bids";

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

global $clsJobBids;
$clsJobBids = new clsJobBids();