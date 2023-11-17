<?php
use Ramsey\Uuid\Uuid;

class clsNetworkHub
{
    public $child_theme             = "dev-rb";
    
    function __construct() {
        
        global $wpdb;

        add_action( 'admin_menu', [$this, 'func_admin_menu'], 10, 1 );
        add_action( 'admin_enqueue_scripts', [$this, 'func_custom_styles'] );
        add_action('wp_enqueue_scripts', [$this, 'func_load_scripts']);
        
    }

    function func_custom_styles() {
        
        wp_register_style( 'datatable_style', '//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' );
        wp_register_script( 'datatable_script', '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js', array('jquery') );
        
    }


    function func_load_scripts(){
        
        wp_register_style( 'datatable_style', '//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' );
        wp_enqueue_style( 'fs_style', home_url() . '/wp-content/themes/'.$this->child_theme.'/css/style.css?t='.time() );
        
        wp_register_script( 'datatable_script', '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js', array('jquery') );
    }

    public function func_admin_menu() {

        add_menu_page(
            __( 'Defined Data', 'fullstackology' ),
            __( 'Defined Data', 'fullstackology' ),
            'read',
            'defined-data',
            [$this, 'func_defined_data'],
            '',
            6
        );
        
    }

    function func_defined_data() {
        echo "in defined data";
    }

    function generate_uuid($prefix = '') {

        $uuid = Uuid::uuid4();
        $txtUUID = $uuid->toString();
        if ($prefix) 
        {
            return $prefix . $txtUUID;
        }
        else
        {
            return $txtUUID;
        }
    }

}

global $clsNetworkHub;
$clsNetworkHub = new clsNetworkHub();