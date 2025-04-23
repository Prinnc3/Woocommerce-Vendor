<?php
/*
Plugin Name: Vendor Name for Products
Description: Adds a vendor name field to WooCommerce products and displays it on the front end.
Version: 1.0
Author: Ehima Prince
Author URI: https://ehimaprince.com
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Add vendor name field to product data panel
function add_vendor_name_field() {
    global $post;

    echo '<div class="options_group">';

    woocommerce_wp_text_input(
        array(
            'id' => '_vendor_name',
            'label' => __('Vendor Name', 'woocommerce'),
            'placeholder' => 'Enter vendor name',
            'description' => __('Specify the vendor for this product.', 'woocommerce'),
            'desc_tip' => true,
            'type' => 'text',
            'value' => get_post_meta($post->ID, '_vendor_name', true),
        )
    );

    echo '</div>';
}
add_action('woocommerce_product_options_general_product_data', 'add_vendor_name_field');

// Save vendor name field
function save_vendor_name_field($post_id) {
    $vendor_name = isset($_POST['_vendor_name']) ? sanitize_text_field($_POST['_vendor_name']) : '';
    update_post_meta($post_id, '_vendor_name', $vendor_name);
}
add_action('woocommerce_process_product_meta', 'save_vendor_name_field');

// Display vendor name on the product page
function display_vendor_name_on_product_page() {
    global $post;

    $vendor_name = get_post_meta($post->ID, '_vendor_name', true);

    if (!empty($vendor_name)) {
        echo '<p class="vendor-name"><strong>' . __('Vendor:', 'woocommerce') . '</strong> ' . esc_html($vendor_name) . '</p>';
    }
}
add_action('woocommerce_single_product_summary', 'display_vendor_name_on_product_page', 25);

// Add custom CSS to style vendor name (optional)
function add_vendor_name_styles() {
    echo '<style>
        .vendor-name {
            font-size: 16px;
            margin-top: 10px;
        }
    </style>';
}
add_action('wp_head', 'add_vendor_name_styles');
