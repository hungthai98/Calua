<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WP_HELPER
 * @subpackage WP_HELPER/admin/partials
 */
?>
<?php
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );	
	//flush rewrite rules when we load this page!
	flush_rewrite_rules();
	$plugin = 'wp-helper-premium/wp-helper-premium.php';
	$option = get_option('hide_sidebar');
	global $hide_sidebar;
	if(!empty($option) == 1){
		$hide_sidebar = $option;
		$col = 'col-md-9';
	} else { $col = 'col-md-9'; }
?>
<div class="mbwph-wrap wrap">
	<form id="frm_mbwphOptions" method="post" action="options.php">
	<div id="mbwphLoader" class="modal"></div>
	<div id="mbwphResult"></div>	
	<?php if( isset($_GET['settings-updated']) ) { ?>
		<div id="message" class="updated settings-error notice is-dismissible alert alert-success">
			<p>
				<strong><?php _e('Settings saved.') ?></strong>
			</p>
		</div>
	<?php } ?>	
	<div class="row">		
		<!--Main Content-->
		<div class="<?php echo $col; ?> mbwph-content">
			<div class="row">
				<div class="col-3 mbwphTabs">					
					<div class="mbwph-Header-logo">
						<img src="<?php echo WP_HELPER_ADMIN_ASSETS_IMG_URL; ?>mbwph-logo-text.svg" alt="Logo WP Helper" class="mbwph-Header-logo-desktop" height="40px">
						<img src="<?php echo WP_HELPER_ADMIN_ASSETS_IMG_URL; ?>mbwph-logo-icon.svg" alt="Logo WP Helper" class="mbwph-Header-logo-mobile" height="50px">
					</div>					
					<?php
						$tab = sanitize_text_field( isset($_GET['tab']) ) ? sanitize_text_field( $_GET['tab'] ) : 'general';
						$this->mbwph_utilities_render_tabs(); 
					?>
					<div class="mbwph-Header-footer">
						<?php echo ' <span class="badge badge-secondary">v'.WP_HELPER_VERSION .'</span>'; ?>
					</div>
				</div>
				<div class="col-9 mwpTabContent">
					<div class="tab-content">
						<div class="tab-pane active"  role="tabpanel">
							<?php 
							switch ($tab) {					
								case 'social': ?>
									<div class="modal-body">
										<?php
											settings_fields( $this->get_plugin().'_social_options_group' );
											do_settings_sections( $this->get_plugin() . '_social_tab');
											//submit_button();
										?>
									</div>
								<?php
									break;
								case 'login': ?>
									<div class="modal-body">
										<?php
											settings_fields( $this->get_plugin().'_mbwph_login_tab' );
											do_settings_sections( $this->get_plugin() . '_mbwph_login_tab');
											//submit_button();
										?>
									</div>
								<?php
									break;					
								case 'smtp':?>
									<div class="modal-body">
										<?php
											settings_fields( $this->get_plugin().'_smtp_options_group' );
											do_settings_sections( $this->get_plugin() . '_smtp_tab');
										?>
										<p class="submit">
											<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save'); ?>">
										<!-- Button trigger modal -->
											<button type="button" class="button secondary" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#testSMTP">
												Kiểm tra SMTP
											</button>
										</p>
									</div>
								<?php
									break;
								case 'security':?>
									<div class="modal-body">
										<?php
											settings_fields( $this->get_plugin().'_security_options_group' );
											do_settings_sections( $this->get_plugin() . '_security_tab');
											//submit_button();
										?>
									</div>				
								<?php
									break;
								case 'insert-header-footer':?>
									<div class="modal-body">
										<?php
											settings_fields( $this->get_plugin().'_header_footer_tab' );
											do_settings_sections( $this->get_plugin() . '_header_footer_tab');
											//submit_button();
										?>
									</div>
								<?php
									break;
								// If no tab or general						
								case 'tutorial': ?>
									<div class="modal-body">
										<h4><?php _e('Hướng dẫn sử dụng', 'mbwph'); ?></h4>
										<ul class="guid-line">
										<?php									
											// Get the JSON									
											// Enter the name of your blog here followed by /wp-json/wp/v2/posts and add filters like this one that limits the result to 2 posts.
											$response = wp_remote_get( 'https://wordpress.matbao.support/wp-json/wp/v2/posts?categories=31' );
											$allposts = '';
											//var_dump($response);
											// Exit if error.
											if ( is_wp_error( $response ) ) {
												return;
											}
											// Get the body.
											$posts = json_decode( wp_remote_retrieve_body( $response ) );
											// Exit if nothing is returned.
											if ( empty( $posts ) ) {
												//return;
												echo 'Không có bài viết.';
											}
											// If there are posts.
											if ( ! empty( $posts ) ) {
												// For each post.
												foreach ( $posts as $post ) {
													// Use print_r($post); to get the details of the post and all available fields											
													// Show a linked title and post date.
													$allposts .= '<li><span class="dashicons dashicons-yes"></span> <a href="' . esc_url( $post->link ) . '" target=\"_blank\">' . esc_html( $post->title->rendered ) . '</a></li>';
												}
												echo $allposts;
											}
										?> 
										</ul>
									</div>
								<?php
									break;
								case 'premium-license': ?>
									<div class="modal-body">
										<ul class="guid-line">
										<?php
											settings_fields( $this->get_plugin().'_premium_options_group' );
											do_settings_sections( $this->get_plugin() . '_premium_tab');
											//submit_button();										
										?>
										</ul>									
									</div>
								<?php
									break;
								default: ?>
									<div class="modal-body">
										<?php												
											settings_fields( $this->get_plugin() . '_general_tab' );
											do_settings_sections( $this->get_plugin() . '_general_tab');
											//submit_button();										
										?>
									</div>								
								<?php	
									break; 
							} ?>
						</div>
					</div>
				</div>
			</div>			
		</div> 
		<!-- Sidebar -->		
		<div class="col-md-3 mbwph-sidebar">
			<?php if($tab != 'tutorial'){ ?>
				<div class="savebutton"><?php submit_button(__('Save'), 'btn btn-rounded');?></div>
			<?php } ?>
			<?php if(!$hide_sidebar || !is_plugin_active($plugin)) {
				require_once( dirname(__FILE__) . '/sidebar.php' );
			} ?>
		</div>		
	</div>
	</form>
</div><!--end wrap-->
<!-- Test SMTP Modal -->
		<div class="modal fade" id="testSMTP" tabindex="-1" role="dialog" aria-labelledby="smtpLabel" aria-hidden="false">
		  <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="smtpLabel">Kiểm tra SMTP</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<form action="" method="post" enctype="multipart/form-data" name="wp_smtp_testform">
					<div class="form-group">
						<label for="mail-addr">Địa chỉ email</label>
						<input type="email" class="form-control" id="mail-addr" placeholder="Nhập email">
					</div>
					<p class="submit">
						<input type="hidden" id="ajax_url" value="<?php echo admin_url('admin-ajax.php'); ?>"/>
						<input id="sendMail" type="button" class="button-primary" value="<?php _e('Gửi / Send', 'mbwph'); ?>"/>						
						<div id="result"></div>
						<div id="loader"></div>
					</p>
				</form>
				<script>				
				(function( $ ) {
					$("#sendMail").on('click', function(event) {
						var loader = document.getElementById('loader');
						var result = document.getElementById('result');
						var email =  jQuery('#mail-addr').val();
						if(verfiyFields()) {							
							var data = {
								'action': 'mbwph_send_mail',								
								'email': email,								
							};						   
							var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
							result.innerHTML = '';
							loader.innerHTML = '<div class="d-flex align-items-center"><strong>Đang xử lý...</strong><div class="spinner-border ml-auto" role="status" aria-hidden="true"></div></div>';
							jQuery.post(ajaxurl, data, function(response) {								
								if(response === 'success'){
									loader.innerHTML = '';
									result.innerHTML = '<div id="smtp-success" class="alert alert-success" role="alert">Chúc mừng! Đã gửi mail thành công</div>';
									jQuery('#mail-addr').val(''); 
								}else{
									loader.innerHTML = '';
									result.innerHTML = '<div id="smtp-fail" class="alert alert-danger" role="alert">Lỗi: Kiểm tra lại cấu hình mail</div>';
								}						
							});							
						}
					});
					 //Verfiy 
					function verfiyFields() {
						
						var flag = true;
						
						var email =  jQuery('#mail-addr');						
						if(isEmail(email.val())==''){							
							document.getElementById('result').innerHTML ='<div class="alert alert-danger">Vui lòng nhập địa chỉ email</div>';
							flag = false;
						}
						return flag;
					}
					function isEmail(email) {
					  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
					  return re.test(email);
					}
				})( jQuery );
				</script>
			  </div>		  
			</div>
			</div>
		</div><!-- // Test SMTP Modal -->