<html>
    <head>
        
    </head>
<body>
    
<h2>Register to E-window</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('validate-user') ?>

    First Name: <input type="text" name="first_name" > <br />
    Last Name: <input type="text" name="last_name" > <br/>
    E-mail : <input type="text" name="email" > <br/>
    Password : <input type="password" name="password" > <br/>
    Confirm Password : <input type="password" name="password_confirm" > <br/>
    Contact Number : <input type="text" name="contact_number" ><br/>
    Register as : <select name="user_type">
                        <option value="2">Shopper</option>
                        <option value="3">Shop Owner </option>
                  </select>
    <br />
    <input type="submit" name="submit" value="Register" /> 

</form>
</body>
</html>

