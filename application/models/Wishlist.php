<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Wishlist
 *
 * @author FAIZAN ALI
 */
class Wishlist extends CI_Model {
    protected $me;
    public function __construct()
    {
        $this->load->database();
        $this->me = $this->session->userdata('user_id');
    }
    function create_wishlist() {
        $data = array(
            'wishlist_name' => $this->input->post('wishlist_name'),
            'user_id' => $this->me
        );
        try {
            $this->db->insert('wishlist',$data);
            return $this->db->insert_id();
        }
        catch (Exception $e) {
            echo $e;
        }
    }
    
    function add_to_wishlist($itemID,$wishlistID) {
        $data = array(
            'wishlist_id' => $wishlistID,
            'item_id' => $itemID
        );
        try {
            $this->db->insert('wishlist_items',$data);
        }
        catch (Exception $e) {
            echo $e;
        }
    }
    function get_user_wishlists($userID) {
        if($userID == NULL) {
            $userID = $this->me;
        }
        $query = $this->db->get_where('wishlist',array('user_id'=>$userID));
        return $query->result();
    }
    
    function get_wishlist_items($wishlistID) {        
        $query = $this->db->select('*')->from('wishlist_items')
                ->join('item', 'wishlist_items.item_id =  item.item_id')
                ->where('wishlist_items.wishlist_id',$wishlistID)->get();
        return $query->result();        
    }
    
    function remove_item_from_wishlist($itemID,$wishlistID) {
       try {
           $this->db->delete('wishlist_items',array('wishlist_id'=>$wishlistID,'item_id'=>$itemID ));
        }
        catch (Exception $error_string) {
            echo $error_string;
        }
    }
    
    function get_wishlist_owner($wishlistID) {
        $query = $this->db->select('user_id')->from('wishlist')->where('wishlist_id',$wishlistID)->get();
        return $query->row_array();
    }
    
    function item_exists_in_wishlist($itemID,$wishlistID) {
        $query = $this->db->get_where('wishlist_items',array('wishlist_id'=>$wishlistID,'item_id'=>$itemID));
        $count = $query->num_rows();
        if($count >= 1) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
   /**
    *
    * @TODO: Implement this with transaction handling
    * 
    */
    function remove_wishlist($wishlistID) {
        $this->db->trans_start();
        $this->db->delete('wishlist_items',array('wishlist_id'=>$wishlistID));
        $this->db->delete('wishlist_comments',array('wishlist_id'=>$wishlistID));
        $this->db->delete('wishlist',array('wishlist_id'=>$wishlistID));
        $this->db->trans_complete();
    }
    
    function add_wishlist_comments($wishlistID) {
        $data = array(
            'wishlist_id' => $wishlistID,
            'author_id' => $this->me,
            'text' => $this->input->post('comment_text')
        );
        try {
            $this->db->insert('wishlist_comments',$data);
        }
        catch (Exception $e) {
            echo $e;
        }
        
    }
    
    function get_wishlist_comments($wishlistID) { // @todo:  Filter only the required data
        $query = $this->db->select('*')->from('wishlist_comments')
                ->join('users', 'wishlist_comments.author_id =  users.id')
                ->where('wishlist_comments.wishlist_id',$wishlistID)->get();
        return $query->result();
    }
    
    function remove_wishlist_comments($commentID) {
        try {
            $this->db->delete('wishlist_comments',array('id'=>$commentID));
        }
        catch (Exception $error_string) {
            echo $error_string;
        }
    }
    
    function have_delete_right($commentID) {
        $query = $this->db->get_where('wishlist_comments',array('id'=>$commentID));
        $comment = $query->row_array();
        $wishlistID = $comment['wishlist_id'];
        $authorID = $comment['author_id'];
        $wishlist_owner = $this->get_wishlist_owner($wishlistID);
        if($wishlist_owner['user_id'] == $this->me || $authorID == $this->me ) {
            // The user is the author of the comment or owner of the wishlist
            return true;
        }
        else {
            return false;
        }
    }
    
    function is_my_wishlist($wishlistID) {
        $owner = $this->get_wishlist_owner($wishlistID);
        if($owner['user_id'] == $this->me) {
            return true;
        }
        else {
            return false;
        }
    }
    function get_default_wishlist() {
        $result = $this->db->select('wishlist_id')->from('wishlist')->where(array('wishlist_name'=>'Wishlist','user_id'=>$this->me))->get()->row_array();
        return $result['wishlist_id'];
    }
}

?>
