<?php
wp_enqueue_style( 'datatable_style' );
wp_enqueue_script( 'datatable_script' );

global $clsJobDetails;
$arrActiveJobs = $clsJobDetails->getActiveJobs( get_current_user_id() );


if (!$arrActiveJobs)
{
    ?>
    <div class="alert alert-danger">
        <?php echo __("No active jobs found.", "dev-i18n"); ?>
    </div>
    <?php
}
else
{
    ?>
    <table id="tblRecords" class="display responsive" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Engineer</th>
                <th>Job Status</th>
                <th>Posted Date</th>
                <th>Title</th>
                <th>Target Budget</th>
                <th>Target Date</th>
                <th>Agreed Budget</th>
                <th>Agreed Date</th>
                <th>Final Budget</th>
                <th>Final Date</th>
                <th>Accepted by Business</th>
                <th>Accepted Date</th>
                <th>Accepted by Engineer</th>
                <th>Accepted Date</th>
            </tr>
        </thead>

        <tbody>
            <?php
            foreach ($arrActiveJobs as $objActiveJob)
            {
                ?>
                <tr>
                    <td><?php echo $objActiveJob->jobDetail_Id_PK ?></td>
                    <td>
                        <?php 
                        if (!empty($objActiveJob->jobDetail_Engineer_UserId_FK))
                        {
                            $objUser = get_user_by('ID', $objActiveJob->jobDetail_Engineer_UserId_FK);
                            echo $objUser->display_name;
                        }
                        ?>
                    </td>
                    <td><?php echo $objActiveJob->define_Job_Status_Name ?></td>
                    <td><?php echo ($objActiveJob->jobDetail_Posted_DT) ? date("d M, Y", strtotime($objActiveJob->jobDetail_Posted_DT)) : ''; ?></td>
                    <td><?php echo $objActiveJob->jobDetail_Title ?></td>
                    <td><?php echo $objActiveJob->jobDetail_Proposal_Target_Budget ?></td>
                    <td><?php echo ($objActiveJob->jobDetail_Proposal_Target_Date) ? date("d M, Y", strtotime($objActiveJob->jobDetail_Proposal_Target_Date)) : ''; ?></td>
                    <td><?php echo $objActiveJob->jobDetail_Proposal_Agreed_Budget ?></td>
                    <td><?php echo ($objActiveJob->jobDetail_Proposal_Agreed_Date) ? date("d M, Y", strtotime($objActiveJob->jobDetail_Proposal_Agreed_Date)) : ''; ?></td>
                    <td><?php echo $objActiveJob->jobDetail_Proposal_Final_Budget ?></td>
                    <td><?php echo ($objActiveJob->jobDetail_Proposal_Final_Date) ? date("d M, Y", strtotime($objActiveJob->jobDetail_Proposal_Final_Date)) : '' ?></td>
                    <td><?php echo $objActiveJob->jobDetail_is_Accepted_by_Business_Bool ?></td>
                    <td><?php echo ($objActiveJob->jobDetail_is_Accepted_by_Business_DT) ? date("d M, Y", strtotime($objActiveJob->jobDetail_is_Accepted_by_Business_DT)) : ''; ?></td>
                    <td><?php echo $objActiveJob->jobDetail_is_Accepted_by_Engineer_Bool ?></td>
                    <td><?php echo ($objActiveJob->jobDetail_is_Accepted_by_Engineer_DT) ? date("d M, Y", strtotime($objActiveJob->jobDetail_is_Accepted_by_Engineer_DT)) : ''; ?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <script>
    jQuery(document).ready(function($){
        $("#tblRecords").DataTable({
            responsive: true
        });
    });
    </script>
    <?php
}
?>