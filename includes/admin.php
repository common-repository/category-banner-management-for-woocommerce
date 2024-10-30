<?php
if( ! defined( 'ABSPATH' ) ) die(); // Stop execution if accessed directly

// Class for Wordpress Admin Banner Management
class DD_WooCommerce_Category_Banners_Admin {
	// Constructor
    public function __construct() {
        add_action('product_cat_add_form_fields', array($this, 'add_banner_upload_field_category_add_page'), 10, 2);
        add_action('product_cat_edit_form_fields', array($this, 'add_banner_upload_field'), 10, 2);
		add_action( 'create_product_cat', array($this, 'save_banner_upload_field'), 10, 2);
        add_action('edited_product_cat', array($this, 'save_banner_upload_field'), 10, 2);
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    }

	// Banner field display in Category Add page.
    public function add_banner_upload_field_category_add_page($term) {
        wp_nonce_field('category_banner_nonce', 'category_banner_nonce');
        ?>
        <div class="form-field">
			<label for="category_banner"><?php esc_html_e('Category Banner', 'category-banner-management-for-woocommerce'); ?></label>
            <input type="hidden" name="category_banner_id" id="category_banner_id" value="">
			<div id="category-banner-preview"></div>
                <button id="category-banner-upload-button" class="button"><?php esc_html_e('Upload/Add Banner', 'category-banner-management-for-woocommerce'); ?></button>
			<p class="description"><?php esc_html_e( 'Upload a full width banner that will be visible at the top of this product category page.','category-banner-management-for-woocommerce' ); ?></p>
		</div>
        <div class="form-field">
        	<label for="dd_category_banner_link"><?php esc_html_e('Category Banner Link', 'category-banner-management-for-woocommerce'); ?></label>
            <input type="text" id="dd_category_banner_link" placeholder="https://yourwebsitelink.com/" name="dd_category_banner_link" value=""/>
                <p class="description"><?php echo esc_html__( 'Add a link on the banner image. Leave it blank if you don\'t want to add link.','category-banner-management-for-woocommerce'); ?>
                <br />
               	<label><?php echo esc_html__('Open link in new tab?', 'category-banner-management-for-woocommerce'); ?></label>
                <input type="checkbox" name="dd_category_banner_link_new_tab" value="1" />
        </div>
        <?php
    }

	// Banner field display in Category Edit page.
    public function add_banner_upload_field($term) {
        $banner_id = get_term_meta($term->term_id, 'category_banner_id', true);
        $banner_url = wp_get_attachment_url($banner_id);
		$dd_category_banner_link = get_term_meta($term->term_id, 'dd_category_banner_link', true);
		$banner_link_new_tab = get_term_meta($term->term_id, 'dd_category_banner_link_new_tab', true);
		$checkedlinknewtab = ($banner_link_new_tab == 1) ? " checked" : "";

        wp_nonce_field('category_banner_nonce', 'category_banner_nonce');
        ?>
        <tr class="form-field">
            <th scope="row"><label for="category_banner"><?php esc_html_e('Category Banner', 'category-banner-management-for-woocommerce'); ?></label></th>
            <td>
                <input type="hidden" name="category_banner_id" id="category_banner_id" value="<?php echo esc_attr($banner_id); ?>">
                <div id="category-banner-preview"><?php if($banner_url != "") { ?><img src="<?php echo esc_url($banner_url); ?>" alt="<?php esc_html_e('Banner Preview', 'category-banner-management-for-woocommerce'); ?>" /> <?php } ?></div>
                <button id="category-banner-upload-button" class="button"><?php esc_html_e('Upload/Add Banner', 'category-banner-management-for-woocommerce'); ?></button>
                <?php if($banner_url != "") { ?><button id="category-banner-remove-button" class="button"><?php esc_html_e('Remove Banner', 'category-banner-management-for-woocommerce'); ?></button><?php } ?>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row"><label for="dd_category_banner_link"><?php esc_html_e('Category Banner Link', 'category-banner-management-for-woocommerce'); ?></label></th>
            <td>
            	<input type="text" id="dd_category_banner_link" placeholder="https://yourwebsitelink.com/" name="dd_category_banner_link" value="<?php echo esc_attr( $dd_category_banner_link ); ?>"/>
                <p class="description"><?php echo esc_html__( 'Add a link on the banner image. Leave it blank if you don\'t want to add link.','category-banner-management-for-woocommerce'); ?>
                <br />
               	<label><?php echo esc_html__('Open link in new tab?', 'category-banner-management-for-woocommerce'); ?></label>
                <input type="checkbox" name="dd_category_banner_link_new_tab" value="1" <?php echo $checkedlinknewtab; ?> />
            </td>
        </tr>
        <?php
    }

    public function save_banner_upload_field($term_id) {
        $banner_nonce = isset($_POST['category_banner_nonce']) ? sanitize_text_field( wp_unslash( $_POST["category_banner_nonce"] )) : "";
        if ($banner_nonce == "" || !wp_verify_nonce($banner_nonce, 'category_banner_nonce')) {
            return;
        }

        if (isset($_POST['category_banner_id'])) {
            $cat_banner_id = sanitize_text_field($_POST['category_banner_id']);
            update_term_meta($term_id, 'category_banner_id', absint($cat_banner_id));
        }
		else {
            update_term_meta($term_id, 'category_banner_id', "");
		}

        if (isset($_POST['dd_category_banner_link'])) {
            $dd_category_banner_link = sanitize_text_field($_POST['dd_category_banner_link']);
            update_term_meta($term_id, 'dd_category_banner_link', $dd_category_banner_link);
        }
		else {
            update_term_meta($term_id, 'dd_category_banner_link', "");
		}

        if (isset($_POST['dd_category_banner_link_new_tab'])) {
            update_term_meta($term_id, 'dd_category_banner_link_new_tab', 1);
        }
		else {
            update_term_meta($term_id, 'dd_category_banner_link_new_tab', 0);
		}
    }

    public function enqueue_admin_assets($hook) {
        if ($hook !== 'edit-tags.php') {
            //return;
        }

        wp_enqueue_script('category-banner-admin', WCBM_PLUGIN_DIR_URL . 'assets/js/admin.js', array('jquery'), '1.0', true);
    }
}

new DD_WooCommerce_Category_Banners_Admin();