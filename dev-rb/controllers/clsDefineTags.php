<?php
class clsDefineTags
{
    public $child_theme             = "dev-rb";
    private $table                  = "define_Tags";
    
    function __construct() {
        
        global $wpdb;

        add_action( 'admin_menu', [$this, 'func_admin_menu'], 20, 1 );
        add_action( 'admin_init', [$this, 'func_admin_init'] );
        
    }

    /*
    * This function will handle all the form submissions done in Define Roles section;
    */

    function func_admin_init() {
        if (isset($_POST['add_define_tag']))
        {
            global $wpdb;
            $wpdb->insert( $this->table, [
                "define_Tag_Id_PK" => $_POST['define_Tag_Id_PK'],
                "define_Tag_Name" => $_POST['define_Tag_Name'],
            ] );
            
            wp_redirect("admin.php?page=define-tags&added=1");
            exit;
        }

        if (isset($_POST['edit_define_tag']))
        {
            global $wpdb;
            $wpdb->update( $this->table, [
                "define_Tag_Name" => $_POST['define_Tag_Name'],
            ], [
                "define_Tag_Id_PK" => $_POST['define_tag_id']
            ] );
            
            wp_redirect("admin.php?page=define-tags&updated=1");
            exit;
        }


    }

    public function func_admin_menu() {

        add_submenu_page('defined-data',
                __('Tags', 'dev-i18n'),
                __('Tags', 'dev-i18n'),
                'read',
                'define-tags',
                [$this, 'func_define_tags']
            );

        remove_submenu_page('defined-data','defined-data');

    }

    function func_define_tags() {
        
        $view = @$_GET['view'];
        if (!$view)
        {
            include(ABSPATH . 'wp-content/themes/'.$this->child_theme.'/views/define_tags/list.php');
        }
        else
        {
            include(ABSPATH . 'wp-content/themes/'.$this->child_theme.'/views/define_tags/'.$view.'.php');
        }
    }

    function get_records() {
        global $wpdb;
        return $wpdb->get_results( "SELECT * FROM {$this->table}" );
    }

    function get_define_tag( $id ) {
        global $wpdb;
        $objTags = $wpdb->get_results( 
            $wpdb->prepare("SELECT * FROM {$this->table} WHERE `define_Tag_Id_PK` = '%s'", [$id])
         );
        
        if ($objTags)
        {
            return $objTags[0];
        }
        else
        {
            return false;
        }
        
    }

    function delete_tag( $id ) {
        global $wpdb;
        $wpdb->delete( $this->table, [
            "define_Tag_Id_PK" => $id
        ] );
    }
}

global $clsDefineTags;
$clsDefineTags = new clsDefineTags();