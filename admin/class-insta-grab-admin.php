<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://www.squareonemd.co.uk
 * @since      1.1.9
 *
 * @package    Insta_Grab
 * @subpackage Insta_Grab/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Insta_Grab
 * @subpackage Insta_Grab/admin
 * @author     Elliott Richmond <elliott@squareonemd.co.uk>
 */
class Insta_Grab_Admin {

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
	 * @var      string    $insta_grab       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $insta_grab, $version ) {

		$this->insta_grab = $insta_grab;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the Dashboard.
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

		wp_enqueue_style( $this->insta_grab, plugin_dir_url( __FILE__ ) . 'css/insta-grab-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->insta_grab.'-prism', plugin_dir_url( __FILE__ ) . 'css/prism.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the dashboard.
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

		wp_enqueue_script( $this->insta_grab, plugin_dir_url( __FILE__ ) . 'js/insta-grab-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->insta_grab .'-prism', plugin_dir_url( __FILE__ ) . 'js/prism.js', array(), $this->version, false );

	}

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will sit under "Settings"
        add_options_page(
            'Settings Instagrabagram', 
            'Instagrabagram', 
            'manage_options', 
            'instagrabagram-setting-admin', 
            array( $this, 'instagrabagram_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function instagrabagram_admin_page()
    {
        // Set class property
        $this->options = get_option( 'instagrabagram_option_name' );
        $this->settings = get_option( 'instagrabagram_settings_name' );
        
		include_once(plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/insta-grab-admin-display.php');

	}
	
    /**
     * Check all api settings are empty or not
	 * @return      boolean    $bool    true if a setting is empty.
     */
	public function check_api_settings(){
		$bool = false;
		if (empty($this->options['insta_apiKey']) || empty($this->options['insta_apiSecret']) || empty($this->options['insta_apiCallback'])) {
			$bool = true;
		}
		return $bool;
	}
	
    /**
     * output error if setting is empty
     */
	public function confirm_api_settings() {
		if ($this->check_api_settings()) { ?>
			<div class="notice notice-error"><p>It doesn't look like there are any Instagram Client details saved yet, make sure to create a new Client in your Instagram account, <a href="http://instagram.com/developer/" target="_blank">do you want to create that now?</a></p></div>
		<?php }
	}
	
    /**
     * Check all api settings are set complete
	 * @return      boolean    $bool    true if a setting is empty.
     */
	public function check_if_ready_to_authorise() {
		$api_settings = array($this->options['insta_apiKey'],$this->options['insta_apiSecret'],$this->options['insta_apiCallback']);
		$filtered = array_filter($api_settings);
		if (!empty($filtered) && count($filtered) == 3) {
		    $getLoginUrl = 'https://api.instagram.com/oauth/authorize?client_id='.$this->options['insta_apiKey'].'&redirect_uri='.$this->options['insta_apiCallback'].'&response_type=code&scope=public_content';
	    } else {
		    $getLoginUrl = false;
	    }
	    
	    return $getLoginUrl;

	}
	
    /**
     * Check all api settings are set complete
	 * @return      boolean    $bool    true if a setting is empty.
     */
	public function ready_to_authorise() {
		if($this->options['insta_access_token']){
			return;
		}
		if ($this->check_if_ready_to_authorise()) { ?>
			<div class="authorise-instagram">
				<a href="<?php echo esc_attr($this->check_if_ready_to_authorise()); ?>">
				<h4>Good job! Now you are ready to authorise Instagram!</h4>
	            <img src="<?php echo plugin_dir_url( dirname(__FILE__) ) . 'admin/img/Instagram_AppIcon.jpg';?>" alt="authorise-instagram"/>
	            <h4>Click here to authorise Instagram...</h4>
	            </a>
			</div> <!-- .inside -->
		<?php }
	}
	
	public function initialise_settings() {
		$settings = get_option( 'instagrabagram_settings_name' );
		unset($settings['insta_apitag']);
		update_option( 'instagrabagram_settings_name', $settings );
	}
	
    /**
     * Register and add settings
     * @TODO clean up comments
     * @TODO add a title option
     * @TODO add a css overide option,
     *   check priorty loading and css specificity 
     *   the theme might override naturally 
     */
    public function page_init() {     
	    
	    $this->initialise_settings();
	       
        register_setting(
            'instagrabagram_option_group', // Option group
            'instagrabagram_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            '', // Title
            array( $this, 'print_section_info' ), // Callback
            'instagrabagram-setting-admin' // Page
        );  

        add_settings_field(
            'insta_apiKey', // ID
            'CLIENT ID', // Title 
            array( $this, 'insta_apiKey_callback' ), // Callback
            'instagrabagram-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'insta_apiSecret', // ID
            'CLIENT SECRET', // Title 
            array( $this, 'insta_apiSecret_callback' ), // Callback
            'instagrabagram-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'insta_apiCallback', // ID
            'WEBSITE URL', // Title 
            array( $this, 'insta_apiCallback_callback' ), // Callback
            'instagrabagram-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'insta_access_token', // ID
            'Access Token (called on authorisation)', // Title 
            array( $this, 'insta_access_token_callback' ), // Callback
            'instagrabagram-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        register_setting(
            'instagrabagram_settings_group', // Option group
            'instagrabagram_settings_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'igag_setting_section_id', // ID
            '', // Title
            array( $this, 'igag_setting_info' ), // Callback
            'igag-setting-admin' // Page
        );  

/*
        add_settings_field(
            'insta_apitag', // ID
            'Inastagram Hashtag', // Title 
            array( $this, 'insta_apitag_callback' ), // Callback
            'igag-setting-admin', // Page
            'igag_setting_section_id' // Section           
        );      
*/

        add_settings_field(
            'insta_count', // ID
            'How Many Images to pull (numeric)', // Title 
            array( $this, 'insta_count_callback' ), // Callback
            'igag-setting-admin', // Page
            'igag_setting_section_id' // Section           
        );      

        add_settings_field(
            'insta_link', // ID
            'Clickable image links to Instagram', // Title 
            array( $this, 'insta_link_callback' ), // Callback
            'igag-setting-admin', // Page
            'igag_setting_section_id' // Section           
        );      

    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['insta_apiKey'] ) )
            $new_input['insta_apiKey'] = strip_tags( $input['insta_apiKey'] );

        if( isset( $input['insta_apiSecret'] ) )
            $new_input['insta_apiSecret'] = strip_tags( $input['insta_apiSecret'] );

        if( isset( $input['insta_apiCallback'] ) )
            $new_input['insta_apiCallback'] = esc_url_raw( $input['insta_apiCallback'] );

        if( isset( $input['insta_access_token'] ) )
            $new_input['insta_access_token'] = strip_tags( $input['insta_access_token'] );

/*
		if( isset( $input['insta_apitag'] ) )
            $new_input['insta_apitag'] = strip_tags( $input['insta_apitag'] );
*/

        if( isset( $input['insta_count'] ) )
            $new_input['insta_count'] = absint( $input['insta_count'] );

        if( isset( $input['insta_link'] ) )
            $new_input['insta_link'] = strip_tags( $input['insta_link'] );


        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_instagram_section_info() {
        print 'Enter the Instagram Hashtag and number of images:';
    }

    /** 
     * Print the Section text
     */
    public function print_section_info() {
        print '<p>Enter all your Instagram Client settings here inorder to make requests to the Instagram API:</p>';
    }

    public function igag_setting_info() {
        print 'Enter all your Instagram settings here:';
    }

    /** 
     * Print the Section text
     */
    public function print_other_section_info() {
        print 'Miscellaneous settings:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function insta_apiKey_callback()
    {
        printf(
            '<input type="text" id="insta_apiKey" name="instagrabagram_option_name[insta_apiKey]" value="%s" />',
            isset( $this->options['insta_apiKey'] ) ? esc_attr( $this->options['insta_apiKey']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function insta_apiSecret_callback()
    {
        printf(
            '<input type="text" id="insta_apiSecret" name="instagrabagram_option_name[insta_apiSecret]" value="%s" />',
            isset( $this->options['insta_apiSecret'] ) ? esc_attr( $this->options['insta_apiSecret']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function insta_apiCallback_callback()
    {
        printf(
            '<input type="text" id="insta_apiCallback" name="instagrabagram_option_name[insta_apiCallback]" value="%s" />',
            isset( $this->options['insta_apiCallback'] ) ? esc_attr( $this->options['insta_apiCallback']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function insta_access_token_callback()
    {
        printf(
            '<input type="text" id="insta_access_token" name="instagrabagram_option_name[insta_access_token]" value="%s" />',
            isset( $this->options['insta_access_token'] ) ? esc_attr( $this->options['insta_access_token']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
/*
    public function insta_apitag_callback()
    {
        printf(
            '<input type="text" id="insta_apitag" name="instagrabagram_settings_name[insta_apitag]" value="%s" />',
            isset( $this->settings['insta_apitag'] ) ? esc_attr( $this->settings['insta_apitag']) : ''
        );
    }
*/

    /** 
     * Get the settings option array and print one of its values
     */
    public function insta_count_callback()
    {
        printf(
            '<input type="text" id="insta_count" name="instagrabagram_settings_name[insta_count]" value="%s" />',
            isset( $this->settings['insta_count'] ) ? esc_attr( $this->settings['insta_count']) : ''
        );
    }
    
    /** 
     * Get the settings option array and print one of its values
     */
    public function insta_link_callback()
    {
		$linked = isset( $this->settings['insta_link'] ) ? esc_attr( $this->settings['insta_link']) : ''
		?>
		<input type="checkbox" id="insta_link" name="instagrabagram_settings_name[insta_link]" value="1" <?php checked( $linked, 1 ); ?> />
		<?php
    }


}
