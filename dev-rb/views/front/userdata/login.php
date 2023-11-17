<?php

if (@$_GET['loginerror'] === "1")
{
    ?>
    <div class="alert alert-danger">
        <?php echo __("Invalid Login details.", "dev-i18n"); ?>
    </div>
    <?php
}
?>
<form action="" method="post">

    <label for="email">
        <?php echo __("Email Address:", "dev-i18n"); ?> <br>
        <input type="email" name="email" class="form-field w100" />
    </label>

    <br><br>

    <label for="password">
        <?php echo __("Password:", "dev-i18n"); ?> <br>
        <input type="password" name="password" class="form-field w100" />
    </label>

    <br><br>

    <center>
        <input type="submit" name="sbtUserLogin" value="<?php echo __("Login", "dev-i18n"); ?>" class="btn btn-primary" />
    </center>
    

</form>