(function( $ ) {
	
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note that this assume you're going to use jQuery, so it prepares
	 * the $ function reference to be used within the scope of this
	 * function.
	 *
	 * From here, you're able to define handlers for when the DOM is
	 * ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * Or when the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and so on.
	 *
	 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
	 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
	 * be doing this, we should try to minimize doing that in our own work.
	 */
	 
	 $(function() {
		 
		var modal = (function(){
			var 
			method = {},
			$overlay,
			$modal,
			$content,
			$close;
			
			// Append the HTML
			$overlay = $('<div id="igoverlay"></div>');
			$modal = $('<div id="igmodal"></div>');
			$content = $('<div id="igcontent"></div>');
			$close = $('<a id="igclose" href="#"><i class="fas fa-times-circle"></i></a>');
			
			$modal.hide();
			$overlay.hide();
			$modal.append($content, $close);
						
			$(document).ready(function(){
				$('body').append($overlay, $modal);
			});
			
			// Center the modal in the viewport
			method.center = function () {
				var top, left;
				
				top = Math.max($(window).height() - $modal.outerHeight(), 0) / 2;
				left = Math.max($(window).width() - $modal.outerWidth(), 0) / 2;
				
				$modal.css({
					top:top + $(window).scrollTop(), 
					left:left + $(window).scrollLeft()
				});
			};
			
			// Open the modal
			method.open = function (settings) {
				$content.empty().append(settings.content);
				
				$modal.css({
					width: settings.width || 'auto', 
					height: settings.height || 'auto'
				})
				
				method.center();
				
				$(window).bind('resize.modal', method.center);
				
				$modal.show();
				$overlay.show();
			};
			
			// Close the modal
			method.close = function () {

				$modal.hide();
				$overlay.hide();
				$content.empty();
				$(window).unbind('resize.modal');
				
				$('body').removeClass('noscroll');
				
			};
			
			$close.click(function(e){
				e.preventDefault();
				method.close();
			});

			$overlay.click(function(e){
				e.preventDefault();
				method.close();
			});
			
			return method;
		}());
		

		$('a.igmedia').on('click touch', function(e){
			
			$('body').addClass('noscroll');
			
			var key = $(this).data('media_key');
			
			var contents = '<div class="igimage-holder"><img src="'+object_name[key].standard_resolution+'"></div><div class="igcontent-holder"><div class="top"><span class="profile-image"><a href="https://www.instagram.com/'+object_name[key].profile.username+'" target="_blank"><img src="'+object_name[key].profile.profile_picture+'"></a></span><span class="profile-name">'+object_name[key].profile.full_name+'</span></div><div class="comments"><div class="caption">'+object_name[key].caption+'</div></div><div class="likes-comments"><ul><li class="iginstagram"><a href="https://www.instagram.com/'+object_name[key].profile.username+'" target="_blank"><i class="fab fa-instagram"></i></a></li><li><i class="fas fa-heart"></i> '+object_name[key].likes+'</li><li><i class="fas fa-comment"></i> '+object_name[key].comments+'</li></ul></div></div><div class="igclearer"></div>';
			
			modal.open({content: contents});
			e.preventDefault();
		});
	
		console.log(object_name);
		 
	 });
	 


})( jQuery );

