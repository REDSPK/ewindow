<?php $this->load->view('templates/header'); ?>
<h1>Your Wish lists</h1>
<?php
    foreach($wishlists as $wishlist){
?>
<a href="view-my-wishlist/<?php echo $wishlist->wishlist_id;?>"><?php echo $wishlist->wishlist_name; ?></a> <br/>
<?php
    }
?>
<?php $this->load->view('templates/footer'); ?>