<html>
    <head>
        
    </head>
<body>
    
<h2>Register to E-window</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('validate-login') ?>

    
    Username : <input type="text" name="username" > <br/>
    Password : <input type="password" name="password" > <br/>

    <input type="submit" name="submit" value="Create news item" /> 

</form>

</body>
</html>


