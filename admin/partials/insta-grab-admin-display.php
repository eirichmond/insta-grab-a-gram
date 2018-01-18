<?php

/**
 * Provide a dashboard view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://www.squareonemd.co.uk
 * @since      1.0.0
 *
 * @package    Insta_Grab
 * @subpackage Insta_Grab/admin/partials
 */
?>

<div class="wrap">				
	<h2>Instagrabagram</h2>
	
		<?php $this->confirm_api_settings();?>

			<h2 class="insta-nav-tab-wrapper">
				<a href="#instatab1" class="nav-tab nav-tab-active">API Settings</a>
				<a href="#instatab2" class="nav-tab">Instagrabagram Settings</a>
				<a href="#instatab3" class="nav-tab">Hooks and Filters</a>
			</h2>

				
			<div id="poststuff">
			
				<div id="post-body" class="metabox-holder columns-2">
				
					<!-- main content -->
					<div id="post-body-content">
							
							
						<div class="tabs">
							
							<div id="instatab1" class="tabs nav-tab-active">
						
								<div class="meta-box-sortables ui-sortable">
									
									<div class="postbox">
									
										<div class="inside">
								            <form method="post" action="options.php">
								            <?php
								                // This prints out all hidden setting fields
								                settings_fields( 'instagrabagram_option_group' );   
								                do_settings_sections( 'instagrabagram-setting-admin' );
								                submit_button(); 
								            ?>
								            </form>
										</div> <!-- .inside -->
										
										<?php $this->ready_to_authorise(); ?>
									
									</div> <!-- .postbox -->
									
								</div> <!-- .meta-box-sortables .ui-sortable -->
								
							</div>
						
							<div id="instatab2" class="tabs" style="display: none;">
						
								<div class="meta-box-sortables ui-sortable">
									
									<div class="postbox">
									
										<div class="inside">
								            <form method="post" action="options.php">
								            <?php
								                // This prints out all hidden setting fields
								                settings_fields( 'instagrabagram_settings_group' );   
								                do_settings_sections( 'igag-setting-admin' );
								                submit_button(); 
								            ?>
								            </form>
										</div> <!-- .inside -->
									
									</div> <!-- .postbox -->
									
								</div> <!-- .meta-box-sortables .ui-sortable -->
								
							</div>
						
							<div id="instatab3" class="tabs" style="display: none;">
						
								<div class="meta-box-sortables ui-sortable">
									
									<div class="postbox">
									
										<div class="inside">
											<h3><span>Hooks and Filters</span></h3>
											<div class="inside">
											<p>Adding the following hooks and filters to you own plugins or functions.php file will allow you to customise your own feed.</p>
												
											<p>To filter the instagrabagram article markup id</p>
<pre><code class="language-php">
function example_igag_container_id( $article_id ) {
	$article_id = 'instagrab';
    return $article_id;
}
add_filter( 'igag_article_id', 'example_igag_container_id' );
</code></pre>


<p>To filter the instagrabagram ul markup id</p>
<pre><code class="language-php">
function example_igag_ul_id( $ul_id ) {
	$ul_id = 'igag-ul';
    return $ul_id;
}
add_filter( 'igag_ul_id', 'example_igag_ul_id' );
</code></pre>

<p>An add action before images feed</p>
<pre><code class="language-php">
function example_igag_before_images() {
	echo '<header class="entry-header"><h2 class="entry-title">My Instagrabagram Feed!</h2></header>';
}
add_action('igag_before_ul_list_images', 'example_igag_before_images');
</code></pre>

<p>An add action after images feed</p>
<pre><code class="language-php">
function example_igag_after_images() {
	echo '<div class="entry-content"><p>Thanks for taking a peek, you can hashtag us too! By using #instagrabagram</p></div>';
}
add_action('igag_after_ul_list_images', 'example_igag_after_images');
</code></pre>
						
											</div> <!-- .inside -->
										</div> <!-- .inside -->
									
									</div> <!-- .postbox -->
									
								</div> <!-- .meta-box-sortables .ui-sortable -->
								
							</div>
						
						</div>

							
						</div> <!-- post-body-content -->
						
						<!-- sidebar -->
						<div id="postbox-container-1" class="postbox-container">
							
							<div class="meta-box-sortables">
								
								<div class="postbox">
								
									<h3><span>What next?</span></h3>
									<div class="inside">

										<p>Once installed there are a couple of things you need to do to get things working.</p> 
										<ol>
											<li>Go to <a href="http://Instagram.com/developer/">http://Instagram.com/developer/</a> and click the button that says "Register Your Application"</li>
											<li>Fill in the details requested by Instagram, these will be thing like Application Name, Description, Website and redirect_uri (same as website will do).</li>
											<li>Once complete you will be given a CLIENT ID and a CLIENT SECRET.</li>
											<li>Now simply copy and paste the CLIENT ID, CLIENT SECRET and WEBSITE URI to this settings page which can be found from Dashboard > Settings > Instagrabagram.</li>
											<li>Save your settings then place <br>&lt;?php do_action('insta_grab_a_gram'); ?&gt;<br> where you want your feed to appear in one of your theme templates files.</li>
											<li>Take some instagrams and hashtag them with the hashtag you setup in the settings and your feed will auto populate</li>
										</ol>
							            <p><strong>Note:</strong> For this to work correctly you should have access to your template files, this is not shortcode it is a php custom action tag and must be placed in your template files where you want the feed to appear. If you do not have access then you should get your web developer or host to place this action tag.</p>
							            <p>&lt;?php do_action('insta_grab_a_gram'); ?&gt;</p>
							            
							            <p>There are plans to create a shortcode option for future updates but for now this is the only way to make this plugin work, sorry for an inconvenience caused at this time.</p>

									</div> <!-- .inside -->
									
								</div> <!-- .postbox -->
								
							</div> <!-- .meta-box-sortables -->
							
						</div> <!-- #postbox-container-1 .postbox-container -->
						
					</div> <!-- #post-body .metabox-holder .columns-2 -->
					
					<br class="clear">
				</div> <!-- #poststuff -->
				
			</div> <!-- .wrap -->
