<?php
/**
 * Plugin Name: WP Helper Lite
 * Plugin URI:  https://wordpress.matbao.support
 * Description: Công cụ tổng hợp các tiện ích được người dùng thường sử dụng: Social, SMTP, Security, SEO,... giúp người dùng tránh phải việc sử dụng quá nhiều plugin cho nhiều chứ năng khác nhau dẫn tới website hoạt động chậm chạp. ❤ Plugin được phát triển bởi đội ngũ MWP Team - Mat Bao Corp.
 * Version:     2.1
 * Author:      Mat Bao Corp
 * Author URI:  https://wordpress.matbao.support
 * Text Domain: mbwph
 * Domain Path: /languages
 * License:     GPL2
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
define( 'WP_HELPER_VERSION', '2.1' );
define( 'WP_HELPER_FILE' , __FILE__ );
define( 'WP_HELPER_PLUGIN_BASE', plugin_basename( WP_HELPER_FILE ) );
define( 'WP_HELPER_PATH' , realpath( plugin_dir_path( WP_HELPER_FILE ) ) . '/' );
define( 'WP_HELPER_URL' , plugin_dir_url( WP_HELPER_FILE ) );
define( 'WP_HELPER_ADMIN_ASSETS_URL' , WP_HELPER_URL . 'admin/assets/' );
define( 'WP_HELPER_PUBLIC_URL' , WP_HELPER_PATH . 'public/' );
define( 'WP_HELPER_PUBLIC_ASSETS_URL' , WP_HELPER_PATH . 'public/partials/assets/' );
define( 'WP_HELPER_PUBLIC_IMAGES_URL' , WP_HELPER_URL . 'public/partials/assets/images' );
define( 'WP_HELPER_ADMIN_ASSETS_IMG_URL' , WP_HELPER_ADMIN_ASSETS_URL . 'images/' );

add_action('plugins_loaded', 'mbwph_load_plugin_textdomain');
function mbwph_load_plugin_textdomain()
{
	load_plugin_textdomain('mbwph');
}
function mbwph_admin_notice_activation_hook() {
	set_transient( 'mwp-admin-notice', true, 5 );
}register_activation_hook( __FILE__, 'mbwph_admin_notice_activation_hook' );

function mbwph_admin_actived_notice(){
	/* Check transient, if available display notice */
	if( get_transient( 'mwp-admin-notice' ) ){
		?>
		<div class="updated notice is-dismissible">
			<p>Cám ơn bạn đã sử dụng plugin <strong>WP Helper Lite</strong> ! Hãy bấm <a href="<?php echo admin_url('admin.php?page=wp-helper'); ?>">vào đây</a> để cài đặt <strong>WP Helper Lite</strong>.</p>
		</div>
		<?php
		/* Delete transient, only display this notice once. */
		delete_transient( 'mwp-admin-notice' );
	}
}add_action( 'admin_notices', 'mbwph_admin_actived_notice' );
require WP_HELPER_PATH . 'includes/class-wp-helper-lite.php';
function run_WP_HELPER() {
	$plugin = new WP_HELPER();
	$plugin->run();
}
run_WP_HELPER();