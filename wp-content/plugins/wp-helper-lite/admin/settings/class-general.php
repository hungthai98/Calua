<?php
/**
 * Controls settings of plugin
 *
 * @package    WP_HELPER
 * @subpackage WP_HELPER/admin/settings
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
class WP_HELPER_General extends WP_HELPER_Admin {		
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $WP_HELPER    The ID of this plugin.
	 */
	private $WP_HELPER, $plugin;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $WP_HELPER       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $WP_HELPER ) {
		$this->id    = 'general';
		$this->label = __( 'General', 'mbwph' );
		$this->WP_HELPER = $WP_HELPER;
		$this->plugin = 'wp-helper-premium/wp-helper-premium.php';
	}

	/**
	 * Creates our settings sections with fields etc. 
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function mbwph_settings_general_init() {
		$this->general_post_init();		
	}

	/**
	 * Creates post settings sections with fields etc. 
	 *
	 * @since    1.1.0
	 * @access   public
	 */
	public function general_post_init() {
		// add_settings_section( $id, $title, $callback, $menu_slug );
		add_settings_section(
			$this->WP_HELPER . '-post-page-options', // section
			apply_filters( $this->WP_HELPER . '-display-section-title', __( '', 'mbwph' ) ),
			array( $this, 'display_post_page_section' ),
			$this->WP_HELPER . '_general_tab'
		);
		add_settings_section(
			$this->WP_HELPER . '-widgets-options', // section
			apply_filters( $this->WP_HELPER . '-display-section-title', __( '', $this->WP_HELPER ) ),
			array( $this, 'display_widgets_section' ),
			$this->WP_HELPER . '_general_tab'
		);
		add_settings_field(
			'editor_type',
			apply_filters( $this->WP_HELPER . '-editor_type-label', __( 'Trình soạn thảo', 'mbwph' ) ),
			array( $this, 'mbwph_opt_editor_type_field' ),
			$this->WP_HELPER . '_general_tab',		// Page
			$this->WP_HELPER . '-post-page-options', 	// section to add to
			array( // The $args
				'editor_type' // Should match Option ID
			) 
		);
		add_settings_field(
			'duplicate_post_page',
			apply_filters( $this->WP_HELPER . '-duplicate_post_page-label', __( 'Sao chép trang/bài viết', 'mbwph' ) ),
			array( $this, 'mbwph_cb_duplicate_post_page_field' ),
			$this->WP_HELPER . '_general_tab',		// Page
			$this->WP_HELPER . '-post-page-options', 	// section to add to
			array( // The $args
				'duplicate_post_page' // Should match Option ID
			) 
		);		
		add_settings_field(
			'relative_image_url',
			apply_filters( $this->WP_HELPER . '-relative_image_url-label', __( 'Tối ưu đường dẫn ảnh', 'mbwph' ) ),
			array( $this, 'mbwph_cb_relative_image_url_field' ),
			$this->WP_HELPER . '_general_tab',		// Page
			$this->WP_HELPER . '-post-page-options', 	// section to add to
			array( // The $args
				'relative_image_url' // Should match Option ID
			) 
		);
		add_settings_field(
			'duplicate_widget',
			apply_filters( $this->WP_HELPER . '-duplicate_widget-label', __( 'Sao chép Widget', 'mbwph' ) ),
			array( $this, 'mbwph_cb_duplicate_widget_field' ),
			$this->WP_HELPER . '_general_tab',		// Page
			$this->WP_HELPER . '-widgets-options', 	// section to add to
			array( // The $args
				'duplicate_widget' // Should match Option ID
			) 
		);		
		add_settings_field(
			'allow_widget_class',
			apply_filters( $this->WP_HELPER . '-allow_widget_class-label', __( 'Chèn class CSS vào widget', 'mbwph' ) ),
			array( $this, 'mbwph_cb_allow_widget_class_field' ),
			$this->WP_HELPER . '_general_tab',		// Page
			$this->WP_HELPER . '-widgets-options', 	// section to add to
			array( // The $args
				'allow_widget_class' // Should match Option ID
			) 
		);		
		add_settings_field(
			'duplicate_menu',
			apply_filters( $this->WP_HELPER . '-duplicate_menu-label', __( 'Sao chép menu', 'mbwph' ) ),
			array( $this, 'mbwph_cb_duplicate_menu_field' ),
			$this->WP_HELPER . '_general_tab',		// Page
			$this->WP_HELPER . '-widgets-options', 	// section to add to
			array( // The $args
				'duplicate_menu' // Should match Option ID
			) 
		);
		
		add_settings_section(
			$this->WP_HELPER . '-advanced-options', // section
			apply_filters( $this->WP_HELPER . '-display-section-title', __( '', $this->WP_HELPER ) ),
			array( $this, 'display_advanced_section' ),
			$this->WP_HELPER . '_general_tab'
		);
		add_settings_field(
			'hide_sidebar',
			apply_filters( $this->WP_HELPER . '-hide_sidebar-label', __( 'Ẩn sidebar', 'mbwph' ) ),
			array( $this, 'mbwph_cb_hide_sidebar_field' ),
			$this->WP_HELPER . '_general_tab',		// Page
			$this->WP_HELPER . '-advanced-options', 	// section to add to
			array( // The $args
				'hide_sidebar' // Should match Option ID
			) 
		);
		add_settings_field(
			'wprocket_install',
			apply_filters( $this->WP_HELPER . '-wprocket_install-label', __( 'WP Rocket Plugin <span class="description"  data-toggle="tooltip" data-placement="right" title="Làm cho website tải nhanh hơn trong một vài cú nhấp chuột"><span class="dashicons dashicons-editor-help"></span></span>', 'mbwph' ) ),
			array( $this, 'mbwph_btn_wprocket_install_field' ),
			$this->WP_HELPER . '_general_tab',		// Page
			$this->WP_HELPER . '-advanced-options', 	// section to add to
			array( // The $args
				'wprocket_install' // Should match Option ID
			) 
		);		
		register_setting($this->WP_HELPER . '_general_tab','editor_type');
		register_setting($this->WP_HELPER . '_general_tab','duplicate_post_page');
		register_setting($this->WP_HELPER . '_general_tab','relative_image_url');
		register_setting($this->WP_HELPER . '_general_tab','duplicate_widget');
		register_setting($this->WP_HELPER . '_general_tab','allow_widget_class');
		register_setting($this->WP_HELPER . '_general_tab','duplicate_menu');
		register_setting($this->WP_HELPER . '_general_tab','hide_sidebar');
	}
	
	/**
	 * Creates a settings section
	 *
	 * @since 		1.0.0
	 * @param 		array 		$params 		Array of parameters for the section
	 * @return 		mixed 						The settings section
	 */
	public function display_post_page_section( $params ) {
		_e('<h4>Trang / Bài viết</h4>','mbwph');		
	}
	public function display_widgets_section( $params ) {
		_e('<h4>Giao diện</h4>','mbwph');		
	}
	public function display_advanced_section( $params ) {
		_e('<h3>Nâng cao</h3>','mbwph');
		_e('<span class="description">Các chức năng dành cho phiên bản Premium, <a href="https://www.matbao.net/hosting/wp-helper-plugin.html" target="_blank">tìm hiểu thêm</a></span>','mbwph');
	}	
	/**
	 * Enable/Disable Checkbox Field
	 *
	 * @since 		1.0.0
	 * @return 		mixed 			The settings field
	 */
	public function mbwph_opt_editor_type_field() {
		$option 	= get_option('editor_type');		
		if ( empty( $option ) ) {$option = '';}		
		?>		
		<div class="input-group">
			<select name="editor_type">
				<option value=''><?php _e('Gutenberg', 'mbwph'); ?></option>
				<option value="1" <?php selected( $option, 1 , true ); ?>><?php _e('Classic Editor', 'mbwph'); ?></option>
				<option value="2" disabled><?php _e('TinyMCE Editor', 'mbwph'); ?></option>
			</select>			
			<span class="el-switch-style"></span>
		</div>
		<span class="description"><?php _e('', 'mbwph'); ?></span>
<?php
	}
	public function mbwph_cb_duplicate_post_page_field() {				
		$option 	= get_option('duplicate_post_page');		
		?>		
		<div class="pretty p-switch p-fill">
			<input type="checkbox" name="duplicate_post_page" value="1" <?php checked( $option, 1 , true ); ?> />
			<div class="state p-success">
				<label></label>
			</div>
		</div>
		<span class="description"><?php _e('Cho phép nhân bản trang / bài viết.', 'mbwph'); ?></span>
		<span class="description"  data-toggle="tooltip" data-placement="right" title="<img src='/wp-content/plugins/wp-helper-lite/admin/assets/images/clone-post-page.png'>"><span class="dashicons dashicons-editor-help"></span>
<?php
	}
	public function mbwph_cb_relative_image_url_field() {
		$option 	= get_option( 'relative_image_url' );		
		?>		
		<div class="pretty p-switch p-fill">
			<input type="checkbox" name="relative_image_url" value="1" <?php checked( $option, 1 , true ); ?> />
			<div class="state p-success">
				<label></label>
			</div>
		</div>
		<span class="description"><?php _e('Website không bị lỗi đường dẫn ảnh sau khi đổi tên miền.', 'mbwph'); ?></span>
<?php
	}	
	public function mbwph_cb_duplicate_widget_field() {				
		$option 	= get_option('duplicate_widget');		
		?>		
		<div class="pretty p-switch p-fill">
			<input type="checkbox" name="duplicate_widget" value="1" <?php checked( $option, 1 , true ); ?> />
			<div class="state p-success">
				<label></label>
			</div>
		</div>
		<span class="description"><?php _e('Cho phép nhân bản Widget.', 'mbwph'); ?></span>
		<span class="description"  data-toggle="tooltip" data-placement="right" title="<img src='/wp-content/plugins/wp-helper-lite/admin/assets/images/clone-widget.png'>"><span class="dashicons dashicons-editor-help"></span>
<?php
	}
	public function mbwph_cb_allow_widget_class_field() {				
		$option 	= get_option('allow_widget_class');		
		?>		
		<div class="pretty p-switch p-fill">
			<input type="checkbox" name="allow_widget_class" value="1" <?php checked( $option, 1 , true ); ?> />
			<div class="state p-success">
				<label></label>
			</div>
		</div>
		<span class="description"><?php _e('Cho phép chèn CSS class vào Widget.', 'mbwph'); ?></span>
		<span class="description"  data-toggle="tooltip" data-placement="right" title="<img src='/wp-content/plugins/wp-helper-lite/admin/assets/images/add-css-class-to-widget.png'>"><span class="dashicons dashicons-editor-help"></span></span>
<?php
	}
	public function mbwph_cb_duplicate_menu_field() {				
		$option 	= get_option('duplicate_menu');		
		?>		
		<div class="pretty p-switch p-fill">
			<input type="checkbox" name="duplicate_menu" value="1" <?php checked( $option, 1 , true ); ?> />
			<div class="state p-success">
				<label></label>
			</div>
		</div>
		<span class="description"><?php _e('Cho phép nhân bản menu.', 'mbwph'); ?></span>
		<span class="description"  data-toggle="tooltip" data-placement="right" title="<img src='/wp-content/plugins/wp-helper-lite/admin/assets/images/clone-menu.png'>"><span class="dashicons dashicons-editor-help"></span></span>
<?php
	}
	public function mbwph_cb_hide_sidebar_field() {
		$status = '';
		if (!is_plugin_active($this->plugin)) {$status = 'disabled';}
		$option 	= get_option( 'hide_sidebar' );
		
		?>		
		<div class="pretty p-switch p-fill">
			<input type="checkbox" name="hide_sidebar" value="1" <?php checked( $option, 1 , true ); ?> <?php echo $status; ?> />
			<div class="state p-success">
				<label></label>
			</div>
		</div>
		<span class="description"><?php _e('Bật/Tắt sidebar Tin tài trợ', 'mbwph'); ?></span>
<?php
	}	
	public function mbwph_btn_wprocket_install_field() {
		if (is_plugin_active($this->plugin)) {
		?>
			<a class="btn btn-success btn-sm btn-rounded" target="_blank" href="../wp-admin/themes.php?page=mwp-install-plugins&amp;plugin_status=install"><span class="dashicons dashicons-download"></span> Cài đặt</a>
		<?php
		}else{ ?>
			<a class="btn btn-danger btn-sm btn-rounded" target="_blank" href="https://www.matbao.net/hosting/wp-helper-plugin.html"><span class="dashicons dashicons-download"></span> <?php _e('Get Premium','mbwph');?></a>
		<?php
		}
	}
}