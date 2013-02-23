<html>
<head>
	<title>E-Window</title>
        <script src="<?php echo ROOT_URL; ?>media/js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo ROOT_URL; ?>media/js/common_functions.js"></script>
</head>
<body>
    <a href="<?php echo site_url(); ?>/home">Home Page</a>
    <a href="<?php echo site_url(); ?>/my-shops">My Shops</a>
    <a href="<?php echo site_url(); ?>/my-wishlists">My Wishlists</a>
    
    <br />
    <div class="notification">
        <?php if($this->session->flashdata('notification')) {
            echo $this->session->flashdata('notification');
        }
?>
    </div>
