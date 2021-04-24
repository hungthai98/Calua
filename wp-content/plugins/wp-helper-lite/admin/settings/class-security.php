<?php
/**
 * Controls settings of plugin
 *
 * @package    WP_HELPER
 * @subpackage WP_HELPER/admin/settings
 */
class WP_HELPER_Security extends WP_HELPER_Admin {

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
		$this->id    = 'security';
		$this->label = __( 'Bảo mật', 'mbwph' );
		$this->WP_HELPER = $WP_HELPER;
	}

	/**
	 * Creates our settings sections with fields etc. 
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function mbwph_settings_security_init() {
		$this->security_post_init();		
	}

	/**
	 * Creates post settings sections with fields etc. 
	 *
	 * @since    1.1.0
	 * @access   public
	 */
	public function security_post_init() {
		
		// register_setting( $option_group, $option_name, $settings_sanitize_callback );
		register_setting(
			$this->WP_HELPER . '_security_options_group',
			$this->WP_HELPER . '_security_options', //Options containt value field
			array( $this, 'mbwph_settings_sanitize' )
		);
		// Section Captcha
		add_settings_section(
			$this->WP_HELPER . '-captcha-options', // section
			apply_filters( $this->WP_HELPER . '-display-section-title', __( '', $this->WP_HELPER ) ),
			array( $this, 'print_captcha_section' ),
			$this->WP_HELPER . '_security_tab'
		);
		add_settings_field(
			'enable-captcha',
			apply_filters( $this->WP_HELPER . '-enable-captcha-label', __( 'Kích hoạt', 'mbwph' ) ),
			array( $this, 'mbwph_chk_enable_captcha_field' ),
			$this->WP_HELPER . '_security_tab',		// Page
			$this->WP_HELPER . '-captcha-options' 	// section to add to
		);
		/*add_settings_field(
			'captcha-version',
			apply_filters( $this->WP_HELPER . '-captcha-version-label', __( 'Version', 'mbwph' ) ),
			array( $this, 'mbwph_op_captcha_version_field' ),
			$this->WP_HELPER . '_security_tab',		// Page
			$this->WP_HELPER . '-captcha-options' 	// section to add to
		);*/
		add_settings_field(
			'site-key',
			apply_filters( $this->WP_HELPER . '-site-key-label', __( 'Site key', 'mbwph' ) ),
			array( $this, 'mbwph_txtsite_key_field' ),
			$this->WP_HELPER . '_security_tab',		// Page
			$this->WP_HELPER . '-captcha-options' 	// section to add to
		);
		add_settings_field(
			'secret-key',
			apply_filters( $this->WP_HELPER . '-secret-key-label', __( 'Secret Key', 'mbwph' ) ),
			array( $this, 'mbwph_txtsecret_key_field' ),
			$this->WP_HELPER . '_security_tab',		// Page
			$this->WP_HELPER . '-captcha-options' 	// section to add to
		);
		/*add_settings_field(
			'recaptcha-for',
			apply_filters( $this->WP_HELPER . '-recaptcha-for-label', __( 'reCAPTCHA for', 'mbwph' ) ),
			array( $this, 'mbwph_chk_recaptcha_for_field' ),
			$this->WP_HELPER . '_security_tab',		// Page
			$this->WP_HELPER . '-captcha-options', 	// section to add to			
		);
		add_settings_field(
			'mbwph-login-form',
			apply_filters( $this->WP_HELPER . '-mbwph-login-form-label', __( '', 'mbwph' ) ),
			array( $this, '' ),
			$this->WP_HELPER . '_security_tab',		// Page
			$this->WP_HELPER . '-captcha-options', 	// section to add to			
		);*/
		// Section SSL
		/*add_settings_section(
			$this->WP_HELPER . '-ssl-options', // section
			apply_filters( $this->WP_HELPER . '-ssl-section-title', __( 'Chuyển hướng HTTP sang HTTPS', $this->WP_HELPER ) ),
			array( $this, 'print_ssl_section' ),
			$this->WP_HELPER . '_security_tab'
		);
		add_settings_field(
			'enable-ssl',
			apply_filters( $this->WP_HELPER . '-enable-captcha-label', __( 'Kích hoạt', 'mbwph' ) ),
			array( $this, 'mbwph_chk_enable_ssl_field' ),
			$this->WP_HELPER . '_security_tab',		// Page
			$this->WP_HELPER . '-ssl-options' 	// section to add to
		);*/
		// Section Hide backend
		add_settings_section(
			$this->WP_HELPER . '-hide-login-options', // section
			apply_filters( $this->WP_HELPER . '-hide-login-section-title', __( '', $this->WP_HELPER ) ),
			array( $this, 'print_hide_login_section' ),
			$this->WP_HELPER . '_security_tab'
		);
		add_settings_field(
			'enable-hide-login',
			apply_filters( $this->WP_HELPER . '-enable-hide-login-label', __( 'Kích hoạt', 'mbwph' ) ),
			array( $this, 'mbwph_chk_enable_hide_login_field' ),
			$this->WP_HELPER . '_security_tab',		// Page
			$this->WP_HELPER . '-hide-login-options' 	// section to add to
		);
		add_settings_field(
			'backend-name',
			apply_filters( $this->WP_HELPER . '-backend-name-label', __( 'Tên đường dẫn', 'mbwph' ) ),
			array( $this, 'mbwph_txt_login_name_field' ),
			$this->WP_HELPER . '_security_tab',		// Page
			$this->WP_HELPER . '-hide-login-options' 	// section to add to
		);
	}
	
	/**
	 * Creates a settings section
	 *
	 * @since 		1.0.0
	 * @param 		array 		$params 		Array of parameters for the section
	 * @return 		mixed 						The settings section
	 */
	public function print_captcha_section( $params ) {
		_e('<h4>Cấu hình reCAPTCHA</h4>','mbwph');		
		_e('<span class="description">Nhận khóa <a href="https://www.google.com/recaptcha" target="_blank">reCaptcha</a> từ Google. Làm theo các bước hướng dẫn <a href="https://wordpress.matbao.support/huong-dan/wp-helper-tao-khoa-recaptcha-tu-google.html" target="_blank">tại đây</a>.</span>','mbwph');
	}
	public function print_ssl_section( $params ) {						
		//echo '<div class="alert alert-warning">Chuyển đổi các link từ http -> https.</div>';
	}
	public function print_hide_login_section( $params ) {		
		_e('<h4>Ẩn trang đăng nhập</h4>','mbwph');
	}
	/**
	 * Enable/Disable Checkbox Field
	 *
	 * @since 		1.0.0
	 * @return 		mixed 			The settings field
	 */	
	/*===========Captcha Settings=============*/
	public function mbwph_chk_enable_captcha_field() {

		$options 	= get_option( $this->WP_HELPER . '_security_options' );
		$option 	= 0;

		if ( ! empty( $options['enable-captcha'] ) ) {
			$option = $options['enable-captcha'];
		}		
		?>		
		<div class="pretty p-switch p-fill">
			<input type="checkbox" id="<?php echo $this->WP_HELPER; ?>_security_options[enable-captcha]" name="<?php echo $this->WP_HELPER; ?>_security_options[enable-captcha]" value="1" <?php checked( $option, 1 , true ); ?> />
			<div class="state p-success">
				<label></label>
			</div>			
		</div>
<?php
	}
	public function mbwph_op_captcha_version_field() {

		$options 	= get_option( $this->WP_HELPER . '_security_options' );
		$captcha_version 	= "";

		if ( ! empty( $options['captcha-version'] ) ) {
			$captcha_version = $options['captcha-version'];
		}		
		?>
		<div class="form-group">
			<label class="mbwph_option">
				<input name="<?php echo $this->WP_HELPER; ?>_security_options[captcha-version]" type="radio"
                               value="v2"<?php if ($captcha_version == 'v2') { ?> checked="checked"<?php } ?> />
                        reCAPTCHA v2
			</label>
			<label class="mbwph_option">
				<input name="<?php echo $this->WP_HELPER; ?>_security_options[captcha-version]" type="radio"
                               value="v3"<?php if ($captcha_version == 'v3') { ?> checked="checked"<?php } ?> />
                        reCAPTCHA v3
			</label> 
		</div>
<?php
	}
	public function mbwph_txtsite_key_field() {

		$options 	= get_option( $this->WP_HELPER . '_security_options' );
		$site_key 	= "";

		if ( ! empty( $options['site-key'] ) ) {
			$site_key = $options['site-key'];
		}		
		?>
		<div class="form-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_security_options[site-key]" name="<?php echo $this->WP_HELPER; ?>_security_options[site-key]" value="<?php echo( $site_key); ?>" class="form-control" placeholder="Site key"/> 
		</div>
<?php
	}
	public function mbwph_txtsecret_key_field() {
		
		$options 	= get_option( $this->WP_HELPER . '_security_options');
		$secret_key 	= "";

		if ( ! empty( $options['secret-key'] ) ) {
			$secret_key = $options['secret-key'];
		}		
		?>
		<div class="form-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_security_options[secret-key]" name="<?php echo $this->WP_HELPER; ?>_security_options[secret-key]" value="<?php echo( $secret_key); ?>" class="form-control" placeholder="Secret key"/> 
		</div>
<?php
	}
	public function mbwph_chk_recaptcha_for_field() {		
		$options 	= get_option( $this->WP_HELPER . '_security_options' );				
		$recaptcha_for 	= "";
		//var_dump($options);
		if ( ! empty( $options['mbwph-login-form'] ) ) {
			$option = $options['mbwph-login-form'];
		}		
		?>
		<div class="form-group">		  
			<button class="mbwph-accordion"><?php _e('WordPress Forms', 'mbwph');?></button>
			<div class="mbwph-panel">
				<p>				
					<label class="mbwph_option">
						<input name="<?php echo $this->WP_HELPER; ?>_security_options[mbwph-login-form]" type="checkbox"
									   value="1" <?php echo in_array(1, $option) ? 'checked' : ''; ?> />
								<?php _e('Đăng nhập', 'mbwph');?>
					</label>
					<label class="mbwph_option">
						<input name="<?php echo $this->WP_HELPER; ?>_security_options[recaptcha-for]" type="checkbox"
									   value="2" <?php in_array(2, $recaptcha_for) ? 'checked' : '' ?> />
								<?php _e('Đăng ký', 'mbwph');?>
					</label> 
					<label class="mbwph_option">
						<input name="<?php echo $this->WP_HELPER; ?>_security_options[recaptcha-for]" type="checkbox"
									   value="3" <?php in_array(3, $recaptcha_for) ? 'checked' : '' ?> />
								<?php _e('Khôi phục mật khẩu', 'mbwph');?>
					</label>
					<label class="mbwph_option">
						<input name="<?php echo $this->WP_HELPER; ?>_security_options[recaptcha-for]" type="checkbox"
									   value="4" <?php in_array(4, $recaptcha_for) ? 'checked' : '' ?> />
								<?php _e('Bình luận', 'mbwph');?>
					</label>
				</p>
			</div>
			<button class="mbwph-accordion">Other Forms</button>
			<div class="mbwph-panel">
				<p><a href="https://wordpress.matbao.support/wp-helper-plugin" target="_blank"><span style="color:#f00"><?php _e('Get Premium', 'mbwph');?></span></a></p>
			</div>
		</div>
<?php
	}	
	/*===========SSL Settings=============*/
	public function mbwph_chk_enable_ssl_field() {

		$options 	= get_option( $this->WP_HELPER . '_security_options' );
		$option 	= 0;

		if ( ! empty( $options['enable-ssl'] ) ) {
			$option = $options['enable-ssl'];
		}		
		?>		
		<div class="pretty p-switch p-fill">
			<input type="checkbox" id="<?php echo $this->WP_HELPER; ?>_security_options[enable-ssl]" name="<?php echo $this->WP_HELPER; ?>_security_options[enable-ssl]" value="1" <?php checked( $option, 1 , true ); ?> disabled />
			<span class="el-switch-style"></span>			
		</label>		
		<span class="description"><?php _e('Để sử dụng chức năng này, bạn lưu ý cần phải cài đặt SSL trước đó để kích hoạt ổ khóa xanh trên trình duyệt.', 'mbwph'); ?></span> 
<?php
	}
	/*===========SSL Settings=============*/
	public function mbwph_chk_enable_hide_login_field() {

		$options 	= get_option( $this->WP_HELPER . '_security_options' );
		$option 	= 0;

		if ( ! empty( $options['enable-hide-login'] ) ) {
			$option = $options['enable-hide-login'];
		}		
		?>		
		<div class="pretty p-switch p-fill">
			<input type="checkbox" id="<?php echo $this->WP_HELPER; ?>_security_options[enable-hide-login]" name="<?php echo $this->WP_HELPER; ?>_security_options[enable-hide-login]" value="1" <?php checked( $option, 1 , true ); ?> />
			<div class="state p-success">
				<label></label>
			</div>			
		</div>
		<span class="description"><?php _e('Tránh việc bị tấn công dò mật khẩu, đồng thời giúp người dùng thay đổi đường dẫn quản trị dễ nhớ hơn.', 'mbwph'); ?></span> 		
<?php
	}
	public function mbwph_txt_login_name_field() {

		$options 	= get_option( $this->WP_HELPER . '_security_options' );
		$login_name 	= "";
		$url = get_option( 'siteurl' );

		if ( ! empty( $options['backend-name'] ) ) {
			$login_name = $options['backend-name'];
		}else{$slug = 'your-slug';}
		?>
		<div class="form-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_security_options[backend-name]" name="<?php echo $this->WP_HELPER; ?>_security_options[backend-name]" value="<?php echo( $login_name); ?>" class="form-control" placeholder="Tên đường dẫn vd: quanly"/>
			<span class="description"><?php _e('Link truy cập quản trị mới: <a href="'.$url.'/?'.$login_name.'"target="_bland"><strong>'.$url.'/<strong>?'.$login_name.'</strong></a>', 'mbwph'); ?></span> 
		</div>
<?php
	}
}