<?php
/*
*   Endpoint URL: https://app.networkhub.me/wp-json/v1/user-signup
*/

add_action('rest_api_init', function(){

    register_rest_route( 'v1', '/user-signup', array(
        'methods' => 'POST',                                 // can be GET, POST, PUT, DELETE
        'callback' => 'func_user_register',             // call back function to do the required task
    ) );

    // pass in:
    // email
    // pw
    // first
    // last
    // bname
    // bio

});

/*
$data parameter holds the parameters being passed to the endpoint.
*/
function func_user_register($data) {

    global $clsUserData, $clsNetworkHub;

    $userData_Id_PK = $clsNetworkHub->generate_uuid("user-data-");
    
    $clsUserData->addUserData([
        "userData_Id_PK" => $userData_Id_PK,
        "userData_Define_Role_Id_FK" => 'role-business',
        "userData_Primary_Email" => $data['email'],
        "userData_Password" => md5($data['pw']),
        "userData_Name_Preferred" => $data['first'],
        "userData_Name_First" => $data['first'],
        "userData_Name_Last" => $data['last'],
        "userData_Name_Business" => $data['bname'],
        "userData_Profile_Description" => $data['bio'],
        "userData_DT_Added" => date("Y-m-d H:i:s")
    ]);


    # return response in json;
    return [
        'success' => true
    ];

}