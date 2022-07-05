<div class="main_container">
<?php
$receipt_logo = trim(get_option('upload_receipt_logo', true));
$receipt_title = trim(get_option('receipt_title', true));
$receipt_content = trim(get_option('receipt_content', true));
$footer_content = trim(get_option('receipt_footer', true));
 if (isset($receipt_title)&&$receipt_title &&isset($receipt_content) && $receipt_content &&isset($footer_content) && $footer_content) {
    ?>
	<header class="header"><div class="preview_logo"><img src="<?php echo $receipt_logo;?>"></div></header>
		 	<h2 class="title_content"><?php echo $receipt_title;?></h2>
		 	<div class="preview_content"><?php echo $receipt_content; ?></div>
		 

			<?php

			global $wpdb, $pmpro_invoice, $pmpro_msg, $pmpro_msgt, $current_user;
			if ( $pmpro_msg ) {
			?>
				<div class="<?php echo pmpro_get_element_class( 'pmpro_message ' . $pmpro_msgt, $pmpro_msgt ); ?>"><?php echo $pmpro_msg; ?></div>
				<?php } ?>
				<?php
				if( $pmpro_invoice ) {  ?>
				 <?php
				$pmpro_invoice->getUser();
				$pmpro_invoice->getMembershipLevel();
				?>
				<h3><?php printf(__('Invoice #%s on %s', 'pmpro-better-membership-receipts' ), $pmpro_invoice->code, date_i18n(get_option('date_format'), $pmpro_invoice->getTimestamp()));?></h3>
				<ul>
					<?php do_action("pmpro_invoice_bullets_top", $pmpro_invoice); ?>
					<li><strong><?php _e('Account', 'pmpro-better-membership-receipts' );?>:</strong> <?php echo $pmpro_invoice->user->display_name?> (<?php echo $pmpro_invoice->user->user_email?>)
					</li>
					<li><strong><?php _e('Membership Level', 'pmpro-better-membership-receipts' );?>:</strong> <?php echo $pmpro_invoice->membership_level->name?>
					</li>
					<?php if ( ! empty( $pmpro_invoice->status ) ) { ?>
					<li><strong><?php _e('Status', 'pmpro-better-membership-receipts' ); ?>:</strong>
						<?php
						if ( in_array( $pmpro_invoice->status, array( '', 'success', 'cancelled' ) ) ) {
						$display_status = __( 'Paid', 'pmpro-better-membership-receipts' );
						} else {
						$display_status = ucwords( $pmpro_invoice->status );
						}
						esc_html_e( $display_status );
						?>
					</li>
					<?php } ?>
					<?php if( $pmpro_invoice->getDiscountCode()) { ?>
					<li><strong><?php _e('Discount Code', 'pmpro-better-membership-receipts' );?>:</strong> <?php echo $pmpro_invoice->discount_code->code?>
					</li>
					<?php } ?>
					<?php do_action("pmpro_invoice_bullets_bottom", $pmpro_invoice); ?>
				</ul>
<?php
			// Check instructions
			if ( $pmpro_invoice->gateway == "check" && ! pmpro_isLevelFree( $pmpro_invoice->membership_level ) ) {
				echo '<div class="' . pmpro_get_element_class( 'pmpro_payment_instructions' ) . '">' . wpautop( wp_unslash( pmpro_getOption("instructions") ) ) . '</div>';
			}
		?>
		<div class="<?php echo pmpro_get_element_class( 'pmpro_invoice_details' ); ?>">
			<?php if(!empty($pmpro_invoice->billing->street)) { ?>
				<div class="<?php echo pmpro_get_element_class( 'pmpro_invoice-billing-address' ); ?>">
					<strong><?php _e('Billing Address', 'pmpro-better-membership-receipts' );?></strong>
					<p>
						<span class="<?php echo pmpro_get_element_class( 'pmpro_invoice-field-billing_name' ); ?>"><?php echo $pmpro_invoice->billing->name; ?></span>
						<span class="<?php echo pmpro_get_element_class( 'pmpro_invoice-field-billing_street' ); ?>"><?php echo $pmpro_invoice->billing->street; ?></span>
						<?php if($pmpro_invoice->billing->city && $pmpro_invoice->billing->state) { ?>
							<span class="<?php echo pmpro_get_element_class( 'pmpro_invoice-field-billing_city' ); ?>"><?php echo $pmpro_invoice->billing->city; ?></span>
							<span class="<?php echo pmpro_get_element_class( 'pmpro_invoice-field-billing_state' ); ?>"><?php echo $pmpro_invoice->billing->state; ?></span>
							<span class="<?php echo pmpro_get_element_class( 'pmpro_invoice-field-billing_zip' ); ?>"><?php echo $pmpro_invoice->billing->zip; ?></span>
							<span class="<?php echo pmpro_get_element_class( 'pmpro_invoice-field-billing_country' ); ?>"><?php echo $pmpro_invoice->billing->country; ?></span>
						<?php } ?>
						<span class="<?php echo pmpro_get_element_class( 'pmpro_invoice-field-billing_phone' ); ?>"><?php echo formatPhone($pmpro_invoice->billing->phone); ?></span>
					</p>
				</div> <!-- end pmpro_invoice-billing-address -->
			<?php } ?>

			<?php if ( ! empty( $pmpro_invoice->accountnumber ) || ! empty( $pmpro_invoice->payment_type ) ) { ?>
				<div class="<?php echo pmpro_get_element_class( 'pmpro_invoice-payment-method' ); ?>">
					<strong><?php _e('Payment Method', 'pmpro-better-membership-receipts' );?></strong>
					<?php if($pmpro_invoice->accountnumber) { ?>
						<span class="alignment"><?php echo ucwords( $pmpro_invoice->cardtype ); ?> <?php _e('ending in', 'paid-memberships-pro' );?> <?php echo last4($pmpro_invoice->accountnumber)?>
						<br />
						<?php _e('Expiration', 'pmpro-better-membership-receipts' );?>: <?php echo $pmpro_invoice->expirationmonth?>/<?php echo $pmpro_invoice->expirationyear?></span>
					<?php } else { ?>
						<span class="alignment_payment"><?php echo $pmpro_invoice->payment_type; ?></span>
					<?php } ?>
				</div> <!-- end pmpro_invoice-payment-method -->
			<?php } ?>
				<div class="<?php echo pmpro_get_element_class( 'pmpro_invoice-total' ); ?>">
					<strong><?php _e('Total Billed', 'pmpro-better-membership-receipts' );?></strong>
					<span class="alignmen_total">
					<?php
					if ( (float)$pmpro_invoice->total > 0 ) {
						echo pmpro_get_price_parts( $pmpro_invoice, 'span' );
					} else {
						echo pmpro_escape_price( pmpro_formatPrice(0) );
					}
					?>
					</span>
				</div> 
			</div>	
			<?php }?>
		 	<footer class="preview_footer"><?php echo $footer_content;?></footer>
<?php }
?>

</div>
