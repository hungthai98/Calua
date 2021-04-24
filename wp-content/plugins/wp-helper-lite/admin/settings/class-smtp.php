<?php
/**
 * Controls settings of plugin
 *
 * @package    WP_HELPER
 * @subpackage WP_HELPER/admin/settings
 */
class WP_HELPER_Smtp extends WP_HELPER_Admin {

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
		$this->id    = 'smtp';
		$this->label = __( 'Smtp', 'mbwph' );
		$this->WP_HELPER = $WP_HELPER;
	}

	/**
	 * Creates our settings sections with fields etc. 
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function mbwph_settings_smtp_init() {
		$this->mbwph_smtp_post_init();		
	}

	/**
	 * Creates post settings sections with fields etc. 
	 *
	 * @since    1.1.0
	 * @access   public
	 */
	public function mbwph_smtp_post_init() {
		
		// register_setting( $option_group, $option_name, $settings_sanitize_callback );
		register_setting(
			$this->WP_HELPER . '_smtp_options_group',
			$this->WP_HELPER . '_smtp_options', //Options containt value field
			array( $this, 'mbwph_settings_sanitize' )
		);
		
		// add_settings_section( $id, $title, $callback, $menu_slug );
		add_settings_section(
			$this->WP_HELPER . '-smtp-options', // section
			apply_filters( $this->WP_HELPER . '-display-section-title', __( '', $this->WP_HELPER ) ),
			array( $this, 'print_smtp_section' ),
			$this->WP_HELPER . '_smtp_tab'
		);
		
		// add_settings_field( $id, $title, $callback, $menu_slug, $section, $args );
		add_settings_field(
			'enable-smtp',
			apply_filters( $this->WP_HELPER . '-enable-smtp-label', __( 'Kích hoạt', 'mbwph' ) ),
			array( $this, 'mbwph_op_enable_smtp_field' ),
			$this->WP_HELPER . '_smtp_tab',		// Page
			$this->WP_HELPER . '-smtp-options' 	// section to add to
		);
		add_settings_field(
			'from',
			apply_filters( $this->WP_HELPER . '-from-label', __( 'Email gửi từ', 'mbwph' ) ),
			array( $this, 'mbwph_txtfrom_field' ),
			$this->WP_HELPER . '_smtp_tab',		// Page
			$this->WP_HELPER . '-smtp-options' 	// section to add to
		);
		add_settings_field(
			'from-name',
			apply_filters( $this->WP_HELPER . '-from-name-label', __( 'Tên gửi từ', 'mbwph' ) ),
			array( $this, 'mbwph_txtfrom_name_field' ),
			$this->WP_HELPER . '_smtp_tab',		// Page
			$this->WP_HELPER . '-smtp-options' 	// section to add to
		);
		add_settings_field(
			'smtp-host',
			apply_filters( $this->WP_HELPER . '-smtp-host-label', __( 'SMTP Host', 'mbwph' ) ),
			array( $this, 'mbwph_txtsmtp_host_field' ),
			$this->WP_HELPER . '_smtp_tab',		// Page
			$this->WP_HELPER . '-smtp-options' 	// section to add to
		);
		add_settings_field(
			'smtp-secure',
			apply_filters( $this->WP_HELPER . '-smtp-secure-label', __( 'Bảo mật SMTP', 'mbwph' ) ),
			array( $this, 'mbwph_opsmtp_secure_field' ),
			$this->WP_HELPER . '_smtp_tab',		// Page
			$this->WP_HELPER . '-smtp-options' 	// section to add to
		);
		add_settings_field(
			'smtp-port',
			apply_filters( $this->WP_HELPER . '-smtp-port-label', __( 'Cổng SMTP', 'mbwph' ) ),
			array( $this, 'mbwph_txtsmtp_port_field' ),
			$this->WP_HELPER . '_smtp_tab',		// Page
			$this->WP_HELPER . '-smtp-options' 	// section to add to
		);
		add_settings_field(
			'smtp-auth',
			apply_filters( $this->WP_HELPER . '-smtp-auth-label', __( 'Xác thực SMTP', 'mbwph' ) ),
			array( $this, 'mbwph_opsmtp_auth_field' ),
			$this->WP_HELPER . '_smtp_tab',		// Page
			$this->WP_HELPER . '-smtp-options' 	// section to add to
		);
		add_settings_field(
			'smtp-username',
			apply_filters( $this->WP_HELPER . '-smtp-username-label', __( 'Tên đăng nhập SMTP', 'mbwph' ) ),
			array( $this, 'mbwph_txtsmtp_username_field' ),
			$this->WP_HELPER . '_smtp_tab',		// Page
			$this->WP_HELPER . '-smtp-options' 	// section to add to
		);
		add_settings_field(
			'smtp-password',
			apply_filters( $this->WP_HELPER . '-smtp-password-label', __( 'Mật khẩu SMTP', 'mbwph' ) ),
			array( $this, 'mbwph_txtsmtp_password_field' ),
			$this->WP_HELPER . '_smtp_tab',		// Page
			$this->WP_HELPER . '-smtp-options' 	// section to add to
		);		
	}
	
	/**
	 * Creates a settings section
	 *
	 * @since 		1.0.0
	 * @param 		array 		$params 		Array of parameters for the section
	 * @return 		mixed 						The settings section
	 */
	public function print_smtp_section( $params ) {
		_e('<h4>Cài đặt SMTP</h4>','mbwph');		
		_e('<span class="description">Nếu đây là lần đầu tiên cài đặt SMTP. Vui lòng xem hướng dẫn <a href="https://wordpress.matbao.support/huong-dan/wp-helper-cai-dat-smtp-su-dung-gmail.html" target="_blank">tại đây</a>.</span>', 'mbwph');

	} // display_options_section()
	public function print_captcha_section( $params ) {

		//echo '<p>' . $params['title'] . '</p>';
		echo '<hr/>';
		echo '<div class="alert alert-warning">Nhận khóa <a href="//www.google.com/recaptcha/admin" target="_blank">reCaptcha</a> từ Google. Làm theo các bước hướng dẫn của Google.</div>';

	} // display_options_section()	

	/**
	 * Enable/Disable Checkbox Field
	 *
	 * @since 		1.0.0
	 * @return 		mixed 			The settings field
	 */
	public function mbwph_op_enable_smtp_field() {

		$options 	= get_option( $this->WP_HELPER . '_smtp_options' );
		$option 	= 0;

		if ( ! empty( $options['enable-smtp'] ) ) {
			$option = $options['enable-smtp'];
		}		
		?>		
		<div class="pretty p-switch p-fill">
			<input type="checkbox" id="<?php echo $this->WP_HELPER; ?>_smtp_options[enable-smtp]" name="<?php echo $this->WP_HELPER; ?>_smtp_options[enable-smtp]" value="1" <?php checked( $option, 1 , true ); ?> />
			<div class="state p-success">
				<label></label>
			</div>			
		</div>			
<?php
	} // mbwph_op_enable_smtp_field()
	public function mbwph_txtfrom_field() {

		$options 	= get_option( $this->WP_HELPER . '_smtp_options' );
		$from 	= "";

		if ( ! empty( $options['from'] ) ) {
			$from = $options['from'];
		}		
		?>
		<div class="form-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_smtp_options[from]" name="<?php echo $this->WP_HELPER; ?>_smtp_options[from]" value="<?php echo( $from); ?>" class="form-control" placeholder="Địa chỉ email. vd: your-email@domain"/> 
			<span class="description">Nếu bạn sử dụng Email từ nhà cung cấp (Gmail, Yahoo, Outlook.com, v.v.) thì đây sẽ là địa chỉ email của bạn cho tài khoản đó.</span>
		</div>
<?php
	} // mbwph_txtfrom_field()
	public function mbwph_txtfrom_name_field() {

		$options 	= get_option( $this->WP_HELPER . '_smtp_options' );
		$from_name 	= "";

		if ( ! empty( $options['from-name'] ) ) {
			$from_name = $options['from-name'];
		}		
		?>
		<div class="form-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_smtp_options[from-name]" name="<?php echo $this->WP_HELPER; ?>_smtp_options[from-name]" value="<?php echo( $from_name); ?>" class="form-control" placeholder="Tên đại diện email"/> 
			<span class="description">Vd: Tên Công ty / Cá Nhân</span>
		</div>
<?php
	} // mbwph_txtfrom_name_field()
	public function mbwph_txtsmtp_host_field() {

		$options 	= get_option( $this->WP_HELPER . '_smtp_options' );
		$smtp_host 	= "";

		if ( ! empty( $options['smtp-host'] ) ) {
			$smtp_host = $options['smtp-host'];
		}		
		?>
		<div class="form-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-host]" name="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-host]" value="<?php echo( $smtp_host); ?>" class="form-control" placeholder="Địa chỉ máy chủ SMTP. vd: smtp.gmail.com"/> 
		</div>
<?php
	} // mbwph_txtsmtp_host_field()
	public function mbwph_opsmtp_secure_field() {

		$options 	= get_option( $this->WP_HELPER . '_smtp_options' );
		$smtp_secure	= "";

		if ( ! empty( $options['smtp-secure'] ) ) {
			$smtp_secure = $options['smtp-secure'];
		}
		?>
		<div class="form-group">
			<label class="mbwph_option">
				<input name="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-secure]" type="radio"
                               value=""<?php if ($smtp_secure == '') { ?> checked="checked"<?php } ?> />
                        None
			</label>
			<label class="mbwph_option">
				<input name="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-secure]" type="radio"
                               value="ssl"<?php if ($smtp_secure == 'ssl') { ?> checked="checked"<?php } ?> />
                        SSL
			</label>
			<label class="mbwph_option">
				<input name="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-secure]" type="radio"
                               value="tls"<?php if ($smtp_secure == 'tls') { ?> checked="checked"<?php } ?> />
                        TLS
			</label><br>
			<span class="description">Đối với hầu hết các máy chủ, TLS là tùy chọn được đề xuất. Nếu nhà cung cấp SMTP của bạn cung cấp cả hai tùy chọn SSL và TLS, chúng tôi khuyên bạn nên sử dụng TLS.</span>
		</div>
<?php
	} // mbwph_txtsmtp_secure_field()
	public function mbwph_txtsmtp_port_field() {

		$options 	= get_option( $this->WP_HELPER . '_smtp_options' );
		$smtp_port 	= "";

		if ( ! empty( $options['smtp-port'] ) ) {
			$smtp_port = $options['smtp-port'];
		}		
		?>
		<div class="form-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-port]" name="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-port]" value="<?php echo( $smtp_port); ?>" class="form-control" placeholder="Cổng kết nối máy chủ mail: 465 hoặc 587."/> 
			<span class="description">Tùy vào máy chủ SMTP sẽ có cấu hình thông số Port khác nhau, tuy nhiên thông thường thông số Port SMTP sẽ như sau:<br>None: 25<br>SSL: 465<br>TLS: 587</span>
		</div>
<?php
	} // mbwph_txtsmtp_port_field()
	public function mbwph_opsmtp_auth_field() {

		$options 	= get_option( $this->WP_HELPER . '_smtp_options' );
		$smtp_auth	= "";

		if ( ! empty( $options['smtp-auth'] ) ) {
			$smtp_auth = $options['smtp-auth'];
		}
		?>
		<div class="form-group">
			<label class="mbwph_option">
				<input name="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-auth]" type="radio"
                               value="no"<?php if ($smtp_auth == 'no') { ?> checked="checked"<?php } ?> />
                        No
			</label>
			<label class="mbwph_option">
				<input name="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-auth]" type="radio"
                               value="yes"<?php if ($smtp_auth == 'yes') { ?> checked="checked"<?php } ?> />
                        Yes
			</label>			
		</div>
<?php
	} // mbwph_opsmtp_auth_field()
	public function mbwph_txtsmtp_username_field() {

		$options 	= get_option( $this->WP_HELPER . '_smtp_options' );
		$smtp_username 	= "";

		if ( ! empty( $options['smtp-username'] ) ) {
			$smtp_username = $options['smtp-username'];
		}		
		?>
		<div class="form-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-username]" name="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-username]" value="<?php echo( $smtp_username); ?>" class="form-control" placeholder="Tên đăng nhập"/> 
		</div>
<?php
	} // mbwph_txtsmtp_user_field()
	public function mbwph_txtsmtp_password_field() {

		$options 	= get_option( $this->WP_HELPER . '_smtp_options' );
		$smtp_password 	= "";

		if ( ! empty( $options['smtp-password'] ) ) {
			$smtp_password = $options['smtp-password'];
		}		
		?>
		<div class="form-group">
			<div class="input-group" id="show_hide_password">
				<input type="password" id="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-password]" name="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-password]" value="<?php echo( $smtp_password); ?>" class="form-control" placeholder="Mật khẩu"  data-toggle="password"/>
				<div class="input-group-addon">
					<a href="#"><span class="dashicons dashicons-hidden" aria-hidden="true"></span></a>
				</div>
			</div>
		</div>
<?php
	} // mbwph_txtsmtp_password_field()	
}