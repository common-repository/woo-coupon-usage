<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function wcusage_field_cb_payouts( $args )
{
    $options = get_option( 'wcusage_options' );
    ?>

	<div id="payouts-settings" class="settings-area<?php
    if ( !wcu_fs()->can_use_premium_code() ) {
        ?> premium-only-settings" title="Available with Pro version." style="pointer-events:none; opacity: 0.6;"<?php
    } else { ?>"<?php } ?>>
    
	<?php if ( !wcu_fs()->can_use_premium_code() ) { ?><p><strong style="color: green;"><?php echo esc_html__( 'Available with Pro version.', 'woo-coupon-usage' ); ?></strong></p><?php } ?>

	<h1><?php echo esc_html__( 'Commission Payouts Features', 'woo-coupon-usage' ); ?> (Pro)</h1>

  <hr/>

    <!-- Enable Payouts Features -->
    <?php echo wcusage_setting_toggle_option('wcusage_field_tracking_enable', 1, esc_html__( 'Enable Payouts Features', 'woo-coupon-usage' ), '0px'); ?>

    <i><?php echo esc_html__( 'This will enable payouts features, and keep track of "unpaid commission" for each coupon, whenever new orders are created using that coupon.', 'woo-coupon-usage' ); ?></i><br/>


    <?php echo wcusage_setting_toggle('.wcusage_field_tracking_enable', '.wcu-field-section-payouts-features'); // Show or Hide ?>
    <span class="wcu-field-section-payouts-features">

  		<br/>

      <script>
      jQuery( document ).ready(function() {
        jQuery(".wcusage_field_tracking_enable").on('change', function() {
          if( !jQuery(".wcusage_field_tracking_enable").is(':checked') ) {
            jQuery(".wcusage_field_payouts_enable").attr('checked', false);
            jQuery(".wcusage_field_payouts_enable").change();
          }
        });
      });
      </script>
      <!-- Enable Payout Requests & Log Features -->
      <?php echo wcusage_setting_toggle_option('wcusage_field_payouts_enable', 1, esc_html__( 'Enable Payout Requests & Log Features', 'woo-coupon-usage' ), '0px'); ?>
      <i><?php echo esc_html__( 'This will show a "Payouts" tab on the coupon usage/info page, so the affiliate can view their unpaid commission, and request payouts.', 'woo-coupon-usage' ); ?></i><br/>
      <i><?php echo esc_html__( 'For this to show, a user/affiliate account must be assigned to that coupon. The tab is only shown to this user.', 'woo-coupon-usage' ); ?></i><br/>

  		<br/><br/>

      <?php if ( wcu_fs()->can_use_premium_code() ) { ?>
      <!-- FAQ: How to payouts work? -->
      <div class="wcu-admin-faq">

        <?php echo wcusage_admin_faq_toggle(
        "wcu_show_section_qna_manage_payouts",
        "wcu_qna_manage_payouts",
        "FAQ: How do the commission payouts work?");
        ?>

        <div class="wcu-admin-faq-content wcu_qna_manage_payouts" id="wcu_qna_manage_payouts" style="display: none;">
        <?php } ?>

          <span class="dashicons dashicons-arrow-right"></span> <?php echo esc_html__( 'If an order is created using an affiliates coupon, then marked as completed, the commission will be added to the affiliate account as "unpaid commission".', 'woo-coupon-usage' ); ?><br/>
          
          <span class="dashicons dashicons-arrow-right"></span> <?php echo esc_html__( 'The affiliate can then request a payout for this commission in their affiliate dashboard, which will notify you. This can then be paid in the admin "Payouts" page.', 'woo-coupon-usage' ); ?><br/>

          <span class="dashicons dashicons-arrow-right"></span> <?php echo esc_html__( 'There are also a variety of options available below to automate payout requests/payments, select your payout methods, and much more!', 'woo-coupon-usage' ); ?><br/>

          <span class="dashicons dashicons-arrow-right"></span> <?php echo esc_html__( 'If an order is refunded then the commission will be removed from the users account.', 'woo-coupon-usage' ); ?><br/>

          <span class="dashicons dashicons-arrow-right"></span> <?php echo esc_html__( 'Note: "Unpaid Commission" will start from "0" and will only start tracking after you installed the "PRO" version and activated the payouts functionality.', 'woo-coupon-usage' ); ?><br/>

          <a href="https://couponaffiliates.com/docs/pro-payouts" target="_blank" class="button button-primary" style="margin-top: 10px;"><?php echo esc_html__( 'View Documentation', 'woo-coupon-usage' ); ?> <span class="fas fa-external-link-alt"></span></a>

          <br/><br/>
          
          <?php if ( wcu_fs()->can_use_premium_code() ) { ?>
          <strong><?php echo esc_html__( 'For more information, please watch the video below:', 'woo-coupon-usage' ); ?></strong>
          <br/>
          <div style="max-width: 720px;">
          <div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/837140385?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;" title="Commission Payouts"></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>
          </div>

        </div>

      </div>
      <?php } ?>

      <hr/>

      <h3 id ="wcu-setting-header-payouts-general"><span class="dashicons dashicons-admin-generic" style="margin-top: 2px;"></span> Payouts Settings:</h3>

      <!-- How much unpaid commission must be earned before the affiliate can request a payout. -->
      <?php echo wcusage_setting_number_option('wcusage_field_payout_threshold', '0', esc_html__( 'Payment Threshold', 'woo-coupon-usage' ), '0px'); ?>
      <i><?php echo esc_html__( 'How much "unpaid commission" must be earned/available, before the affiliate can request a payout.', 'woo-coupon-usage' ); ?></i>

  		<br/><br/>

      <!-- Number of days after order "completion" until commission is earned: -->
      <?php echo wcusage_setting_number_option('wcusage_field_payout_days', '0', esc_html__( 'Delay Commission (Number of Days)', 'woo-coupon-usage' ), '0px'); ?>
      <i><?php echo esc_html__( 'The number of days after an order is created, that the commission earned is added to the users account as "unpaid commission. Useful if you want to prevent commission being paid out early for orders that may be refunded etc.', 'woo-coupon-usage' ); ?></i><br/>
      <i><?php echo esc_html__( 'If set to "0" then commission will be added to the affiliates account instantly when an order is completed.', 'woo-coupon-usage' ); ?></i><br/>
      <i><?php echo esc_html__( 'Requires cron jobs to be enabled on your site. Make sure to test this is working after activating. We highly recommend using "Real Cron Jobs" instead of WP Cron.', 'woo-coupon-usage' ); ?> <a href="https://couponaffiliates.com/docs/real-cron-job/"><?php echo esc_html__( 'Learn More', 'woo-coupon-usage' ); ?></a></i><br/>

      <br/>

      <!-- DROPDOWN - Order Status Type Field -->
      <p>
  		<strong><label for="scales"><?php echo esc_html__( 'Order status for "unpaid commission" to be granted:', 'woo-coupon-usage' ); ?></label></strong><br/>
        <select name="wcusage_options[wcusage_payout_status]" id="wcusage_payout_status" class="wcusage_payout_status">
        <?php
        $wcusage_payout_status = wcusage_get_setting_value('wcusage_payout_status', 'wc-completed');
        $orderstatuses = wc_get_order_statuses();
        foreach( $orderstatuses as $key => $status ){
          if( wc_get_order_status_name($wcusage_payout_status) == wc_get_order_status_name($status) ) {
            $checkedx = "selected";
          } else {
            $checkedx = "";
          }
          if( ($key != "wc-pending" && $key != "wc-processing" && $key != "wc-on-hold" && $key != "wc-cancelled" && $key != "wc-refunded" && $key != "wc-failed") || $checkedx) {
            echo '<option value="'.esc_attr($key).'" '.esc_attr($checkedx).'>'.wc_get_order_status_name($status).'</span>';
          }
        }
        ?>
        </select>
        <br/><i><?php echo esc_html__( 'The order status required for "unpaid commission" to be granted. Default "completed" for most sites. This should be the final status for your orders, once it has been paid and delivered.', 'woo-coupon-usage' ); ?></i>
  	   </p>

       <br/>

       <?php echo wcusage_setting_toggle_option('wcusage_field_payout_details_required', 1, 'Require payment details to request payout.', '0px'); ?>
       <i><?php echo esc_html__( 'When enabled, the affiliate will be required to enter their payment details before they can request a payout.', 'woo-coupon-usage' ); ?></i><br/>

       <br/><hr/>

       <h3 id="wcu-setting-header-payouts-scheduled"><span class="dashicons dashicons-admin-generic" style="margin-top: 2px;"></span> <?php echo esc_html__( 'Scheduled Payout Requests', 'woo-coupon-usage' ); ?>:</h3>

       <?php echo wcusage_setting_toggle_option('wcusage_field_enable_payoutschedule', 0, 'Enable Scheduled Payout Requests', '0px'); ?>
       <i><?php echo esc_html__( 'Enable this to automatically submit "payout requests" for your affiliates, every month/week/day, if they meet certain criteria.', 'woo-coupon-usage' ); ?></i><br/>
       <i><?php echo esc_html__( 'This will work in the same way as if the user clicked the "Request Payout" button in their dashboard.', 'woo-coupon-usage' ); ?></i><br/>
       <i><?php echo esc_html__( 'Requires cron jobs to be enabled.', 'woo-coupon-usage' ); ?></i><br/>

        <?php echo wcusage_setting_toggle('.wcusage_field_enable_payoutschedule', '.wcu-field-section-payoutschedule'); // Show or Hide ?>
        <span class="wcu-field-section-payoutschedule">

         <br/>
         <p><strong><?php echo esc_html__( 'A payout request will only be requested automatically if:', 'woo-coupon-usage' ); ?></strong></p>
         <p>- <?php echo esc_html__( 'The "unpaid commission" meets the required payment threshold.', 'woo-coupon-usage' ); ?></p>
         <p>- <?php echo esc_html__( 'The coupon has an affiliate user assigned to it.', 'woo-coupon-usage' ); ?></p>
         <p>- <?php echo esc_html__( 'The affiliate user has entered their payment details (in the "settings" tab on their dashboard).', 'woo-coupon-usage' ); ?></p>

         <br/>

          <!-- Frequency -->
          <p>
          	<?php $wcusage_field_payoutschedule_freq = wcusage_get_setting_value('wcusage_field_payoutschedule_freq', 'monthly'); ?>
          	<input type="hidden" value="0" id="wcusage_field_payoutschedule_freq" data-custom="custom" name="wcusage_options[wcusage_field_payoutschedule_freq]" >
          	<strong><label for="scales"><?php echo esc_html__( 'How often should payout requests be checked & submitted automatically?', 'woo-coupon-usage' ); ?></label></strong><br/>
          	<select name="wcusage_options[wcusage_field_payoutschedule_freq]" id="wcusage_field_payoutschedule_freq">
              <?php $frequency_options = array('monthly', 'weekly', 'daily', 'quarterly'); ?>
              <?php foreach ($frequency_options as $option) { ?>
                <option value="<?php echo esc_attr($option); ?>" <?php if($wcusage_field_payoutschedule_freq == $option) { ?>selected<?php } ?>><?php echo ucfirst(esc_attr($option)); ?></option>           
              <?php } ?>
              </select>
          </p>
          <i><?php echo esc_html__( 'Payout requests will be scheduled to send on the first day of the selected schedule.', 'woo-coupon-usage' ); ?></i><br/>

          <br/>

          <!-- DateTime -->
          <p <?php if( !wcu_fs()->can_use_premium_code() || !wcu_fs()->is_premium() ) { ?>style="opacity: 0.4; pointer-events: none;" class="wcu-settings-pro-only"<?php } ?>>
          	<?php $wcusage_field_payoutschedule_time = wcusage_get_setting_value('wcusage_field_payoutschedule_time', '09'); ?>
          	<input type="hidden" value="0" id="wcusage_field_payoutschedule_time" data-custom="custom" name="wcusage_options[wcusage_field_payoutschedule_time]" >
          	<strong><label for="scales"><?php echo esc_html__( 'What time of the day should payouts be requested automatically?', 'woo-coupon-usage' ); ?></label></strong><br/>
          	<select name="wcusage_options[wcusage_field_payoutschedule_time]" id="wcusage_field_payoutschedule_time">
             <?php for ($x = 0; $x <= 24; $x++) { ?>
             <?php if($x < 10) { $x = sprintf("%02d", $x); } ?>
          		<option value="<?php echo esc_attr($x); ?>" <?php if($wcusage_field_payoutschedule_time == $x) { ?>selected<?php } ?>><?php echo esc_attr($x); ?>:00</option>
             <?php } ?>
          	</select>
          </p>
        </span>

        <br/><hr/>

        <h3 id="wcu-setting-header-payouts-scheduled"><span class="dashicons dashicons-admin-generic" style="margin-top: 2px;"></span> <?php echo esc_html__( 'Automatic Payouts', 'woo-coupon-usage' ); ?>:</h3>

        <?php echo wcusage_setting_toggle_option('wcusage_payouts_auto_accept', 0, 'Automatically and instantly pay affiliates commission into their account, after a payout request is made.', '0px'); ?>
        <i><?php echo esc_html__( 'With this enabled commission will be paid instantly into the affiliate account automatically, as soon as they request a payout. This will apply to Stripe, PayPal and Store Credit payout methods.', 'woo-coupon-usage' ); ?></i><br/>
        <i><?php echo esc_html__( 'Warning: If you use this option, you should be even more careful of fraudulent activity. We do recommend reviewing and accepting payouts manually instead, simply so you can make sure each payout is valid and non-fraudulent.', 'woo-coupon-usage' ); ?></i><br/>

        <?php echo wcusage_setting_toggle('.wcusage_payouts_auto_accept', '.wcu-field-section-auto-payout'); // Show or Hide ?>
        <span class="wcu-field-section-auto-payout">

          <br/>

          <!-- Threshold -->
          <?php echo wcusage_setting_number_option('wcusage_payouts_auto_accept_threshold', '200', esc_html__( 'Threshold for automatic payouts', 'woo-coupon-usage' ) . ": (" . wcusage_get_currency_symbol() . ")", '40px'); ?>
          <i style="margin-left: 40px;"><?php echo esc_html__( 'Set a threshold on the maximum amount that can be paid automatically. Any payout requests above this amount will require manual approval.', 'woo-coupon-usage' ); ?></i><br/>

          <br/>

          <!-- Manual First Payout -->
          <?php echo wcusage_setting_toggle_option('wcusage_payouts_auto_accept_first_manual', 0, 'Require manual approval for affiliates first payout request.', '40px'); ?>
          <i style="margin-left: 40px;"><?php echo esc_html__( 'With this enabled, the first ever payout request by an affiliate will require manual approval. After they have at-least 1 completed payout, all future payouts can be paid automatically.', 'woo-coupon-usage' ); ?></i><br/>

        </span>

  		<br/><hr/>

      <h3><span class="dashicons dashicons-admin-generic" style="margin-top: 2px;"></span> Payment Methods:</h3>

      <style>
      .wcu-admin-payouts-headers label {
        font-size: 16px;
      }
      </style>

      <!-- Enable Manual Payment Method #1 -->
      <div style="margin-bottom: 20px;"></div>

      <span class="wcu-admin-payouts-headers">
        <?php echo wcusage_setting_toggle_option('wcusage_field_paypal_enable', 0, esc_html__( 'Custom Payment Method', 'woo-coupon-usage' ) . " #1", '0px'); ?>
      </span>
      <i><?php echo esc_html__( 'A custom "manual" payment method of your choice.', 'woo-coupon-usage' ); ?></i><br/>

      <?php echo wcusage_setting_toggle('.wcusage_field_paypal_enable', '.wcu-field-section-tr-payouts-paypal'); // Show or Hide ?>
      <span class="wcu-field-section-tr-payouts-paypal">

        <br/>

        <!-- Change Payment Method Label (Default: "Manual") -->
        <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_paypal_only', 'Manual', esc_html__( 'Payment Method Name', 'woo-coupon-usage' ), '40px'); ?>

        <br/>

        <!-- Payment Method Info -->
        <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_paypal_info', '', esc_html__( 'Payment Method Information', 'woo-coupon-usage' ), '40px'); ?>
        <i style="margin-left: 40px;"><?php echo esc_html__( 'Custom information/text shown when payment method is selected (in the dashboard settings).', 'woo-coupon-usage' ); ?></i><br/>

    		<br/>

        <?php echo wcusage_setting_toggle_option('wcusage_field_paypal_enable_field', 1, esc_html__( 'Show Payment Details Field', 'woo-coupon-usage' ), '40px'); ?>

        <?php echo wcusage_setting_toggle('.wcusage_field_paypal_enable_field', '.wcu-field-section-tr-payouts-paypal-field'); // Show or Hide ?>
        <span class="wcu-field-section-tr-payouts-paypal-field">

          <br/>

          <!-- Change Payment Details Label (Default: "Payment Details") -->
          <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_paypal', 'Payment Details', esc_html__( 'Payment Details Field Label', 'woo-coupon-usage' ), '40px'); ?>

        </span>

      </span>

      <!-- Enable Manual Payment Method #2 -->
      <div style="margin-bottom: 40px;"></div>

      <span class="wcu-admin-payouts-headers">
        <?php echo wcusage_setting_toggle_option('wcusage_field_paypal2_enable', 0, esc_html__( 'Custom Payment Method', 'woo-coupon-usage' ) . " #2", '0px'); ?>
      </span>
      <i><?php echo esc_html__( 'A custom "manual" payment method of your choice.', 'woo-coupon-usage' ); ?></i><br/>

      <?php echo wcusage_setting_toggle('.wcusage_field_paypal2_enable', '.wcu-field-section-tr-payouts-paypal2'); // Show or Hide ?>
      <span class="wcu-field-section-tr-payouts-paypal2">

        <!-- Change Payment Method Label (Default: "Manual") -->
        <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_paypal2_only', 'Manual', esc_html__( 'Payment Method Name', 'woo-coupon-usage' ), '40px'); ?>

        <br/>

        <!-- Payment Method Info -->
        <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_paypal2_info', '', esc_html__( 'Payment Method Information', 'woo-coupon-usage' ), '40px'); ?>
        <i style="margin-left: 40px;"><?php echo esc_html__( 'Custom information/text shown when payment method is selected (in the dashboard settings).', 'woo-coupon-usage' ); ?></i><br/>

        <br/>

        <?php echo wcusage_setting_toggle_option('wcusage_field_paypal2_enable_field', 1, esc_html__( 'Show Payment Details Field', 'woo-coupon-usage' ), '40px'); ?>

        <?php echo wcusage_setting_toggle('.wcusage_field_paypal2_enable_field', '.wcu-field-section-tr-payouts-paypal2-field'); // Show or Hide ?>
        <span class="wcu-field-section-tr-payouts-paypal2-field">

          <br/>

          <!-- Change Payment Details Label (Default: "Payment Details") -->
          <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_paypal2', 'Payment Details', esc_html__( 'Payment Details Field Label', 'woo-coupon-usage' ), '40px'); ?>

        </span>

      </span>

      <!-- Enable Direct Bank Transfer -->
      <div style="margin-bottom: 40px;"></div>

      <span class="wcu-admin-payouts-headers">
        <?php echo wcusage_setting_toggle_option('wcusage_field_banktransfer_enable', 0, esc_html__( 'Direct Bank Transfer (Manual)', 'woo-coupon-usage' ), '0px'); ?>
      </span>
      <i><?php echo esc_html__( 'A direct bank transfer payment method (paid manually).', 'woo-coupon-usage' ); ?></i><br/>

      <?php echo wcusage_setting_toggle('.wcusage_field_banktransfer_enable', '.wcu-field-section-tr-payouts-banktransfer'); // Show or Hide ?>
      <span class="wcu-field-section-tr-payouts-banktransfer">

        <br/>

        <!-- Change Payment Method Label (Default: "Manual") -->
        <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_banktransfer_only', 'Bank Transfer', esc_html__( 'Payment Method Name', 'woo-coupon-usage' ), '40px'); ?>

        <br/>

        <!-- Payment Method Info -->
        <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_banktransfer_info', '', esc_html__( 'Payment Method Information', 'woo-coupon-usage' ), '40px'); ?>
        <i style="margin-left: 40px;"><?php echo esc_html__( 'Custom information/text shown when payment method is selected (in the dashboard settings).', 'woo-coupon-usage' ); ?></i><br/>

        <br/>

        <!-- Change Name Label -->
        <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_banktransfer_name', 'Payee Name', esc_html__( '"Payee Name" Field Label', 'woo-coupon-usage' ), '40px'); ?>

        <br/>

        <!-- Change Sort Code Label -->
        <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_banktransfer_sort', 'Sort Code', esc_html__( '"Sort Code" Field Label', 'woo-coupon-usage' ), '40px'); ?>

        <br/>

        <!-- Change Account Number Label -->
        <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_banktransfer_account', 'Account Number', esc_html__( '"Account Number" Field Label', 'woo-coupon-usage' ), '40px'); ?>
        
        <br/>

        <!-- Change Account Other Info Label -->
        <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_banktransfer_other', '', esc_html__( 'Extra Field Label', 'woo-coupon-usage' ), '40px'); ?>
        
        <br class="wcusage_field_tr_payouts_banktransfer_other2" style="display: none;"/>

        <!-- Change Account Other Info Label -->
        <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_banktransfer_other2', '', esc_html__( 'Extra Field Label', 'woo-coupon-usage' ), '40px'); ?>

        <br class="wcusage_field_tr_payouts_banktransfer_other3" style="display: none;"/>

        <!-- Change Account Other Info Label -->
        <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_banktransfer_other3', '', esc_html__( 'Extra Field Label', 'woo-coupon-usage' ), '40px'); ?>

        <br class="wcusage_field_tr_payouts_banktransfer_other4" style="display: none;"/>

        <!-- Change Account Other Info Label -->
        <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_banktransfer_other4', '', esc_html__( 'Extra Field Label', 'woo-coupon-usage' ), '40px'); ?>

        <!-- Only show extra fields if previous field is filled -->
        <script>
        jQuery( document ).ready(function() {
          wcusage_check_banktransfer_other_fields();
          jQuery('#wcusage_field_tr_payouts_banktransfer_other, #wcusage_field_tr_payouts_banktransfer_other2, #wcusage_field_tr_payouts_banktransfer_other3').on('change', function() {
            wcusage_check_banktransfer_other_fields();
          });
          function wcusage_check_banktransfer_other_fields() {
            if(jQuery('#wcusage_field_tr_payouts_banktransfer_other').val() != "") {
              jQuery('#wcusage_field_tr_payouts_banktransfer_other2').parent().show();
              jQuery('.wcusage_field_tr_payouts_banktransfer_other2').show();
              if(jQuery('#wcusage_field_tr_payouts_banktransfer_other2').val() != "") {
                jQuery('#wcusage_field_tr_payouts_banktransfer_other3').parent().show();
                jQuery('.wcusage_field_tr_payouts_banktransfer_other3').show();
                if(jQuery('#wcusage_field_tr_payouts_banktransfer_other3').val() != "") {
                  jQuery('#wcusage_field_tr_payouts_banktransfer_other4').parent().show();
                  jQuery('.wcusage_field_tr_payouts_banktransfer_other4').show();
                } else {
                  jQuery('#wcusage_field_tr_payouts_banktransfer_other4').parent().hide();
                  jQuery('.wcusage_field_tr_payouts_banktransfer_other4').hide();
                }
              }
            } else {
              jQuery('#wcusage_field_tr_payouts_banktransfer_other2').parent().hide();
              jQuery('.wcusage_field_tr_payouts_banktransfer_other2').hide();
              jQuery('#wcusage_field_tr_payouts_banktransfer_other3').parent().hide();
              jQuery('.wcusage_field_tr_payouts_banktransfer_other3').hide();
              jQuery('#wcusage_field_tr_payouts_banktransfer_other4').parent().hide();
              jQuery('.wcusage_field_tr_payouts_banktransfer_other4').hide();
            }
          }
        });
        </script>

        <!-- User Role -->
        <?php do_action('wcusage_hook_payouts_user_role_select', 'wcusage_field_tr_payouts_banktransfer_role'); ?>

      </span>

      <!-- Enable PayPal Payouts API -->
      <div style="margin-bottom: 40px;" id="paypalapi-settings"></div>

      <span class="wcu-admin-payouts-headers">
        <?php echo wcusage_setting_toggle_option('wcusage_field_paypalapi_enable', 0, esc_html__( 'PayPal Payouts', 'woo-coupon-usage' ), '0px'); ?>
      </span>
      <i><?php echo esc_html__( 'PayPal Payouts payment method will allow you to one-click pay your affiliates directly into their PayPal account.', 'woo-coupon-usage' ); ?>
      <?php echo esc_html__( 'In most cases PayPal Payouts fees are 2%.', 'woo-coupon-usage' ); ?> <a href="https://www.paypal.com/us/webapps/mpp/merchant-fees#paypal-payouts" target="_blank"><?php echo esc_html__( 'Learn More', 'woo-coupon-usage' ); ?></a>.</i><br/>
      <i><?php echo esc_html__( 'Prerequisites: To use PayPal Payouts, you will need a PayPal business account and must have access to it’s PayPal Payouts features.', 'woo-coupon-usage' ); ?> <a href="https://developer.paypal.com/docs/payouts/integrate/prerequisites" target="_blank"><?php echo esc_html__( 'Learn More', 'woo-coupon-usage' ); ?></a>.</i><br/>
      <i><?php echo esc_html__( 'Note: Payouts can only be made if you have the required funds in your PayPal account.', 'woo-coupon-usage' ); ?></i><br/>

      <?php echo wcusage_setting_toggle('.wcusage_field_paypalapi_enable', '.wcu-field-section-tr-payouts-paypalapi'); // Show or Hide ?>
      <span class="wcu-field-section-tr-payouts-paypalapi">

        <br/>

        <!-- Change Payment Method Label (Default: "Manual") -->
        <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_paypalapi_only', 'PayPal Payouts', esc_html__( 'Payment Method Name', 'woo-coupon-usage' ), '40px'); ?>

        <br/>

        <!-- Change Payment Details Label (Default: "Payment Details") -->
        <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_paypalapi', 'PayPal Email Address', esc_html__( 'Payment Details Field Label', 'woo-coupon-usage' ), '40px'); ?>

        <br/>

        <!-- Payment Method Info -->
        <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_paypalapi_info', '', esc_html__( 'Payment Method Information', 'woo-coupon-usage' ), '40px'); ?>
        <i style="margin-left: 40px;"><?php echo esc_html__( 'Custom information/text shown when payment method is selected (in the dashboard settings).', 'woo-coupon-usage' ); ?></i><br/>

        <br/>

        <p style="margin-left: 40px; font-size: 16px; font-weight: bold;">Payment Email</p>

        <br/>

        <!-- Change PayPal Payment Subject -->
        <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_paypalapi_subject', 'Commission Payout', esc_html__( 'Payment Subject', 'woo-coupon-usage' ), '40px'); ?>

        <br/>

        <!-- Change PayPal Payment Message -->
        <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_paypalapi_message', 'Congrats, you have received a new commission payout!', esc_html__( 'Payment Message', 'woo-coupon-usage' ), '40px'); ?>

        <br/>

        <p style="margin-left: 40px; font-size: 16px; font-weight: bold;">API Credentials*</p>

        <p style="margin-left: 40px;">Instructions: <a href="https://couponaffiliates.com/docs/pro-paypal-payouts-setup" target="_blank">https://couponaffiliates.com/docs/pro-paypal-payouts-setup</a></p>

        <br/>

        <!-- Change Payment Details Label (Default: "Payment Details") -->
        <?php echo wcusage_setting_toggle_option('wcusage_field_tr_payouts_paypalapi_test', 0, esc_html__( 'Enable Test Mode?', 'woo-coupon-usage' ), '40px'); ?>

        <br/>

        <script>
        jQuery( document ).ready(function() {
          wcusage_check_paypal_test_mode();
          jQuery('.wcusage_field_tr_payouts_paypalapi_test').change(function(){
            wcusage_check_paypal_test_mode();
          });
          function wcusage_check_paypal_test_mode() {
            if(jQuery('.wcusage_field_tr_payouts_paypalapi_test').prop('checked')) {
              jQuery('.wcu-field-section-tr-payouts-paypalapi-live').hide();
              jQuery('.wcu-field-section-tr-payouts-paypalapi-test').show();
            } else {
              jQuery('.wcu-field-section-tr-payouts-paypalapi-live').show();
              jQuery('.wcu-field-section-tr-payouts-paypalapi-test').hide();
            }
          }
        });
        </script>

        <span class="wcu-field-section-tr-payouts-paypalapi-live">

            <?php echo wcusage_setting_text_option('wcusage_field_paypalapi_id', '', esc_html__( '[Live] Client ID', 'woo-coupon-usage' ), '40px'); ?>

            <br/>

            <?php echo wcusage_setting_text_option('wcusage_field_paypalapi_secret', '', esc_html__( '[Live] Client Secret', 'woo-coupon-usage' ), '40px'); ?>

        </span>

        <span class="wcu-field-section-tr-payouts-paypalapi-test" style="color: red;">

            <?php echo wcusage_setting_text_option('wcusage_field_paypalapi_test_id', '', esc_html__( '[Test] Client ID', 'woo-coupon-usage' ), '40px'); ?>

            <br/>

            <?php echo wcusage_setting_text_option('wcusage_field_paypalapi_test_secret', '', esc_html__( '[Test] Client Secret', 'woo-coupon-usage' ), '40px'); ?>

        </span>

        <div style="clear: both;"></div>
        
        <!-- User Role -->
        <?php do_action('wcusage_hook_payouts_user_role_select', 'wcusage_field_tr_payouts_paypalapi_role'); ?>

      </span>

      <!-- Enable Stripe Payouts API -->
      <div style="margin-bottom: 40px;" id="stripeapi-settings"></div>

      <span class="wcu-admin-payouts-headers">
        <?php echo wcusage_setting_toggle_option('wcusage_field_stripeapi_enable', 0, esc_html__( 'Stripe Payouts ("Connect")', 'woo-coupon-usage' ), '0px'); ?>
      </span>
      <?php
      $usaicon = '<img src="'.WCUSAGE_UNIQUE_PLUGIN_URL.'images/us.png" style="height: 8px;"> US';
      $ukicon = '<img src="'.WCUSAGE_UNIQUE_PLUGIN_URL.'images/gb.png" style="height: 8px;"> UK';
      ?>
      <i><?php echo esc_html__( 'Stripe Payouts payment method will allow you to one-click pay your affiliates directly into their Stripe / bank account.', 'woo-coupon-usage' ); ?>
      <?php echo esc_html__( 'Fees vary (typically around 1% - 2%). Learn more about Stripe Connect', 'woo-coupon-usage' ); ?> <a href="https://stripe.com/connect" target="_blank">here</a>.</i><br/>
      <i><?php echo esc_html__( 'Note: Payouts can only be made if you have the required funds in your Stripe account.', 'woo-coupon-usage' ); ?> <a href="https://couponaffiliates.com/docs/pro-stripe-payouts/#funds" target="_blank"><?php echo esc_html__( 'Learn More.', 'woo-coupon-usage' ); ?></a></i><br/>

      <?php echo wcusage_setting_toggle('.wcusage_field_stripeapi_enable', '.wcu-field-section-tr-payouts-stripeapi'); // Show or Hide ?>
      <span class="wcu-field-section-tr-payouts-stripeapi">

        <br/>

        <?php $wcusage_field_stripeapi_connect = wcusage_get_setting_value('wcusage_field_stripeapi_connect', 'standard'); ?>
    		<strong style="margin-left: 40px; display: inline-block;"><label for="scales"><?php echo esc_html__( 'Account Type:', 'woo-coupon-usage' ); ?></label></strong><br/>
    		<select style="margin-left: 40px;" name="wcusage_options[wcusage_field_stripeapi_connect]" id="wcusage_field_stripeapi_connect" class="wcusage_field_stripeapi_connect">
          <option value="standard" <?php if($wcusage_field_stripeapi_connect == "standard") { ?>selected<?php } ?>>Standard</option>
    			<option value="express" <?php if($wcusage_field_stripeapi_connect == "express") { ?>selected<?php } ?>>Express</option>
        </select>
        <br/><i style="margin-left: 40px;">If you're not sure, then use "Standard". The "Express" option offers a better user experience, but has extra fees. Learn More: <a href="https://couponaffiliates.com/docs/pro-stripe-payouts-standard-vs-express" target="_blank">Standard vs Express</a></i>

        <br/><br/>

        <!-- Change Payment Method Label -->
        <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_stripeapi_only', 'Stripe Payouts', esc_html__( 'Payment Method Name', 'woo-coupon-usage' ), '40px'); ?>

        <br/>

        <!-- Change Stripe Account Label -->
        <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_stripeapi', 'Stripe Account', esc_html__( 'Stripe Account Label', 'woo-coupon-usage' ), '40px'); ?>

        <br/>

        <!-- Payment Method Info -->
        <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_stripeapi_info', '', esc_html__( 'Payment Method Information', 'woo-coupon-usage' ), '40px'); ?>
        <i style="margin-left: 40px;"><?php echo esc_html__( 'Custom information/text shown when payment method is selected (in the dashboard settings).', 'woo-coupon-usage' ); ?></i><br/>

        <br/>

        <p style="margin-left: 40px; font-size: 16px; font-weight: bold;">API Credentials*</p>

        <p style="margin-left: 40px;">Get API keys here: <a href="https://dashboard.stripe.com/apikeys" target="_blank">https://dashboard.stripe.com/apikeys</a></p>

        <p style="margin-left: 40px;">Instructions: <a href="https://couponaffiliates.com/docs/pro-stripe-payouts-setup" target="_blank">https://couponaffiliates.com/docs/pro-stripe-payouts-setup</a></p>

        <br/>

        <!-- Change Payment Details Label (Default: "Payment Details") -->
        <?php echo wcusage_setting_toggle_option('wcusage_field_tr_payouts_stripeapi_test', 0, esc_html__( 'Enable Test Mode?', 'woo-coupon-usage' ), '40px'); ?>

        <br/>

        <script>
        jQuery( document ).ready(function() {
          wcusage_check_stripe_test_mode();
          jQuery('.wcusage_field_tr_payouts_stripeapi_test').change(function(){
            wcusage_check_stripe_test_mode();
          });
          function wcusage_check_stripe_test_mode() {
            if(jQuery('.wcusage_field_tr_payouts_stripeapi_test').prop('checked')) {
              jQuery('.wcu-field-section-tr-payouts-stripeapi-live').hide();
              jQuery('.wcu-field-section-tr-payouts-stripeapi-test').show();
            } else {
              jQuery('.wcu-field-section-tr-payouts-stripeapi-live').show();
              jQuery('.wcu-field-section-tr-payouts-stripeapi-test').hide();
            }
          }
        });
        </script>

        <span class="wcu-field-section-tr-payouts-stripeapi-live">

          <?php echo wcusage_setting_text_option('wcusage_field_stripeapi_publish', '', esc_html__( '[Live] API Publishable Key', 'woo-coupon-usage' ), '40px'); ?>

          <br/>

          <?php echo wcusage_setting_text_option('wcusage_field_stripeapi_secret', '', esc_html__( '[Live] API Secret Key', 'woo-coupon-usage' ), '40px'); ?>

        </span>

        <span class="wcu-field-section-tr-payouts-stripeapi-test" style="color: red;">

          <?php echo wcusage_setting_text_option('wcusage_field_stripeapi_test_publish', '', esc_html__( '[Test] API Publishable Key', 'woo-coupon-usage' ), '40px'); ?>

          <br/>

          <?php echo wcusage_setting_text_option('wcusage_field_stripeapi_test_secret', '', esc_html__( '[Test] API Secret Key', 'woo-coupon-usage' ), '40px'); ?>

        </span>

        <div style="clear: both;"></div>

        <!-- User Role -->
        <?php do_action('wcusage_hook_payouts_user_role_select', 'wcusage_field_tr_payouts_stripeapi_role'); ?>

      </span>

      <!-- Enable Store Credit -->
      <div style="margin-bottom: 40px;" id="storecredit-settings"></div>

      <span class="wcu-admin-payouts-headers">
        <?php echo wcusage_setting_toggle_option('wcusage_field_storecredit_enable', 0, esc_html__( 'Store Credit / Wallet', 'woo-coupon-usage' ), '0px'); ?>
      </span>
      <i><?php echo esc_html__( 'Store credit payouts will allow affiliates to have commission paid out into a "wallet" which they can then use as a discount to purchase items/products from your shop.', 'woo-coupon-usage' ); ?> <a href="https://couponaffiliates.com/docs/pro-store-credit" target="_blank"><?php echo esc_html__( 'Learn More.', 'woo-coupon-usage' ); ?></a></i><br/>
      <i><?php echo esc_html__( 'If you want to show the logged in users current store credit balance somewhere, use the shortcode', 'woo-coupon-usage' ); ?>: [couponaffiliates_credit]</i><br/>

      <?php echo wcusage_setting_toggle('.wcusage_field_storecredit_enable', '.wcu-field-section-tr-payouts-storecredit'); // Show or Hide ?>
      <span class="wcu-field-section-tr-payouts-storecredit">

        <br/>

        <!-- Store Credit System/Plugin Picker -->
        <script>
        jQuery( document ).ready(function() {
          wcusage_js_storecredit_system_change();
          jQuery('#wcusage_field_storecredit_system').change(function() {
            wcusage_js_storecredit_system_change();
          });
        });
        function wcusage_js_storecredit_system_change() {
          jQuery('.section-default-credit-system').hide();
          jQuery('.section-default-credit-system-settings').show();
          if( jQuery('#wcusage_field_storecredit_system :selected' ).val() == '' ) {
            jQuery('.section-default-credit-system-settings').hide();
          }
          if( jQuery('#wcusage_field_storecredit_system :selected' ).val() == 'default' ) {
            jQuery('.section-default-credit-system-settings').show();
            jQuery('.section-default-credit-system').hide();
            jQuery('.section-default-credit-system-default').show();
          }
          if( jQuery('#wcusage_field_storecredit_system :selected' ).val() == 'custom' ){
            jQuery('.section-default-credit-system-settings').hide();
            jQuery('.section-default-credit-system').hide();
            jQuery('.section-default-credit-system-custom').show();
          }
          <?php
          // Custom Hook
          if( wcu_fs()->can_use_premium_code() ) {
            do_action('wcusage_hook_settings_store_credit_dropdown_script');
          }
          ?>
        }
        </script>
        <?php $wcusage_field_storecredit_system = wcusage_get_setting_value('wcusage_field_storecredit_system', 'default'); ?>
    		<strong style="margin-left: 40px; display: inline-block;"><label for="scales"><?php echo esc_html__( 'Wallet System', 'woo-coupon-usage' ); ?></label></strong><br/>
    		<select style="margin-left: 40px;" name="wcusage_options[wcusage_field_storecredit_system]" id="wcusage_field_storecredit_system" class="wcusage_field_storecredit_system">
          <option value="">Select an option...</option>
          <option value="default" <?php if($wcusage_field_storecredit_system == "default") { ?>selected<?php } ?>><?php echo esc_html__( '(Free) Built-in Store Credit & Wallet System', 'woo-coupon-usage' ); ?></option>
          <?php
          // Custom Hook
          if( wcu_fs()->can_use_premium_code() ) {
            do_action('wcusage_hook_settings_store_credit_dropdown', $wcusage_field_storecredit_system);
          }
          ?>
          <option value="custom" <?php if($wcusage_field_storecredit_system == "custom") { ?>selected<?php } ?>><?php echo esc_html__( '(Custom) 3rd Party Wallet Plugin Integrations', 'woo-coupon-usage' ); ?></option>
        </select>

        <br/>

        <span class="section-default-credit-system section-default-credit-system-default">

          <!-- Info -->
          <br/><strong style="margin-left: 40px; display: inline-block;"><label for="scales"><?php echo esc_html__( 'Information:', 'woo-coupon-usage' ); ?></label></strong><br/>
          <p style="margin-left: 40px;">
            <?php echo esc_html__( 'You are all set! Store credit payouts will now be added to the users wallet automatically in one-click. They can spend this credit when visiting the cart/checkout.', 'woo-coupon-usage' ); ?>
          </p>
          <p style="margin-left: 40px;">
            <?php echo esc_html__( 'This is our default store credit system, built directly into this plugin. (A more simple solution with no additional setup needed.)', 'woo-coupon-usage' ); ?>
          </p>

        </span>

        <span class="section-default-credit-system section-default-credit-system-custom">

          <!-- Info -->
          <br/><strong style="margin-left: 40px; display: inline-block;"><label for="scales"><?php echo esc_html__( 'Information:', 'woo-coupon-usage' ); ?></label></strong><br/>
          <p style="margin-left: 40px;">
            <?php echo esc_html__( 'For most websites, unless you are already using a 3rd party wallet plugin, we would suggest just using our free built-in wallet system.', 'woo-coupon-usage' ); ?>
          </p>
          <br/>
          <p style="margin-left: 40px;">
            <?php echo esc_html__( 'However, if preferred, you can use a 3rd party wallet plugin for the store credit payouts. This does however require more setup work, and an additional integration plugin.', 'woo-coupon-usage' ); ?>
          </p>
          <br/>
          <p style="margin-left: 40px;">
            <?php echo esc_html__( 'The following integration addons are available to download and install right now:', 'woo-coupon-usage' ); ?>
          </p>

          <br/>

          <!-- TeraWallet Info -->
          <p style="margin-left: 40px;">
            <?php
            $terawallet_active = ( is_plugin_active( 'woo-wallet/woo-wallet.php' ) ? true : false );
            $terawallet_addon_active = ( is_plugin_active( 'woo-coupon-usage-terawallet-integration-premium/wcu-terawallet-integration.php' ) ? true : false );
            $terawallet_link = "https://en-gb.wordpress.org/plugins/woo-wallet";
            ?>
            <strong>TeraWallet</strong> <span style="font-size: 10px;">By WCBeginner <a href="<?php echo esc_url($terawallet_link); ?>" target="_blank" title="View Plugin"><span class="fas fa-external-link-alt"></span></a></span><br/>
            <?php if($terawallet_active) { ?><span class="fas fa-check-circle" style="color: green;"></span> Plugin Installed & Activated<br/><?php } ?>
            <?php if($terawallet_addon_active) { ?>
              <?php if(!$terawallet_active) { ?><span class="fas fa-times-circle" style="color: red;"></span> Plugin Installed & Activated<br/><?php } ?>
              <span class="fas fa-check-circle" style="color: green;"></span> Integration Addon Installed & Activated
            <?php } else { ?>
              Integration Addon Price: $19.99 (One-Time)<br/>
              <?php if($terawallet_active) { ?><span class="fas fa-times-circle" style="color: red;"></span><?php } ?>
                <a href="https://couponaffiliates.com/addons/terawallet-integration" target="_blank" title="View Addon" style="text-decoration: none;">
                  View Details & Download Integration <span class="fas fa-arrow-circle-right"></span>
                </a>
            <?php } ?>
          </p>

          <br/>

          <!-- YITH WooCommerce Account Funds Info -->
          <p style="margin-left: 40px;">
            <?php
            $yithfunds_active = ( is_plugin_active( 'yith-woocommerce-account-funds-premium/init.php' ) ? true : false );
            $yithfunds_addon_active = ( is_plugin_active( 'woo-coupon-usage-yithfunds-integration-premium/wcu-yithfunds-integration.php' ) ? true : false );
            $yithfunds_link = "https://yithemes.com/themes/plugins/yith-woocommerce-account-funds";
            ?>
            <strong>YITH WooCommerce Account Funds</strong> <span style="font-size: 10px;">By YITH® <a href="<?php echo esc_url($yithfunds_link); ?>" target="_blank" title="View Plugin"><span class="fas fa-external-link-alt"></span></a></span><br/>
            <?php if($yithfunds_active) { ?><span class="fas fa-check-circle" style="color: green;"></span> Plugin Installed & Activated<br/><?php } ?>
            <?php if($yithfunds_addon_active) { ?>
              <?php if(!$yithfunds_active) { ?><span class="fas fa-times-circle" style="color: red;"></span> Plugin Installed & Activated<br/><?php } ?>
              <span class="fas fa-check-circle" style="color: green;"></span> Integration Addon Installed & Activated
            <?php } else { ?>
              Integration Addon Price: $19.99 (One-Time)<br/>
              <?php if($yithfunds_active) { ?><span class="fas fa-times-circle" style="color: red;"></span><?php } ?>
                <a href="https://couponaffiliates.com/addons/yithfunds-integration" target="_blank" title="View Addon" style="text-decoration: none;">
                  View Details & Download Integration <span class="fas fa-arrow-circle-right"></span>
                </a>
            <?php } ?>
          </p>

          <br/>

          <p style="margin-left: 40px;">
            <?php echo esc_html__( 'Once you have installed/activated both the integration addon, and the wallet plugin, refresh this page. You will then be able to enable it in the "Wallet System" dropdown above.', 'woo-coupon-usage' ); ?>
          </p>

          <br/>

          <p style="margin-left: 40px; font-weight: bold;">
            <?php echo esc_html__( 'Want us to create a new plugin integration?', 'woo-coupon-usage' ); ?> <a href="https://roadmap.couponaffiliates.com/boards/feature-requests" target="_blank"><?php echo esc_html__( 'Submit a feature request.', 'woo-coupon-usage' ); ?></a>
          </p>

        </span>

        <?php
        // Custom Hook
        if( wcu_fs()->can_use_premium_code() ) {
          do_action('wcusage_hook_settings_store_credit_info');
        }
        ?>

        <br/>

        <span class="section-default-credit-system-settings">

          <!-- Change Payment Method Label - Store Credit -->
          <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_storecredit_only', 'Store Credit', esc_html__( 'Payment Method Name', 'woo-coupon-usage' ), '40px'); ?>
          <i style="margin-left: 40px;"><?php echo esc_html__( 'The name of your Store Credit wallet, show in the payout method selection etc.', 'woo-coupon-usage' ); ?></i><br/>

          <br/>

          <!-- Payment Method Info - Store Credit -->
          <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_storecredit_info', '', esc_html__( 'Payment Method Information', 'woo-coupon-usage' ), '40px'); ?>
          <i style="margin-left: 40px;"><?php echo esc_html__( 'Custom information/text shown when payment method is selected (in the dashboard settings).', 'woo-coupon-usage' ); ?></i><br/>

          <br/>

          <!-- "Store Credit Balance" Text - Store Credit -->
          <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_storecredit_balance', 'Store Credit Balance', esc_html__( 'Custom "Store Credit Balance" Text', 'woo-coupon-usage' ), '40px'); ?>
          <i style="margin-left: 40px;"><?php echo esc_html__( 'Text shown next to the users store credit balance.', 'woo-coupon-usage' ); ?></i><br/>

          <br/>

          <!-- Custom "Affiliate Commission" Text -->
          <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_storecredit_description', 'Affiliate Commission', esc_html__( 'Custom "Affiliate Commission" Text', 'woo-coupon-usage' ), '40px'); ?>
          <i style="margin-left: 40px;"><?php echo esc_html__( 'Used when describing the store credit payment/transaction in the logs.', 'woo-coupon-usage' ); ?></i><br/>

          <span class="section-default-credit-system section-default-credit-system-default">

            <br/>

            <!-- Change Cart Discount Text - Store Credit -->
            <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_storecredit_discount', 'Store Credit Discount', esc_html__( 'Cart Discount Text', 'woo-coupon-usage' ), '40px'); ?>
            <i style="margin-left: 40px;"><?php echo esc_html__( 'This is the name of the discount shown on the cart page, when store credit is applied.', 'woo-coupon-usage' ); ?></i><br/>

            <br/>

            <!-- "Affiliate store credit available" Text - Store Credit -->
            <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_storecredit_available', 'Affiliate store credit available', esc_html__( 'Custom "Affiliate store credit available" Text', 'woo-coupon-usage' ), '40px'); ?>
            <i style="margin-left: 40px;"><?php echo esc_html__( 'Shown on the cart/checkout page when they have credit available to spend.', 'woo-coupon-usage' ); ?></i><br/>

            <br/>

            <!-- "Apply {credit} credit to this order." Text - Store Credit -->
            <?php echo wcusage_setting_text_option('wcusage_field_tr_payouts_storecredit_apply', 'Apply {credit} credit to this order.', esc_html__( 'Custom "Apply credit to this order" Text', 'woo-coupon-usage' ), '40px'); ?>
            <i style="margin-left: 40px;"><?php echo esc_html__( 'This is shown below the message above, next to a checkbox, allowing them to apply some or all of their credit to the cart.', 'woo-coupon-usage' ); ?></i><br/>
            <i style="margin-left: 40px;"><?php echo esc_html__( 'Use merge tag {credit} to show the amount of credit they can apply.', 'woo-coupon-usage' ); ?></i><br/>

            <br/>

            <!-- Show "Store Credit" Column on Users List -->
            <?php echo wcusage_setting_toggle_option('wcusage_field_tr_payouts_storecredit_users_col', 1, esc_html__( 'Show "Store Credit" column on admin users list?', 'woo-coupon-usage' ), '40px'); ?>
            <i style="margin-left: 40px;"><?php echo esc_html__( 'This will show the current "Store Credit" for each user on the "All Users" admin page.', 'woo-coupon-usage' ); ?></i><br/>

            <br/>

            <!-- Commission Bonus % -->
            <?php echo wcusage_setting_number_option('wcusage_field_tr_payouts_storecredit_bonus', '0', esc_html__( 'Bonus Commission (%)', 'woo-coupon-usage' ), '40px'); ?>
            <i style="margin-left: 40px;"><?php echo esc_html__( 'Give affiliates extra commission % as a bonus for selecting Store Credit as their payout method.', 'woo-coupon-usage' ); ?></i><br/>
            <i style="margin-left: 40px;"><?php echo esc_html__( 'This bonus is not applied on the dashboard or when they request payouts. It will simply apply the bonus % as additional credit, when the payout is marked as paid.', 'woo-coupon-usage' ); ?></i><br/>

            <?php if(get_option("woocommerce_tax_display_cart") == "incl") { ?>

              <br/>

              <!-- "Store Credit" Exclude Tax -->
              <?php echo wcusage_setting_toggle_option('wcusage_field_tr_payouts_storecredit_excl_tax', 0, esc_html__( 'Exclude/Remove taxes from Store Credit in cart.', 'woo-coupon-usage' ), '40px'); ?>
              <i style="margin-left: 40px;"><?php echo esc_html__( 'This will remove/deduct the tax amount from the store credit, if it is added to the credit amount in the cart.', 'woo-coupon-usage' ); ?></i><br/>

            <?php } ?>
            
          </span>

          <?php
          // Custom Hook
          if( wcu_fs()->can_use_premium_code() ) {
            do_action('wcusage_hook_settings_store_credit_options');
          }
          ?>

        </span>

        <!-- User Role -->
        <?php do_action('wcusage_hook_payouts_user_role_select', 'wcusage_field_tr_payouts_storecredit_role'); ?>

      </span>

      <div style="margin-bottom: 40px;"></div>

      <hr/>

      <h3><span class="dashicons dashicons-admin-generic" style="margin-top: 2px;"></span> Default Payout Method:</h3>

      <p>If required, you can set one of the payout methods as the default. This means that if the affiliate does not currently have a payout method selected, this one will be enabled by default.</p>
      <p>- If set to "Store Credit Payouts" or "Custom Payment methods" (with field disabled), they will therefore be able to instantly request payouts without needing to select their payout method first.</p>
      <p>- If set to "Direct Bank Transfer", "PayPal Payouts" or "Stripe Payouts" they will still be required to update and set their payment details in the settings tab, but it will be selected as their default option.</p>

      <br/>

      <?php $currentdefaulttype = wcusage_get_setting_value('wcusage_field_payouts_default_type', '0'); ?>
      <p>
      <select name="wcusage_options[wcusage_field_payouts_default_type]" id="wcusage_field_payouts_default_type">
          <option value="-" <?php if(!$currentdefaulttype) { ?>selected<?php } ?>><?php echo esc_html__( 'No Default', 'woo-coupon-usage' ); ?></option>
          <option value="custom1" <?php if($currentdefaulttype == "custom1") { ?>selected<?php } ?>><?php echo esc_html__( 'Custom Payment Method #1', 'woo-coupon-usage' ); ?></option>
          <option value="custom2" <?php if($currentdefaulttype == "custom2") { ?>selected<?php } ?>><?php echo esc_html__( 'Custom Payment Method #2', 'woo-coupon-usage' ); ?></option>
          <option value="banktransfer" <?php if($currentdefaulttype == "banktransfer") { ?>selected<?php } ?>><?php echo esc_html__( 'Direct Bank Transfer', 'woo-coupon-usage' ); ?></option>
          <option value="paypalapi" <?php if($currentdefaulttype == "paypalapi") { ?>selected<?php } ?>><?php echo esc_html__( 'PayPal Payouts', 'woo-coupon-usage' ); ?></option>
          <option value="stripeapi" <?php if($currentdefaulttype == "stripeapi") { ?>selected<?php } ?>><?php echo esc_html__( 'Stripe Payouts', 'woo-coupon-usage' ); ?></option>
          <option value="credit" <?php if($currentdefaulttype == "credit") { ?>selected<?php } ?>><?php echo esc_html__( 'Store Credit / Wallet', 'woo-coupon-usage' ); ?></option>
      </select>
      </p>

      <br/><hr/>

      <h3><span class="dashicons dashicons-admin-generic" style="margin-top: 2px;"></span> <?php echo esc_html__( 'Email Notifications', 'woo-coupon-usage' ); ?></h3>

      <p>
  		  <?php echo esc_html__( 'To manage (and enable) email notifications for payouts, go to the "Emails" settings tab.', 'woo-coupon-usage' ); ?>
  		</p>

      <br/><hr/>

      <h3><span class="dashicons dashicons-admin-generic" style="margin-top: 2px;"></span> Invoices & PDF Statements:</h3>

      <p>You can enable "Invoices" and "PDF statement" features in the "PRO modules" section. A new settings tab (Invoices/Statements) will then appear on this page for setup and customisation.</p>
      <p>- Invoices will allow affiliates to upload their invoices when submitting a payout.</p>
      <p>- Statements will automatically generate a PDF payment statement for affiliates to download, when a payout is requested.</p>

    </span>

	</div>

 <?php
}

/*
* Payouts User Role Select
*/
add_action('wcusage_hook_payouts_user_role_select', 'wcusage_payouts_user_role_select', 10, 1);
function wcusage_payouts_user_role_select($thisid) {

  $options = get_option('wcusage_options');

  if(!empty($options[$thisid])) {
    $current_roles = $options[$thisid];
  } else {
    $current_roles = '';
  }
  ?>
  
  <span style="margin-left: 40px;">

  <!-- Toggle Option -->
  <?php
  if(empty($current_roles)) {    
    $toggle_checked = 0;
  } else {
    $toggle_checked = 1;
    $options1 = get_option('wcusage_options');
    $options1[$thisid . '_toggle'] = 1;
    update_option('wcusage_options', $options1);
  }
  echo wcusage_setting_toggle_option($thisid.'_toggle', $toggle_checked, esc_html__( 'Limit to certain user roles & groups?', 'woo-coupon-usage' ), '40px');
  echo wcusage_setting_toggle('.'.$thisid.'_toggle', '.payouts-role-select-'.$thisid); // Show or Hide
  ?>

  <script>
  jQuery( document ).ready(function() {
    if(jQuery('.payouts-role-select-<?php echo esc_attr($thisid); ?> input[type="checkbox"]:checked').length > 0) {
      jQuery('#<?php echo esc_attr($thisid); ?>_toggle_p label.switch').hide();
    } else {
      jQuery('#<?php echo esc_attr($thisid); ?>_toggle_p label.switch').show();
    }
    jQuery('.payouts-role-select-<?php echo esc_attr($thisid); ?> input[type="checkbox"]').change(function() {
      if(jQuery('.payouts-role-select-<?php echo esc_attr($thisid); ?> input[type="checkbox"]:checked').length > 0) {
        jQuery('#<?php echo esc_attr($thisid); ?>_toggle_p label.switch').hide();
      } else {
        jQuery('#<?php echo esc_attr($thisid); ?>_toggle_p label.switch').show();
      }
    });
  });
  </script>

  <!-- User Role Select -->
  <span class="payouts-role-select-<?php echo esc_attr($thisid); ?>">

    <span style="height: 50px; width: 250px; overflow-y: auto;
    display: block; margin-left: 40px; border: 1px solid #ddd; padding: 10px;">

    <?php
    $roles = get_editable_roles();
    // Re-order with all those containing "coupon_affiliate" at the start
    $roles2 = array();
    foreach ($roles as $key => $role) {
      if (strpos($key, 'coupon_affiliate') !== false) {
        $roles2[$key] = $role;
        unset($roles[$key]);
      }
    }
    $roles2 = array_merge($roles2, $roles);
    foreach ($roles2 as $key => $role) {
      $name = 'wcusage_options['.$thisid.']['.$key.']';
      $role_name = $role['name'];
      if (strpos($key, 'coupon_affiliate') !== false) {
        $role_name = '(Group) '.$role_name;
      }
      $checked = '';
      if(isset($options[$thisid]) && is_array($options[$thisid])) {
        if(isset($options[$thisid][$key])) {
          $checked = 'checked';
        }
      } else {
        if(isset($options[$thisid]) && $options[$thisid] == $key) {
          $checked = 'checked';
        }
      }
      echo '<span id="'.esc_attr($thisid).'">
      <input type="checkbox" checktype="multi"
      class="payouts-role payouts-role-'.esc_attr($key).' wcusage_field_'.esc_attr($thisid).'_role"
      checktypekey="'.esc_attr($key).'"
      customid="'.esc_attr($thisid).'"
      name="'.esc_attr($name).'"
      '.esc_attr($checked).'> '.esc_attr($role_name).'</span><br/>';
    }
    ?>

    </span>

  </span>

  <i style="margin-left: 40px;"><?php echo esc_html__( 'If at-least 1 role is selected, this payout method will only be available for the selected user roles. If none are selected it will be available for all roles.', 'woo-coupon-usage' ); ?></i><br/>

  </span>

  <?php
}