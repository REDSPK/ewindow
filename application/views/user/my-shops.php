<?php $this->load->view('templates/header'); ?>
<h1>My Shops</h1>
<?php foreach($shops as $shop):?>
    <h4><a href="view-shop/<?php echo $shop->shop_id ?>"><?php echo $shop ->name;?></a></h4>
<?php
    endforeach;
//    var_dump($shops);
?>
<?php $this->load->view('templates/footer'); ?>