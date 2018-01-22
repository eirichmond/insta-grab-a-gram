<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://www.squareonemd.co.uk
 * @since      1.0.0
 *
 * @package    Insta_Grab
 * @subpackage Insta_Grab/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php if ($instasettings['insta_stats']) { ?>
	<div class="instgram-stats">
		
		<ul>
			<li><strong><?php echo esc_html( $stats['media'] ); ?></strong> posts</li>
			<li><strong><?php echo esc_html( $stats['follows'] ); ?></strong> followers</li>
			<li><strong><?php echo esc_html( $stats['followed_by'] ); ?></strong> followings</li>
		</ul>
	
	</div>
<?php } ?>


<div class="instagram-three-col-grid">
	
	<?php foreach($medias as $k => $media) { ?>
		<div class="item">
			
			<?php $this->render_item_start($k, $media); ?>
			
				<div class="item-stats">
					<ul class="item-stats-list">
						<li><i class="fas fa-heart"></i> <?php echo esc_html( $media['likes'] ); ?></li>
						<li><i class="fas fa-comment"></i> <?php echo esc_html( $media['comments'] ); ?></li>
					</ul>
				</div>
				
			<?php $this->render_item_end($media); ?>
			
			<img src="<?php echo esc_html( $media['standard_resolution'] ); ?>">
		</div>
	<?php } ?>
</div>


