<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Create Order Columns
add_filter( 'manage_edit-shop_order_columns', 'wusage_add_order_column_header', 20 );
add_filter( 'manage_woocommerce_page_wc-orders_columns', 'wusage_add_order_column_header', 20 );
function wusage_add_order_column_header(  $columns  ) {
    $wcusage_show_column_code = wcusage_get_setting_value( 'wcusage_field_show_column_code', '1' );
    if ( !$wcusage_show_column_code ) {
        return $columns;
    }
    $options = get_option( 'wcusage_options' );
    $new_columns = array();
    foreach ( $columns as $column_name => $column_info ) {
        $new_columns[$column_name] = $column_info;
        if ( 'order_total' === $column_name ) {
            $new_columns['wcu_order_affiliate_coupon'] = esc_html__( 'Coupon / Affiliate', 'woo-coupon-usage' );
        }
    }
    return $new_columns;
}

// Add Order Column Content
add_action(
    'manage_shop_order_posts_custom_column',
    'wcusage_add_order_column_content',
    20,
    2
);
add_action(
    'manage_woocommerce_page_wc-orders_custom_column',
    'wcusage_add_order_column_content',
    100,
    2
);
function wcusage_add_order_column_content(  $column, $order_id  ) {
    if ( $column !== 'wcu_order_affiliate_coupon' ) {
        return;
    }
    global $post;
    $order = wc_get_order( $order_id );
    $wcusage_show_column_code = wcusage_get_setting_value( 'wcusage_field_show_column_code', '1' );
    if ( !$wcusage_show_column_code ) {
        return;
    }
    $affiliate = array();
    $coupon_codes = array();
    $coupon_code = "";
    $nocoupon = true;
    if ( $order_id ) {
        $wcusage_field_lifetime = wcusage_get_setting_value( 'wcusage_field_lifetime', '0' );
        $lifetimeaffiliate = wcusage_order_meta( $order_id, 'lifetime_affiliate_coupon_referrer' );
        $affiliatereferrer = wcusage_order_meta( $order_id, 'wcusage_referrer_coupon' );
        if ( !$lifetimeaffiliate && !$affiliatereferrer && class_exists( 'WooCommerce' ) ) {
            if ( version_compare( WC_VERSION, 3.7, ">=" ) ) {
                foreach ( $order->get_coupon_codes() as $coupon_code ) {
                    // Get the WC_Coupon object;
                    $getcoupon = wcusage_get_coupon_info( $coupon_code );
                    if ( !$lifetimeaffiliate && $wcusage_field_lifetime || $coupon_code == $lifetimeaffiliate || !$wcusage_field_lifetime && !$lifetimeaffiliate ) {
                        if ( $coupon_code ) {
                            if ( $coupon_code != $lifetimeaffiliate ) {
                                $coupon_code_linked = wcusage_output_affiliate_info_orders( $coupon_code, $order_id, "" );
                            } else {
                                $coupon_code_linked = wcusage_output_affiliate_info_orders( $coupon_code, $order_id, "returncoupon" );
                            }
                            array_push( $affiliate, "" );
                            array_push( $coupon_codes, $coupon_code_linked );
                        }
                        $nocoupon = false;
                    }
                }
            }
        }
        if ( $nocoupon && $lifetimeaffiliate ) {
            $coupon_code_linked = wcusage_output_affiliate_info_orders( $lifetimeaffiliate, $order_id, "return" );
            array_push( $affiliate, "" );
            array_push( $coupon_codes, $coupon_code_linked );
        }
        if ( $nocoupon && !$lifetimeaffiliate && $affiliatereferrer ) {
            $coupon_code_linked = wcusage_output_affiliate_info_orders( $affiliatereferrer, $order_id, "url" );
            array_push( $affiliate, "" );
            array_push( $coupon_codes, $coupon_code_linked );
        }
        $affiliate = implode( ', ', $affiliate );
        if ( !$affiliate ) {
            $affiliate = "-";
        }
        $coupon_codes = implode( '<br>', $coupon_codes );
        if ( !$coupon_codes ) {
            $coupon_codes = "-";
        }
        if ( 'wcu_order_affiliate_coupon' === $column ) {
            echo wp_kses_post( $coupon_codes );
        }
        if ( 'wcu_order_affiliate' === $column ) {
            echo wp_kses_post( $affiliate );
        }
    }
}

// Get the affiliate info tooltip
function wcusage_output_affiliate_info_orders(  $coupon_code, $order_id, $thetype  ) {
    $wcusage_show_column_code = wcusage_get_setting_value( 'wcusage_field_show_column_code', '1' );
    if ( !$wcusage_show_column_code ) {
        return;
    }
    $getinfo = wcusage_get_the_order_coupon_info( $coupon_code, "", $order_id );
    $order = wc_get_order( $order_id );
    $coupon_info = wcusage_get_coupon_info( $coupon_code );
    $coupon_id = $coupon_info[2];
    if ( $order_id ) {
        $wcusage_field_lifetime = wcusage_get_setting_value( 'wcusage_field_lifetime', '0' );
        // Lifetime Text
        if ( $thetype == "return" ) {
            $typetext = "<p style='margin: 0;'>(Lifetime Referral Sale)</p>";
            $typeicon = "<span class='wcu-tooltop-lifetime'>" . wc_help_tip( "(Lifetime Commission)<br/>This is a returning customer that didn't use the coupon code at checkout, but is a linked as a 'lifetime referral' for this affiliate coupon." ) . "</span> ";
        } elseif ( $thetype == "returncoupon" ) {
            $typetext = "<p style='margin: 0;'>(Lifetime Referral Sale)</p>";
            $typeicon = "<span class='wcu-tooltop-lifetime2'>" . wc_help_tip( "(Lifetime Commission)<br/>This is a lifetime referral that used the affiliates coupon code at checkout." ) . "</span> ";
        } elseif ( $thetype == "url" ) {
            $typetext = "<p style='margin: 0;'>(Custom / URL Referral)</p>";
            $typeicon = "<span class='wcu-tooltop-url1'>" . wc_help_tip( "(Custom / URL Referral)<br/>This referral was set manually by an admin, or it was made via the referral URL but the coupon was not used." ) . "</span> ";
        } else {
            $typetext = "";
            $typeicon = "";
        }
        // Commission Paid Icon
        $ispaid = wcusage_order_ispaid( $order_id );
        // Commission
        if ( $getinfo['thecommissionnum'] > 0 && $order->get_status() != "refunded" && !wcusage_coupon_disable_commission( $coupon_id ) ) {
            $commissiontext = esc_html__( 'Commission', 'woo-coupon-usage' ) . ": " . $getinfo['thecommission'] . $ispaid . "<br/>";
        } else {
            $commissiontext = "";
        }
        // MLA Commission
        $mla_text = "";
        $wcusage_field_mla_enable = wcusage_get_setting_value( 'wcusage_field_mla_enable', '0' );
        if ( $wcusage_field_mla_enable && wcu_fs()->can_use_premium_code() && !wcusage_coupon_disable_commission( $coupon_id ) ) {
            $get_parents = get_user_meta( $getinfo['theuserid'], 'wcu_ml_affiliate_parents', true );
            if ( !empty( $get_parents ) && is_array( $get_parents ) ) {
                $mla_text .= "<br/><p style='margin: 0;'><strong>MLA Commission:</strong>";
                foreach ( $get_parents as $key => $parent_id ) {
                    $parent_user_info = get_user_by( 'ID', $parent_id );
                    $parent_user_name = "";
                    $parent_user_id = "";
                    if ( $parent_user_info ) {
                        $parent_user_name = $parent_user_info->user_login;
                        $parent_user_id = $parent_user_info->ID;
                    }
                    $parent_commission = wcusage_mla_get_commission_from_tier( $getinfo['thecommissionnum'], $key );
                    $mla_text .= "<br/>(" . $key . ") " . $parent_user_name . ": " . wcusage_format_price( $parent_commission );
                }
                $mla_text .= "</p>";
            }
        }
        // Message
        $coupon_code_linked = '<span class="wcusage-orders-affiliate-column">' . $typeicon . '<a href="' . $getinfo['uniqueurl'] . '" target="_blank">' . $coupon_code . '</a>';
        if ( !wcusage_coupon_disable_commission( $coupon_id ) ) {
            $coupon_code_linked .= wc_help_tip( "<span style='font-size: 18px;'>" . $coupon_code . "</span>" . $typetext . "<p style='margin: 0;'>" . $getinfo['affililiateusertext'] . $commissiontext . $mla_text );
        }
        return $coupon_code_linked;
    } else {
        return "";
    }
}

// Styling
function wcusage_wc_cogs_add_order_profit_column_style() {
    $css = '.widefat .column-wcu_order_affiliate_coupon, .widefat .column-wcu_order_affiliate, .widefat .column-wcu_order_affiliate_commission { max-width: 100px; text-align: right; }';
    wp_add_inline_style( 'woocommerce_admin_styles', $css );
}

add_action( 'admin_print_styles', 'wcusage_wc_cogs_add_order_profit_column_style' );
// Get The Order Coupon Info
function wcusage_get_the_order_coupon_info(
    $coupon_code,
    $coupon_post_object,
    $order_id,
    $update = 0
) {
    $wcusage_show_column_code = wcusage_get_setting_value( 'wcusage_field_show_column_code', '1' );
    if ( !$wcusage_show_column_code ) {
        return;
    }
    $order = wc_get_order( $order_id );
    if ( $coupon_code ) {
        $options = get_option( 'wcusage_options' );
        $commission = 0;
        $coupon_id = wcusage_get_coupon_id( $coupon_code );
        // Commission
        $wcusage_total_commission = wcusage_order_meta( $order_id, 'wcusage_total_commission' );
        if ( !$wcusage_total_commission || $update ) {
            if ( $update ) {
                $order_data = wcusage_calculate_order_data(
                    $order_id,
                    $coupon_code,
                    1,
                    0,
                    1
                );
            } else {
                $order_data = wcusage_calculate_order_data(
                    $order_id,
                    $coupon_code,
                    1,
                    0
                );
            }
            if ( isset( $order_data['totalcommission'] ) ) {
                $commission += $order_data['totalcommission'];
            } else {
                $commission = 0;
            }
        } else {
            $commission = $wcusage_total_commission;
        }
        $thecommission = wcusage_get_base_currency_symbol() . number_format(
            (float) $commission,
            2,
            '.',
            ''
        );
        // User
        $theuserid = "";
        $couponuser = get_post_meta( $coupon_id, 'wcu_select_coupon_user', true );
        if ( $couponuser ) {
            $current_user = get_user_by( 'id', $couponuser );
            $username = "";
            if ( $current_user ) {
                $username = $current_user->user_login;
            }
            if ( $username ) {
                $theuser = $username;
                $theuserid = $username = $current_user->ID;
            } else {
                $theuser = '';
            }
        } else {
            $theuser = '';
        }
        // Coupon Code & Link
        $thepageurl = wcusage_get_coupon_shortcode_page( 1, 0 );
        $wcusage_justcoupon = wcusage_get_setting_value( 'wcusage_field_justcoupon', '1' );
        if ( $wcusage_justcoupon ) {
            $secretid = $coupon_code;
        } else {
            $secretid = $coupon_code . "-" . $coupon_id;
        }
        $uniqueurl = $thepageurl . 'couponid=' . $secretid;
        $affililiateusertext = "";
        $thecommissionpaid = 0;
        if ( $order instanceof WC_Order ) {
            $thecommissionpaid = $order->get_meta( 'wcu_commission_paid' );
        }
        if ( $thecommissionpaid ) {
            $thecommission = wcusage_format_price( $thecommissionpaid );
        }
        if ( wcusage_coupon_disable_commission( $coupon_id ) ) {
            $commission = 0;
            $thecommission = wcusage_format_price( 0 );
        }
        $return_array = [];
        $return_array['uniqueurl'] = $uniqueurl;
        $return_array['affililiateusertext'] = $affililiateusertext;
        $return_array['thecommission'] = $thecommission;
        $return_array['thecommissionnum'] = $commission;
        $return_array['theuser'] = $theuser;
        $return_array['theuserid'] = $theuserid;
        return $return_array;
    } else {
        return "";
    }
}

/*
 * Get order is paid icon
 */
function wcusage_order_ispaid(  $order_id  ) {
    $order = wc_get_order( $order_id );
    $ispaid = "";
    return $ispaid;
}
