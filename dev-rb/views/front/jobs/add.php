<?php

if (@$_GET['added'] === "1")
{
    ?>
    <div class="alert alert-success">
        <?php echo __("Job has been added.", "dev-i18n"); ?>
    </div>
    <?php
}

global $clsDefineJobStatus;
$arrJobStatus = $clsDefineJobStatus->get_records();
?>
<form action="" method="post">


    <label for="timezon">
        <?php echo __("Job Status:", "dev-i18n"); ?> <br>
        <select name="jobDetail_Defined_Job_Status_FK" id="jobDetail_Defined_Job_Status_FK" class="form-field w100">
            <?php
            foreach ($arrJobStatus as $objJobStatus)
            {
                if ($objJobStatus->define_Job_Status_Id_PK != "job-status-open") continue;

                ?>
                <option value="<?php echo $objJobStatus->define_Job_Status_Id_PK; ?>"><?php echo $objJobStatus->define_Job_Status_Name; ?></option>
                <?php
            }
            ?>
        </select>
    </label>

    <br><br>

    <label for="title">
        <?php echo __("Job Title:", "dev-i18n"); ?> <br>
        <input type="text" name="jobDetail_Title" class="form-field w100" />
    </label>

    <br><br>

    <label for="title">
        <?php echo __("Job Description:", "dev-i18n"); ?> <br>
        <?php  wp_editor( '', 'jobDetail_Description_from_Business', ['media_buttons' => false] ); ?>
    </label>

    <br><br>

    <label for="amount">
        <?php echo __("Target Budget:", "dev-i18n"); ?> <br>
        <input type="number" name="jobDetail_Proposal_Target_Budget" class="form-field w100" />
    </label>

    <br><br>

    <label for="amount">
        <?php echo __("Target Date:", "dev-i18n"); ?> <br>
        <input type="date" name="jobDetail_Proposal_Target_Date" class="form-field w100" />
    </label>

    <br><br>
    

    <input type="hidden" name="jobDetail_Business_UserId_FK" value="<?php echo get_current_user_id(); ?>" />
    <input type="hidden" name="jobDetail_Engineer_UserId_FK" value="" />
    <input type="hidden" name="jobDetail_Description_from_Engineer" value="" />
    

    <center>
        <input type="submit" name="sbtAddJob" value="<?php echo __("Post Job", "dev-i18n"); ?>" class="btn btn-primary" />
    </center>
    

</form>