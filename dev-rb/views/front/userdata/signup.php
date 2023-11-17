<?php
global $clsDefineRoles;
$arrRoles = $clsDefineRoles->get_records();

if (@$_GET['signup'] === "1")
{
    ?>
    <div class="alert alert-success">
        <?php echo __("User Signup successful.", "dev-i18n"); ?>
    </div>
    <?php
}

?>
<form action="" method="post">

    <label for="business">
        <?php echo __("Business Name:", "dev-i18n"); ?> <br>
        <input type="text" name="userData_Name_Business" class="form-field w100" />
    </label>

    <br><br>

    <label for="business">
        <?php echo __("Role:", "dev-i18n"); ?> <br>
        <select name="userData_Define_Role_Id_FK" id="userData_Define_Role_Id_FK" class="form-field w100">
            <?php
            foreach ($arrRoles as $objRole)
            {
                if (
                        $objRole->define_Role_Id_PK != "role-business" && 
                        $objRole->define_Role_Id_PK != "role-engineer"
                ) continue;

                ?>
                <option value="<?php echo $objRole->define_Role_Id_PK ?>"><?php echo $objRole->define_Role_Name; ?></option>
                <?php
            }
            ?>
        </select>
    </label>

    <br><br>

    <label for="fname">
        <?php echo __("First Name:", "dev-i18n"); ?> <br>
        <input type="text" name="userData_Name_First" class="form-field w100" onblur="javascript: setPreferredName(this.value);" />
    </label>

    <br><br>

    <label for="lname">
        <?php echo __("Last Name:", "dev-i18n"); ?> <br>
        <input type="text" name="userData_Name_Last" class="form-field w100" />
    </label>

    <br><br>

    <label for="pname">
        <?php echo __("Preferred Name:", "dev-i18n"); ?> <br>
        <input type="text" name="userData_Name_Preferred" class="form-field w100" />
    </label>

    <br><br>

    <label for="timezon">
        <?php echo __("Timezone:", "dev-i18n"); ?> <br>
        <select name="userData_Timezone" id="userData_Timezone" class="form-field w100">
            <option value="US">United States</option>
        </select>
    </label>

    <br><br>

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
        <input type="submit" name="sbtUserSignup" value="<?php echo __("Signup", "dev-i18n"); ?>" class="btn btn-primary" />
    </center>
    

</form>

<script>
function setPreferredName(firstname) {
    jQuery('input[name=userData_Name_Preferred]').val( firstname );
}    
</script>