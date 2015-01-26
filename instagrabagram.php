<?php
/**
 * Plugin Name: Instagrabagram
 * Plugin URI: http://www.squareonemd.co.uk
 * Description: snapshot instagram images by hashtag.
 * Version: 1.0
 * Author: Elliott Richmond
 * Author URI: http://www.squareonemd.co.uk
 * License: GPL2
 */

require_once( plugin_dir_path( __FILE__ ) . 'public.php' );

class MySettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
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
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>Instagrabagram</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'instagrabagram_option_group' );   
                do_settings_sections( 'instagrabagram-setting-admin' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'instagrabagram_option_group', // Option group
            'instagrabagram_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'API settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'instagrabagram-setting-admin' // Page
        );  

        add_settings_field(
            'insta_apiKey', // ID
            'apiKey', // Title 
            array( $this, 'insta_apiKey_callback' ), // Callback
            'instagrabagram-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'insta_apiSecret', // ID
            'apiSecret', // Title 
            array( $this, 'insta_apiSecret_callback' ), // Callback
            'instagrabagram-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'insta_apiCallback', // ID
            'apiCallback', // Title 
            array( $this, 'insta_apiCallback_callback' ), // Callback
            'instagrabagram-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'insta_apitag', // ID
            'Hashtag', // Title 
            array( $this, 'insta_apitag_callback' ), // Callback
            'instagrabagram-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'insta_count', // ID
            'How Many Images to pull (numeric)', // Title 
            array( $this, 'insta_count_callback' ), // Callback
            'instagrabagram-setting-admin', // Page
            'setting_section_id' // Section           
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

        if( isset( $input['insta_apitag'] ) )
            $new_input['insta_apitag'] = strip_tags( $input['insta_apitag'] );

        if( isset( $input['insta_count'] ) )
            $new_input['insta_count'] = absint( $input['insta_count'] );


        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter all instagram settings here for the API:';
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
    public function insta_apitag_callback()
    {
        printf(
            '<input type="text" id="insta_apitag" name="instagrabagram_option_name[insta_apitag]" value="%s" />',
            isset( $this->options['insta_apitag'] ) ? esc_attr( $this->options['insta_apitag']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function insta_count_callback()
    {
        printf(
            '<input type="text" id="insta_count" name="instagrabagram_option_name[insta_count]" value="%s" />',
            isset( $this->options['insta_count'] ) ? esc_attr( $this->options['insta_count']) : ''
        );
    }

}

if( is_admin() )
    $my_settings_page = new MySettingsPage();