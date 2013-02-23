

<?php foreach ($shops as $shop): ?>
    <a href="../view-shop/<?php echo $shop->shop_id;?>"><?php echo $shop->name; ?></a>
   <?php endforeach; ?>

