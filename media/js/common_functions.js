$(document).ready(function(){
    /**
     * add item to the wishlist.
    */
      $('body').on('click', 'a.wishlist_item', function(e) {
            e.preventDefault();
            var link = $(this).attr('href');
            $.ajax({
                url:link,
                data:is_ajax = "1",
                type:'POST',
                success: function(result){
                    $('.notification').html(result);
                }
            });
      });
      /**
       *  Form submission for add item in the shop.
       */
      $('.add_item').click(function(e){
            e.preventDefault();
            var action = $('#add_item_form').attr('action');
            $.ajax({
                url:action,
                data:$('#add_item_form').serialize(),
                type:'POST',
                success: function(result){
                    $('.notification').html(result);
                }
            });
      });
      /**
       * Form submission for creating a new wishlist
       */
      $('.create_wishlist').click(function(e){
            e.preventDefault();
            var action = $('#create_wishlist_form').attr('action');
            $.ajax({
                url:action,
                data:$('#create_wishlist_form').serialize(),
                type:'POST',
                success: function(result){
                    $('.notification').html(result);
                }
            });
      });
      /**
       * Add wishlist comments.
       */
      $('.submit_wishlist_comment').click(function(e){
            e.preventDefault();
            var action = $('#add_wishlist_comment_form').attr('action');
            $.ajax({
                url:action,
                data:$('#add_wishlist_comment_form').serialize(),
                type:'POST',
                success: function(result){
                    $('.notification').html(result);
                }
            });
      });
      /**
       * Add Item comments.
       */
      $('.submit_item_comment').click(function(e){
            e.preventDefault();
            var action = $('#add_item_comment_form').attr('action');
            $.ajax({
                url:action,
                data:$('#add_item_comment_form').serialize(),
                type:'POST',
                success: function(result){
                    $('.notification').html(result);
                }
            });
      });
      /**
       * Add shop comments
       */
      $('.submit_shop_comment').click(function(e){
            e.preventDefault();
            var action = $('#add_shop_comment_form').attr('action');
            $.ajax({
                url:action,
                data:$('#add_shop_comment_form').serialize(),
                type:'POST',
                success: function(result){
                    $('.notification').html(result);
                }
            });
      });
      
      /**
       * TODO : Remove Item from the wishlist
       */
      
    });

