<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of item_controller
 *
 * @author FAIZAN ALI
 */
class item_controller extends CI_Controller{
    //put your code here
     public function __construct()
    {
        parent::__construct();
        $this->load->model('Ion_auth_model');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('Item');
    }
    function load_additem_form ($shopID) {
        if($this->ion_auth_model->is_my_shop($shopID) && $this->ion_auth->logged_in()) 
        {
            $data['shopID'] = $shopID;
            $this->load->view('add-item',$data);
        }
        else {
            echo "Access not granted";
        }
    }
    /*
     * Add the items to the shop, given the shop id
     */
    function validate_and_add_item($shopID) {
        if($this->ion_auth_model->is_my_shop($shopID) && $this->ion_auth->logged_in() ) {
            $this->form_validation->set_rules('item_name', 'Item Name', 'required|xss_clean');
            $this->form_validation->set_rules('price', 'Item Price', 'required|xss_clean');
            if ($this->form_validation->run() === FALSE)
            {
                if($this->input->is_ajax_request()) {
                    echo validation_errors();
                }
                else {
                    $this->load->view('add-item');
                }
                    
            }
            else
            {
                $this->Item->addItem($shopID);
                if($this->input->is_ajax_request()) {
                    echo "Item added to the shop";
                }
                else {
                    $this->session->set_flashdata('notification', 'Item added to the shop');
                     redirect('view-shop/'.$shopID);
                }             
            }
        }
        else {
            echo "please login to continue.. or you are not the owner of this shop";
        }
    }
    function validate_and_update_item($itemID) {
        $data['item'] = $this->Item->get_item($itemID);
        if($this->ion_auth_model->is_my_shop($data['item']['shop_id']) && $this->ion_auth->logged_in() )
        {
            $this->form_validation->set_rules('item_name', 'Item Name', 'required|xss_clean');
            $this->form_validation->set_rules('price', 'Item Price', 'required|xss_clean');

            if ($this->form_validation->run() === FALSE)
            {
                $data['item'] = $this->Item->get_item($itemID);
                $this->load->view('edit-item',$data);
            }
            else
            {
                $this->Item->updateItem($itemID);
                redirect('view-item/'.$itemID);
            }
        }
        else {
            echo "You dont have rights to eidt this Item";
        }
    }
    /*
     * View a particular item, get the item ID and returns the item Object.
     * @TODO: optimize this by performing a join on shop and item and get the selected data only
     */
    function view_item($itemID) {
        $data['item'] = $this->Item->get_item($itemID);
        $this->Item->increment_item_views($itemID);
        if($data['item']) {
             $data['comments'] = $this->get_item_comments($itemID);
             $data['shop'] = $this->Shop->get_shop($data['item']['shop_id']);
             if(!$this->ion_auth_model->is_my_shop($data['item']['shop_id'])) {
                    $this->load->view('shop/view-item',$data);
             }
             else {
                 $this->load->view('user/view-my-item',$data);
             }
        } else {
            echo "No item with this ID found";
            die();
        }
    }
    /**
     * Description : To edit the item
     * @param type $itemID 
     */
    function edit_item($itemID) {
        
        $data['item'] = $this->Item->get_item($itemID);
        if($data && $this->ion_auth_model->is_my_shop($data['item']['shop_id']) && $this->ion_auth->logged_in()) {
            $this->load->view('edit-item',$data);
        } else {
            echo "No item with this ID found or you dont have the rights. or log in";
            die();
        }
    }
    /**
     *
     * @param type $itemID 
     */
    function add_comment($itemID) {
        if($this->ion_auth->logged_in()) {
            $data['item'] = $this->Item->get_item($itemID);
            $data['shop'] = $this->Shop->get_shop($data['item']['shop_id']);
            $data['comments'] = $this->get_item_comments($itemID);
            $this->form_validation->set_rules('comment_text', 'Comment Text', 'required|xss_clean');
            if ($this->form_validation->run() === FALSE)
            {
                if($this->input->is_ajax_request()) {
                    echo 'Comment text missing';
                }
                else {
                    $this->session->set_flashdata('notification', 'Comment text missing');
                    redirect("view-item/$itemID");
                    return;
                }
            }
            $this->Item->add_comment($itemID);
            if($this->input->is_ajax_request()) {
                echo 'Your comment has been added via ajax request';
            }
            else {
                $this->session->set_flashdata('notification', 'Your comment has been added via non ajax request');
                redirect("view-item/$itemID");
            }
        }
        else {
            echo "You must login first to add comment";
        }
    }
    /**
     * To all the comments of a particular item. User login is not required to vew item comments.
     * @param type $itemID 
     */
    function get_item_comments($itemID) {
        return $this->Item->get_item_comments($itemID);
    }
    
    function delete_item($itemID) {
        $this->Item->delete_item($itemID);
        echo "item Deleted";
        
    }
    
    
}

?>
