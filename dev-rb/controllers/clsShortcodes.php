<?php
class devShortcodes {
    private $shortcodes = array(
        'user-signup' => 'func_user_signup',
        'user-login' => 'func_user_login',
        'job-business-post' => 'func_job_business_post',
        'job-business-list-active' => 'func_job_business_list_active',
        'job-business-list-closed' => 'func_job_business_list_closed',
        'job-engineer-list-available' => 'func_job_engineer_list_available',
        'job-engineer-list-inprogress' => 'func_job_engineer_list_inprogress',
        'job-engineer-list-finished' => 'func_job_engineer_list_finished'
    );
    
    function __construct() {
        
        foreach ($this->shortcodes as $shortcode => $callback)
        {
            add_shortcode($shortcode, array($this, $callback));
        }
    }
    
    function func_user_signup() {
        return get_template_part('views/front/userdata/signup');
    }

    function func_user_login() {
        return get_template_part('views/front/userdata/login');
    }

    function func_job_business_post() {
        return get_template_part('views/front/jobs/add');
    }

    function func_job_business_list_active() {
        return get_template_part('views/front/jobs/active');
    }

    function func_job_business_list_closed() {
        return get_template_part('views/front/jobs/closed');
    }

    function func_job_engineer_list_available() {
        return get_template_part('views/front/engineer/available');
    }

    function func_job_engineer_list_inprogress() {
        return get_template_part('views/front/engineer/inprogress');
    }

    function func_job_engineer_list_finished() {
        return get_template_part('views/front/engineer/finished');
    }


}

new devShortcodes();