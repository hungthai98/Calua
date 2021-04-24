<div class="card">
	<h5 class="card-header">Tin tài trợ</h5>
	<div class="card-body">
		<?php									
			// Get the JSON									
			// Enter the name of your blog here followed by /wp-json/wp/v2/posts and add filters like this one that limits the result to 2 posts.
			$responseMB = wp_remote_get( 'https://wordpress.matbao.support/wp-json/wp/v2/pages/885' );
			$infoMB = '';
			//var_dump($response);
			// Exit if error.
			if ( is_wp_error( $responseMB ) ) {
				return;
			}
			// Get the body.
			$postsMB = json_decode( wp_remote_retrieve_body( $responseMB ) );
			// Exit if nothing is returned.
			if ( empty( $postsMB ) ) {
				//return;
				echo 'Không có nội dung.';
			}
			// If there are posts.
			if ( ! empty( $postsMB ) ) {
				// For each post.
				$infoMB = $postsMB->content->rendered;
			}
			echo $infoMB;
		?>
	</div>
</div>