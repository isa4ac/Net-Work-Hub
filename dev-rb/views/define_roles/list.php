<div class="wrap">

    <h2>Roles</h2>

    <?php

    global $clsDefineRoles;

    wp_enqueue_style( 'datatable_style' );
    wp_enqueue_script( 'datatable_script' );

    if (@$_GET['added'] === "1")
    {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'Role has been added!', 'networkhub' ); ?></p>
        </div>
        <?php
    }

    if (@$_GET['updated'] === "1")
    {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'Role has been updated!', 'networkhub' ); ?></p>
        </div>
        <?php
    }

    if (@$_GET['action'] === "delete")
    {
        $clsDefineRoles->delete_role( $_GET['id'] );
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'Role has been deleted!', 'networkhub' ); ?></p>
        </div>
        <?php
    }

    
    $jobDefineRoles = $clsDefineRoles->get_records();
    ?>

    <div>
        <a class="button button-primary" href="admin.php?page=define-roles&view=add">Add</a>
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
            <?php if ($jobDefineRoles) { foreach ($jobDefineRoles as $objDefineRole) { ?>
            <tr>
                <td>
                <a href="admin.php?page=define-roles&view=edit&id=<?php echo $objDefineRole->define_Role_Id_PK; ?>"><?php echo $objDefineRole->define_Role_Id_PK ?></a>
                </td>
                <td><?php echo $objDefineRole->define_Role_Name ?></td>
                <td>
                    <a class="button" href="admin.php?page=define-roles&view=edit&id=<?php echo $objDefineRole->define_Role_Id_PK; ?>">Edit</a> 
                    <a class="button" style="border-color:red; color:red;" href="admin.php?page=define-roles&action=delete&id=<?php echo $objDefineRole->define_Role_Id_PK; ?>">Delete</a>
                    
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
