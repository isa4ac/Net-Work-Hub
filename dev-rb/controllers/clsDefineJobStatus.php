<?php
class clsDefineJobStatus
{
    public $child_theme             = "dev-rb";
    private $table                  = "define_Job_Status";
    
    function __construct() {
        
        global $wpdb;

        add_action( 'admin_menu', [$this, 'func_admin_menu'], 20, 1 );
        add_action( 'admin_init', [$this, 'func_admin_init'] );
        
    }

    function getTable() {
        return $this->table;
    }

    /*
    * This function will handle all the form submissions done in JOb Stauts section;
    */

    function func_admin_init() {
        if (isset($_POST['add_job_status']))
        {
            global $wpdb;
            $wpdb->insert( $this->table, [
                "define_Job_Status_Id_PK" => $_POST['define_Job_Status_Id_PK'],
                "define_Job_Status_Name" => $_POST['define_Job_Status_Name'],
            ] );
            
            wp_redirect("admin.php?page=job-status&added=1");
            exit;
        }

        if (isset($_POST['edit_job_status']))
        {
            global $wpdb;
            $wpdb->update( $this->table, [
                "define_Job_Status_Name" => $_POST['define_Job_Status_Name'],
            ], [
                "define_Job_Status_Id_PK" => $_POST['job_status_id']
            ] );
            
            wp_redirect("admin.php?page=job-status&updated=1");
            exit;
        }


    }

    public function func_admin_menu() {

        add_submenu_page('defined-data',
                __('Job Status', 'dev-i18n'),
                __('Job Status', 'dev-i18n'),
                'read',
                'job-status',
                [$this, 'func_job_status']
            );

        remove_submenu_page('defined-data','defined-data');

    }

    function func_job_status() {
        
        $view = @$_GET['view'];
        if (!$view)
        {
            include(ABSPATH . 'wp-content/themes/'.$this->child_theme.'/views/define_job_status/list.php');
        }
        else
        {
            include(ABSPATH . 'wp-content/themes/'.$this->child_theme.'/views/define_job_status/'.$view.'.php');
        }
    }

    function get_records() {
        global $wpdb;
        return $wpdb->get_results( "SELECT * FROM {$this->table}" );
    }

    function get_define_job_status( $id ) {
        global $wpdb;
        $objDefineJobStatus = $wpdb->get_results( 
            $wpdb->prepare("SELECT * FROM {$this->table} WHERE `define_Job_Status_Id_PK` = '%s'", [$id])
         );
        
        if ($objDefineJobStatus)
        {
            return $objDefineJobStatus[0];
        }
        else
        {
            return false;
        }
        
    }

    function delete_job_status( $id ) {
        global $wpdb;
        $wpdb->delete( $this->table, [
            "define_Job_Status_Id_PK" => $id
        ] );
    }
}

global $clsDefineJobStatus;
$clsDefineJobStatus = new clsDefineJobStatus();