<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
function wcusage_options_page() {
    $options = get_option( 'wcusage_options' );
    $admin_perms = "administrator";
    if ( isset( $options['wcusage_field_admin_permission'] ) ) {
        if ( current_user_can( 'administrator' ) ) {
            $admin_perms = "administrator";
        } else {
            $admin_perms = $options['wcusage_field_admin_permission'];
        }
    } else {
        $admin_perms = "administrator";
    }
    // add top level menu page
    add_menu_page(
        esc_html__( 'Coupon Affiliates', 'woo-coupon-usage' ),
        esc_html__( 'Coupon Affiliates', 'woo-coupon-usage' ),
        $admin_perms,
        'wcusage',
        'wcusage_dashboard_page_html',
        WCUSAGE_UNIQUE_PLUGIN_URL . 'images/icon.png',
        58
    );
    add_submenu_page(
        'wcusage',
        esc_html__( 'Dashboard', 'woo-coupon-usage' ),
        esc_html__( 'Dashboard', 'woo-coupon-usage' ),
        $admin_perms,
        'wcusage',
        ''
    );
    add_submenu_page(
        'wcusage_hide',
        esc_html__( 'Coupon Affiliates: Info & Help', 'woo-coupon-usage' ),
        esc_html__( 'Info & Help', 'woo-coupon-usage' ),
        'manage_options',
        'wcusage_help',
        'wcusage_admin_list_page_html'
    );
    add_submenu_page(
        'wcusage_hide',
        esc_html__( 'Coupon Affiliates: Setup Wizard', 'woo-coupon-usage' ),
        esc_html__( 'Setup Wizard', 'woo-coupon-usage' ),
        'manage_options',
        'wcusage_setup',
        'wcusage_setup_page_html'
    );
    add_submenu_page(
        'wcusage',
        esc_html__( 'Plugin Settings', 'woo-coupon-usage' ),
        esc_html__( 'Settings', 'woo-coupon-usage' ),
        'manage_options',
        'wcusage_settings',
        'wcusage_options_page_html'
    );
    if ( class_exists( 'WooCommerce' ) ) {
        add_submenu_page(
            'wcusage',
            '',
            '<hr style="width:100%;height:1px;background:#ddd;border:none;margin: 1px 0 1px 0;">',
            $admin_perms,
            'wcu_dummy_page1',
            '__return_null'
        );
        add_submenu_page(
            'wcusage',
            esc_html__( 'Affiliate Coupons', 'woo-coupon-usage' ),
            esc_html__( 'Coupons', 'woo-coupon-usage' ),
            $admin_perms,
            'wcusage_coupons',
            'wcusage_coupons_page'
        );
        add_submenu_page(
            'wcusage',
            esc_html__( 'Affiliate Orders', 'woo-coupon-usage' ),
            esc_html__( 'Affiliate Orders', 'woo-coupon-usage' ),
            $admin_perms,
            'wcusage_referrals',
            'wcusage_orders_page'
        );
        add_submenu_page(
            'wcusage',
            '',
            '<hr style="width:100%;height:1px;background:#ddd;border:none;margin: 2px 0 0px 0;">',
            $admin_perms,
            'wcu_dummy_page2',
            '__return_null'
        );
        $wcusage_field_registration_enable = wcusage_get_setting_value( 'wcusage_field_registration_enable', '1' );
        $wcusage_register_role = wcusage_get_setting_value( 'wcusage_field_register_role', '1' );
        $wcusage_field_registration_accepted_role = wcusage_get_setting_value( 'wcusage_field_registration_accepted_role', 'coupon_affiliate' );
        add_submenu_page(
            'wcusage',
            esc_html__( 'Affiliate Users', 'woo-coupon-usage' ),
            esc_html__( 'Affiliate Users', 'woo-coupon-usage' ),
            $admin_perms,
            'wcusage_affiliates',
            'wcusage_coupon_users_page'
        );
        add_submenu_page(
            'wcusage',
            esc_html__( 'Add New Affiliate', 'woo-coupon-usage' ),
            esc_html__( 'Add New Affiliate', 'woo-coupon-usage' ),
            $admin_perms,
            'wcusage_add_affiliate',
            'wcusage_admin_new_registration_page'
        );
        add_submenu_page(
            'wcusage',
            esc_html__( 'Affiliate Registrations', 'woo-coupon-usage' ),
            esc_html__( 'Registrations', 'woo-coupon-usage' ),
            $admin_perms,
            'wcusage_registrations',
            'wcusage_admin_registrations_page_html'
        );
        add_submenu_page(
            'wcusage',
            '',
            '<hr style="width:100%;height:1px;background:#ddd;border:none;margin: 2px 0 0px 0;">',
            $admin_perms,
            'wcu_dummy_page3',
            '__return_null'
        );
        $wcusage_field_urls_enable = wcusage_get_setting_value( 'wcusage_field_urls_enable', '1' );
        $wcusage_field_show_click_history = wcusage_get_setting_value( 'wcusage_field_show_click_history', '1' );
        if ( $wcusage_field_urls_enable && $wcusage_field_show_click_history ) {
            add_submenu_page(
                'wcusage',
                esc_html__( 'Referral URL Visits (Clicks)', 'woo-coupon-usage' ),
                esc_html__( 'Referral URL Visits', 'woo-coupon-usage' ),
                $admin_perms,
                'wcusage_clicks',
                'wcusage_admin_clicks_page_html'
            );
        }
        add_submenu_page(
            'wcusage',
            esc_html__( 'Admin Reports & Analytics', 'woo-coupon-usage' ),
            esc_html__( 'Admin Reports', 'woo-coupon-usage' ),
            $admin_perms,
            'wcusage_admin_reports',
            'wcusage_admin_reports_page_html'
        );
        $enable_activity_log = wcusage_get_setting_value( 'wcusage_enable_activity_log', '1' );
        if ( $enable_activity_log ) {
            // Make this hidden
            add_submenu_page(
                'wcusage_tools',
                esc_html__( 'Coupon Affiliates: Activity Log', 'woo-coupon-usage' ),
                esc_html__( 'Activity Log', 'woo-coupon-usage' ),
                $admin_perms,
                'wcusage_activity',
                'wcusage_admin_activity_page_html'
            );
        }
        add_submenu_page(
            'wcusage_tools',
            'Import/Export Custom Tables',
            'Import/Export Custom Tables',
            $admin_perms,
            'wcusage-data-import-export',
            'wcusage_data_import_export_page'
        );
        add_submenu_page(
            'wcusage_tools',
            'Bulk Create: Affiliate Coupons',
            'Bulk Create: Affiliate Coupons',
            $admin_perms,
            'wcusage-bulk-coupon-creator',
            'wcusage_bulk_coupon_creator_page'
        );
        add_submenu_page(
            'wcusage_tools',
            'Bulk Assign: Coupons to Orders',
            'Bulk Assign: Coupons to Orders',
            $admin_perms,
            'wcusage-bulk-assign-coupons',
            'wcusage_bulk_assign_coupons_page'
        );
        add_submenu_page(
            'wcusage_tools',
            'Bulk Assign: Per-Affiliate Product Rates',
            'Bulk Assign: Per-Affiliate Product Rates',
            $admin_perms,
            'wcusage-bulk-product-rates',
            'wcusage_bulk_assign_rates_page'
        );
        add_submenu_page(
            'wcusage_tools',
            'Bulk Edit: Product Settings',
            'Bulk Edit: Product Settings',
            $admin_perms,
            'wcusage-bulk-edit-product',
            'wcusage_bulk_product_page'
        );
        add_submenu_page(
            'wcusage_tools',
            'Bulk Edit: Coupon Settings',
            'Bulk Edit: Coupon Settings',
            $admin_perms,
            'wcusage-bulk-edit-coupon',
            'wcusage_bulk_coupon_page'
        );
        add_submenu_page(
            'wcusage',
            'Coupon Affiliates Admin Tools',
            'Admin Tools',
            $admin_perms,
            'wcusage_tools',
            'wcusage_tools_page'
        );
        add_submenu_page(
            'wcusage',
            '',
            '<hr style="width:100%;height:1px;background:#ddd;border:none;margin: 2px 0 0px 0;">',
            $admin_perms,
            'wcu_dummy_page6',
            '__return_null'
        );
        add_submenu_page(
            'wcusage',
            esc_html__( 'Coupon Affiliates: PRO Modules', 'woo-coupon-usage' ),
            '<span class="dashicons dashicons-star-filled" style="font-size: 17px; color: green;"></span>' . esc_html__( 'PRO Modules', 'woo-coupon-usage' ),
            $admin_perms,
            'admin.php?page=wcusage_settings&section=tab-pro-details',
            ''
        );
    }
}

add_action( 'admin_menu', 'wcusage_options_page', 1 );
// Remove submenus
function wcusage_admin_submenu_filter(  $submenu_file  ) {
    global $plugin_page;
    $hidden_submenus = array(
        'wcusage_help'  => false,
        'wcusage_setup' => false,
    );
    foreach ( $hidden_submenus as $submenu => $unused ) {
        remove_submenu_page( 'wcusage', $submenu );
    }
    return $submenu_file;
}

add_filter( 'submenu_file', 'wcusage_admin_submenu_filter' );