<?php
class clsDefineStates
{
    public $child_theme             = "dev-rb";
    private $table                  = "define_States";
    
    function __construct() {
        
        global $wpdb;

        add_action( 'admin_menu', [$this, 'func_admin_menu'], 20, 1 );
        add_action( 'admin_init', [$this, 'func_admin_init'] );
        
    }

    /*
    * This function will handle all the form submissions done in Define Ship Methods section;
    */

    function func_admin_init() {
        if (isset($_POST['add_define_state']))
        {
            global $wpdb;
            $wpdb->insert( $this->table, [
                "define_State_Id_PK" => $_POST['define_State_Id_PK'],
                "define_State_Name" => $_POST['define_State_Name'],
                "define_State_2Character" => $_POST['define_State_2Character'],
                "define_State_is_Enabled" => $_POST['define_State_is_Enabled']
            ] );
            
            wp_redirect("admin.php?page=define-state&added=1");
            exit;
        }

        if (isset($_POST['edit_define_state']))
        {
            global $wpdb;
            $wpdb->update( $this->table, [
                "define_State_Name" => $_POST['define_State_Name'],
                "define_State_2Character" => $_POST['define_State_2Character'],
                "define_State_is_Enabled" => $_POST['define_State_is_Enabled']
            ], [
                "define_State_Id_PK" => $_POST['define_state_id']
            ] );
            
            wp_redirect("admin.php?page=define-state&updated=1");
            exit;
        }


    }

    public function func_admin_menu() {

        add_submenu_page('defined-data',
                __('States', 'dev-i18n'),
                __('States', 'dev-i18n'),
                'read',
                'define-state',
                [$this, 'func_define_state']
            );

        remove_submenu_page('defined-data','defined-data');

    }

    function func_define_state() {
        
        $view = @$_GET['view'];
        if (!$view)
        {
            include(ABSPATH . 'wp-content/themes/'.$this->child_theme.'/views/define_states/list.php');
        }
        else
        {
            include(ABSPATH . 'wp-content/themes/'.$this->child_theme.'/views/define_states/'.$view.'.php');
        }
    }

    function get_records() {
        global $wpdb;
        return $wpdb->get_results( "SELECT * FROM {$this->table}" );
    }

    function get_define_state( $id ) {
        global $wpdb;
        $objRoles = $wpdb->get_results( 
            $wpdb->prepare("SELECT * FROM {$this->table} WHERE `define_State_Id_PK` = '%s'", [$id])
         );
        
        if ($objRoles)
        {
            return $objRoles[0];
        }
        else
        {
            return false;
        }
        
    }

    function delete_state( $id ) {
        global $wpdb;
        $wpdb->delete( $this->table, [
            "define_State_Id_PK" => $id
        ] );
    }
}

global $clsDefineStates;
$clsDefineStates = new clsDefineStates();