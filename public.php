<?php

require_once( plugin_dir_path( __FILE__ ) . 'inc/instagram.class.php' );

function get_instagram_settings () {

	$instasetup = get_option( 'instagrabagram_option_name' );
	if (!empty($instasetup)) {
	
	    $instagram = new Instagram(array(
	      'apiKey'      => $instasetup['insta_apiKey'],
	      'apiSecret'   => $instasetup['insta_apiSecret'],
	      'apiCallback' => $instasetup['insta_apiCallback']
	    ));
	    
	    $hashtag = $instasetup['insta_apitag'];	    

		$medias = $instagram->getTagMedia($hashtag);
		
		//echo '<pre>'; print_r($medias); echo '</pre>';
		
		if ($medias->meta->code == '400'){
			echo 'Cannot connect to your images';		
		} else {
			echo '<div class="fpimages">
				<div class="tiles row">';
		
				    foreach ($medias->data as $media) {
				    	$image = $media->images->standard_resolution->url;
				    	echo '<div>
							    <img src="'.$image.'" />
							</div>';
				    }
			echo '</div>
				</div>';
		}
	} else {
		$settings_url = get_bloginfo('url') . '/wp-admin/options-general.php?page=instagrabagram-setting-admin';
		echo '<div class="row"><div class="primary alert">There seems to be a problem connecting to your Instagram App, have you input the correct <a href="' . $settings_url . '">details here</a></div></div>';
	}

	
}

add_action( 'insta_grab_a_gram', 'get_instagram_settings' );