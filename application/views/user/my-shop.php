<?php $this->load->view('templates/header'); ?>
<h1> Welcome to <?php echo $shop['name']; ?></h1>
<div style="background-color: yellow;width: 17%; ">Views: <?php echo $shop['num_views']; ?></div>
<a href="../add-item/<?php echo $shop['shop_id']; ?>">Add Items To this shop</a>
<?php
    echo "<h3>items</h3>";
    foreach($items as $item):
    echo '<a href="../view-item/'.$item->item_id.'">'.$item->item_name.  '</a>';
    echo '<a href="'.site_url().'/add-item-to-wishlist/'.$item->item_id.'" class="wishlist_item">     Add to Wishlist</a> <br />';
    endforeach;
?>
<h3>Categories</h3>
<?php
    foreach($categories as $category):
    echo $category->category_name; 
    echo '<br />';
    endforeach;
?>

<?php
    $shopID = $shop['shop_id'];
    $attributes = array('id'=>'add_shop_comment_form');
    echo form_open("add-shop-comment/$shopID",$attributes); 
?>
<input type="text" name="comment_text" value="Enter the comment"> <br/>
<input type="submit" name="submit" value="Comment" class="submit_shop_comment">
       
<h3>Comments</h3>
<?php 
    foreach($comments as $comment):
?>
<?php echo $comment->text; ?>
<a href="../remove-shop-comment/<?php echo $comment->id; ?>"> remove comment</a> <br/>
<?php endforeach; ?>

<?php $this->load->view('templates/footer'); ?>