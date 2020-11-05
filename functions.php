<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}
add_action( 'wp_footer', 'my_action_javascript' ); // Write our JS below here

function my_action_javascript() { ?>
	<script type="text/javascript" >
	jQuery(document).ready(function($) {
		var page_count='<?php echo ceil(wp_count_posts('post')->publish/2); ?>';
		var ajaxurl='<?php echo admin_url('admin-ajax.php');?>';
		var page=2;
        jQuery('#load_more').click(function(){
		var data = {
			'action': 'my_action',
			'whatever': page,
		};
		jQuery.post(ajaxurl, data, function(response) {
			jQuery('#container').append(response);
			if(page_count==page){
				jQuery('#load_more').hide();
			}
			page=page + 1;
		});
	});
   });
	</script> <?php
}
add_action( 'wp_ajax_my_action', 'my_action' );
add_action( 'wp_ajax_nopriv_my_action', 'my_action' );
function my_action() {
	global $wpdb; // this is how you get access to the database
        $args=array(
   'post_type'=>'post',
   'paged'=>$_POST['page'],
   );
	$the_query = new WP_Query( $args );
	 
	// The Loop
	if ( $the_query->have_posts() ) {
	    while ( $the_query->have_posts() ) {
	        $the_query->the_post();
	        echo '<li>' . get_the_title() . '</li>';
	    }
	} else {
	    // no posts found
	}
	/* Restore original Post Data */
	wp_reset_postdata();
	wp_die(); 
}
?>