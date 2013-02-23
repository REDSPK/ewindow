<?php $this->load->view('templates/header'); ?>

<h1><?php echo $item['item_name']; ?></h1>
<div style="background-color: yellow;width: 17%; ">Views: <?php echo $item['num_views']; ?></div>
<div class ="notification"></div>
<a href="../view-shop/<?php echo $shop['shop_id'];?>">Back to <?php echo $shop['name']; ?></a>
<br/>
<a href="../edit-item-form/<?php echo $item['item_id'];?>">Edit this Item</a>
<br/>
<a href="../delete-item/<?php echo $item['item_id'];?>">Delete Item</a>
<br/>
<a href="<?php echo site_url(); ?>/add-item-to-wishlist/<?php echo $item['item_id'];?>/21" class="wishlist_item">Add to wishlist</a>
<!--<a href="#" class="wishlist_item" value="">Add to wishlist</a>-->
<br/>

<?php
    $itemID = $item['item_id'];
    $attributes = array('id'=>'add_item_comment_form');
    echo form_open("add-item-comment/$itemID",$attributes); 
?>
<input type="text" name="comment_text" /> <br/>
<input type="submit" name="submit" value="comment" class="submit_item_comment"/> 

<?php
//    var_dump($item);
//    var_dump($shop);
//    var_dump($comments);
?>
<?php echo validation_errors(); ?>

<?php $this->load->view('templates/footer'); ?>
