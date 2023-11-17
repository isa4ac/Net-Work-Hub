<?php
global $clsDefineRoles;
$objDefineRole = $clsDefineRoles->get_define_role( $_GET['id'] );
?>
<div class="wrap">
    <h2>Edit Define Role</h2>
    
    <form action="" method="post">
        <table class="form-table">

            <tr class="form-field">
                <th>
                    <label>Name:</label>
                </th>
                <td>
                    <input name="define_Role_Name" type="text" id="define_Role_Name" value="<?php echo $objDefineRole->define_Role_Name; ?>">
                </td>
            </tr>

        </table>

        <p class="submit">
            <input type="hidden" name="define_role_id" value="<?php echo $objDefineRole->define_Role_Id_PK; ?>" />
            <input type="submit" name="edit_define_role" id="edit_define_role" class="button button-primary" value="Edit Define Role">
        </p>

    </form>
</div>