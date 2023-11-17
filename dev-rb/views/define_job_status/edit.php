<?php
global $clsDefineJobStatus;
$objDefineJobStatus = $clsDefineJobStatus->get_define_job_status( $_GET['id'] );
?>
<div class="wrap">
    <h2>Edit Job Status</h2>
    
    <form action="" method="post">
        <table class="form-table">

            <tr class="form-field">
                <th>
                    <label>Name:</label>
                </th>
                <td>
                    <input name="define_Job_Status_Name" type="text" id="define_Job_Status_Name" value="<?php echo $objDefineJobStatus->define_Job_Status_Name; ?>">
                </td>
            </tr>

        </table>

        <p class="submit">
            <input type="hidden" name="job_status_id" value="<?php echo $objDefineJobStatus->define_Job_Status_Id_PK; ?>" />
            <input type="submit" name="edit_job_status" id="edit_job_status" class="button button-primary" value="Edit Job Status">
        </p>

    </form>
</div>