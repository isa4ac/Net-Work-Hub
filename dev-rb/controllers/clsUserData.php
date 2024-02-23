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
        
        if ( is_wp_error( $user ) )  {
            $error_string = $user->get_error_message();
            return json_encode([
                'success' => false,
                'message' => $error_string
            ]);
        } else { // success:
            return json_encode([
                'success' => true,
                'user' => $user
            ]);
        }

    }

    function attemptLogin($email, $pw) {
        global $wpdb;

        // First Name
        // Last Name
        // experience (start date)
        // jobs done
        // avg rating (return 0 if null)
        // bio

        $passKey = md5($pw);

        $query = "SELECT userData_WordPress_UserId_FK, userData_Define_Role_Id_FK, userData_Timezone, userData_Primary_Email, userData_Name_First, userData_Name_Last, userData_Name_Business, userData_Profile_Description" .
        " FROM {$this->table}" .
        " WHERE userData_Primary_Email = '{$email}' AND userData_Password = '{$passKey}' LIMIT 1";
        $arrUserData = $wpdb->get_results(
            $wpdb->prepare($query, [$email, $passKey])
        );
//        return $arrUserData;
        if ($arrUserData) {
            return $arrUserData[0];
        } else {
            return $query;
        }
    }

    function getEngineerData($engID) {
        global $wpdb;
        $query = "ud.userData_Name_First, ud.userData_Name_Last, ud.userData_Experience_Start, COUNT(jd.jobDetail_Id_PK) as jobs_Done, AVG(jr.jobReview_for_Engineer_Rating) as avg_Review, ud.userData_Profile_Description as bio" .
            " FROM {$this->table} as ud" .
            " JOIN job_Reviews jf on ud.userData_Id_PK = jr.jobReview_for_Engineer_UserId_FK" .
            " JOIN job_Details jd on ud.userData_Id_PK = jd.jobDetail_Engineer_UserId_FK" .
            " WHERE userData_Id_PK = '{$engID}' LIMIT 1";
        $arrUserData = $wpdb->get_results(
            $wpdb->prepare($query, [$engID])
        );
//        return $arrUserData;
        if ($arrUserData) {
            return $arrUserData[0];
        } else {
            return $query;
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

    function getUserDataByUserId( $intWPUserId ) {
        global $wpdb;
        $query = "SELECT * FROM {$this->table} WHERE userData_Id_PK = '%s'";
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