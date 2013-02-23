<?php

/**
 * @todo : add to default wishlist if no wishlist created.
 * @todo : wishlist comments.
 */

/**
 * Description of Wishlist
 *
 * @author FAIZAN ALI
 */
class Wishlist_controller extends CI_Controller {
    protected $me;
    public function __construct() {
        parent::__construct();
        $this->load->model('Wishlist');
        $this->load->helper('form');
	$this->load->library('form_validation');
        $this->me = $this->session->userdata('user_id');
    }
    function create_wishlist() {
       if($this->ion_auth->logged_in()) {
           $this->form_validation->set_rules('wishlist_name', 'Wishlist Name', 'required|xss_clean');
           if ($this->form_validation->run() === FALSE)
            {
               if($this->input->is_ajax_request()) {
                   echo validation_errors();
               }
               else {
                    if($this->ion_auth->in_group(SHOP_OWNER)){
                        redirect('shop-owner-home');
                    }
                    else if($this->ion_auth->in_group(SHOPPER)){
                        redirect('shopper-home');
                    }
               }
            }
            else if($this->input->post('wishlist_name') == 'Wishlist' || $this->input->post('wishlist_name') == 'wishlist') {
                if($this->input->is_ajax_request()) {
                   echo "'Wishlist' is a reserved name. please choose another name";
               }
               else {
                   $this->session->set_flashdata('notification', "'Wishlist' is a reserved name. please choose another name");
                    if($this->ion_auth->in_group(SHOP_OWNER)){
                        redirect('shop-owner-home');
                    }
                    else if($this->ion_auth->in_group(SHOPPER)){
                        redirect('shopper-home');
                    }
               }
            }
            else {
                $this->Wishlist->create_wishlist();
                if($this->input->is_ajax_request()){
                    echo "Wishlist created";
                }
                else {
                    if($this->ion_auth->in_group(SHOP_OWNER)){
                        $this->session->set_flashdata('notification', 'Wishlist Created');
                        redirect('shop-owner-home');
                    }
                    else if($this->ion_auth->in_group(SHOPPER)){
                        $this->session->set_flashdata('notification', 'Wishlist Created');
                        redirect('shopper-home');
                    }
                }
            }
       } 
       else {
           $this->session->set_flashdata('notification', 'You are not logged in');
           redirect('login-form');
       }
    }
    
    function add_to_wishlist($itemID,$wishlistID = NULL) {
       if($this->ion_auth->logged_in()) {
           if($wishlistID) { //if user already has a wishlist
               if($this->Wishlist->is_my_wishlist($wishlistID)) {
                   if(!$this->Wishlist->item_exists_in_wishlist($itemID,$wishlistID)) {
                        $this->Wishlist->add_to_wishlist($itemID,$wishlistID);
                        if($this->input->is_ajax_request()) {
                            echo 'Item added in the wishlist';
                        }
                        else {
                            $this->session->set_flashdata('notification', 'Item added in the wishlist');
                            redirect('view-my-wishlist/'.$wishlistID);
                        }
                   }
                   else { //if the item already exist in that particular wishlist
                       if($this->input->is_ajax_request()) {
                            echo 'The items already exists in this wishlist';
                        }
                        else {
                            $this->session->set_flashdata('notification', 'The items already exists in this wishlist');
                            redirect('view-my-wishlist/'.$wishlistID);
                        }
                   }
               }
               else { //if user is not the owner of that wishlist
                   if($this->input->is_ajax_request()) {
                            echo 'You dont have the rights to add to this wishlist';
                        }
                    else {
                        $this->session->set_flashdata('notification', 'You dont have the rights to add to this wishlist');
                        redirect('view-my-wishlist/'.$wishlistID);
                    }
               }
           }
           else { //make it add to default wishlist if no wishlist is created @TODO
                $wishlistID = $this->Wishlist->get_default_wishlist();
                if(!$this->Wishlist->item_exists_in_wishlist($itemID,$wishlistID)) {
                    $this->Wishlist->add_to_wishlist($itemID,$wishlistID);
                    if($this->input->is_ajax_request()) {
                        echo 'Item added in the wishlist';
                    }
                    else {
                        $this->session->set_flashdata('notification', 'Item added in the wishlist');
                        redirect('view-my-wishlist/'.$wishlistID);
                    }
                }
                else {
                    if($this->input->is_ajax_request()) {
                        echo 'The items already exists in this wishlist';
                    }
                    else {
                        $this->session->set_flashdata('notification', 'The items already exists in this wishlist');
                        redirect('view-my-wishlist/'.$wishlistID);
                    }
                }
           }
        }
       else { //if the user is not logged in
            if($this->input->is_ajax_request()) {
                    echo 'You dont have the rights to add to this wishlist';
            }
            else {
                $this->session->set_flashdata('notification', 'You are not logged in');
                redirect('login-form');
            }
       }
    }
   
    function get_user_wishlists($userID = NULL) {
       $data['wishlists'] = $this->Wishlist->get_user_wishlists($userID);
       if($userID == NULL || $userID == $this->me) {
           $this->load->view('user/my-wishlists',$data);
       } 
       else {
           $this->load->view('user/user-wishlists',$data);
       }
    }
    
    function view_wishlist($wishlistID) {
       $data['wishlist_items'] = $this->get_wishlist_items($wishlistID);
       $data['wishlist_comments'] = $this->Wishlist->get_wishlist_comments($wishlistID);
       $data['wishlistID'] = $wishlistID;
       if($this->ion_auth->logged_in() && $this->Wishlist->is_my_wishlist($wishlistID)) {
           $this->load->view('user/view-my-wishlist',$data);
       } 
       else {
           $this->load->view('user/view-user-wishlist',$data);
       }
    }
    
    function get_wishlist_items($wishlistID) {
        return $this->Wishlist->get_wishlist_items($wishlistID);
    }
    function remove_item_from_wishlist($itemID,$wishlistID) {
        if($this->ion_auth->logged_in()) {
           if($this->Wishlist->is_my_wishlist($wishlistID)) {
               if($this->Wishlist->item_exists_in_wishlist($itemID,$wishlistID)) {
                    $this->Wishlist->remove_item_from_wishlist($itemID,$wishlistID);
                    redirect('view-my-wishlist/'.$wishlistID);
               }
           }
           else {
               echo "You cannot remove item from this wishlist as you are not the owner";
           }
       }
       else {
           echo "Please login to continue";
       }
    }
   
    function remove_wishlist($wishlistID) {
       if($wishlistID == $this->Wishlist->get_default_wishlist()) {
           if($this->input->is_ajax_request()) {
               echo "You cannot remove default wishlist";
           }
           else {
                $this->session->set_flashdata('notification','You cannot remove default wishlist');
                redirect('my-wishlists');
           }
       }
       if($this->ion_auth->logged_in()) {
           if($this->Wishlist->is_my_wishlist($wishlistID)) {
               if($this->input->is_ajax_request()) {
                   echo "The wishlist has been removed";
               }
               else {
                    $this->Wishlist->remove_wishlist($wishlistID);
                    redirect('my-wishlists');
               }
           }
           else {
               if($this->input->is_ajax_request()) {
                   echo 'You dont have the rights to remove this wishlist';
               }
               else {
                    $this->session->set_flashdata('notification','You dont have the rights to remove this wishlist');
                    redirect('my-wishlists');
               }
           }
       }
       else {
           $this->session->set_flashdata('notification', 'You must be Logged in to remove wishlist');
           redirect('login-form');
       }
    }
    
    function add_wishlist_comments($wishlistID) {
        $this->form_validation->set_rules('comment_text', 'Name', 'required|xss_clean');
        if ($this->form_validation->run() == FALSE)
        {
           if($this->input->is_ajax_request()) {
                echo 'Comment text missing';
            }
            else {
                $this->session->set_flashdata('notification', 'Comment text missing');
                redirect('view-my-wishlist/'.$wishlistID);
            }
        }
        else {
            $this->Wishlist->add_wishlist_comments($wishlistID);
            if($this->input->is_ajax_request()) {
                echo 'Your comment has been added via ajax request';
            }
            else {
                $this->session->set_flashdata('notification', 'Your comment has been added via non ajax request');
                 redirect('view-my-wishlist/'.$wishlistID);
            }
        }
    }
    
    function remove_wishlist_comments($commentID) { //redirect to the same page
        if($this->Wishlist->have_delete_right($commentID) ) {
            $this->Wishlist->remove_wishlist_comments($commentID);
            echo "Comment deleted";
        }
        else {
            echo "This is not your comment hence you cant delete it";
        }
    }
}

?>
