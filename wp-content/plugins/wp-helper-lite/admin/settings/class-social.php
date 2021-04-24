<?php

/**
 * Controls settings of plugin
 *
 * @package    WP_HELPER
 * @subpackage WP_HELPER/admin/settings
 */
class WP_HELPER_Social extends WP_HELPER_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $WP_HELPER    The ID of this plugin.
	 */
	private $WP_HELPER;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $WP_HELPER       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $WP_HELPER ) {
		$this->id    = 'social';
		$this->label = __( 'Mạng xã hội', 'mbwph' );
		$this->WP_HELPER = $WP_HELPER;		
	}

	/**
	 * Creates our settings sections with fields etc. 
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function mbwph_settings_social_init() {		
		$this->social_post_init();		
	}

	/**
	 * Creates post settings sections with fields etc. 
	 *
	 * @since    1.1.0
	 * @access   public
	 */
	public function social_post_init() {
		
		// register_setting( $option_group, $option_name, $settings_sanitize_callback );
		register_setting(
			$this->WP_HELPER . '_social_options_group',
			$this->WP_HELPER . '_social_options',
			array( $this, 'mbwph_settings_sanitize' )
		);		
		// add_settings_section( $id, $title, $callback, $menu_slug );
		add_settings_section(
			$this->WP_HELPER . '-social-options', // section			
			apply_filters( $this->WP_HELPER . '-social-section-title', __( '', 'mbwph' ) ),
			array( $this, 'print_social_section' ),
			$this->WP_HELPER . '_social_tab'
		);
		add_settings_section(
			$this->WP_HELPER . '-social-contact-options', // section			
			apply_filters( $this->WP_HELPER . '-social-section-title', __( '', 'mbwph' ) ),
			array( $this, 'print_contact_section' ),
			$this->WP_HELPER . '_social_tab'
		);
		add_settings_section(
			$this->WP_HELPER . '-messenger-options', // section
			apply_filters( $this->WP_HELPER . '-messenger-section-title', __( '', $this->WP_HELPER ) ),
			array( $this, 'print_messenger_section' ),
			$this->WP_HELPER . '_social_tab'
		);
		add_settings_section(
			$this->WP_HELPER . '-comment-options', // section
			apply_filters( $this->WP_HELPER . '-comment-section-title', __( '', $this->WP_HELPER ) ),
			array( $this, 'print_comment_section' ),
			$this->WP_HELPER . '_social_tab'
		);	
		
		// add_settings_field( $id, $title, $callback, $menu_slug, $section, $args );
		add_settings_field(
			'enable-fbmessenger',
			apply_filters( $this->WP_HELPER . '-enable-fbmessenger-label', __( 'Kích hoạt', 'mbwph' ) ),
			array( $this, 'mbwph_chk_enable_fbmessenger_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-social-options' // section to add to
		);
		
		//Contact setting
		add_settings_field(
			'btn-color',
			apply_filters( $this->WP_HELPER . '-btn-color-label', __( 'Màu nút liên hệ', 'mbwph' ) ),
			array( $this, 'mbwph_btn_color_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-social-contact-options' // section to add to
		);
		add_settings_field(
			'btn-message',
			apply_filters( $this->WP_HELPER . '-btn-message-label', __( 'Lời chào', 'mbwph' ) ),
			array( $this, 'mbwph_txt_btn_message_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-social-contact-options' // section to add to
		);
		add_settings_field(
			'zalo-phone',
			apply_filters( $this->WP_HELPER . '-zalo-phone-label', __( 'Zalo Chat', 'mbwph' ) ),
			array( $this, 'mbwph_txt_zalo_phone_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-social-contact-options' // section to add to
		);	
		add_settings_field(
			'tawkto-id',
			apply_filters( $this->WP_HELPER . '-tawkto-id-label', __( 'Tawk.to ID', 'mbwph' ) ),
			array( $this, 'mbwph_txt_tawkto_id_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-social-contact-options' // section to add to
		);	
		add_settings_field(
			'phone-number',
			apply_filters( $this->WP_HELPER . '-phone-number-label', __( 'Số điện thoại', 'mbwph' ) ),
			array( $this, 'mbwph_txt_phone_number_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-social-contact-options' // section to add to
		);	
		add_settings_field(
			'mail-to',
			apply_filters( $this->WP_HELPER . '-mail-to-label', __( 'Email', 'mbwph' ) ),
			array( $this, 'mbwph_txt_mail_to_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-social-contact-options' // section to add to
		);
		// Messenger Setting
		add_settings_field(
			'greeting-message',
			apply_filters( $this->WP_HELPER . '-greeting-message-label', __( 'Lời chào Messenger', 'mbwph' ) ),
			array( $this, 'mbwph_txt_greeting_message_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-messenger-options' // section to add to
		);
		add_settings_field(
			'theme-color',
			apply_filters( $this->WP_HELPER . '-theme-color-label', __( 'Màu nút Messenger', 'mbwph' ) ),
			array( $this, 'mbwph_btn_theme_color_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-messenger-options' // section to add to
		);		
		add_settings_field(
			'fb-app-id',
			apply_filters( $this->WP_HELPER . '-fb-app-id-label', __( 'Facebook App ID', 'mbwph' ) ),
			array( $this, 'mbwph_txt_fb_app_id_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-messenger-options' // section to add to
		);
		add_settings_field(
			'fb-page-id',
			apply_filters( $this->WP_HELPER . '-fb-page-id-label', __( 'Facebook Page ID', 'mbwph' ) ),
			array( $this, 'mbwph_txt_fb_page_id_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-messenger-options' // section to add to
		);	
		add_settings_field(
			'fb-page-link',
			apply_filters( $this->WP_HELPER . '-fb-page-link-label', __( 'Fanpage', 'mbwph' ) ),
			array( $this, 'mbwph_txt_fb_page_link_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-messenger-options' // section to add to
		);	
		
		// add_settings_field( $id, $title, $callback, $menu_slug, $section, $args );
		add_settings_field(
			'enable-fbcomment',
			apply_filters( $this->WP_HELPER . '-enable-fbcomment-label', __( 'Kích hoạt', 'mbwph' ) ),
			array( $this, 'mbwph_chk_enable_fbcomment_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-comment-options' // section to add to
		);
	}
	
	/**
	 * Creates a settings section
	 *
	 * @since 		1.0.0
	 * @param 		array 		$params 		Array of parameters for the section
	 * @return 		mixed 						The settings section
	 */
	public function print_social_section( $params ) {
		_e( '<h3>MẠNG XÃ HỘI</h3>','mbwph');
		_e( '<span class="description">Cài đặt các nút Gọi ngay, Facebook, Zalo, Tawkto...</span>','mbwph');
	} // display_options_section()
	public function print_contact_section( $params ) {
		_e( '<h4>Liên hệ</h4>','mbwph');
	} // display_options_section()
	public function print_messenger_section( $params ) {
		_e( '<h4>Facebook Messenger</h4>','mbwph');
	}
	public function print_comment_section( $params ) {
		_e( '<h4>Bình luận Facebook</h4>','mbwph');
	}
	/**
	 * Enable/Disable Checkbox Field
	 *
	 * @since 		1.0.0
	 * @return 		mixed 			The settings field
	 */
	public function mbwph_chk_enable_fbmessenger_field() {

		$options 	= get_option( $this->WP_HELPER . '_social_options' );
		$option 	= 0;

		if ( ! empty( $options['enable-fbmessenger'] ) ) {
			$option = $options['enable-fbmessenger'];
		}	
		?>
		<div class="pretty p-switch p-fill">
			<input type="checkbox" name="<?php echo $this->WP_HELPER; ?>_social_options[enable-fbmessenger]" value="1" <?php checked( $option, 1 , true ); ?> />
			<div class="state p-success">
				<label></label>
			</div>			
		</div>
		<span class="description" ><?php _e('Bật để kích hoạt các tiện ích bên dưới.', 'mbwph'); ?></span>		
<?php
	} // mbwph_chk_enable_fbmessenger_field()
	public function mbwph_btn_color_field() {
		$options 	= get_option( $this->WP_HELPER . '_social_options' );				
		if ( isset( $options['btn-color'] ) ) {
			$btn_color = esc_attr($options['btn-color']);
		}
		else
		{
			$btn_color = "#17568c";
		}
		?>
		<div class="placeholder">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_social_options[btn-color]" name="<?php echo $this->WP_HELPER; ?>_social_options[btn-color]" value="<?php echo( $btn_color); ?>" data-default-color="#17568c" class="color-field"></input>
			<span class="description"><?php _e('Tùy chỉnh màu nút liên hệ.', 'mbwph'); ?></span>			
		</div>		
<?php	} // mb_wp_manage_options_field()
	public function mbwph_txt_btn_message_field() {

		$options 	= get_option( $this->WP_HELPER . '_social_options' );		
		$btn_message = 'Xin chào ! Chung tôi có thể giúp gì cho bạn ?';
		if ( ! empty( $options['btn-message'] ) ) {
			$btn_message = $options['btn-message'];
		}
		else {$btn_message = "";}
		?>
		<div class="form-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_social_options[btn-message]" name="<?php echo $this->WP_HELPER; ?>_social_options[btn-message]" value="<?php echo($btn_message); ?>" class="form-control" placeholder="Xin chào ! Chúng tôi có thể giúp gì cho bạn ?"/>
			<span class="description">Xóa nội dung trên để tắt lời chào.</span>
		</div>
<?php	}
	public function mbwph_btn_theme_color_field() {
		$options 	= get_option( $this->WP_HELPER . '_social_options' );				
		if ( isset( $options['theme-color'] ) ) {
			$theme_color = esc_attr($options['theme-color']);
		}
		else
		{
			$theme_color = "#17568c";
		}
		?>
		<div class="placeholder">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_social_options[theme-color]" name="<?php echo $this->WP_HELPER; ?>_social_options[theme-color]" value="<?php echo( $theme_color); ?>" data-default-color="#17568c" class="color-field"></input>
		</div>
<?php	} // mb_wp_manage_options_field()
	public function mbwph_txt_greeting_message_field() {

		$options 	= get_option( $this->WP_HELPER . '_social_options' );
		$greeting 	= '';

		if ( ! empty( $options['greeting-message'] ) ) {
			$greeting = $options['greeting-message'];
		}		
		?>
		<div class="form-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_social_options[greeting-message]" name="<?php echo $this->WP_HELPER; ?>_social_options[greeting-message]" value="<?php echo($greeting); ?>" class="form-control" placeholder="Lời chào"/>			
		</div>
<?php
	}
	public function mbwph_chk_enable_fbcomment_field() {
		$options 	= get_option( $this->WP_HELPER . '_social_options' );
		$enable_comment 	= 0;
		
		if ( ! empty( $options['enable-fbcomment'] ) ) {
			$enable_comment = $options['enable-fbcomment'];
		}
	?>
		<div class="pretty p-switch p-fill">
			<input type="checkbox" id="<?php echo $this->WP_HELPER; ?>_social_options[enable-fbcomment]" name="<?php echo $this->WP_HELPER; ?>_social_options[enable-fbcomment]" value="1" <?php checked( $enable_comment, 1 , true ); ?> />
			<div class="state p-success">
				<label></label>
			</div>			
		</div>		
		<span class="description">Bật để kích hoạt tính năng bình luận facebook vào bài viết và trang.</span>		
<?php
	} // mbwph_chk_enable_fbcomment_field()
	public function mbwph_txt_fb_app_id_field() {

		$options 	= get_option( $this->WP_HELPER . '_social_options' );
		$app_id 	= '';

		if ( ! empty( $options['fb-app-id'] ) ) {
			$app_id = $options['fb-app-id'];
		}		
		?>
		<div class="form-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_social_options[fb-app-id]" name="<?php echo $this->WP_HELPER; ?>_social_options[fb-app-id]" value="<?php echo($app_id); ?>" class="form-control" placeholder="ID ứng dụng"/>
			<span class="description">Làm theo <a href="https://wordpress.matbao.support/huong-dan/huong-dan-tao-app-id-facebook.html" target="_blank">hướng dẫn</a> để lấy App ID.</span>
		</div>		
<?php
	}
	public function mbwph_txt_fb_page_id_field() {

		$options 	= get_option( $this->WP_HELPER . '_social_options' );
		$page_id 	= '';

		if ( ! empty( $options['fb-page-id'] ) ) {
			$page_id = $options['fb-page-id'];
		}		
		?>
		<div class="form-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_social_options[fb-page-id]" name="<?php echo $this->WP_HELPER; ?>_social_options[fb-page-id]" value="<?php echo($page_id); ?>" class="form-control" placeholder="Page ID ứng dụng"/>
			<span class="description">Làm theo <a href="https://wordpress.matbao.support/huong-dan/huong-dan-lay-id-fanpage-facebook.html" target="_blank">hướng dẫn</a> để lấy Page ID.</span>
		</div>		
<?php
	} // mbwph_txt_app_id_field()
	public function mbwph_txt_fb_page_link_field() {

		$options 	= get_option( $this->WP_HELPER . '_social_options' );
		$page_id 	= '';

		if ( ! empty( $options['fb-page-link'] ) ) {
			$page_id = $options['fb-page-link'];
		}		
		?>
		<div class="form-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_social_options[fb-page-link]" name="<?php echo $this->WP_HELPER; ?>_social_options[fb-page-link]" value="<?php echo($page_id); ?>" class="form-control" placeholder="Đường dẫn Fanpage. VD: https://www.facebook.com/your-page"/>
			<span class="description"></span>
		</div>		
<?php
	} // mbwph_txt_app_id_field()
	public function mbwph_op_fb_comment_on_field() {

		$options 	= get_option( $this->WP_HELPER . '_social_options' );
		$option	= "";

		if ( ! empty( $options['fb-comment-on'] ) ) {
			$option = $options['fb-comment-on'];
		}
		?>
		<div class="form-group">
			<label class="mbwph_option">
				<input name="<?php echo $this->WP_HELPER; ?>_social_options[fb-comment-on]" type="radio"
                               value="post"<?php if ($option == 'post') { ?> checked="checked"<?php } ?> />
                        Bài viết
			</label>
			<label class="mbwph_option">
				<input name="<?php echo $this->WP_HELPER; ?>_social_options[fb-comment-on]" type="radio"
                               value="product"<?php if ($option == 'product') { ?> checked="checked"<?php } ?> />
                        Sản phẩm
			</label>
			<label class="mbwph_option">
				<input name="<?php echo $this->WP_HELPER; ?>_social_options[fb-comment-on]" type="radio"
                               value="both"<?php if ($option == 'both') { ?> checked="checked"<?php } ?> />
                        Bài viết & Sản phẩm
			</label>
		</div>
<?php
	} // mbwph_op_fb_comment_on_field()
	public function mbwph_txt_zalo_phone_field() {

		$options 	= get_option( $this->WP_HELPER . '_social_options' );
		$zalo_phone	= '';

		if ( ! empty( $options['zalo-phone'] ) ) {
			$zalo_phone = $options['zalo-phone'];
		}		
		?>
		<div class="form-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_social_options[zalo-phone]" name="<?php echo $this->WP_HELPER; ?>_social_options[zalo-phone]" value="<?php echo($zalo_phone); ?>" class="form-control" placeholder="Số điện thoại sử dụng Zalo"/>			
		</div>		
<?php
	} // mbwph_txt_zalo_phone_field()
	
	public function mbwph_txt_tawkto_id_field() {

		$options 	= get_option( $this->WP_HELPER . '_social_options' );
		$tawkto_id	= '';

		if ( ! empty( $options['tawkto-id'] ) ) {
			$tawkto_id = $options['tawkto-id'];
		}		
		?>
		<div class="form-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_social_options[tawkto-id]" name="<?php echo $this->WP_HELPER; ?>_social_options[tawkto-id]" value="<?php echo($tawkto_id); ?>" class="form-control" placeholder="Mã ID Tawk.to"/>
			<span class="description">Làm theo <a href="https://wordpress.matbao.support/huong-dan/wp-helper-huong-dan-dang-ky-tai-khoan-tawk-to-va-lay-tawk-to-id.html" target="_blank">hướng dẫn</a> để lấy Tawk.To ID.</span>
		</div>		
<?php
	} // mbwph_txt_tawkto_id_field()	
	
	public function mbwph_txt_phone_number_field() {

		$options 	= get_option( $this->WP_HELPER . '_social_options' );
		$phone_number	= '';

		if ( ! empty( $options['phone-number'] ) ) {
			$phone_number = $options['phone-number'];
		}		
		?>
		<div class="form-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_social_options[phone-number]" name="<?php echo $this->WP_HELPER; ?>_social_options[phone-number]" value="<?php echo($phone_number); ?>" class="form-control" placeholder="Số điện thoại"/>			
		</div>		
<?php
	} // mbwph_txt_phone_number_field()
	public function mbwph_txt_mail_to_field() {

		$options 	= get_option( $this->WP_HELPER . '_social_options' );
		$email	= '';

		if ( ! empty( $options['mail-to'] ) ) {
			$email = $options['mail-to'];
		}		
		?>
		<div class="form-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_social_options[mail-to]" name="<?php echo $this->WP_HELPER; ?>_social_options[mail-to]" value="<?php echo($email); ?>" class="form-control" placeholder="Nhập địa chỉ email"/>			
		</div>		
<?php
	} // mbwph_txt_phone_number_field()
}