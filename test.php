<?php
/*
 * Template Name: test
 * description: >-
  Page template without sidebar
 */
get_header(); ?>

<?php
 
// The Query
$args=array(
   'post_type'=>'post',
   'paged'=>1
   );
$the_query = new WP_Query( $args );
 
// The Loop
if ( $the_query->have_posts() ) {
    echo '<ul id="container">';
    while ( $the_query->have_posts() ) {
        $the_query->the_post();
        echo '<li>' . get_the_title() . '</li>';
    }
    echo '</ul>
    <button id="load_more">Load More</button>
    ';

} else {
    // no posts found
}
/* Restore original Post Data */
wp_reset_postdata();
get_footer();

?>