<?php
global $clsDefineStates;
$objDefineState = $clsDefineStates->get_define_state( $_GET['id'] );
?>
<div class="wrap">
    <h2>Edit State</h2>
    
    <form action="" method="post">
        <table class="form-table">

            <tr class="form-field">
                <th>
                    <label>Name:</label>
                </th>
                <td>
                    <input name="define_State_Name" type="text" id="define_State_Name" value="<?php echo $objDefineState->define_State_Name; ?>">
                </td>
            </tr>

            <tr class="form-field">
                <th>
                    <label>2 Character:</label>
                </th>
                <td>
                    <input name="define_State_2Character" type="text" id="define_State_2Character" value="<?php echo $objDefineState->define_State_2Character; ?>">
                </td>
            </tr>

            <tr class="form-field">
                <th>
                    <label>Enabled:</label>
                </th>
                <td>
                    <select name="define_State_is_Enabled" id="define_State_is_Enabled">
                        <option value="1" <?php if ($objDefineState->define_State_is_Enabled === "1") { echo "selected"; } ?> >Yes</option>
                        <option value="0" <?php if ($objDefineState->define_State_is_Enabled === "0") { echo "selected"; } ?> >No</option>
                    </select>
                </td>
            </tr>

        </table>

        <p class="submit">
            <input type="hidden" name="define_state_id" value="<?php echo $objDefineState->define_State_Id_PK; ?>" />
            <input type="submit" name="edit_define_state" id="edit_define_state" class="button button-primary" value="Edit State">
        </p>

    </form>
</div>