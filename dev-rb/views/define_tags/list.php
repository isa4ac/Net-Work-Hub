<div class="wrap">

    <h2>Tags</h2>

    <?php

    global $clsDefineTags;

    wp_enqueue_style( 'datatable_style' );
    wp_enqueue_script( 'datatable_script' );

    if (@$_GET['added'] === "1")
    {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'Tag has been added!', 'networkhub' ); ?></p>
        </div>
        <?php
    }

    if (@$_GET['updated'] === "1")
    {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'Tag has been updated!', 'networkhub' ); ?></p>
        </div>
        <?php
    }

    if (@$_GET['action'] === "delete")
    {
        $clsDefineTags->delete_tag( $_GET['id'] );
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'Tag has been deleted!', 'networkhub' ); ?></p>
        </div>
        <?php
    }

    
    $jobDefineTags = $clsDefineTags->get_records();
    ?>

    <div>
        <a class="button button-primary" href="admin.php?page=define-tags&view=add">Add</a>
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
            <?php if ($jobDefineTags) { foreach ($jobDefineTags as $objDefineTag) { ?>
            <tr>
                <td>
                <a href="admin.php?page=define-tags&view=edit&id=<?php echo $objDefineTag->define_Tag_Id_PK; ?>"><?php echo $objDefineTag->define_Tag_Id_PK ?></a>
                </td>
                <td><?php echo $objDefineTag->define_Tag_Name ?></td>
                <td>
                    <a class="button" href="admin.php?page=define-tags&view=edit&id=<?php echo $objDefineTag->define_Tag_Id_PK; ?>">Edit</a> 
                    <a class="button" style="border-color:red; color:red;" href="admin.php?page=define-tags&action=delete&id=<?php echo $objDefineTag->define_Tag_Id_PK; ?>">Delete</a>
                    
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
