<?php
/**
 * Description of resgiter_user
 *
 * @author faizan.ali
 */
class User_Controller extends CI_Controller{
    //put your code here
    protected $me;
    public function __construct() {
        parent::__construct();
        $this->load->model('Ion_auth_model');
        $this->load->model('Wishlist');
        $this->load->helper('form');
	$this->load->library('form_validation');
        $this->me = $this->session->userdata('user_id');
    }
    function view_home_page() {
        if($this->ion_auth->in_group(SHOP_OWNER)){
                redirect('shop-owner-home');
        }
        else if($this->ion_auth->in_group(SHOPPER)){
            redirect('shopper-home');
        }
    }
    function open_registration_form () {
        $this->load->view('user/register');
    }
    function activate_account($activation_code,$id) {
            if($this->Ion_auth_model->activate($id,$activation_code))
            {
                $url = '/login-form';
                $message = 'Congratulation!! Your account has been activated. please <a href='.$url.'>Login to the E-window</a>';
                
                $this->session->set_flashdata('activation-status',$message);
                redirect('account-activation-status');
            }
            else {
                   $message = "You have either clicked a wrong link or your activation link has expired. please register again";
                   $this->session->set_flashdata('activation-status',$message);
                   redirect('account-activation-status');
            }
//        
    }
    function account_activation_status_view() {
        $data['msg'] = $this->session->flashdata('activation-status');
        $this->load->view('user/account-activation-status',$data);
    }
    function validate_and_register() {
        /**
         * Load form helper classes and set validation rules
         */
        $this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
        $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[users.username]');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
        
        if($this->form_validation->run() == FALSE) {
            $this->load->view('user/register');
        }
        else {
            
            $password = $this->input->post('password');
            $email = $this->input->post('email');
            $username = $email;
            $group = $this->input->post('user_type');
            $user_group = array($group);
            $additionalInformation = array (
                                     'first_name' => $this->input->post('first_name'),
                                     'last_name' => $this->input->post('last_name'),
                                     'phone' => $this->input->post('contact_number'),
                                    );
           
           $data =  $this->ion_auth->register($username, $password, $email, $additionalInformation,$user_group);
           $message = "an email with activation link has been sent to your account. please click the link to activate ur account";
           $this->session->set_flashdata('activation-status',$message);
           redirect('account-activation-status');
        }
    }
    function open_login_form () {
        $this->load->view('user/login');
    }
    function redirect_shop_owner_home() {
        $this->load->view('user/shop-owner-home');
    }
    function redirect_shopper_home () {
        $this->load->view('user/shopper-home');
    }
    function validate_and_login() {
        $password = $this->input->post('password');
        $username = $this->input->post('username');
        
        if($this->ion_auth->login($username, $password)){
            $user = $this->ion_auth->user()->row();
            $data['user'] = $user;
            $this->view_home_page();
        }
        else {
            $this->load->view('user/login');
        }
    }
    function login_with_facebook() {
        $fb_data = $this->session->userdata('fb_data'); // This array contains all the user FB information
        if((!$fb_data['uid']) or (!$fb_data['me']))
        {
            redirect('login-form');
        }
        else
        {
            $data = array(
                    'fb_data' => $fb_data,
                    );
            $this->load->view('home', $data);
        }
    }  
    
}

?>
