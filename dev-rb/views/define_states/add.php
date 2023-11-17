<div class="wrap">
    <h2>Add State</h2>
    
    <form action="" method="post">
        <table class="form-table">

            <tr class="form-field">
                <th>
                    <label>ID:</label>
                </th>
                <td>
                    <input name="define_State_Id_PK" type="text" id="define_State_Id_PK" value="">
                </td>
            </tr>

            <tr class="form-field">
                <th>
                    <label>Name:</label>
                </th>
                <td>
                    <input name="define_State_Name" type="text" id="define_State_Name" value="">
                </td>
            </tr>

            <tr class="form-field">
                <th>
                    <label>2 Character:</label>
                </th>
                <td>
                    <input name="define_State_2Character" type="text" id="define_State_2Character" value="">
                </td>
            </tr>

            <tr class="form-field">
                <th>
                    <label>Enabled:</label>
                </th>
                <td>
                    <select name="define_State_is_Enabled" id="define_State_is_Enabled">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </td>
            </tr>

        </table>

        <p class="submit">
            <input type="submit" name="add_define_state" id="add_define_state" class="button button-primary" value="Add State">
        </p>

    </form>
</div>