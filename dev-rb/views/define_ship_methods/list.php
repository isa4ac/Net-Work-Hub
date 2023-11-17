<div class="wrap">

    <h2>Ship Methods</h2>

    <?php

    global $clsDefineShipMethods;

    wp_enqueue_style( 'datatable_style' );
    wp_enqueue_script( 'datatable_script' );

    if (@$_GET['added'] === "1")
    {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'Ship Methods has been added!', 'networkhub' ); ?></p>
        </div>
        <?php
    }

    if (@$_GET['updated'] === "1")
    {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'Ship Methods has been updated!', 'networkhub' ); ?></p>
        </div>
        <?php
    }

    if (@$_GET['action'] === "delete")
    {
        $clsDefineShipMethods->delete_ship_method( $_GET['id'] );
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'Ship Methods has been deleted!', 'networkhub' ); ?></p>
        </div>
        <?php
    }

    
    $objShipMethods = $clsDefineShipMethods->get_records();
    ?>

    <div>
        <a class="button button-primary" href="admin.php?page=define-ship-methods&view=add">Add</a>
    </div>

    <br><br>

    <table id="tblRecords" class="wp-list-table widefat fixed striped table-view-list posts">

        <thead>
            <tr>
                <td class="manage-column column-title column-primary sortable desc">ID</td>
                <td class="manage-column column-title column-primary sortable desc">Name</td>
                <td class="manage-column column-title column-primary sortable desc">Tracking URL</td>
                <td width="120"></td>
            </tr>
        </thead>

        <tbody>
            <?php if ($objShipMethods) { foreach ($objShipMethods as $objShipMethod) { ?>
            <tr>
                <td>
                <a href="admin.php?page=define-ship-methods&view=edit&id=<?php echo $objShipMethod->define_Ship_Method_Id_PK; ?>"><?php echo $objShipMethod->define_Ship_Method_Id_PK ?></a>
                </td>
                <td><?php echo $objShipMethod->define_Ship_Method_Name ?></td>
                <td><?php echo $objShipMethod->define_Ship_Method_Tracking_URL ?></td>
                <td>
                    <a class="button" href="admin.php?page=define-ship-methods&view=edit&id=<?php echo $objShipMethod->define_Ship_Method_Id_PK; ?>">Edit</a> 
                    <a class="button" style="border-color:red; color:red;" href="admin.php?page=define-ship-methods&action=delete&id=<?php echo $objShipMethod->define_Ship_Method_Id_PK; ?>">Delete</a>
                    
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
