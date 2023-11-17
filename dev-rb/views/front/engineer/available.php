<?php
wp_enqueue_style( 'datatable_style' );
wp_enqueue_script( 'datatable_script' );

global $clsJobDetails, $clsUserData;
$arrJobsEngineerAvailable = $clsJobDetails->getJobsEngineerAvailable();

//p_r($arrJobsEngineerAvailable);

if (!$arrJobsEngineerAvailable)
{
    ?>
    <div class="alert alert-danger">
        <?php echo __("No available jobs found.", "dev-i18n"); ?>
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
                <th>Business User</th>
                <th>Title</th>
                <th>Posted Date</th>
                <th>Target Budget</th>
                <th>Target Date</th>
            </tr>
        </thead>

        <tbody>
            <?php
            foreach ($arrJobsEngineerAvailable as $objJob)
            {
                ?>
                <tr>
                    <td><?php echo $objJob->jobDetail_Id_PK ?></td>
                    <td>
                        <?php 
                        if (!empty($objJob->jobDetail_Business_UserId_FK))
                        {
                            $objUser = $clsUserData->getUserDataByWPUserId($objJob->jobDetail_Business_UserId_FK);
                            echo $objUser->userData_Name_Business;
                        }
                        ?>
                    </td>
                    <td><?php echo $objJob->jobDetail_Title ?></td>
                    <td><?php echo ($objJob->jobDetail_Posted_DT) ? date("d M, Y", strtotime($objJob->jobDetail_Posted_DT)) : ''; ?></td>
                    <td><?php echo $objJob->jobDetail_Proposal_Target_Budget ?></td>
                    <td><?php echo ($objJob->jobDetail_Proposal_Target_Date) ? date("d M, Y", strtotime($objJob->jobDetail_Proposal_Target_Date)) : ''; ?></td>
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