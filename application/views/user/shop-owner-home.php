<?php $this->load->view('templates/header'); ?>
<?php 
    $user = $this->ion_auth->user()->row(); 
?>
<h1>Welcome <?php echo ($user->first_name); ?></h1>
<a href="create-shop">Add a new shop</a> <br/>
<a href="my-shops">See your Shops</a> <br/>
<a href="my-wishlists">See you wishlists</a>
<?php
    $attributes = array('id'=>'create_wishlist_form');
    echo form_open('create-wishlist',$attributes); 
?>
Wishlist Name: <input type="text" name="wishlist_name" /> <br />
<input type="submit" name="submit" value="Create Wishlist" class="create_wishlist"/> <br/>

<?php $this->load->view('templates/footer'); ?>