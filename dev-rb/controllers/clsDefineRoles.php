<?php
class clsDefineRoles
{
    public $child_theme             = "dev-rb";
    private $table                  = "define_Roles";
    
    function __construct() {
        
        global $wpdb;

        add_action( 'admin_menu', [$this, 'func_admin_menu'], 20, 1 );
        add_action( 'admin_init', [$this, 'func_admin_init'] );
        
    }

    /*
    * This function will handle all the form submissions done in Define Roles section;
    */

    function func_admin_init() {
        if (isset($_POST['add_define_role']))
        {
            global $wpdb;
            $wpdb->insert( $this->table, [
                "define_Role_Id_PK" => $_POST['define_Role_Id_PK'],
                "define_Role_Name" => $_POST['define_Role_Name'],
            ] );
            
            wp_redirect("admin.php?page=define-roles&added=1");
            exit;
        }

        if (isset($_POST['edit_define_role']))
        {
            global $wpdb;
            $wpdb->update( $this->table, [
                "define_Role_Name" => $_POST['define_Role_Name'],
            ], [
                "define_Role_Id_PK" => $_POST['define_role_id']
            ] );
            
            wp_redirect("admin.php?page=define-roles&updated=1");
            exit;
        }


    }

    public function func_admin_menu() {

        add_submenu_page('defined-data',
                __('Roles', 'dev-i18n'),
                __('Roles', 'dev-i18n'),
                'read',
                'define-roles',
                [$this, 'func_define_roles']
            );

        remove_submenu_page('defined-data','defined-data');

    }

    function func_define_roles() {
        
        $view = @$_GET['view'];
        if (!$view)
        {
            include(ABSPATH . 'wp-content/themes/'.$this->child_theme.'/views/define_roles/list.php');
        }
        else
        {
            include(ABSPATH . 'wp-content/themes/'.$this->child_theme.'/views/define_roles/'.$view.'.php');
        }
    }

    function get_records() {
        global $wpdb;
        return $wpdb->get_results( "SELECT * FROM {$this->table}" );
    }

    function get_define_role( $id ) {
        global $wpdb;
        $objRoles = $wpdb->get_results( 
            $wpdb->prepare("SELECT * FROM {$this->table} WHERE `define_Role_Id_PK` = '%s'", [$id])
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

    function delete_role( $id ) {
        global $wpdb;
        $wpdb->delete( $this->table, [
            "define_Role_Id_PK" => $id
        ] );
    }
}

global $clsDefineRoles;
$clsDefineRoles = new clsDefineRoles();