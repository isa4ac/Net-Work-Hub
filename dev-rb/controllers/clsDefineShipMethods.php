<?php
class clsDefineShipMethods
{
    public $child_theme             = "dev-rb";
    private $table                  = "define_Ship_Methods";
    
    function __construct() {
        
        global $wpdb;

        add_action( 'admin_menu', [$this, 'func_admin_menu'], 20, 1 );
        add_action( 'admin_init', [$this, 'func_admin_init'] );
        
    }

    /*
    * This function will handle all the form submissions done in Define Ship Methods section;
    */

    function func_admin_init() {
        if (isset($_POST['add_define_ship_methods']))
        {
            global $wpdb;
            $wpdb->insert( $this->table, [
                "define_Ship_Method_Id_PK" => $_POST['define_Ship_Method_Id_PK'],
                "define_Ship_Method_Name" => $_POST['define_Ship_Method_Name'],
                "define_Ship_Method_Tracking_URL" => $_POST['define_Ship_Method_Tracking_URL']
            ] );
            
            wp_redirect("admin.php?page=define-ship-methods&added=1");
            exit;
        }

        if (isset($_POST['edit_define_ship_methods']))
        {
            global $wpdb;
            $wpdb->update( $this->table, [
                "define_Ship_Method_Name" => $_POST['define_Ship_Method_Name'],
                "define_Ship_Method_Tracking_URL" => $_POST['define_Ship_Method_Tracking_URL']
            ], [
                "define_Ship_Method_Id_PK" => $_POST['define_ship_method_id']
            ] );
            
            wp_redirect("admin.php?page=define-ship-methods&updated=1");
            exit;
        }


    }

    public function func_admin_menu() {

        add_submenu_page('defined-data',
                __('Ship Methods', 'dev-i18n'),
                __('Ship Methods', 'dev-i18n'),
                'read',
                'define-ship-methods',
                [$this, 'func_define_ship_methods']
            );

        remove_submenu_page('defined-data','defined-data');

    }

    function func_define_ship_methods() {
        
        $view = @$_GET['view'];
        if (!$view)
        {
            include(ABSPATH . 'wp-content/themes/'.$this->child_theme.'/views/define_ship_methods/list.php');
        }
        else
        {
            include(ABSPATH . 'wp-content/themes/'.$this->child_theme.'/views/define_ship_methods/'.$view.'.php');
        }
    }

    function get_records() {
        global $wpdb;
        return $wpdb->get_results( "SELECT * FROM {$this->table}" );
    }

    function get_define_ship_method( $id ) {
        global $wpdb;
        $objRoles = $wpdb->get_results( 
            $wpdb->prepare("SELECT * FROM {$this->table} WHERE `define_Ship_Method_Id_PK` = '%s'", [$id])
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

    function delete_ship_method( $id ) {
        global $wpdb;
        $wpdb->delete( $this->table, [
            "define_Ship_Method_Id_PK" => $id
        ] );
    }
}

global $clsDefineShipMethods;
$clsDefineShipMethods = new clsDefineShipMethods();