<?php
/**
 * Plugin Name: WooCommerce Custom Product Fields
 * Description: Adds "Installation Required" and "Warranty Period" fields to WooCommerce products.
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) exit;

// Load only if WooCommerce is active
add_action('plugins_loaded', function () {
    if (!class_exists('WooCommerce')) return;

    // Step 1: Add custom fields in the product editor
    add_action('woocommerce_product_options_general_product_data', function () {
        echo '<div class="options_group">';

        // Checkbox field
        woocommerce_wp_checkbox([
            'id' => '_installation_required',
            'label' => __('Installation Required', 'woocommerce'),
            'description' => __('Check if this product requires installation.', 'woocommerce')
        ]);

        // Select dropdown
        woocommerce_wp_select([
            'id' => '_warranty_period',
            'label' => __('Warranty Period', 'woocommerce'),
            'options' => [
                '' => __('Select Warranty', 'woocommerce'),
                '6 months' => __('6 Months', 'woocommerce'),
                '1 year' => __('1 Year', 'woocommerce'),
                '2 years' => __('2 Years', 'woocommerce'),
            ],
        ]);

        echo '</div>';
    });

    // Step 2: Save field values when product is saved
    add_action('woocommerce_process_product_meta', function ($post_id) {
        $install = isset($_POST['_installation_required']) ? 'yes' : 'no';
        update_post_meta($post_id, '_installation_required', $install);

        if (isset($_POST['_warranty_period'])) {
            update_post_meta($post_id, '_warranty_period', sanitize_text_field($_POST['_warranty_period']));
        }
    });

    // Step 3: Display fields on the single product page
    add_action('woocommerce_single_product_summary', function () {
        global $product;

        $installation_required = get_post_meta($product->get_id(), '_installation_required', true);
        $warranty_period = get_post_meta($product->get_id(), '_warranty_period', true);

        echo '<div class="woocommerce-custom-fields" style="margin-top:20px;">';

        if ($installation_required === 'yes') {
            echo '<p><strong>Installation Required:</strong> Yes</p>';
        }

        if (!empty($warranty_period)) {
            echo '<p><strong>Warranty Period:</strong> ' . esc_html($warranty_period) . '</p>';
        }

        echo '</div>';
    }, 25); // Run after the short description
});
