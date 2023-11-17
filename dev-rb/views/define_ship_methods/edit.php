<?php
global $clsDefineShipMethods;
$objDefineShipMethod = $clsDefineShipMethods->get_define_ship_method( $_GET['id'] );
?>
<div class="wrap">
    <h2>Edit Ship Method</h2>
    
    <form action="" method="post">
        <table class="form-table">

            <tr class="form-field">
                <th>
                    <label>Name:</label>
                </th>
                <td>
                    <input name="define_Ship_Method_Name" type="text" id="define_Ship_Method_Name" value="<?php echo $objDefineShipMethod->define_Ship_Method_Name; ?>">
                </td>
            </tr>

            <tr class="form-field">
                <th>
                    <label>Tracking URL:</label>
                </th>
                <td>
                    <input name="define_Ship_Method_Tracking_URL" type="text" id="define_Ship_Method_Tracking_URL" value="<?php echo $objDefineShipMethod->define_Ship_Method_Tracking_URL; ?>">
                </td>
            </tr>

        </table>

        <p class="submit">
            <input type="hidden" name="define_ship_method_id" value="<?php echo $objDefineShipMethod->define_Ship_Method_Id_PK; ?>" />
            <input type="submit" name="edit_define_ship_methods" id="edit_define_ship_methods" class="button button-primary" value="Edit Ship Method">
        </p>

    </form>
</div>