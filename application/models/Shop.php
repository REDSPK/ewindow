<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Shop
 *
 * @author FAIZAN ALI
 */
class Shop extends CI_Model{
    protected $me;
    public function __construct()
    {
        $this->me = $this->session->userdata('user_id');
        $this->load->database();
    }
    
    public function get_shop($id) {
        $query = $this->db->get_where('shop', array('shop_id'=> $id));
        return $query->row_array();
    }
    public function create_shop($logo_path)
    {
        $categories = $this->input->post('categories');
	$data = array(
		'name' => $this->input->post('name'),
		'alias' => $this->input->post('alias'),
		'mission_statement' => $this->input->post('mission_statement'),
                'owner' => $this->me,
                'logo' => $logo_path,
	);
        try {
            $this->db->insert('shop', $data);
            $shopID = $this->db->insert_id();
            foreach ($categories as $category) {
                try {
                    $this->db->insert('shop_categories',array('shop_id'=>$shopID,'category_id'=>$category));
                }
                catch (Exception $e) {
                    echo $e;
                }
            }
        }
        catch (Exception $e) {
            echo $e;
        }
        return ;
    }
    
    function get_shop_categories($shopID) {
        $query = $this->db->select('category_name')->from('categories')
                ->join('shop_categories', 'categories.category_id = shop_categories.category_id')
                ->where('shop_id',$shopID)->get();
        return $query->result();
    }
    
    function get_shops_by_user($id) {
        $query = $this->db->get_where('shop', array('owner' => $id));
        return $query->result();
    }
    
    function get_shop_by_id($shopID) {
        $query = $this->db->get_where('shop', array('shop_id' => $shopID));
        return $query->row_array();
    }
    
    function get_num_items($shopID) {
        $query = $this->db->get_where('item',array('shop_id'=>$shopID));
        return $query->num_rows();
    }
    
    function get_categories () {
        $query = $this->db->get('categories');
        return $query->result();
    }
    
    /**
     *
     * @TODO
     */
    function deactivate_shop ($shopID) {
        
    }
    
    function add_shop_comments($shopID) {
        $data = array(
            'shop_id' => $shopID,
            'author_id' => $this->me,
            'text' => $this->input->post('comment_text')
        );
        try {
            $this->db->insert('shop_comments',$data);
        }
        catch (Exception $e) {
            echo $e;
        }
    }
    
    function have_delete_rights($commentID) {
        $query = $this->db->get_where('shop_comments',array('id'=>$commentID));
        $comment = $query->row_array();        
        $authorID = $comment['author_id'];
        $shop_owner = $this->get_shop_owner($comment['shop_id']);
        if($shop_owner == $this->me || $authorID == $me ) {
            // The user is the author of the comment or owner of the wishlist
            return true;
        }
        else {
            return false;
        }
    }
    
    function get_shop_comments($shopID) {
        $query = $this->db->select('*')->from('shop_comments')
                ->join('users', 'shop_comments.author_id =  users.id')
                ->where('shop_comments.shop_id',$shopID)->get();
        return $query->result();
    }
    
    function get_shop_owner($shopID) {
        $query = $this->db->select('owner')->from('shop')->where('shop_id',$shopID)->get();
        $result = $query->row_array();
        return $result['owner'];
    }
    
    function remove_shop_comments($commentID) {
        try {
            $this->db->delete('shop_comments',array('id'=>$commentID));
        }
        catch (Exception $error_string) {
            echo $error_string;
        }
    }
    
    function is_my_shop($shopID) {
        if($this->get_shop_owner($shopID) == $this->me) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
    
    function get_allowed_products($shopID) {
        $query = $this->db->get_where('shop',array('shop_id'=>$shopID));
        $result = $query->row_array();
        return $result['allowed_products'];
    }
    
    function get_shop_views($shopID) {
        $query = $this->db->select('num_views')->from('shop')->where('shop_id',$shopID)->get();
        $result = $query->row_array();
        return $result['num_views'];
    }
    
    function increment_shop_views($shopID) {
        $data=array('num_views' => 'num_views+1');
        $query = "UPDATE shop SET num_views = num_views + 1 WHERE shop_id =$shopID";
        try {
            $this->db->query($query);
        }
        catch (Exception $e) {
            die($e);
        }
    }
}

?>
