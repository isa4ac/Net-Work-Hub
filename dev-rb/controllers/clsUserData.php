<?php
class clsUserData
{
    public $child_theme             = "dev-rb";
    private $table                  = "user_Data";
    
    function __construct() {
        
        global $wpdb;

        //add_action( 'admin_menu', [$this, 'func_admin_menu'], 20, 1 );
        //add_action( 'admin_init', [$this, 'func_admin_init'] );

        add_action( 'template_redirect', [$this, 'func_template_redirect'] );
        
    }

    function func_template_redirect() {

        # User Signup form submission;
        if (isset($_POST['sbtUserSignup']))
        {
            global $clsNetworkHub, $post;

            $userData_Id_PK = $clsNetworkHub->generate_uuid("user-data-");

            $wpUserId = wp_insert_user([
                'user_pass' => $_POST['password'],
                'user_login' => $_POST['email'],
                'user_email' => $_POST['email'],
                'first_name' => $_POST['userData_Name_First'],
                'last_name' => $_POST['userData_Name_Last'],
                'role' => ($_POST['userData_Define_Role_Id_FK'] === "role-business") ? "business" : "engineer"
            ]);

            update_user_meta($wpUserId, "uuid_key", $userData_Id_PK);

            $this->addUserData([
                "userData_Id_PK" => $userData_Id_PK,
                "userData_WordPress_UserId_FK" => $wpUserId,
                "userData_Define_Role_Id_FK" => $_POST['userData_Define_Role_Id_FK'],
                "userData_Timezone" => $_POST['userData_Timezone'],
                "userData_Primary_Email" => $_POST['email'],
                "userData_Password" => md5($_POST['password']),
                "userData_Name_Preferred" => $_POST['userData_Name_Preferred'],
                "userData_Name_First" => $_POST['userData_Name_First'],
                "userData_Name_Last" => $_POST['userData_Name_Last'],
                "userData_Name_Business" => $_POST['userData_Name_Business'],
                "userData_Profile_Description" => "",
                "userData_is_Enabled" => "1",
                "userData_DT_Added" => date("Y-m-d H:i:s")
            ]);

            wp_redirect( add_query_arg(['signup'=>1], get_permalink($post->ID)) );
            exit;
        }

        # User Login form submission;
        if (isset($_POST['sbtUserLogin']))
        {
            global $post;
            $objUser = $this->checkUserLogin( $_POST['email'], $_POST['password'] );

            $objUser = json_decode($objUser);
            
            if ($objUser->success)
            {
                wp_redirect( add_query_arg(['loginsuccess'=>1], get_permalink(38)) );
            }
            else
            {
                wp_redirect( add_query_arg(['loginerror'=>1], get_permalink($post->ID)) );
            }
            
            exit;
        }
    }

    function checkUserLogin($username, $password) {
        $user = wp_authenticate_username_password(null, $username, $password);
        
        if ( is_wp_error( $user ) ) 
        {
            $error_string = $user->get_error_message();
            return json_encode([
                'success' => false,
                'message' => $error_string
            ]);
        }
        else
        {
            return json_encode([
                'success' => true,
                'user' => $user
            ]);
        }

    }

    function get_records() {
        global $wpdb;
        return $wpdb->get_results( "SELECT * FROM {$this->table}" );
    }

    function addUserData( $data ) {
        global $wpdb;
        $wpdb->insert( $this->table, $data );
    }

    function getUserDataByWPUserId( $intWPUserId ) {
        global $wpdb;
        $query = "SELECT * FROM {$this->table} WHERE userData_WordPress_UserId_FK = '%s'";
        $arrUserData = $wpdb->get_results(
            $wpdb->prepare($query, [$intWPUserId])
        );
        if ($arrUserData)
            return $arrUserData[0];
        else
            return false;
    }

}

global $clsUserData;
$clsUserData = new clsUserData();