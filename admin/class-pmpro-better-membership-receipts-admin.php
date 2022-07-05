<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.expresstechsoftwares.com/
 * @since      1.0.0
 *
 * @package    Pmpro_Better_Membership_Receipts
 * @subpackage Pmpro_Better_Membership_Receipts/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pmpro_Better_Membership_Receipts
 * @subpackage Pmpro_Better_Membership_Receipts/admin
 * @author     ExpressTech Softwares Solutions Pvt Ltd <contact@expresstechsoftwares.com>
 */
class Pmpro_Better_Membership_Receipts_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string     $plugin_name       The name of this plugin.
	 * @param      string     $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pmpro_Better_Membership_Receipts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pmpro_Better_Membership_Receipts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pmpro-better-membership-receipts-admin.css', array(), $this->version, 'all' );
	}
	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pmpro_Better_Membership_Receipts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pmpro_Better_Membership_Receipts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pmpro-better-membership-receipts-admin.js', array( 'jquery' ), $this->version, false );
		 wp_enqueue_media();
	}

	/**
	 * Add custom menu.
	 * 
	 * @since    1.0.0
	 * 
	 */
	public function ets_add_custom_reciept_menu() {
		add_submenu_page('pmpro-dashboard',
						 __('pmpro better membership receipt','pmpro-better-membership-receipts'), 
						 __('Membership Receipt','pmpro-better-membership-receipts'), 
						 'manage_options',
						 'pmpro-recipt' , 
						 array ($this, 'pmpro_recipt_add' )
			);
	}
// add reciept.
	public function pmpro_recipt_add() {
	require_once PMPRO_BETTER_RECEIPT_PATH . 'admin/partials/pmpro-better-membership-receipts-admin-display.php';		
	}
// save content.
	public function save_content()  {
		if (isset($_POST['save_btn'] ) ) :
			if ( isset($_POST['ets_save_receipt_main_setting']) && wp_verify_nonce($_POST['ets_save_receipt_main_setting'], 'save_receipt_main_setting')) :
				$receipt_logo = isset($_POST['upload_receipt_logo']) && $_POST['upload_receipt_logo'] ? sanitize_text_field(trim($_POST['upload_receipt_logo'] ) ) : '';
				$receipt_title = isset($_POST['receipt_title']) && $_POST['receipt_title'] ? sanitize_text_field(trim($_POST['receipt_title'] ) ) : '';
				$company_name = isset($_POST['company_name']) && $_POST['company_name'] ? sanitize_text_field(trim($_POST['company_name'] ) ) : '';
				echo nl2br($_POST['company_address']);
				$company_address = isset($_POST['company_address']) && $_POST['company_address'] ? nl2br(sanitize_textarea_field(trim($_POST['company_address'] ) ) ) : '';

				if ( isset($_POST['receipt_footer']) && $_POST['receipt_footer']) :
					$receipt_footer = htmlentities( wpautop( $_POST['receipt_footer'] ) );
					$receipt_footer = stripslashes( $receipt_footer );
				endif;
				$receipt_content = isset($_POST['receipt_content']) && $_POST['receipt_content'] ? nl2br(sanitize_textarea_field(trim($_POST['receipt_content'] ) ) ) : '';
				update_option('upload_receipt_logo' , $receipt_logo);	
				update_option('receipt_title', $receipt_title);
				update_option('company_name', $company_name);
				update_option('company_address', $company_address);
				update_option('receipt_footer', $receipt_footer);
				update_option('receipt_content', $receipt_content);
				if ( isset( $_SERVER['HTTP_REFERER'] ) ) :
					$message = 'Your setting saved sucesfully.';
					$pre_location = $_SERVER['HTTP_REFERER'] . '&save_settings_msg=' . $message;
						wp_safe_redirect( $pre_location );
				endif;
			endif;
		endif;
	}
}
