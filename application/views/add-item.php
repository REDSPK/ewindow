<?php $this->load->view('templates/header'); ?>
    
<h2>Add Items to your Shop</h2>

<?php echo validation_errors(); ?>

<?php
    $attributes = array('id'=>'add_item_form');
    echo form_open_multipart("validate-add-item/$shopID",$attributes);
    ?>

    Item Name: <input type="text" name="item_name" > <br />
    Price: <input type="text" name="price" > <br/>
    Discount: <input type="text" name="discount" > <br/>
    

    <input type="submit" name="submit" value="Add Item" class="add_item" /> 

</form>
<?php $this->load->view('templates/footer'); ?>


