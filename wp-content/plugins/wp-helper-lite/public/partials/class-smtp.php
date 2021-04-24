<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 * 
 * @since      1.0.0
 *
 * @package    MB_WP_Manage
 * @subpackage MB_WP_Manage/public/partials
 */
if ( defined( 'ABSPATH' ) && ! class_exists( 'mbwph_Smtp_Load_Settings' ) ) {		
	class mbwph_Smtp_Load_Settings{
		private $WP_HELPER;
		private $smtpOptions, $phpmailer_error;
		/**
		* Class constructor.
		*/
		public function __construct() {
			$this->WP_HELPER = 'wp-helper';
			$this->setup_vars();
			$this->hooks();
		}
		private function hooks(){
			add_action( 'phpmailer_init', array( $this,'mbwph_smtp' ), 999);
			add_action( 'wp_mail_failed', array( $this, 'mbwph_catch_phpmailer_error' ) );			
		}
		function setup_vars(){
			$this->smtpOptions = get_option($this->WP_HELPER . '_smtp_options') ;		
		}
		function mbwph_smtp( $phpmailer ) {

			if( ! is_email($this->smtpOptions["from"] ) || empty( $this->smtpOptions["smtp-host"] ) ) {
				return;
			}
			$phpmailer->IsSMTP();
			//$phpmailer->Mailer = "smtp";
			$phpmailer->From = $this->smtpOptions["from"];
			$phpmailer->FromName = $this->smtpOptions["from-name"];
			$phpmailer->SetFrom ( $phpmailer->From, $phpmailer->FromName );
			$phpmailer->Sender = $phpmailer->From; //Return-Path
			$phpmailer->AddReplyTo($phpmailer->From,$phpmailer->FromName); //Reply-To
			$phpmailer->Host = $this->smtpOptions["smtp-host"];
			$phpmailer->SMTPSecure = $this->smtpOptions["smtp-secure"];
			$phpmailer->Port = $this->smtpOptions["smtp-port"];
			$phpmailer->SMTPAuth = ($this->smtpOptions["smtp-auth"]=="yes") ? TRUE : FALSE;

			if( $phpmailer->SMTPAuth ){
				$phpmailer->Username = $this->smtpOptions["smtp-username"];
				$phpmailer->Password = $this->smtpOptions["smtp-password"];
			}
		}
		function mbwph_catch_phpmailer_error( $error ) {
			$this->phpmailer_error = $error;
		}		
	}
}