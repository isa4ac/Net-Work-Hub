<div class="wrap">

    <h2>Job Status</h2>

    <?php

    global $clsDefineJobStatus;

    wp_enqueue_style( 'datatable_style' );
    wp_enqueue_script( 'datatable_script' );

    if (@$_GET['added'] === "1")
    {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'Job Status has been added!', 'networkhub' ); ?></p>
        </div>
        <?php
    }

    if (@$_GET['updated'] === "1")
    {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'Job Status has been updated!', 'networkhub' ); ?></p>
        </div>
        <?php
    }

    if (@$_GET['action'] === "delete")
    {
        $clsDefineJobStatus->delete_job_status( $_GET['id'] );
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'Job Status has been deleted!', 'networkhub' ); ?></p>
        </div>
        <?php
    }

    
    $jobStatuses = $clsDefineJobStatus->get_records();
    ?>

    <div>
        <a class="button button-primary" href="admin.php?page=job-status&view=add">Add</a>
    </div>

    <br><br>

    <table id="tblRecords" class="wp-list-table widefat fixed striped table-view-list posts">

        <thead>
            <tr>
                <td class="manage-column column-title column-primary sortable desc">ID</td>
                <td class="manage-column column-title column-primary sortable desc">Name</td>
                <td width="120"></td>
            </tr>
        </thead>

        <tbody>
            <?php if ($jobStatuses) { foreach ($jobStatuses as $objJobStatus) { ?>
            <tr>
                <td>
                <a href="admin.php?page=job-status&view=edit&id=<?php echo $objJobStatus->define_Job_Status_Id_PK; ?>"><?php echo $objJobStatus->define_Job_Status_Id_PK ?></a>
                </td>
                <td><?php echo $objJobStatus->define_Job_Status_Name ?></td>
                <td>
                    <a class="button" href="admin.php?page=job-status&view=edit&id=<?php echo $objJobStatus->define_Job_Status_Id_PK; ?>">Edit</a> 
                    <a class="button" style="border-color:red; color:red;" href="admin.php?page=job-status&action=delete&id=<?php echo $objJobStatus->define_Job_Status_Id_PK; ?>">Delete</a>
                    
                </td>
            </tr>
            <?php } } ?>
            
        </tbody>

    </table>



</div>
<script>
jQuery(document).ready(function($){
    $("#tblRecords").DataTable();
});
</script>
