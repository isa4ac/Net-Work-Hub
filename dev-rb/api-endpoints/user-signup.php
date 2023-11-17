<?php
/*
*   Endpoint URL: https://app.networkhub.me/wp-json/v1/user-signup
*/

add_action('rest_api_init', function(){

    register_rest_route( 'v1', '/user-signup', array(
        'methods' => 'POST',                                 // can be GET, POST, PUT, DELETE
        'callback' => 'func_user_register',             // call back function to do the required task
    ) );

});

/*
$data parameter holds the parameters being passed to the endpoint.
*/
function func_user_register($data) {

    global $clsUserData, $clsNetworkHub;

    $userData_Id_PK = $clsNetworkHub->generate_uuid("user-data-");

    $wpUserId = wp_insert_user([
        'user_pass' => $data['password'],
        'user_login' => $data['email'],
        'user_email' => $data['email'],
        'first_name' => $data['firstname'],
        'last_name' => $data['lastname'],
        'role' => $data['role']
    ]);

    update_user_meta($wpUserId, "uuid_key", $userData_Id_PK);
    
    $userId = $clsUserData->addUserData([
        "userData_Id_PK" => $userData_Id_PK,
        "userData_WordPress_UserId_FK" => $wpUserId,
        "userData_Define_Role_Id_FK" => $data['define_Role_Id_PK'],
        "userData_Timezone" => $data['userData_Timezone'],
        "userData_Primary_Email" => $data['email'],
        "userData_Password" => md5($data['password']),
        "userData_Name_Preferred" => $data['name_preferred'],
        "userData_Name_First" => $data['firstname'],
        "userData_Name_Last" => $data['lastname'],
        "userData_Name_Business" => $data['business_name'],
        "userData_Profile_Description" => $data['profile_description'],
        "userData_is_Enabled" => $data['is_enabled'],
        "userData_DT_Added" => date("Y-m-d H:i:s")
    ]);


    # return response in json;
    return [
        'success' => true,
        'data' => $wpUserId
    ];

}