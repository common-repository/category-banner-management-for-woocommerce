<?php
if( ! defined( 'ABSPATH' ) ) die(); // Stop execution if accessed directly

// Class for Frontend Banner Display
class DD_WooCommerce_Category_Banners_Frontend {
	// Constructor
    public function __construct() {
        add_action('woocommerce_archive_description', array($this, 'display_category_banner'), 1);
    }
	
	// Function to display banner on category page above category description text
    public function display_category_banner() {
        if (is_product_category()) {
            $category = get_queried_object();
            $banner_id = get_term_meta($category->term_id, 'category_banner_id', true);

            if ($banner_id) {
                $banner_url = wp_get_attachment_url($banner_id);
				$banner_link = get_term_meta($category->term_id, 'dd_category_banner_link', true);
				$banner_link_new_tab = get_term_meta($category->term_id, 'dd_category_banner_link_new_tab', true);
				if($banner_link != "") {
	                echo '<a href="' . esc_url($banner_link) . '"';
					if($banner_link_new_tab == 1) {
						echo ' target="=_blank"';	
					}
					echo '><img src="' . esc_url($banner_url) . '" alt="' . esc_attr($category->name) . '" class="category-banner"></a>';
				}
				else {
	                echo '<img src="' . esc_url($banner_url) . '" alt="' . esc_attr($category->name) . '" class="category-banner">';
				}
            }
        }
    }
}

new DD_WooCommerce_Category_Banners_Frontend();
