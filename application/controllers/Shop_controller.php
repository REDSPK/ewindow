<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of shop_controller
 *
 * @author FAIZAN ALI
 */
class Shop_controller extends CI_Controller {
    protected $me;
    public function __construct()
    {
        parent::__construct();
        $config = array();
        $this->load->model('Shop');
        $this->load->model('Ion_auth_model');
        $this->load->model('Item');
        $this->load->helper('form');
	$this->load->library('form_validation');
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = ALLOWED_IMAGE_MIMES;
        $config['max_size']	= MAX_LOGO_SIZE;
        $config['max_width']  = MAX_LOGO_WIDTH;
        $config['max_height']  = MAX_LOGO_HEIGHT;
        $this->load->library('upload', $config);
        $this->upload->initialize($config); 
    }
    function create_shop() {
        if($this->ion_auth->logged_in() && $this->ion_auth->in_group(SHOP_OWNER) ) {
            $data['categories'] = $this->get_categories();
            $this->load->view('shop/create_shop',$data);
        }
        else {
            echo "Please login to continue or you dont have the rights to create the shop";
        }
    }
    //put your code here
    function validate_and_create_shop() {
        if($this->ion_auth->logged_in() && $this->ion_auth->in_group(SHOP_OWNER)) {
            $this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
            $this->form_validation->set_rules('alias', 'Alias', 'required|xss_clean');
            $this->form_validation->set_rules('mission_statement', 'Mission Statement', 'required|xss_clean');
            if ($this->form_validation->run() === FALSE)
            {
                    $this->load->view('shop/create_shop');
            }
            else if (!$this->upload->do_upload('shop_logo')) {
               
                echo $this->upload->display_errors();
//                $this->load->view('upload_form', $error);
            }
            else
            {       
                    $uploaded_data =  $this->upload->data();
                    $logo_path = 'http://localhost/ewindow/trunk/ewindow/uploads/'.$uploaded_data['file_name'];
                    $this->Shop->create_shop($logo_path);
                    redirect('my-shops');
            }
        }
        else {
            echo "access forbidden";
        }
    }
    function view_shop($shopID) {
        $this->Shop->increment_shop_views($shopID);
        $data['shop'] = $this->Shop->get_shop_by_id($shopID);
        $data['items'] = $this->get_items_by_shop($shopID);
        $data['categories'] = $this->get_shop_categories($shopID);
        $data['comments'] = $this->Shop->get_shop_comments($shopID);
        if (empty($data['shop'])) {
		echo "No data found in shop";
	}
        else {
            if($this->Shop->is_my_shop($shopID)) {
                $this->load->view('user/my-shop',$data);
            }
            else {
                $this->load->view('shop/view-shop',$data);
            }
        }
    }
    
    function get_categories() {
       return $this->Shop->get_categories();
    }
    
    function get_shop_categories($shopID) {
        return $this->Shop->get_shop_categories($shopID);
    }
    /*
     * Returns all the shops of a particular user if a user id is passed
     * If no user Id is passed returns the logged in user shops
     */
    function get_shops_by_user($id = NULL) {
        if($id) {
            $user = $this->ion_auth->user()->row($id);
        }
        else {
            if($this->ion_auth->logged_in()) {
                $user = $this->ion_auth->user()->row();
            }
            else {
                echo "please login to view your shops continue";
            }
        }
        $data['shops'] = $this->Shop->get_shops_by_user($user->id);
        $this->load->view('user/my-shops',$data); 
    }
    
    function get_items_by_shop($shopID) {
        $data = $this->Item->get_shop_items($shopID);
        return $data;
    }
    
    function add_shop_comments($shopID) {
        $this->form_validation->set_rules('comment_text', 'Name', 'required|xss_clean');
        if ($this->form_validation->run() === FALSE)
        {
           if($this->input->is_ajax_request()) {
                echo 'Comment text missing';
            }
            else {
                $this->session->set_flashdata('notification', 'Comment text missing');
                 redirect('view-shop/'.$shopID);
            }
        }
        else {
            $this->Shop->add_shop_comments($shopID);
            if($this->input->is_ajax_request()) {
                echo 'Your comment has been added via ajax request';
            }
            else {
                $this->session->set_flashdata('notification', 'Your comment has been added via non ajax request');
                 redirect('view-shop/'.$shopID);
            }         
        }
    }
    
    function remove_shop_comments($commentID){ 
        if($this->Shop->have_delete_rights($commentID)) {
            $this->Shop->remove_shop_comments($commentID);
            echo "Comment deleted";
        }
        else {
            echo "This is not your comment hence you cant delete it";
        }
    }
}

?>
