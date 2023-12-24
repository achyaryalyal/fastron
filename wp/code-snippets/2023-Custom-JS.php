/////////////////////////////////
// Custom JS
/////////////////////////////////

function custom_js(){
?>
	<script>
	// social share condition
	function socialShare() {
		jQuery(window).scroll(function() {
			var postContent = jQuery("#col-single-post");
			if(typeof(postContent) != "undefined" && postContent !== null) {
				var postContentPosition = postContent.position().top;
				var contentHeight = (jQuery(".et_pb_post_content").height()) + 180;
				jQuery(".wp-socializer[data-stick-to='#col-single-post']").height(contentHeight);
				if(jQuery(this).scrollTop() > contentHeight ) {
					jQuery(".wp-socializer[data-stick-to='#col-single-post']").addClass("holdy");
				} else {
					jQuery(".wp-socializer[data-stick-to='#col-single-post']").removeClass("holdy");
				}
				jQuery(".wp-socializer[data-stick-to='#col-single-post']").css("height","auto");
			}
		});
	}
	
	(function($){
		$(document).ready(function(){
			socialShare();
			// add icon to single post meta
			var titleMetaContainer = $("#judul-pos .et_pb_title_container .et_pb_title_meta_container");
			if(typeof(titleMetaContainer) != "undefined" && titleMetaContainer !== null) {
				var published = $("#judul-pos .et_pb_title_container .et_pb_title_meta_container .published");
				if(typeof(published) != "undefined" && published !== null) {
					published.prepend('<i class="fas fa-clock" style=" color:#ecd53c;padding-right:2px;"></i> ');
				}
				var category = $("#judul-pos .et_pb_title_container .et_pb_title_meta_container a");
				if(typeof(category) != "undefined" && category !== null) {
					category.prepend('<i class="fas fa-bookmark" style="color:#ecd53c;padding-right:2px;"></i> ');
				}
			}
			// hide featured image on video content
			if($(".et_pb_title_container h1").is(':contains("BBG TV:"), :contains("Video:")')) {
				$(".et_pb_title_featured_container").css({"display":"none"});
				$(".et_pb_title_featured_container img").css({"display":"none"});
				$(".et_pb_title_container h1").css({"margin-top":"0"});
			}
			// ivory search placeholder
			$(".is-search-input").attr("placeholder","Ketikkan kata kunci lalu ENTER").blur();
			// wp-socializer replace icon twitter
			$(".socializer a i.fab.fa-twitter").addClass("fa-x-twitter").removeClass("fa-twitter");
			$(".socializer .sr-twitter a").css("color","#fff").css("border-color","#1E3050").css("background-color","#1E3050");
			$(".socializer .sr-share-menu").css("display","none");
			$(".wpsr-share-icons").css("font-weight","600").css("border-top","1px solid #e6e6e6").css("padding-top","13px");
			$(".wpsr-si-inner").css("padding-top","10px");
			// passive event listeners
			jQuery.event.special.touchstart = {
				setup: function( _, ns, handle ) {
					this.addEventListener("touchstart", handle, { passive: !ns.includes("noPreventDefault") });
				}
			};
			jQuery.event.special.touchmove = {
				setup: function( _, ns, handle ) {
					this.addEventListener("touchmove", handle, { passive: !ns.includes("noPreventDefault") });
				}
			};
		});
	})(jQuery);
	</script>
<?php
}
add_action('wp_footer', 'custom_js');
