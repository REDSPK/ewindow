<?php
/**
 * Description of item
 *
 * @author FAIZAN ALI
 */
class Item extends CI_Model {
    protected $me;
    public function __construct()
    {
        $this->load->database();
        $this->load->model('Shop');
        $this->me = $this->session->userdata('user_id');
    }
    function addItem($shopID) {
       $data = array(
           'item_name' => $this->input->post('item_name'),
           'price' => $this->input->post('price'),
           'discount' => $this->input->post('discount'),
           'shop_id' => $shopID
       );
       $query = $this->db->get_where('shop',array('shop_id'=>$shopID));
       $result = $query->row_array();
       if($this->Shop->get_num_items($shopID) < $this->Shop->get_allowed_products($shopID)) {
            try {
                $this->db->insert('item', $data);
            }
            catch (Exception $e) {
                echo $e;
            }
       }
       else {
           die("You have exceeded the number of allowed products");
       }
    }
    function updateItem($itemID) {
        $data = array(
           'item_name' => $this->input->post('item_name'),
           'price' => $this->input->post('price'),
           'discount' => $this->input->post('discount'),
       );
       try { 
            $query = $this->db->where('item_id', $itemID);
            $this->db->update('item', $data);
       }
       catch (Exception $e) {
                echo $e;
        }
    }
    function get_shop_items($shopID) {
        $query = $this->db->get_where('item',array('shop_id'=>$shopID));
        return $query->result();
    }
    function get_item($itemID) {
        $query = $this->db->get_where('item',array('item_id'=>$itemID));
        return $query->row_array();
    }
    /**
     * Description : to add the comment to an existing Item.
     * @param type $itemID 
     */
    function add_comment($itemID) {
        $data = array(
            'item_id' => $itemID,
            'author_id' => $this->me,
            'text' => $this->input->post('comment_text')
        ); 
        try {
             $this->db->insert('item_comments', $data);
        } 
        catch (Exception $e) {
            echo $e;
        }
    }
    
    function get_item_comments($itemID) {
        $query = $this->db->get_where('item_comments',array('item_id'=>$itemID));
        return $query->result();
    }
    /**
     * To delete the item.
     * @param type $itemID 
     */
    function delete_item($itemID) {
        try {
            $this->db->trans_start();
            $query = $this->db->delete('item',array('item_id'=>$itemID));
            $query2 = $this->db->delete('item_comments',array('item_id'=>$itemID));
            $this->db->trans_complete();
        }
        catch (Exception $e) {
            echo $e;
        }
    }
    function get_item_views($itemID) {
        $query = $this->db->select('num_views')->from('item')->where('item_id',$itemID)->get();
        $result = $query->row_array();
        return $result['num_views'];
    }
    function increment_item_views($itemID) {
        $data=array('num_views' => 'num_views+1');
        $query = "UPDATE item SET num_views = num_views + 1 WHERE item_id =$itemID";
        try {
            $this->db->query($query);
        }
        catch (Exception $e) {
            die($e);
        }
    }
    
}

?>
