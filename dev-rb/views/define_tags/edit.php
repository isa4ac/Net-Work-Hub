<?php
global $clsDefineTags;
$objDefineTag = $clsDefineTags->get_define_tag( $_GET['id'] );
?>
<div class="wrap">
    <h2>Edit Define Tag</h2>
    
    <form action="" method="post">
        <table class="form-table">

            <tr class="form-field">
                <th>
                    <label>Name:</label>
                </th>
                <td>
                    <input name="define_Tag_Name" type="text" id="define_Tag_Name" value="<?php echo $objDefineTag->define_Tag_Name; ?>">
                </td>
            </tr>

        </table>

        <p class="submit">
            <input type="hidden" name="define_tag_id" value="<?php echo $objDefineTag->define_Tag_Id_PK; ?>" />
            <input type="submit" name="edit_define_tag" id="edit_define_tag" class="button button-primary" value="Edit Define Tag">
        </p>

    </form>
</div>