<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.squareonemd.co.uk
 * @since      1.0.0
 *
 * @package    Insta_Grab
 * @subpackage Insta_Grab/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Insta_Grab
 * @subpackage Insta_Grab/public
 * @author     Elliott Richmond <elliott@squareonemd.co.uk>
 */
class Insta_Grab_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $insta_grab    The ID of this plugin.
	 */
	private $insta_grab;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $insta_grab       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $insta_grab, $version ) {

		$this->insta_grab = $insta_grab;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Insta_Grab_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Insta_Grab_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->insta_grab, plugin_dir_url( __FILE__ ) . 'css/insta-grab-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Insta_Grab_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Insta_Grab_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->insta_grab, plugin_dir_url( __FILE__ ) . 'js/insta-grab-public.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * Render public.
	 * @TODO add conditionals for options
	 * @TODO debug current wp themes and add to history notes
	 * @TODO finalise public css
	 * @TODO allow user css overide
	 * @since    1.0.0
	 */
	public function get_instagram_settings () {

		$instasetup = get_option( 'instagrabagram_option_name' );
		if (!empty($instasetup)) {
		
		    $instagram = new Instagram(array(
		      'apiKey'      => $instasetup['insta_apiKey'],
		      'apiSecret'   => $instasetup['insta_apiSecret'],
		      'apiCallback' => $instasetup['insta_apiCallback']
		    ));
		    
		    $hashtag = $instasetup['insta_apitag'];	    

			$medias = $instagram->getTagMedia($hashtag);
			$media_count = $instasetup['insta_count'];

			// debug using $variable
			// echo '<pre>'; print_r($medias); echo '</pre>';
			
			if ($medias->meta->code == '400'){
				echo 'Cannot connect to your images';		
			} else {
				echo '<article id="instagrab" class="hentry">';
				echo '<ul class="entry-content">';
						$count = 0;
					    foreach ($medias->data as $media) {
					    	if ($count == $media_count) continue;
					    	$image = $media->images->standard_resolution->url;
					    	echo '<li>
								    <img src="'.$image.'" />
								</li>';
							$count++;
					    }
				echo '</ul>';
				echo '</article>';
			}
		} else {
			$settings_url = get_bloginfo('url') . '/wp-admin/options-general.php?page=instagrabagram-setting-admin';
			echo '<div class="row"><div class="primary alert">There seems to be a problem connecting to your Instagram App, have you input the correct <a href="' . $settings_url . '">details here</a></div></div>';
		}
	
	}
}
