<html>
    <head>
        
    </head>
<body>
    
<h2>Create a new Shop</h2>

<?php echo validation_errors(); ?>

<?php echo form_open_multipart('validate-shop'); ?>

Name: <input type="text" name="name" > <br />
alias: <input type="text" name="alias" > <br />
mission Statement : <input type="text" name="mission_statement" > <br />
Logo : <input type="file" name="shop_logo" > <br />

<?php foreach ($categories as $category) { ?>
<input type="checkbox" name="categories[]" value="<?php echo $category->category_id;?>" /> <?php echo $category->category_name;?>
<?php } ?>	
	<input type="submit" name="submit" value="Create Shop" /> 
        
</form>
</body>
</html>
