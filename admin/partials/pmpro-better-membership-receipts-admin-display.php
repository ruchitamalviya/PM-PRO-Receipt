<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.expresstechsoftwares.com/
 * @since      1.0.0
 *
 * @package    Pmpro_Better_Membership_Receipts
 * @subpackage Pmpro_Better_Membership_Receipts/admin/partials
 */

?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
    $receipt_logo = sanitize_text_field(trim(get_option('upload_receipt_logo', false)));
    $receipt_title = sanitize_text_field(trim(get_option('receipt_title', false)));
    $receipt_content = sanitize_textarea_field(trim(get_option('receipt_content', false)));
    $company_name = sanitize_text_field(trim(get_option('company_name', false)));
    $company_address = sanitize_textarea_field(trim(get_option('company_address', false)));
?>
<div class="child_container">
    <h2 class="heading"><?php _e('Membership Receipt Settings','pmpro-better-membership-receipts')?></h2>
    <form method="post" action="<?php echo get_site_url() . '/wp-admin/admin-post.php'; ?>" id="register">
        <input type="hidden" class="ets_field" name="action" value="ets_save_receipt_settings">
        <?php wp_nonce_field('save_receipt_main_setting', 'ets_save_receipt_main_setting');?>
        <label for="receipt_title"><?php_e('Title','pmpro-better-membership-receipts')?></label><br><br>
        <input type="text" class="ets_field" id="receipt_title" name="receipt_title" value="<?php echo (isset($receipt_title) && $receipt_title) ?
             esc_html($receipt_title) : ''; ?>"><br><br>
        <label for="upload-receipt-logo"><?php _e('Logo','pmpro-better-membership-receipts')?></label><br><br>
        <input type="button" class="ets_field" value="Upload Logo" id="upload-receipt-logo">
        <input type="hidden" class="ets_field" id="upload_receipt_logo" name="upload_receipt_logo" value="<?php echo (isset($receipt_logo) && $receipt_logo) ?
             $receipt_logo : '' ; ?>"/><br><br>
        <div id="#logo_receipt_preview" class="upload-receipt-preview">
            <img src="<?php echo  $receipt_logo?>" width="100px" height="100px">
        </div><br><br>
        
        <label for="company_name"><?php _e('Company Name','pmpro-better-membership-receipts')?></label><br><br>
         <input type="text" class="ets_field" id="company_name" name="company_name" value="<?php echo (isset($company_name) &&  $company_name) ?
              esc_html($company_name) : ''; ?>"><br><br>
        <label for="company_address"><?php _e('Company Address','pmpro-better-membership-receipts')?></label><br><br>
        <textarea id="company_address" name="company_address" rows="6" cols="35"><?php echo (isset($company_address) && $company_address) ? $company_address : '' ; ?></textarea><br><br>
        <label for="receipt_footer"><?php _e('Footer','pmpro-better-membership-receipts')?></label><br><br>
        <?php
            $footer_editor_manager = array(
                'textarea_rows' => 12,
                'quicktags'     => true,
                'tinymce'       => true,
                'media_buttons' => true,
                'class'         => 'regular-text',
                'textarea_name' => 'receipt_footer',
            );
            $footer_content = '';
            $footer_content = sanitize_text_field(trim(get_option("receipt_footer", false)));
            $footer_content = html_entity_decode( $footer_content );
            $footer_content = stripslashes( $footer_content );
            wp_editor( $footer_content, 'receipt_footer', $footer_editor_manager );   
        ?>
        <br>
        <label for="receipt_content"><?php _e('Content','pmpro-better-membership-receipts')?></label><br><br>
        <textarea id="receipt_content" name="receipt_content" rows="8" cols="35"><?php echo (isset($receipt_content) && $receipt_content) ?
             ($receipt_content) : '' ;?></textarea><br><br>
        <input type="submit" name="save_btn" id="save_btn" class="ets_field" value="<?php _e('Save','pmpro-better-membership-receipts')?>">  
    </form>
</div>
   