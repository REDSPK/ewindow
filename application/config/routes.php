<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['default_controller'] = 'welcome/index';

$route['create-shop'] = 'Shop_controller/create_shop';
$route['create-wishlist'] = 'Wishlist_controller/create_wishlist';
$route['my-shops'] = 'Shop_controller/get_shops_by_user';
$route['register-user'] = 'User_controller/open_registration_form';
$route['login-form'] = "User_controller/open_login_form";
$route['my-wishlists'] = 'Wishlist_controller/get_user_wishlists';
$route['user-wishlists/(:any)'] = 'Wishlist_controller/get_user_wishlists/$1';


/*
 * Form Action routes
 */

$route['validate-shop'] = 'Shop_controller/validate_and_create_shop';
$route['validate-login'] = 'User_controller/validate_and_login';
$route['validate-user'] = 'User_controller/validate_and_register';
$route['shopper-home'] = 'User_controller/redirect_shopper_home';
$route['shop-owner-home'] = 'User_controller/redirect_shop_owner_home';
$route['account-activation-status'] = 'User_controller/account_activation_status_view';
$route['home'] = 'User_controller/view_home_page';

/*
 * Routes with arguments
 */

$route['activate-account/(:any)'] = 'User_controller/activate_account/$1';
$route['validate-item/(:any)'] = 'item_controller/validate_and_add_item/$1';
$route['add-item/(:any)'] = 'item_controller/load_additem_form/$1';
$route['view-shop/(:any)'] = 'Shop_controller/view_shop/$1';
$route['view-shops-by-category/(:any)'] = 'Shop_controller/view_shops_by_category/$1';
$route['edit-item-form/(:any)'] = 'item_controller/edit_item/$1';
$route['validate-add-item/(:any)'] = 'item_controller/validate_and_add_item/$1';
$route['validate-edit-item/(:any)'] = 'item_controller/validate_and_update_item/$1';
$route['view-item/(:any)'] = 'Item_controller/view_item/$1';
$route['add-item-comment/(:any)'] = 'item_controller/add_comment/$1';
$route['add-wishlist-comment/(:any)'] = 'Wishlist_controller/add_wishlist_comments/$1';
$route['add-shop-comment/(:any)'] = 'Shop_controller/add_shop_comments/$1';
$route['delete-item/(:any)'] = 'item_controller/delete_item/$1';
$route['view-my-wishlist/(:any)'] = 'Wishlist_controller/view_wishlist/$1';
$route['add-item-to-wishlist/(:any)'] = 'Wishlist_controller/add_to_wishlist/$1';
$route['remove-item-from-wishlist/(:any)'] = 'Wishlist_controller/remove_item_from_wishlist/$1';
$route['remove-shop-comment/(:any)'] = 'Shop_controller/remove_shop_comments/$1';
$route['remove-wishlist/(:any)'] = 'Wishlist_controller/remove_wishlist/$1';
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */