<?php
/**
 * @ Class: mbwph_Posts
 *
 */
 
add_action('wp_ajax_mbwph_send_mail', array('mbwph_Posts', 'mbwph_send_mail') );
add_action('wp_ajax_nopriv_mbwph_send_mail', array('mbwph_Posts', 'mbwph_send_mail') );
add_filter('wp_mail_content_type', array('mbwph_Posts', 'mbwph_mail_content_type') );

class mbwph_Posts {
   
    public static function mbwph_send_mail() {
		
        if (sanitize_text_field($_POST['email'])) {
           
            $to = sanitize_text_field($_POST['email']);
            $subject = 'WP Helper - Cấu hình SMTP thành công';
           
            ob_start();
           
            echo '<p>Xin chúc mừng bạn đã cấu hình máy chủ SMTP thành công.</p><br>';
			echo '<p>WP Helper Team.</p>';
           
            $message = ob_get_contents();
           
            ob_end_clean();

            $mail = wp_mail($to, $subject, $message);
           
            if($mail){
                echo 'success';
            }
        }
       
        exit();
       
    }
       
    public static function mbwph_mail_content_type() {
        return "text/html";
    }
}