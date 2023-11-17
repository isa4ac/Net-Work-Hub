<div class="wrap">

    <h2>States</h2>

    <?php

    global $clsDefineStates;

    wp_enqueue_style( 'datatable_style' );
    wp_enqueue_script( 'datatable_script' );

    if (@$_GET['added'] === "1")
    {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'State has been added!', 'networkhub' ); ?></p>
        </div>
        <?php
    }

    if (@$_GET['updated'] === "1")
    {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'State has been updated!', 'networkhub' ); ?></p>
        </div>
        <?php
    }

    if (@$_GET['action'] === "delete")
    {
        $clsDefineStates->delete_state( $_GET['id'] );
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'State has been deleted!', 'networkhub' ); ?></p>
        </div>
        <?php
    }

    
    $objStates = $clsDefineStates->get_records();
    ?>

    <div>
        <a class="button button-primary" href="admin.php?page=define-state&view=add">Add</a>
    </div>

    <br><br>

    <table id="tblRecords" class="wp-list-table widefat fixed striped table-view-list posts">

        <thead>
            <tr>
                <td class="manage-column column-title column-primary sortable desc">ID</td>
                <td class="manage-column column-title column-primary sortable desc">Name</td>
                <td class="manage-column column-title column-primary sortable desc">2 Character</td>
                <td class="manage-column column-title column-primary sortable desc">Enabled</td>
                <td width="120"></td>
            </tr>
        </thead>

        <tbody>
            <?php if ($objStates) { foreach ($objStates as $objState) { ?>
            <tr>
                <td>
                <a href="admin.php?page=define-state&view=edit&id=<?php echo $objState->define_State_Id_PK; ?>"><?php echo $objState->define_State_Id_PK ?></a>
                </td>
                <td><?php echo $objState->define_State_Name ?></td>
                <td><?php echo $objState->define_State_2Character ?></td>
                <td><?php echo ($objState->define_State_is_Enabled === "1") ? 'Yes' : 'No'; ?></td>
                <td>
                    <a class="button" href="admin.php?page=define-state&view=edit&id=<?php echo $objState->define_State_Id_PK; ?>">Edit</a> 
                    <a class="button" style="border-color:red; color:red;" href="admin.php?page=define-state&action=delete&id=<?php echo $objState->define_State_Id_PK; ?>">Delete</a>
                    
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
