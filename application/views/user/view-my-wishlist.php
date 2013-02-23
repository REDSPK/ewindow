<?php $this->load->view('templates/header'); ?>
<?php
//    var_dump($wishlist_items);
//    var_dump($wishlist_comments);
    echo "<br />"; 
    echo "<a href='../remove-wishlist/$wishlistID'>remove wishlist</a>";
    echo '<h2>Items</h2>'; 
    foreach($wishlist_items as $item) {
       echo '<a href="../view-item/'.$item->item_id.'">'.$item->item_name.'</a> ';
       echo '<a href="../remove-item-from-wishlist/'.$item->item_id.'/'.$item->wishlist_id.'">Romve This Item</a> <br/>';
?>

<?php 
    }
?>
<h3>Comment</h3>
<?php
    $attributes = array('id'=>'add_wishlist_comment_form');
    echo form_open("add-wishlist-comment/$wishlistID",$attributes); 
?>
<input type="text" name="comment_text" value="Exter the comment"> <br/>
<input type="submit" name="submit" value="Comment" class="submit_wishlist_comment"/>

<?php $this->load->view('templates/footer'); ?>