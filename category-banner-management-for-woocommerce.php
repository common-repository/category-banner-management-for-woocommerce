<?php
/*
 * Plugin Name: Category Banner Management for Woocommerce
 * Description: The plugin enables you to incorporate or upload image banners to Woocommerce category pages. You can upload any image as a banner at the top of the category page.
 * Tags: banner management for woocommerce, woocommerce category banner, banner woocommerce, banner wordpress, banner in wordpress
 * Author: 		DoubleDome Digital Marketing
 * Author URI: 	https://www.doubledome.com/category-banner-management-for-woocommerce
 * Version: 	1.3
 * License:  	GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: category-banner-management-for-woocommerce
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define('WCBM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WCBM_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));
define( 'WCBM_VERSION', "1.3");

require_once WCBM_PLUGIN_DIR . 'includes/admin.php';
require_once WCBM_PLUGIN_DIR . 'includes/frontend.php';