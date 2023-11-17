<?php
/* User roles */

add_action('init', 'fs_wp_role');

function fs_wp_role() {
    
    if ( get_option( 'business_version' ) != 1 ) {
        add_role('business', __(
           'Business'),
           array(
               'read'            => true,
               'level_100'        => true,
               'create_posts'   => false,
               'edit_posts'     => false,
               'delete_posts'   => false,
               //'edit_dashboard' => true
               )
        );
        update_option( 'business_version', 1 );
    }

    if ( get_option( 'engineer_version' ) != 1 ) {
        add_role('engineer', __(
           'Engineer'),
           array(
               'read'            => true,
               'level_100'        => true,
               'create_posts'   => false,
               'edit_posts'     => false,
               'delete_posts'   => false,
               //'edit_dashboard' => true
               )
        );
        update_option( 'engineer_version', 1 );
    }

    if ( get_option( 'sysop_version' ) != 1 ) {
        add_role('sysop', __(
           'Sysop'),
           array(
               'read'            => true,
               'level_100'        => true,
               'create_posts'   => false,
               'edit_posts'     => false,
               'delete_posts'   => false,
               //'edit_dashboard' => true
               )
        );
        update_option( 'sysop_version', 1 );
    }

}