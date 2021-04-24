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
if ( defined( 'ABSPATH' ) && ! class_exists( 'mbwph_Social_Load_Settings' ) ) {		
	class mbwph_Social_Load_Settings{
		private $WP_HELPER;
		private $socialOptions;
		/**
		* Class constructor.
		*/
		public function __construct() {
			$this->WP_HELPER = 'wp-helper';
			$this->setup_vars();
			$this->hooks();
		}
		function setup_vars(){
			$this->socialOptions = get_option($this->WP_HELPER . '_social_options') ;		
		}		
		private function hooks(){
			//Load Styles, Script			
			//if(! is_admin()){
				add_action('wp_enqueue_scripts', array( $this,'mbwph_load_style_script'), 1001);
				add_action('wp_footer', array($this, 'render_html_social'));
			//}
			if(!empty($this->socialOptions["fb-app-id"])){
				add_action('wp_head', array( $this, 'hook_facebook_messenger_scripts'));
				add_action('wp_footer',array( $this, 'hook_messenger_button'));			
			}
			if(!empty($this->socialOptions["enable-fbcomment"]) && $this->socialOptions["enable-fbcomment"] == true){				
				//Remove Default Comment WordPress
				add_filter( 'comments_open', array( $this, 'remove_default_comment' ), 20, 2 );
				add_action( 'wp_head', array( $this, 'hook_facebook_comment_scripts'));
				add_filter( 'the_content', array( $this, 'show_facebook_comment' ));			
			}
			//Tawk.to
			if(!empty($this->socialOptions["tawkto-id"])){			
				add_action('wp_footer',array( $this, 'hook_tawkto_button'));
			}
			
		}
		function mbwph_load_style_script(){				
			wp_enqueue_style( 'dashicons' );
			wp_enqueue_style( 'mbwph-style', plugin_dir_url( __FILE__ ) .'assets/css/mbwph-style.css');
			wp_enqueue_script( 'mfb-script', plugin_dir_url( __FILE__ ) . 'assets/js/mbwph-scripts.js', array('jquery'), '1.0.0', false );
		}
		function render_html_social(){
			$html = '';
			$btn_color = $this->socialOptions["btn-color"];
			$btn_message =  $this->socialOptions["btn-message"];
			$fb_appID = $this->socialOptions["fb-app-id"];
			$fb_greeting = $this->socialOptions["greeting-message"];
			$fb_pageID = $this->socialOptions["fb-page-id"];
			$fb_page_link = $this->socialOptions["fb-page-link"];
			$tawkID = $this->socialOptions["tawkto-id"];
			$call_us = $this->socialOptions["phone-number"];
			$email = $this->socialOptions["mail-to"];
			$tawkto =  $this->socialOptions["tawkto-id"];
			$zalo_phone = $this->socialOptions["zalo-phone"];
			
			if(!empty($fb_appID && $fb_pageID) || !empty($zalo_phone) || !empty($tawkID) || !empty($call_us) || !empty($email)){
				$html = '<div class="mbwph-contact mbwph-contact-right mbwph-contact-low">';
				if(!empty($call_us)){
					$html .='<a href="tel:'.$call_us.'" tooltip="'.$call_us.'" class="mbwph-contact-icon mbwph-tooltip-right mbwph-call"></a>';
				}
				if(!empty($email)){
					$html .='<a href="mailto:'.$email.'" tooltip="'.$email.'" class="mbwph-contact-icon mbwph-tooltip-right mbwph-mail"></a>';
				}
				if(!empty($tawkto)){            
					$html .='<a href="javascript:void(Tawk_API.toggle())" tooltip="Chat trực tuyến" class="mbwph-contact-icon mbwph-tooltip-right mbwph-tawkto"></a>';
				}
				if(!empty($fb_page_link)){            
					$html .='<a href="'.$fb_page_link.'" tooltip="Fanpage" class="mbwph-contact-icon mbwph-tooltip-right mbwph-facebook" target="_blank"></a>';
				}
				if(!empty($fb_appID && $fb_pageID)){
					$html .='<a href="/" tooltip="Messenger" class="mbwph-contact-icon mbwph-tooltip-right mbwph-message mbwph-messenger"></a>';
				}
				if(!empty($zalo_phone)){
					$html .='<a href="https://zalo.me/'.$zalo_phone.'" tooltip="Zalo: '.$zalo_phone.'" class="mbwph-contact-icon mbwph-tooltip-right mbwph-zalo" target="_blank"></a>';
				}
				if(!empty($btn_message)){
					$html .='<div class="mbwph-inner-text mbwph-inner-text-right mbwph-inner-text-low" value=""><span class="mbwph-close-inner-text"></span>
								'.$btn_message.'
							</div>';
				}
				$html .='
					<div class="mbwph-inner-mark" style="background: '.$btn_color.';"></div>
						<a href="javascript:void(0);" class="mbwph-contact-icon mbwph-btn" style="background: '.$btn_color.';">
							<i class="mbwph-inner-mark-border" style="border: 1px solid '.$btn_color.';"></i>
							<div class="mbwph-sm-icon">
								<div class="mbwph-sm-icon-item mbwph-fade-icon"><i class="dashicons dashicons-testimonial" style="font-size: 30px;"></i></div>
								<div class="mbwph-sm-icon-item mbwph-fade-icon"><i class="dashicons dashicons-phone" style="font-size: 30px;"></i></div>
								<div class="mbwph-sm-icon-item mbwph-fade-icon"><i class="dashicons dashicons-email" style="font-size: 30px;"></i></div>
							</div>
						</a>';
				$html .='</div>';
			}
			echo $html;
		}

		function remove_default_comment($open, $post_id){
			$post = get_post( $post_id );		
			if($post->post_type=='post'){
				return false;
			}
			return $open;
		}
		function hook_facebook_comment_scripts(){
			$fb_appID = $this->socialOptions["fb-app-id"];		
			$html = '
				<div id="fb-root"></div>
				<script>(function(d, s, id) {					
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.12&appId='. $fb_appID. '&autoLogAppEvents=1";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, "script", "facebook-jssdk"));</script>';
			echo $html;
		}
		function show_facebook_comment( $content ) {    
			if( is_single() && !is_page() && ! empty( $GLOBALS['post'] ) ){
				if ( $GLOBALS['post']->ID == get_the_ID() ) {
					
					$content .= '<hr/><div class="fb-comments" xid="'. $GLOBALS['post']->ID .'" data-width="100%" data-numposts="10"></div>';
				}
			}
			return $content;
		}
		function hook_facebook_messenger_scripts(){		
			$html = '
				 <div class="mbwph-fb-chat mbwph-fbc-right"><div id="fb-root"></div></div>
				  <script>
					window.fbAsyncInit = function() {
					  FB.init({
						xfbml            : true,
						version          : "v5.0"
					  });
					};
					(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js";
					fjs.parentNode.insertBefore(js, fjs);
				  }(document, "script", "facebook-jssdk"));</script>';
			echo $html;
		}
		function hook_messenger_button(){
			$fb_pageID = $this->socialOptions["fb-page-id"];
			$theme_color = $this->socialOptions["theme-color"];
			//$greeting = $this->socialOptions["greeting-message"];
			if(!empty($this->socialOptions["greeting-message"])){
				$greeting = $this->socialOptions["greeting-message"];
			} else {
				$greeting = 'Xin chào ! Chúng tôi có thể giúp gì cho bạn.';				
			}			
			$html = '	<div class="fb-customerchat"
						  attribution="setup_tool"
						  page_id="'.$fb_pageID.'"
						  theme_color="'.$theme_color.'"
						  logged_in_greeting="'.$greeting.'"
						  logged_out_greeting="'.$greeting.'">
						</div>';			
			echo $html;
		}
		function hook_tawkto_button(){
			$tawkto_id = $this->socialOptions["tawkto-id"];
			//<!--Start of Tawk.to Script-->
			$html =	'<script type="text/javascript">
				var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
				(function(){
				var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
				s1.async=true;
				s1.src="https://embed.tawk.to/'. $tawkto_id .'/default";
				s1.charset="UTF-8";
				s1.setAttribute("crossorigin","*");
				s0.parentNode.insertBefore(s1,s0);
				})();
				</script>';
			//<!--End of Tawk.to Script-->						
			echo $html;
		}
	}
}