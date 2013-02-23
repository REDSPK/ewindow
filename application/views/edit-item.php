<html>
    <head>
        
    </head>
<body>
    
<h2>Add Items to your Shop</h2>

<?php echo validation_errors(); ?>

<?php echo form_open_multipart('validate-edit-item/'.$item['item_id']); ?>

    Item Name: <input type="text" name="item_name" value =" <?php echo $item['item_name']; ?>"> <br />
    Price: <input type="text" name="price" value =" <?php echo $item['price']; ?>">  <br/>
    Discount: <input type="text" name="discount" value =" <?php echo $item['discount']; ?>"> <br/>
    

    <input type="submit" name="submit" value="update Item" /> 

</form>
</body>
</html>
